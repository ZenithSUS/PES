<?php
require_once "../Classes/PHPExcel.php";
include('database.php');
session_start();

header('Content-Type: application/x-www-form-urlencoded');
if (isset($_POST['fileName'])) {
    
    $fileName = $_POST['fileName'];
    $eval_role = $_POST['eval_role'];
    
    if ($eval_role == "HR") {

        $user_to_eval = $_POST['user_to_eval'];
        $absence = $_POST['abs'];
        $suspension = $_POST['sus'];
        $tardiness = $_POST['tard'];
        $rating = $absence + $suspension + $tardiness;
        
    } else if ($eval_role == "HRM") {

        $user_to_eval = $_POST['user_to_eval'];
        $absence = $_POST['abs'];
        $suspension = $_POST['sus'];
        $tardiness = $_POST['tard'];
        $productivity = $_POST['productivity'];
        $knowledge = $_POST['knowledge'];
        $quality = $_POST['quality'];
        $initiative = $_POST['initiative'];
        $attitude = $_POST['attitude'];
        $communication = $_POST['communication'];
        $creativity = $_POST['creativity'];
        $rate_comment = $_POST['rate_comment'];

        $rating = $absence + $suspension + $tardiness + $productivity + $knowledge + $quality + $initiative + $attitude + $communication + $creativity;
    } else {

        $user_to_eval = $_POST['user_to_eval'];
        $productivity = $_POST['productivity'];
        $knowledge = $_POST['knowledge'];
        $quality = $_POST['quality'];
        $initiative = $_POST['initiative'];
        $attitude = $_POST['attitude'];
        $communication = $_POST['communication'];
        $creativity = $_POST['creativity'];
        $rate_comment = $_POST['rate_comment'];

        $rating = $productivity + $knowledge + $quality + $initiative + $attitude + $communication + $creativity;
    }

    $sql = "SELECT * FROM accounts WHERE employee_id = ?";

    $stmt = $con->prepare($sql);

    $stmt->bind_param('s', $user_to_eval);

    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

        $userRecord = $result->fetch_assoc();

        $fname = $userRecord['first_name'] . " " . $userRecord['middle_name'] . " " . $userRecord['last_name'];
        $department = $userRecord['department'];
        $position = $userRecord['position'];
        $status = $userRecord['emp_status'];
        $dateHired = $userRecord['date_hired'];
    } else {
        echo json_encode(['success' => false, 'message' => 'User not exists']);
    }

    
    $date_today = date('F j, Y');

    switch ($eval_role) {

        case "Manager":

            $updateStatus = "UPDATE evaluation SET evaluator_manager = ? WHERE evaluation_file = ?";
            $stmt = $con->prepare($updateStatus);
            $stmt->bind_param("ss", $_SESSION['user_id'], $fileName);

            if ($stmt->execute()) {

                $updateStatus = "UPDATE accounts SET for_eval = ? WHERE current_eval = ?";
                $changeEval = date("F d, Y", strtotime("+6 months"));
                $stmt = $con->prepare($updateStatus);
                $stmt->bind_param("ss", $changeEval, $fileName);

                if ($stmt->execute()) {

                    $getUserId = "SELECT employee_id FROM accounts WHERE current_eval = ?";
                    $stmt = $con->prepare($getUserId);
                    $stmt->bind_param("s", $fileName);
                    $stmt->execute();
                    $stmt->bind_result($user_to_eval);
                    $stmt->fetch();
                    $stmt->close();

                    if (empty($user_to_eval)) {
                        error_log("Error: No employee_id found for file: $fileName");
                        echo json_encode(['success' => false, 'message' => 'No user found for evaluation']);
                        exit;
                    }

                    $checkExists = "SELECT COUNT(*) FROM eval_summary WHERE user_id = ?";
                    $stmt = $con->prepare($checkExists);
                    $stmt->bind_param("s", $user_to_eval);
                    $stmt->execute();
                    $stmt->bind_result($count);
                    $stmt->fetch();
                    $stmt->close();

                    if ($count > 0) {
                        $sql = "UPDATE eval_summary SET rating = rating + ?, comment = ?, file = ? WHERE user_id = ?";
                        $stmt = $con->prepare($sql);
                        $stmt->bind_param("ssss", $rating, $rate_comment, $fileName, $user_to_eval);

                        if (!$stmt->execute()) {
                            error_log("Failed to update eval_summary: " . $stmt->error);
                            echo json_encode(['success' => false, 'message' => 'Failed to update eval_summary']);
                            exit;
                        }
                    }
                    
                    createEvalMgr($fileName, $productivity, $knowledge, $quality, $initiative, $attitude, $communication, $creativity, $date_today, $rate_comment);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Failed to update status']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update status']);
            }

            break;

        case "HR":

            $updateStatus = "UPDATE evaluation SET evaluator_hr = ? WHERE evaluation_file = ?";
            $stmt = $con->prepare(query: $updateStatus);
            $stmt->bind_param("ss", $_SESSION['user_id'], $fileName);

            if ($stmt->execute()) {

                $checkExists = "SELECT COUNT(*) FROM eval_summary WHERE user_id = ?";
                $stmt = $con->prepare($checkExists);
                $stmt->bind_param("s", $user_to_eval);
                $stmt->execute();
                $stmt->bind_result($count);
                $stmt->fetch();
                $stmt->close();

                if ($count > 0) {

                    $updateSummary = "UPDATE eval_summary SET rating = ? WHERE user_id = ?";
                    $stmt = $con->prepare($updateSummary);
                    $stmt->bind_param("ss", $rating, $user_to_eval);
                } else {

                    $insertSummary = "INSERT INTO eval_summary (user_id, hr_id, rating) VALUES (?, ?, ?)";
                    $stmt = $con->prepare($insertSummary);
                    $stmt->bind_param("sss", $user_to_eval, $_SESSION['user_id'], $rating);
                }

                if ($stmt->execute()) {
                    createEvalHR($fileName, $fname, $department, $position, $status, $date_today, $dateHired, $absence, $suspension, $tardiness);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Failed to update eval_summary']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update evaluation']);
            }


            break;

        case "HRM":

            $updateStatus = "UPDATE evaluation SET evaluator_hr = ?, evaluator_manager = ? WHERE evaluation_file = ?";
            $stmt = $con->prepare(query: $updateStatus);
            $stmt->bind_param("sss", $_SESSION['user_id'], $_SESSION['user_id'], $fileName);
            
            if ($stmt->execute()) {

                $checkExists = "SELECT COUNT(*) FROM eval_summary WHERE user_id = ?";
                $stmt = $con->prepare($checkExists);
                $stmt->bind_param("s", $user_to_eval);
                $stmt->execute();
                $stmt->bind_result($count);
                $stmt->fetch();
                $stmt->close();

                if ($count > 0) {

                    $updateStatus = "UPDATE accounts SET for_eval = ? WHERE current_eval = ?";
                    $changeEval = date("F d, Y", strtotime("+6 months"));
                    $stmt = $con->prepare($updateStatus);
                    $stmt->bind_param("ss", $changeEval, $fileName);

                    if ($stmt->execute()) {

                        $updateSummary = "UPDATE eval_summary SET rating = ? WHERE user_id = ?";
                        $stmt = $con->prepare($updateSummary);
                        $stmt->bind_param("ss", $rating, $user_to_eval);
                    }
                } else {

                    $insertSummary = "INSERT INTO eval_summary (user_id, hr_id, rating, comment, file) VALUES (?, ?, ?, ?, ?)";
                    $stmt = $con->prepare($insertSummary);
                    $stmt->bind_param("sssss", $user_to_eval, $_SESSION['user_id'], $rating, $rate_comment, $fileName);

                    if ($stmt->execute()) {

                        $updateStatus = "UPDATE accounts SET for_eval = ? WHERE current_eval = ?";
                        $changeEval = date("F d, Y", strtotime("+6 months"));
                        $stmt = $con->prepare($updateStatus);
                        $stmt->bind_param("ss", $changeEval, $fileName);
                    }
                }

                if ($stmt->execute()) {
                    createEvalHRM($fileName, $fname, $department, $position, $status, $date_today, $dateHired, $absence, $suspension, $tardiness, $productivity, $knowledge, $quality, $initiative, $attitude, $communication, $creativity, $rate_comment);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Failed to update eval_summary']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update evaluation']);
            }


            break;

        default:

            break;
    }
} else {

    echo json_encode(['success' => false, 'message' => 'File name and name are required.']);
}

