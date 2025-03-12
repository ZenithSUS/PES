<?php

include '../api/database.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_GET['action'])) {
        switch ($_GET['action']) {
            case 'getActivities':
                $sec = $_GET['section'];
                getActivities($con, $sec);
                break;
            case 'getLectures':
                $sec = $_GET['section'];
                getLectures($con, $sec);
                break;
            case 'getQuestions':
                $id = $_GET['id'];
                getQuestions($con, $id);
                break;
            case 'checkRecordExists':
                $aid = $_GET['aid'];
                $sid = $_GET['sid'];
                checkRecordExists($con, $aid, $sid);
                break;
            default:
                echo json_encode(['error' => 'Invalid action']);
                break;
        }
    } else {
        echo json_encode(['error' => 'No action specified']);
    }
} else {
    echo json_encode(['error' => 'Invalid request method']);
}

$con->close();

// function checkRecordExists($con, $aid, $sid) {
//     $sql = "SELECT * FROM records WHERE activity_id = ? AND student_id = ?";
//     if ($stmt = $con->prepare($sql)) {
//         $stmt->bind_param("ii", $aid, $sid);
//         $stmt->execute();
//         $result = $stmt->get_result();
//         if ($result && $result->num_rows > 0) {
//             echo json_encode(['exist' => 'You already taken this assessment test']); // iwant to add to the response is score column and the percentage column from records
//         } else {
//             echo json_encode(['nrec' => 'No Record/s']);
//         }
//         $stmt->close();
//     } else {
//         echo json_encode(['error' => 'Failed to prepare the statement: ' . $con->error]);
//     }
// }

function checkRecordExists($con, $aid, $sid) {
    $sql = "SELECT * FROM records WHERE activity_id = ? AND student_id = ?";
    if ($stmt = $con->prepare($sql)) {
        $stmt->bind_param("ii", $aid, $sid);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result && $result->num_rows > 0) {
            // Fetch the row
            $row = $result->fetch_assoc();
            $response = [
                'exist' => 'You have already taken this assessment test',
                'score' => $row['score'],
                'items' => $row['items'],
                'percentage' => $row['percentage']
            ];
            echo json_encode($response);
        } else {
            echo json_encode(['nrec' => 'No Record/s']);
        }
        
        $stmt->close();
    } else {
        echo json_encode(['error' => 'Failed to prepare the statement: ' . $con->error]);
    }
}

function getQuestions($con, $activity_id) {
    $sql = "SELECT q.question_id, q.question_text, c.choice_id, c.choice_text, c.is_correct
            FROM questions q
            LEFT JOIN choices c ON q.question_id = c.question_id
            WHERE q.activity_id = ?";
    if ($stmt = $con->prepare($sql)) {
        $stmt->bind_param("i", $activity_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result && $result->num_rows > 0) {
            $questions = [];
            while ($row = $result->fetch_assoc()) {
                $question_id = $row['question_id'];
                if (!isset($questions[$question_id])) {
                    $questions[$question_id] = [
                        'questionId' => $row['question_id'],
                        'questionText' => $row['question_text'],
                        'choices' => []
                    ];
                }
                if ($row['choice_id']) {
                    $questions[$question_id]['choices'][] = [
                        'choiceId' => $row['choice_id'],
                        'choiceText' => $row['choice_text'],
                        'isCorrect' => $row['is_correct']
                    ];
                }
            }
            echo json_encode(array_values($questions));
        } else {
            echo json_encode([]);
        }
        $stmt->close();
    } else {
        echo json_encode(['error' => 'Failed to prepare the statement: ' . $con->error]);
    }
}

function getActivities($con, $sec) {
    $sql = "SELECT sections.*, activities.*
            FROM activities 
            LEFT JOIN sections ON sections.section_id = activities.section_id
            WHERE activities.section_id = ? AND status = 0";
    if ($stmt = $con->prepare($sql)) {
        $stmt->bind_param("i", $sec);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result && $result->num_rows > 0) {
            $act = [];
            while ($row = $result->fetch_assoc()) {
                $act[] = [
                    'activity_id' => $row['activity_id'],
                    'activity_name' => $row['activity_name'],
                    'section_name' => $row['section_name'],
                    'section_id' => $row['section_id'],
                    'status' => $row['status'],
                ];
            }
            echo json_encode($act);
        } else {
            echo json_encode([]);
        }
        $stmt->close();
    } else {
        echo json_encode(['error' => 'Failed to prepare the statement: ' . $con->error]);
    }
}

function getLectures($con, $sec) {
    $sql = "SELECT sections.*, lectures.*
            FROM lectures 
            LEFT JOIN sections ON sections.section_id = lectures.section_id
            WHERE lectures.section_id = ?";
    if ($stmt = $con->prepare($sql)) {
        $stmt->bind_param("i", $sec);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result && $result->num_rows > 0) {
            $lec = [];
            while ($row = $result->fetch_assoc()) {
                $lec[] = [
                    'lecture_id' => $row['lecture_id'],
                    'lecture_name' => $row['lecture_name'],
                    'fileType' => $row['fileType'],
                    'section_id' => $row['section_id'],
                    'section_name' => $row['section_name'],
                    'status' => $row['status'],
                    'file' => $row['file'],
                    'imgType' => isset($row['imgType']) ? $row['imgType'] : '',
                    'imageFile' => isset($row['imageFile']) ? base64_encode($row['imageFile']) : '',
                ];
            }
            echo json_encode($lec);
        } else {
            echo json_encode([]);
        }
        $stmt->close();
    } else {
        echo json_encode(['error' => 'Failed to prepare the statement: ' . $con->error]);
    }
}
?>