function createEvalMgr($fileName, $productivity, $knowledge, $quality, $initiative, $attitude, $communication, $creativity, $date_today, $rate_comment)
{

    $reader = PHPExcel_IOFactory::createReaderForFile($fileName);

    $excel_obj = $reader->load($fileName);

    $worksheet = $excel_obj->getActiveSheet();


    $A56 = new PHPExcel_RichText();
    $boldA56 = $A56->createTextRun($_SESSION['full']);
    $boldA56->getFont()->setBold(true);
    $worksheet->getCell('A56')->setValue($A56);

    $A56 = new PHPExcel_RichText();
    $boldA56 = $A56->createTextRun($_SESSION['department'] . " Department, Manager");
    $worksheet->getCell('A57')->setValue($A56);

    $A56 = new PHPExcel_RichText();
    $boldA56 = $A56->createTextRun($date_today);
    $boldA56->getFont()->setBold(true);
    $worksheet->getCell('G52')->setValue($A56);

    switch (true) {
        case ($productivity >= 14.5 && $productivity <= 15):
            $F13 = new PHPExcel_RichText();
            $boldF13 = $F13->createTextRun($productivity);
            $boldF13->getFont()->setBold(true);
            $worksheet->getCell('F13')->setValue($F13);
            break;

        case ($productivity >= 13.9 && $productivity <= 14.4):
            $G13 = new PHPExcel_RichText();
            $boldG13 = $G13->createTextRun($productivity);
            $boldG13->getFont()->setBold(true);
            $worksheet->getCell('G13')->setValue($G13);
            break;

        case ($productivity >= 12 && $productivity <= 13.8):
            $H13 = new PHPExcel_RichText();
            $boldH13 = $H13->createTextRun($productivity);
            $boldH13->getFont()->setBold(true);
            $worksheet->getCell('H13')->setValue($H13);
            break;

        case ($productivity >= 11.5 && $productivity <= 11.9):
            $I13 = new PHPExcel_RichText();
            $boldI13 = $I13->createTextRun($productivity);
            $boldI13->getFont()->setBold(true);
            $worksheet->getCell('I13')->setValue($I13);
            break;

        case ($productivity <= 11.4):
            $J13 = new PHPExcel_RichText();
            $boldJ13 = $J13->createTextRun($productivity);
            $boldJ13->getFont()->setBold(true);
            $worksheet->getCell('J13')->setValue($J13);
            break;
    }

    switch (true) {
        case ($knowledge >= 14.5 && $knowledge <= 15):
            $F16 = new PHPExcel_RichText();
            $boldF16 = $F16->createTextRun($knowledge);
            $boldF16->getFont()->setBold(true);
            $worksheet->getCell('F16')->setValue($F16);
            break;

        case ($knowledge >= 13.9 && $knowledge <= 14.4):
            $G16 = new PHPExcel_RichText();
            $boldG16 = $G16->createTextRun($knowledge);
            $boldG16->getFont()->setBold(true);
            $worksheet->getCell('G16')->setValue($G16);
            break;

        case ($knowledge >= 12 && $knowledge <= 13.8):
            $H16 = new PHPExcel_RichText();
            $boldH16 = $H16->createTextRun($knowledge);
            $boldH16->getFont()->setBold(true);
            $worksheet->getCell('H16')->setValue($H16);
            break;

        case ($knowledge >= 11.5 && $knowledge <= 11.9):
            $I16 = new PHPExcel_RichText();
            $boldI16 = $I16->createTextRun($knowledge);
            $boldI16->getFont()->setBold(true);
            $worksheet->getCell('I16')->setValue($I16);
            break;

        case ($knowledge <= 11.4):
            $J16 = new PHPExcel_RichText();
            $boldJ16 = $J16->createTextRun($knowledge);
            $boldJ16->getFont()->setBold(true);
            $worksheet->getCell('J16')->setValue($J16);
            break;
    }

    switch (true) {
        case ($quality >= 14.5 && $quality <= 15):
            $F19 = new PHPExcel_RichText();
            $boldF19 = $F19->createTextRun($quality);
            $boldF19->getFont()->setBold(true);
            $worksheet->getCell('F19')->setValue($F19);
            break;

        case ($quality >= 13.9 && $quality <= 14.4):
            $G19 = new PHPExcel_RichText();
            $boldG19 = $G19->createTextRun($quality);
            $boldG19->getFont()->setBold(true);
            $worksheet->getCell('G19')->setValue($G19);
            break;

        case ($quality >= 12 && $quality <= 13.8):
            $H19 = new PHPExcel_RichText();
            $boldH19 = $H19->createTextRun($quality);
            $boldH19->getFont()->setBold(true);
            $worksheet->getCell('H19')->setValue($H19);
            break;

        case ($quality >= 11.5 && $quality <= 11.9):
            $I19 = new PHPExcel_RichText();
            $boldI19 = $I19->createTextRun($quality);
            $boldI19->getFont()->setBold(true);
            $worksheet->getCell('I19')->setValue($I19);
            break;

        case ($quality <= 11.4):
            $J19 = new PHPExcel_RichText();
            $boldJ19 = $J19->createTextRun($quality);
            $boldJ19->getFont()->setBold(true);
            $worksheet->getCell('J19')->setValue($J19);
            break;
    }

    switch (true) {
        case ($initiative >= 9.5 && $initiative <= 10):
            $F22 = new PHPExcel_RichText();
            $boldF22 = $F22->createTextRun($initiative);
            $boldF22->getFont()->setBold(true);
            $worksheet->getCell('F22')->setValue($F22);
            break;

        case ($initiative >= 9 && $initiative <= 9.4):
            $G22 = new PHPExcel_RichText();
            $boldG22 = $G22->createTextRun($initiative);
            $boldG22->getFont()->setBold(true);
            $worksheet->getCell('G22')->setValue($G22);
            break;

        case ($initiative >= 8 && $initiative <= 8.9):
            $H22 = new PHPExcel_RichText();
            $boldH22 = $H22->createTextRun($initiative);
            $boldH22->getFont()->setBold(true);
            $worksheet->getCell('H22')->setValue($H22);
            break;

        case ($initiative >= 7.5 && $initiative <= 7.9):
            $I22 = new PHPExcel_RichText();
            $boldI22 = $I22->createTextRun($initiative);
            $boldI22->getFont()->setBold(true);
            $worksheet->getCell('I22')->setValue($I22);
            break;

        case ($initiative <= 7.4):
            $J22 = new PHPExcel_RichText();
            $boldJ22 = $J22->createTextRun($initiative);
            $boldJ22->getFont()->setBold(true);
            $worksheet->getCell('J22')->setValue($J22);
            break;
    }

    switch (true) {
        case ($attitude >= 9.5 && $attitude <= 10):
            $F25 = new PHPExcel_RichText();
            $boldF25 = $F25->createTextRun($attitude);
            $boldF25->getFont()->setBold(true);
            $worksheet->getCell('F25')->setValue($F25);
            break;

        case ($attitude >= 9 && $attitude <= 9.4):
            $G25 = new PHPExcel_RichText();
            $boldG25 = $G25->createTextRun($attitude);
            $boldG25->getFont()->setBold(true);
            $worksheet->getCell('G25')->setValue($G25);
            break;

        case ($attitude >= 8 && $attitude <= 8.9):
            $H25 = new PHPExcel_RichText();
            $boldH25 = $H25->createTextRun($attitude);
            $boldH25->getFont()->setBold(true);
            $worksheet->getCell('H25')->setValue($H25);
            break;

        case ($attitude >= 7.5 && $attitude <= 7.9):
            $I25 = new PHPExcel_RichText();
            $boldI25 = $I25->createTextRun($attitude);
            $boldI25->getFont()->setBold(true);
            $worksheet->getCell('I25')->setValue($I25);
            break;

        case ($attitude <= 7.4):
            $J25 = new PHPExcel_RichText();
            $boldJ25 = $J25->createTextRun($attitude);
            $boldJ25->getFont()->setBold(true);
            $worksheet->getCell('J25')->setValue($J25);
            break;
    }

    switch (true) {
        case ($communication == 5):
            $F28 = new PHPExcel_RichText();
            $boldF28 = $F28->createTextRun($communication);
            $boldF28->getFont()->setBold(true);
            $worksheet->getCell('F28')->setValue($F28);
            break;

        case ($communication >= 4.5 && $communication < 5):
            $G28 = new PHPExcel_RichText();
            $boldG28 = $G28->createTextRun($communication);
            $boldG28->getFont()->setBold(true);
            $worksheet->getCell('G28')->setValue($G28);
            break;

        case ($communication >= 4 && $communication < 4.5):
            $H28 = new PHPExcel_RichText();
            $boldH28 = $H28->createTextRun($communication);
            $boldH28->getFont()->setBold(true);
            $worksheet->getCell('H28')->setValue($H28);
            break;

        case ($communication >= 3.5 && $communication < 4):
            $I28 = new PHPExcel_RichText();
            $boldI28 = $I28->createTextRun($communication);
            $boldI28->getFont()->setBold(true);
            $worksheet->getCell('I28')->setValue($I28);
            break;

        case ($communication <= 3.4):
            $J28 = new PHPExcel_RichText();
            $boldJ28 = $J28->createTextRun($communication);
            $boldJ28->getFont()->setBold(true);
            $worksheet->getCell('J28')->setValue($J28);
            break;
    }

    switch (true) {
        case ($creativity == 5):
            $F31 = new PHPExcel_RichText();
            $boldF31 = $F31->createTextRun($creativity);
            $boldF31->getFont()->setBold(true);
            $worksheet->getCell('F31')->setValue($F31);
            break;

        case ($creativity >= 4.5 && $creativity < 5):
            $G31 = new PHPExcel_RichText();
            $boldG31 = $G31->createTextRun($creativity);
            $boldG31->getFont()->setBold(true);
            $worksheet->getCell('G31')->setValue($G31);
            break;

        case ($creativity >= 4 && $creativity < 4.5):
            $H31 = new PHPExcel_RichText();
            $boldH31 = $H31->createTextRun($creativity);
            $boldH31->getFont()->setBold(true);
            $worksheet->getCell('H31')->setValue($H31);
            break;

        case ($creativity >= 3.5 && $creativity < 4):
            $I31 = new PHPExcel_RichText();
            $boldI31 = $I31->createTextRun($creativity);
            $boldI31->getFont()->setBold(true);
            $worksheet->getCell('I31')->setValue($I31);
            break;

        case ($creativity <= 3.4):
            $J31 = new PHPExcel_RichText();
            $boldJ31 = $J31->createTextRun($creativity);
            $boldJ31->getFont()->setBold(true);
            $worksheet->getCell('J31')->setValue($J31);
            break;
    }

    $A44 = new PHPExcel_RichText();
    $boldA44 = $A44->createTextRun($rate_comment);
    $worksheet->getCell('A44')->setValue($A44);

    $worksheet->getCell('F43')->setValue('=F13 + G13 + H13 + I13 + J13 + F16 + G16 + H16 + I16 + J16 + F19 + G19 + H19 + I19 + J19 +F22 + G22 + H22 + I22 + J22 +F25 + G25 + H25 + I25 + J25 +F28 + G28 + H28 + I28 + J28 +F31 + G31 + H31 + I31 + J31 +F35 + G35 + H35 + I35 + J35 +F38 + G38 + H38 + I38 + J38 +F41 + G41 + H41 + I41 + J41');

    $lookupValue = 'F43';
    $lookupRange = 'E45:F49';
    $columnIndex = 2;
    $rangeLookup = TRUE;
    $vlookupFormula = '=IF(F43>=97, "Excellent", IF(F43>=90, "Very Good", IF(F43>=75, "Good", IF(F43>=60, "Fair", "Poor"))))';

    $worksheet->getCell('G43')->setValue($vlookupFormula);

    $writer = PHPExcel_IOFactory::createWriter($excel_obj, 'Excel2007');
    $writer->save($fileName);

    echo json_encode(['success' => true]);
}

function createEvalHR($fileName, $fname, $department, $position, $status, $date_today, $dateHired, $absence, $suspension, $tardiness)
{

    $reader = PHPExcel_IOFactory::createReaderForFile($fileName);

    $excel_obj = $reader->load($fileName);

    $worksheet = $excel_obj->getActiveSheet();

    $C8 = new PHPExcel_RichText();
    $boldC8 = $C8->createTextRun($fname);
    $boldC8->getFont()->setBold(true);
    $worksheet->getCell('C8')->setValue($C8);

    $A52 = new PHPExcel_RichText();
    $boldA52 = $A52->createTextRun($fname);
    $boldA52->getFont()->setBold(true);
    $worksheet->getCell('A52')->setValue($A52);

    $F56 = new PHPExcel_RichText();
    $boldF56 = $F56->createTextRun($_SESSION['full']);
    $boldF56->getFont()->setBold(true);
    $worksheet->getCell('F56')->setValue($F56);

    $C9 = new PHPExcel_RichText();
    $boldC9 = $C9->createTextRun($dateHired);
    $boldC9->getFont()->setBold(true);
    $worksheet->getCell('C9')->setValue(pValue: $C9);

    $C10 = new PHPExcel_RichText();
    $boldC10 = $C10->createTextRun($date_today);
    $boldC10->getFont()->setBold(true);
    $worksheet->getCell('C10')->setValue($C10);

    $I8 = new PHPExcel_RichText();
    $boldI8 = $I8->createTextRun($department);
    $boldI8->getFont()->setBold(true);
    $worksheet->getCell('I8')->setValue($I8);

    $I9 = new PHPExcel_RichText();
    $boldI9 = $I9->createTextRun($position);
    $boldI9->getFont()->setBold(true);
    $worksheet->getCell('I9')->setValue($I9);

    $I10 = new PHPExcel_RichText();
    $boldI10 = $I10->createTextRun($status);
    $boldI10->getFont()->setBold(true);
    $worksheet->getCell('I10')->setValue($I10);



    switch (true) {
        case ($absence == 10):
            $F35 = new PHPExcel_RichText();
            $boldF35 = $F35->createTextRun($absence);
            $boldF35->getFont()->setBold(true);
            $worksheet->getCell('F35')->setValue($F35);
            break;

        case ($absence >= 8.6 && $absence <= 9.5):
            $G35 = new PHPExcel_RichText();
            $boldG35 = $G35->createTextRun($absence);
            $boldG35->getFont()->setBold(true);
            $worksheet->getCell('G35')->setValue($G35);
            break;

        case ($absence >= 6 && $absence <= 8.5):
            $H35 = new PHPExcel_RichText();
            $boldH35 = $H35->createTextRun($absence);
            $boldH35->getFont()->setBold(true);
            $worksheet->getCell('H35')->setValue($H35);
            break;

        case ($absence >= 3.5 && $absence <= 5.9):
            $I35 = new PHPExcel_RichText();
            $boldI35 = $I35->createTextRun($absence);
            $boldI35->getFont()->setBold(true);
            $worksheet->getCell('I35')->setValue($I35);
            break;

        case ($absence == 0):
            $J35 = new PHPExcel_RichText();
            $boldJ35 = $J35->createTextRun($absence);
            $boldJ35->getFont()->setBold(true);
            $worksheet->getCell('J35')->setValue($J35);
            break;

        default:
            break;
    }

    switch (true) {

        case ($suspension == 10):
            $F38 = new PHPExcel_RichText();
            $boldF38 = $F38->createTextRun($suspension);
            $boldF38->getFont()->setBold(true);
            $worksheet->getCell('F38')->setValue($F38);
            break;

        case ($suspension >= 8.6 && $suspension <= 9.5):
            $G38 = new PHPExcel_RichText();
            $boldG38 = $G38->createTextRun($suspension);
            $boldG38->getFont()->setBold(true);
            $worksheet->getCell('G38')->setValue($G38);
            break;

        case ($suspension >= 6 && $suspension <= 8.5):
            $H38 = new PHPExcel_RichText();
            $boldH38 = $H38->createTextRun($suspension);
            $boldH38->getFont()->setBold(true);
            $worksheet->getCell('H38')->setValue($H38);
            break;

        case ($suspension >= 3.5 && $suspension <= 5.9):
            $I38 = new PHPExcel_RichText();
            $boldI38 = $I38->createTextRun($suspension);
            $boldI38->getFont()->setBold(true);
            $worksheet->getCell('I38')->setValue($I38);
            break;

        case ($suspension == 0):
            $J38 = new PHPExcel_RichText();
            $boldJ38 = $J38->createTextRun($suspension);
            $boldJ38->getFont()->setBold(true);
            $worksheet->getCell('J38')->setValue($J38);
            break;

        default:
            break;
    }

    switch (true) {
        case ($tardiness == 5):
            $F41 = new PHPExcel_RichText();
            $boldF41 = $F41->createTextRun($tardiness);
            $boldF41->getFont()->setBold(true);
            $worksheet->getCell('F41')->setValue($F41);
            break;

        case ($tardiness >= 4.7 && $tardiness <= 4.9):
            $G41 = new PHPExcel_RichText();
            $boldG41 = $G41->createTextRun($tardiness);
            $boldG41->getFont()->setBold(true);
            $worksheet->getCell('G41')->setValue($G41);
            break;

        case ($tardiness >= 4.5 && $tardiness <= 4.7):
            $H41 = new PHPExcel_RichText();
            $boldH41 = $H41->createTextRun($tardiness);
            $boldH41->getFont()->setBold(true);
            $worksheet->getCell('H41')->setValue($H41);
            break;

        case ($tardiness >= 2.9 && $tardiness <= 4.4):
            $I41 = new PHPExcel_RichText();
            $boldI41 = $I41->createTextRun($tardiness);
            $boldI41->getFont()->setBold(true);
            $worksheet->getCell('I41')->setValue($I41);
            break;

        case ($tardiness == 0):
            $J41 = new PHPExcel_RichText();
            $boldJ41 = $J41->createTextRun($tardiness);
            $boldJ41->getFont()->setBold(true);
            $worksheet->getCell('J41')->setValue($J41);
            break;

        default:
            break;
    }

    $writer = PHPExcel_IOFactory::createWriter($excel_obj, 'Excel2007');
    $writer->save($fileName);

    echo json_encode(['success' => true]);
}

function createEvalHRM($fileName, $fname, $department, $position, $status, $date_today, $dateHired, $absence, $suspension, $tardiness, $productivity, $knowledge, $quality, $initiative, $attitude, $communication, $creativity, $rate_comment)
{
    
    $reader = PHPExcel_IOFactory::createReaderForFile($fileName);
    $excel_obj = $reader->load($fileName);

    $worksheet = $excel_obj->getActiveSheet();

    $A56 = new PHPExcel_RichText();
    $boldA56 = $A56->createTextRun(pText: "Juan Dela Cruz"); //change to president/ceo name
    $boldA56->getFont()->setBold(true);
    $worksheet->getCell('A56')->setValue($A56);

    $A56 = new PHPExcel_RichText();
    $boldA56 = $A56->createTextRun("President / CEO"); // change position 
    $worksheet->getCell('A57')->setValue($A56);

    $A56 = new PHPExcel_RichText();
    $boldA56 = $A56->createTextRun($date_today);
    $boldA56->getFont()->setBold(true);
    $worksheet->getCell('G52')->setValue($A56);

    $C8 = new PHPExcel_RichText();
    $boldC8 = $C8->createTextRun($fname);
    $boldC8->getFont()->setBold(true);
    $worksheet->getCell('C8')->setValue($C8);

    $A52 = new PHPExcel_RichText();
    $boldA52 = $A52->createTextRun($fname);
    $boldA52->getFont()->setBold(true);
    $worksheet->getCell('A52')->setValue($A52);

    $F56 = new PHPExcel_RichText();
    $boldF56 = $F56->createTextRun($_SESSION['full']);
    $boldF56->getFont()->setBold(true);
    $worksheet->getCell('F56')->setValue($F56);

    $C9 = new PHPExcel_RichText();
    $boldC9 = $C9->createTextRun($dateHired);
    $boldC9->getFont()->setBold(true);
    $worksheet->getCell('C9')->setValue(pValue: $C9);

    $C10 = new PHPExcel_RichText();
    $boldC10 = $C10->createTextRun($date_today);
    $boldC10->getFont()->setBold(true);
    $worksheet->getCell('C10')->setValue($C10);

    $I8 = new PHPExcel_RichText();
    $boldI8 = $I8->createTextRun($department);
    $boldI8->getFont()->setBold(true);
    $worksheet->getCell('I8')->setValue($I8);

    $I9 = new PHPExcel_RichText();
    $boldI9 = $I9->createTextRun($position);
    $boldI9->getFont()->setBold(true);
    $worksheet->getCell('I9')->setValue($I9);

    $I10 = new PHPExcel_RichText();
    $boldI10 = $I10->createTextRun($status);
    $boldI10->getFont()->setBold(true);
    $worksheet->getCell('I10')->setValue($I10);



    switch (true) {
        case ($productivity >= 14.5 && $productivity <= 15):
            $F13 = new PHPExcel_RichText();
            $boldF13 = $F13->createTextRun($productivity);
            $boldF13->getFont()->setBold(true);
            $worksheet->getCell('F13')->setValue($F13);
            break;

        case ($productivity >= 13.9 && $productivity <= 14.4):
            $G13 = new PHPExcel_RichText();
            $boldG13 = $G13->createTextRun($productivity);
            $boldG13->getFont()->setBold(true);
            $worksheet->getCell('G13')->setValue($G13);
            break;

        case ($productivity >= 12 && $productivity <= 13.8):
            $H13 = new PHPExcel_RichText();
            $boldH13 = $H13->createTextRun($productivity);
            $boldH13->getFont()->setBold(true);
            $worksheet->getCell('H13')->setValue($H13);
            break;

        case ($productivity >= 11.5 && $productivity <= 11.9):
            $I13 = new PHPExcel_RichText();
            $boldI13 = $I13->createTextRun($productivity);
            $boldI13->getFont()->setBold(true);
            $worksheet->getCell('I13')->setValue($I13);
            break;

        case ($productivity <= 11.4):
            $J13 = new PHPExcel_RichText();
            $boldJ13 = $J13->createTextRun($productivity);
            $boldJ13->getFont()->setBold(true);
            $worksheet->getCell('J13')->setValue($J13);
            break;
    }

    switch (true) {
        case ($knowledge >= 14.5 && $knowledge <= 15):
            $F16 = new PHPExcel_RichText();
            $boldF16 = $F16->createTextRun($knowledge);
            $boldF16->getFont()->setBold(true);
            $worksheet->getCell('F16')->setValue($F16);
            break;

        case ($knowledge >= 13.9 && $knowledge <= 14.4):
            $G16 = new PHPExcel_RichText();
            $boldG16 = $G16->createTextRun($knowledge);
            $boldG16->getFont()->setBold(true);
            $worksheet->getCell('G16')->setValue($G16);
            break;

        case ($knowledge >= 12 && $knowledge <= 13.8):
            $H16 = new PHPExcel_RichText();
            $boldH16 = $H16->createTextRun($knowledge);
            $boldH16->getFont()->setBold(true);
            $worksheet->getCell('H16')->setValue($H16);
            break;

        case ($knowledge >= 11.5 && $knowledge <= 11.9):
            $I16 = new PHPExcel_RichText();
            $boldI16 = $I16->createTextRun($knowledge);
            $boldI16->getFont()->setBold(true);
            $worksheet->getCell('I16')->setValue($I16);
            break;

        case ($knowledge <= 11.4):
            $J16 = new PHPExcel_RichText();
            $boldJ16 = $J16->createTextRun($knowledge);
            $boldJ16->getFont()->setBold(true);
            $worksheet->getCell('J16')->setValue($J16);
            break;
    }

    switch (true) {
        case ($quality >= 14.5 && $quality <= 15):
            $F19 = new PHPExcel_RichText();
            $boldF19 = $F19->createTextRun($quality);
            $boldF19->getFont()->setBold(true);
            $worksheet->getCell('F19')->setValue($F19);
            break;

        case ($quality >= 13.9 && $quality <= 14.4):
            $G19 = new PHPExcel_RichText();
            $boldG19 = $G19->createTextRun($quality);
            $boldG19->getFont()->setBold(true);
            $worksheet->getCell('G19')->setValue($G19);
            break;

        case ($quality >= 12 && $quality <= 13.8):
            $H19 = new PHPExcel_RichText();
            $boldH19 = $H19->createTextRun($quality);
            $boldH19->getFont()->setBold(true);
            $worksheet->getCell('H19')->setValue($H19);
            break;

        case ($quality >= 11.5 && $quality <= 11.9):
            $I19 = new PHPExcel_RichText();
            $boldI19 = $I19->createTextRun($quality);
            $boldI19->getFont()->setBold(true);
            $worksheet->getCell('I19')->setValue($I19);
            break;

        case ($quality <= 11.4):
            $J19 = new PHPExcel_RichText();
            $boldJ19 = $J19->createTextRun($quality);
            $boldJ19->getFont()->setBold(true);
            $worksheet->getCell('J19')->setValue($J19);
            break;
    }

    switch (true) {
        case ($initiative >= 9.5 && $initiative <= 10):
            $F22 = new PHPExcel_RichText();
            $boldF22 = $F22->createTextRun($initiative);
            $boldF22->getFont()->setBold(true);
            $worksheet->getCell('F22')->setValue($F22);
            break;

        case ($initiative >= 9 && $initiative <= 9.4):
            $G22 = new PHPExcel_RichText();
            $boldG22 = $G22->createTextRun($initiative);
            $boldG22->getFont()->setBold(true);
            $worksheet->getCell('G22')->setValue($G22);
            break;

        case ($initiative >= 8 && $initiative <= 8.9):
            $H22 = new PHPExcel_RichText();
            $boldH22 = $H22->createTextRun($initiative);
            $boldH22->getFont()->setBold(true);
            $worksheet->getCell('H22')->setValue($H22);
            break;

        case ($initiative >= 7.5 && $initiative <= 7.9):
            $I22 = new PHPExcel_RichText();
            $boldI22 = $I22->createTextRun($initiative);
            $boldI22->getFont()->setBold(true);
            $worksheet->getCell('I22')->setValue($I22);
            break;

        case ($initiative <= 7.4):
            $J22 = new PHPExcel_RichText();
            $boldJ22 = $J22->createTextRun($initiative);
            $boldJ22->getFont()->setBold(true);
            $worksheet->getCell('J22')->setValue($J22);
            break;
    }

    switch (true) {
        case ($attitude >= 9.5 && $attitude <= 10):
            $F25 = new PHPExcel_RichText();
            $boldF25 = $F25->createTextRun($attitude);
            $boldF25->getFont()->setBold(true);
            $worksheet->getCell('F25')->setValue($F25);
            break;

        case ($attitude >= 9 && $attitude <= 9.4):
            $G25 = new PHPExcel_RichText();
            $boldG25 = $G25->createTextRun($attitude);
            $boldG25->getFont()->setBold(true);
            $worksheet->getCell('G25')->setValue($G25);
            break;

        case ($attitude >= 8 && $attitude <= 8.9):
            $H25 = new PHPExcel_RichText();
            $boldH25 = $H25->createTextRun($attitude);
            $boldH25->getFont()->setBold(true);
            $worksheet->getCell('H25')->setValue($H25);
            break;

        case ($attitude >= 7.5 && $attitude <= 7.9):
            $I25 = new PHPExcel_RichText();
            $boldI25 = $I25->createTextRun($attitude);
            $boldI25->getFont()->setBold(true);
            $worksheet->getCell('I25')->setValue($I25);
            break;

        case ($attitude <= 7.4):
            $J25 = new PHPExcel_RichText();
            $boldJ25 = $J25->createTextRun($attitude);
            $boldJ25->getFont()->setBold(true);
            $worksheet->getCell('J25')->setValue($J25);
            break;
    }

    switch (true) {
        case ($communication == 5):
            $F28 = new PHPExcel_RichText();
            $boldF28 = $F28->createTextRun($communication);
            $boldF28->getFont()->setBold(true);
            $worksheet->getCell('F28')->setValue($F28);
            break;

        case ($communication >= 4.5 && $communication < 5):
            $G28 = new PHPExcel_RichText();
            $boldG28 = $G28->createTextRun($communication);
            $boldG28->getFont()->setBold(true);
            $worksheet->getCell('G28')->setValue($G28);
            break;

        case ($communication >= 4 && $communication < 4.5):
            $H28 = new PHPExcel_RichText();
            $boldH28 = $H28->createTextRun($communication);
            $boldH28->getFont()->setBold(true);
            $worksheet->getCell('H28')->setValue($H28);
            break;

        case ($communication >= 3.5 && $communication < 4):
            $I28 = new PHPExcel_RichText();
            $boldI28 = $I28->createTextRun($communication);
            $boldI28->getFont()->setBold(true);
            $worksheet->getCell('I28')->setValue($I28);
            break;

        case ($communication <= 3.4):
            $J28 = new PHPExcel_RichText();
            $boldJ28 = $J28->createTextRun($communication);
            $boldJ28->getFont()->setBold(true);
            $worksheet->getCell('J28')->setValue($J28);
            break;
    }

    switch (true) {
        case ($creativity == 5):
            $F31 = new PHPExcel_RichText();
            $boldF31 = $F31->createTextRun($creativity);
            $boldF31->getFont()->setBold(true);
            $worksheet->getCell('F31')->setValue($F31);
            break;

        case ($creativity >= 4.5 && $creativity < 5):
            $G31 = new PHPExcel_RichText();
            $boldG31 = $G31->createTextRun($creativity);
            $boldG31->getFont()->setBold(true);
            $worksheet->getCell('G31')->setValue($G31);
            break;

        case ($creativity >= 4 && $creativity < 4.5):
            $H31 = new PHPExcel_RichText();
            $boldH31 = $H31->createTextRun($creativity);
            $boldH31->getFont()->setBold(true);
            $worksheet->getCell('H31')->setValue($H31);
            break;

        case ($creativity >= 3.5 && $creativity < 4):
            $I31 = new PHPExcel_RichText();
            $boldI31 = $I31->createTextRun($creativity);
            $boldI31->getFont()->setBold(true);
            $worksheet->getCell('I31')->setValue($I31);
            break;

        case ($creativity <= 3.4):
            $J31 = new PHPExcel_RichText();
            $boldJ31 = $J31->createTextRun($creativity);
            $boldJ31->getFont()->setBold(true);
            $worksheet->getCell('J31')->setValue($J31);
            break;
    }

    switch (true) {
        case ($absence == 10):
            $F35 = new PHPExcel_RichText();
            $boldF35 = $F35->createTextRun($absence);
            $boldF35->getFont()->setBold(true);
            $worksheet->getCell('F35')->setValue($F35);
            break;

        case ($absence >= 8.6 && $absence <= 9.5):
            $G35 = new PHPExcel_RichText();
            $boldG35 = $G35->createTextRun($absence);
            $boldG35->getFont()->setBold(true);
            $worksheet->getCell('G35')->setValue($G35);
            break;

        case ($absence >= 6 && $absence <= 8.5):
            $H35 = new PHPExcel_RichText();
            $boldH35 = $H35->createTextRun($absence);
            $boldH35->getFont()->setBold(true);
            $worksheet->getCell('H35')->setValue($H35);
            break;

        case ($absence >= 3.5 && $absence <= 5.9):
            $I35 = new PHPExcel_RichText();
            $boldI35 = $I35->createTextRun($absence);
            $boldI35->getFont()->setBold(true);
            $worksheet->getCell('I35')->setValue($I35);
            break;

        case ($absence == 0):
            $J35 = new PHPExcel_RichText();
            $boldJ35 = $J35->createTextRun($absence);
            $boldJ35->getFont()->setBold(true);
            $worksheet->getCell('J35')->setValue($J35);
            break;

        default:
            break;
    }

    switch (true) {

        case ($suspension == 10):
            $F38 = new PHPExcel_RichText();
            $boldF38 = $F38->createTextRun($suspension);
            $boldF38->getFont()->setBold(true);
            $worksheet->getCell('F38')->setValue($F38);
            break;

        case ($suspension >= 8.6 && $suspension <= 9.5):
            $G38 = new PHPExcel_RichText();
            $boldG38 = $G38->createTextRun($suspension);
            $boldG38->getFont()->setBold(true);
            $worksheet->getCell('G38')->setValue($G38);
            break;

        case ($suspension >= 6 && $suspension <= 8.5):
            $H38 = new PHPExcel_RichText();
            $boldH38 = $H38->createTextRun($suspension);
            $boldH38->getFont()->setBold(true);
            $worksheet->getCell('H38')->setValue($H38);
            break;

        case ($suspension >= 3.5 && $suspension <= 5.9):
            $I38 = new PHPExcel_RichText();
            $boldI38 = $I38->createTextRun($suspension);
            $boldI38->getFont()->setBold(true);
            $worksheet->getCell('I38')->setValue($I38);
            break;

        case ($suspension == 0):
            $J38 = new PHPExcel_RichText();
            $boldJ38 = $J38->createTextRun($suspension);
            $boldJ38->getFont()->setBold(true);
            $worksheet->getCell('J38')->setValue($J38);
            break;

        default:
            break;
    }

    switch (true) {
        case ($tardiness == 5):
            $F41 = new PHPExcel_RichText();
            $boldF41 = $F41->createTextRun($tardiness);
            $boldF41->getFont()->setBold(true);
            $worksheet->getCell('F41')->setValue($F41);
            break;

        case ($tardiness >= 4.7 && $tardiness <= 4.9):
            $G41 = new PHPExcel_RichText();
            $boldG41 = $G41->createTextRun($tardiness);
            $boldG41->getFont()->setBold(true);
            $worksheet->getCell('G41')->setValue($G41);
            break;

        case ($tardiness >= 4.5 && $tardiness <= 4.7):
            $H41 = new PHPExcel_RichText();
            $boldH41 = $H41->createTextRun($tardiness);
            $boldH41->getFont()->setBold(true);
            $worksheet->getCell('H41')->setValue($H41);
            break;

        case ($tardiness >= 2.9 && $tardiness <= 4.4):
            $I41 = new PHPExcel_RichText();
            $boldI41 = $I41->createTextRun($tardiness);
            $boldI41->getFont()->setBold(true);
            $worksheet->getCell('I41')->setValue($I41);
            break;

        case ($tardiness == 0):
            $J41 = new PHPExcel_RichText();
            $boldJ41 = $J41->createTextRun($tardiness);
            $boldJ41->getFont()->setBold(true);
            $worksheet->getCell('J41')->setValue($J41);
            break;

        default:
            break;
    }

    $A44 = new PHPExcel_RichText();
    $boldA44 = $A44->createTextRun($rate_comment);
    $worksheet->getCell('A44')->setValue($A44);

    $worksheet->getCell('F43')->setValue('=F13 + G13 + H13 + I13 + J13 + F16 + G16 + H16 + I16 + J16 + F19 + G19 + H19 + I19 + J19 +F22 + G22 + H22 + I22 + J22 +F25 + G25 + H25 + I25 + J25 +F28 + G28 + H28 + I28 + J28 +F31 + G31 + H31 + I31 + J31 +F35 + G35 + H35 + I35 + J35 +F38 + G38 + H38 + I38 + J38 +F41 + G41 + H41 + I41 + J41');

    $lookupValue = 'F43';
    $lookupRange = 'E45:F49';
    $columnIndex = 2;
    $rangeLookup = TRUE;
    $vlookupFormula = '=IF(F43>=97, "Excellent", IF(F43>=90, "Very Good", IF(F43>=75, "Good", IF(F43>=60, "Fair", "Poor"))))';

    $worksheet->getCell('G43')->setValue($vlookupFormula);

    $writer = PHPExcel_IOFactory::createWriter($excel_obj, 'Excel2007');
    $writer->save($fileName);

    echo json_encode(['success' => true]);
}
