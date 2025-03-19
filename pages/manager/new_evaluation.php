<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>PES | Accounts</title>
    <link rel="icon" type="image/x-icon" href="../../src/assets/img/favicon.ico" />
    <link href="../../layouts/modern-light-menu/css/light/loader.css" rel="stylesheet" type="text/css" />
    <link href="../../layouts/modern-light-menu/css/dark/loader.css" rel="stylesheet" type="text/css" />
    <script src="../../layouts/modern-light-menu/loader.js"></script>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="../../src/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="../../layouts/modern-light-menu/css/light/plugins.css" rel="stylesheet" type="text/css" />
    <link href="../../layouts/modern-light-menu/css/dark/plugins.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    <link href="../../src/plugins/src/apex/apexcharts.css" rel="stylesheet" type="text/css">
    <link href="../../src/assets/css/light/dashboard/dash_1.css" rel="stylesheet" type="text/css" />
    <link href="../../src/assets/css/dark/dashboard/dash_1.css" rel="stylesheet" type="text/css" />


    <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->

    <!-- BEGIN PAGE LEVEL CUSTOM STYLES -->
    <link rel="stylesheet" type="text/css" href="../../src/plugins/src/table/datatable/datatables.css">

    <link rel="stylesheet" type="text/css" href="../../src/plugins/css/light/table/datatable/dt-global_style.css">
    <link rel="stylesheet" type="text/css" href="../../src/plugins/css/light/table/datatable/custom_dt_custom.css">

    <link rel="stylesheet" type="text/css" href="../../src/plugins/css/dark/table/datatable/dt-global_style.css">
    <link rel="stylesheet" type="text/css" href="../../src/plugins/css/dark/table/datatable/custom_dt_custom.css">
    <link href="../../src/assets/css/light/elements/tooltip.css" rel="stylesheet" type="text/css" />
    <link href="../../src/assets/css/dark/elements/tooltip.css" rel="stylesheet" type="text/css" />

    <link href="../../src/assets/css/dark/components/modal.css" rel="stylesheet" type="text/css" />
    <link href="../../src/assets/css/light/components/modal.css" rel="stylesheet" type="text/css" />

    <link href="../../src/plugins/css/light/filepond/custom-filepond.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="../../src/plugins/src/filepond/filepond.min.css">
    <link rel="stylesheet" href="../../src/plugins/src/filepond/FilePondPluginImagePreview.min.css">
    <!-- <link href="https://unpkg.com/filepond/dist/filepond.min.css" rel="stylesheet"> -->
    <!-- <script defer src="https://unpkg.com/filepond/dist/filepond.min.js"></script> -->

    <!-- END PAGE LEVEL CUSTOM STYLES -->

</head>

<body class="layout-boxed">
    <!-- BEGIN LOADER -->
    <div id="load_screen">
        <div class="loader">
            <div class="loader-content">
                <div class="spinner-grow align-self-center"></div>
            </div>
        </div>
    </div>
    <!--  END LOADER -->

    <!--  BEGIN NAVBAR  -->
    <div class="header-container container-xxl">
        <header class="header navbar navbar-expand-sm expand-header">

            <ul class="navbar-item flex-row ms-lg-auto ms-0">

                <?php include('../../components/nav-dropdown.php'); ?>

            </ul>
        </header>
    </div>
    <!--  END NAVBAR  -->

    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="search-overlay"></div>

        <!--  BEGIN SIDEBAR  -->
        <?php include('../../components/side-navigation.php'); ?>
        <!--  END SIDEBAR  -->

        <!--  BEGIN CONTENT AREA  -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">

                <div class="middle-content container-xxl p-0">

                    <div class=" layout-top-spacing">
                        <nav class="breadcrumb-style-five  mb-3" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">Management</li>
                                <li class="breadcrumb-item"><a href="employees.php">Employees</a></li>
                                <li class="breadcrumb-item"><a href="new_employee.php">New Evaluation</a></li>
                            </ol>
                        </nav>
                    </div>

                    <?php

                    $employee_id = $_POST['empid'];
                    $sql = "SELECT * FROM accounts WHERE employee_id = $employee_id";
                    $result = $con->query($sql);

                    if ($result->num_rows > 0) {

                        $employeeData = $result->fetch_assoc();

                        $fullname = $employeeData['first_name'] . " " . $employeeData['middle_name'] . " " . $employeeData['last_name'];
                        $date_hired = $employeeData['date_hired'];
                        $dpt = $employeeData['department'];
                        $pst = $employeeData['position'];
                        $empstat = $employeeData['emp_status'];
                        $current_eval = $employeeData['current_eval'];
                    } else {

                        echo "No employee found with ID: " . $employee_id;
                    }

                    ?>

                    <div class="row layout-spacing">
                        <div class="col-lg-12">
                            <div class="statbox widget box box-shadow">
                                <div class="widget-content widget-content-area p-5">
                                    <form id="evaluationForm">
                                        <div class="col-12">
                                            <p id="course-error" class="text-light w-100 badge badge-danger mt-2 mb-2"></p>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-12">
                                                <p>Evaluator: <b><?php echo $userFirstname . $userLastname ?></b></p>
                                                <?php

                                                if ($_SESSION['role'] == 1) {
                                                    echo '<p>Position: <b>Human Resource</b></p>';
                                                } else if ($_SESSION['role'] == 2) {
                                                    echo '<p>Position: <b>Manager</b></p>';
                                                    echo '<p>Department:<b> ' . $_SESSION['department'] . '</b></p>';
                                                } else {
                                                    echo '<p>Position: <b>Administrator</b></p>';
                                                }

                                                ?>
                                            </div>
                                        </div>

                                        <div class="container mt-4">
                                            <div class="row mb-2">
                                                <h4>Employee Violations</h4>
                                            </div>
                                            <table class="table table-bordered table-hover" id="violationTable">
                                                <thead class="table-info">
                                                    <tr>
                                                        <th scope="col">Violation</th>
                                                        <th scope="col">Date</th>
                                                        <th scope="col">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    // Fetch violation data for the employee
                                                    $violationSql = " SELECT uv.*, hvl.violation_title 
                                                    FROM user_violations uv JOIN hr_violation_list hvl ON uv.violation_id = hvl.violation_id WHERE uv.employee_id = ? ORDER BY uv.vdate DESC";
                                                    $violationStmt = $con->prepare($violationSql);
                                                    $violationStmt->bind_param("s", $employee_id);
                                                    $violationStmt->execute();
                                                    $violationResult = $violationStmt->get_result();
                                                    $violations = [];
                                                    while ($violation = $violationResult->fetch_assoc()) {
                                                        $violations[] = $violation;
                                                    }
                                                    if (!empty($violations)): ?>
                                                        <?php foreach ($violations as $violation): ?>
                                                            <tr>
                                                                <td><?php echo htmlspecialchars($violation['violation_title']); ?></td>
                                                                <td><?php echo htmlspecialchars($violation['vdate']); ?></td>
                                                                <td><?php echo htmlspecialchars($violation['status']); ?></td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    <?php else: ?>
                                                        <tr>
                                                            <td colspan="3" class="text-center">No violations found</td>
                                                        </tr>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="row mb-4">
                                            <div class="col-12">
                                                <label for="eval_name">
                                                    <p>Employee Name</p>
                                                </label>
                                                <input type="text" class="form-control text-dark" name="eval_name" id="eval_name" value="<?php echo $fullname ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-3">
                                                <label for="lastname">
                                                    <p>Date Hired</p>
                                                </label>
                                                <input id="" class="form-control text-dark" name="eval_hired" type="text" value="<?php echo $date_hired ?>" readonly>
                                            </div>
                                            <div class="col-3">
                                                <label for="lastname">
                                                    <p>Department</p>
                                                </label>
                                                <input id="" class="form-control text-dark" name="eval_dept" type="text" value="<?php echo $dpt ?>" readonly>
                                            </div>
                                            <div class="col-3">
                                                <label for="lastname">
                                                    <p>Position</p>
                                                </label>
                                                <input id="" class="form-control text-dark" name="eval_pos" type="text" value="<?php echo $pst ?>" readonly>
                                            </div>
                                            <div class="col-3">
                                                <label for="lastname">
                                                    <p>Employment Status</p>
                                                </label>
                                                <input id="" class="form-control text-dark" name="eval_empstat" type="text" value="<?php echo $empstat ?>" readonly>
                                            </div>
                                        </div>
                                        <table class="table table-bordered table-hover" id="managerEvaluation">
                                            <thead class="table-info">
                                                <tr>
                                                    <th scope="col">Criteria</th>
                                                    <th scope="col">Weight</th>
                                                    <th scope="col">Rating</th>
                                                    <th scope="col">Remarks</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr hidden>
                                                    <td>1. PRODUCTIVITY</td>
                                                    <td><b class="text-info">15%</b></td>
                                                    <td>
                                                        <input id="current_eval" class="form-control text-dark" name="" type="text" value="<?php echo $current_eval ?>">
                                                    </td>
                                                    <td>
                                                        <p id="zzz"></p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>1. PRODUCTIVITY</td>
                                                    <td><b class="text-info">15%</b></td>
                                                    <td>
                                                        <input id="productivity" class="form-control text-dark" min="0" max="15" oninput="limitValue(this, 15); updateRating(this.value, 'prodRate', 15);" name="eval_productivity" type="number" step="0.01" data-bs-toggle="popover" data-bs-trigger="focus" data-bs-placement="right" data-bs-content="EXCELLENT: 15-14.5<br>VERY GOOD: 14.4-13.9<br>GOOD: 13.8-12<br>FAIR: 11.9-11.5<br>POOR: 11.4-0">
                                                    </td>
                                                    <td>
                                                        <p id="prodRate"></p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>2. KNOWLEDGE OF WORK</td>
                                                    <td><b class="text-info">15%</b></td>
                                                    <td>
                                                        <input id="knowledge" class="form-control text-dark" min="0" max="15" oninput="limitValue(this, 15); updateRating(this.value, 'knowRate', 15);" name="eval_knowledge" type="number" step="0.01" data-bs-toggle="popover" data-bs-trigger="focus" data-bs-placement="right" data-bs-content="EXCELLENT: 15-14.5<br>VERY GOOD: 14.4-13.9<br>GOOD: 13.8-12<br>FAIR: 11.9-11.5<br>POOR: 11.4-0">
                                                    </td>
                                                    <td>
                                                        <p id="knowRate"></p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>3. QUALITY OF WORK</td>
                                                    <td><b class="text-info">15%</b></td>
                                                    <td>
                                                        <input id="quality" class="form-control text-dark" min="0" max="15" oninput="limitValue(this, 15); updateRating(this.value, 'qualRate', 15);" name="eval_quality" type="number" step="0.01" data-bs-toggle="popover" data-bs-trigger="focus" data-bs-placement="right" data-bs-content="EXCELLENT: 15-14.5<br>VERY GOOD: 14.4-13.9<br>GOOD: 13.8-12<br>FAIR: 11.9-11.5<br>POOR: 11.4-0">
                                                    </td>
                                                    <td>
                                                        <p id="qualRate"></p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>4. INITIATIVE</td>
                                                    <td><b class="text-info">10%</b></td>
                                                    <td>
                                                        <input id="initiative" class="form-control text-dark" min="0" max="10" oninput="limitValue(this, 10); updateRating(this.value, 'initRate', 10);" name="eval_initiative" type="number" step="0.01" data-bs-toggle="popover" data-bs-trigger="focus" data-bs-placement="right" data-bs-content="EXCELLENT: 10-9.5<br>VERY GOOD: 9.4-9<br>GOOD: 8.9-8<br>FAIR: 7.9-7.5<br>POOR: 7.4-0">
                                                    </td>
                                                    <td>
                                                        <p id="initRate"></p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>5. WORK ATTITUDE</td>
                                                    <td><b class="text-info">10%</b></td>
                                                    <td>
                                                        <input id="workAttitude" class="form-control text-dark" min="0" max="10" oninput="limitValue(this, 10); updateRating(this.value, 'attitudeRate', 10);" name="eval_work_attitude" type="number" step="0.01" data-bs-toggle="popover" data-bs-trigger="focus" data-bs-placement="right" data-bs-content="EXCELLENT: 10-9.5<br>VERY GOOD: 9.4-9<br>GOOD: 8.9-8<br>FAIR: 7.9-7.5<br>POOR: 7.4-0">
                                                    </td>
                                                    <td>
                                                        <p id="attitudeRate"></p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>6. COMMUNICATION</td>
                                                    <td><b class="text-info">5%</b></td>
                                                    <td>
                                                        <input id="communication" class="form-control text-dark" min="0" max="5" oninput="limitValue(this, 5); updateRating(this.value, 'commRate', 5);" name="eval_communication" type="number" step="0.01" data-bs-toggle="popover" data-bs-trigger="focus" data-bs-placement="right" data-bs-content="EXCELLENT: 5<br>VERY GOOD: 4.9-4.5<br>GOOD: 4.4-4<br>FAIR: 3.9-3.5<br>POOR: 3.4-0">
                                                    </td>
                                                    <td>
                                                        <p id="commRate"></p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>7. CREATIVITY</td>
                                                    <td><b class="text-info">5%</b></td>
                                                    <td>
                                                        <input id="creativity" class="form-control text-dark" min="0" max="5" oninput="limitValue(this, 5); updateRating(this.value, 'creativityRate', 5);" name="eval_creativity" type="number" step="0.01" data-bs-toggle="popover" data-bs-trigger="focus" data-bs-placement="right" data-bs-content="EXCELLENT: 5<br>VERY GOOD: 4.9-4.5<br>GOOD: 4.4-4<br>FAIR: 3.9-3.5<br>POOR: 3.4-0">
                                                    </td>
                                                    <td>
                                                        <p id="creativityRate"></p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Rater's Comment</td>
                                                    <td colspan="4">
                                                        <textarea id="rate_comment" class="form-control text-dark" name="rate_comment" rows="4" style="resize: none;" placeholder="Write a brief comment about the employee"></textarea>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                </div>
                                <!--  -->
                                <div class="container mt-4">
                                    <div class="row mb-2">
                                        <h4>Human Resource Evaluation</h4>
                                    </div>
                                    <!--  -->
                                    <table class="table table-bordered table-hover" id="hrEvaluation">
                                        <thead class="table-info">
                                            <tr>
                                                <th scope="col">Criteria</th>
                                                <th scope="col">Weight</th>
                                                <th scope="col">Rating</th>
                                                <th scope="col">Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><i>ABSENCES</i></td>
                                                <td><b class="text-info">10%</b></td>
                                                <td>
                                                    <input id="hr_initiative" class="form-control text-dark" name="eval_hr_initiative" type="number" step="0.01" onkeyup="scale10()">
                                                </td>
                                                <td>
                                                    <p id="hrInitRate"> </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><i>SUSPENSION / DISCIPLINARY ACTION</i></td>
                                                <td><b class="text-info">10%</b></td>
                                                <td>
                                                    <input id="hr_workAttitude" class="form-control text-dark" name="eval_hr_work_attitude" type="number" step="0.01" onkeyup="scale10()">
                                                </td>
                                                <td>
                                                    <p id="hrAttitudeRate"> </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><i>TARDINESS / UNDERTIME</i></td>
                                                <td><b class="text-info">5%</b></td>
                                                <td>
                                                    <input id="hr_communication" class="form-control text-dark" name="eval_hr_communication" type="number" step="0.01" onkeyup="scale5()">
                                                </td>
                                                <td>
                                                    <p id="hrCommRate"> </p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                </form>

                                <div class="modal-footer mt-4">
                                    <button type="submit" class="btn btn-success m-3" id="submitEvaluation">Submit Evaluation</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <!--  BEGIN FOOTER  -->
        <div class="footer-wrapper">
            <div class="footer-section f-section-1">
                <p class="">Copyright © <span class="dynamic-year">2022</span> <a target="_blank" href="https://designreset.com/cork-admin/">DesignReset</a>, All rights reserved.</p>
            </div>
            <div class="footer-section f-section-2">
                <p class="">Coded with <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                    </svg></p>
            </div>
        </div>
        <!--  END FOOTER  -->
    </div>
    <!--  END CONTENT AREA  -->
    </div>
    <!-- END MAIN CONTAINER -->
    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="../../src/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../src/plugins/src/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../../src/plugins/src/mousetrap/mousetrap.min.js"></script>
    <script src="../../src/plugins/src/waves/waves.min.js"></script>
    <script src="../../src/plugins/src/global/vendors.min.js"></script>
    <script src="../../src/plugins/src/highlight/highlight.pack.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
    <script src="../../src/plugins/src/table/datatable/datatables.js"></script>
    <script src="../../src/assets/js/custom.js"></script>
    <script src="../../src/plugins/src/filepond/filepond.min.js"></script>
    <script src="../../src/plugins/src/filepond/FilePondPluginFileValidateType.min.js"></script>
    <script src="../../src/plugins/src/filepond/FilePondPluginImageExifOrientation.min.js"></script>
    <script src="../../src/plugins/src/filepond/FilePondPluginImagePreview.min.js"></script>
    <script src="../../src/plugins/src/filepond/FilePondPluginImageCrop.min.js"></script>
    <script src="../../src/plugins/src/filepond/FilePondPluginImageResize.min.js"></script>
    <script src="../../src/plugins/src/filepond/FilePondPluginImageTransform.min.js"></script>
    <script src="../../src/plugins/src/filepond/filepondPluginFileValidateSize.min.js"></script>


    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->

    <script>
        const userRole = <?php echo $_SESSION['role']; ?>;
        const user_to_eval = <?php echo $employee_id ?>;


        document.addEventListener('DOMContentLoaded', function() {

            const evaluationForm = document.getElementById('evaluationForm');
            const submitButton = document.getElementById('submitEvaluation');

            evaluationForm.addEventListener('submit', function(event) {

                event.preventDefault();

                submitButton.disabled = true;

                const formData = new FormData(evaluationForm);
                const productivity = document.getElementById('productivity').value;
                const knowledge = document.getElementById('knowledge').value;
                const quality = document.getElementById('quality').value;
                const initiative = document.getElementById('initiative').value;
                const attitude = document.getElementById('workAttitude').value;
                const communication = document.getElementById('communication').value;
                const creativity = document.getElementById('creativity').value;
                const current_eval = document.getElementById('current_eval').value;
                const rate_comment = document.getElementById('rate_comment').value;

                formData.append('productivity', productivity);
                formData.append('knowledge', knowledge);
                formData.append('quality', quality);
                formData.append('initiative', initiative);
                formData.append('attitude', attitude);
                formData.append('communication', communication);
                formData.append('creativity', creativity);
                formData.append('user_to_eval', user_to_eval);

                evalRole = "Manager";

                alert(current_eval);

                insertMgrEvaluation(current_eval, evalRole, productivity, knowledge, quality, initiative, attitude, communication, creativity, rate_comment, user_to_eval);

            });

            submitButton.addEventListener('click', function() {

                evaluationForm.dispatchEvent(new Event('submit'));

            });

        });

        async function insertMgrEvaluation(fileName, evalRole, productivity, knowledge, quality, initiative, attitude, communication, creativity, rate_comment, user_to_eval) {

            const formData = new FormData();

            formData.append('fileName', fileName);
            formData.append('eval_role', evalRole);
            formData.append('productivity', productivity);
            formData.append('knowledge', knowledge);
            formData.append('quality', quality);
            formData.append('initiative', initiative);
            formData.append('attitude', attitude);
            formData.append('communication', communication);
            formData.append('creativity', creativity);
            formData.append('rate_comment', rate_comment);
            formData.append('user_to_eval', user_to_eval);


            fetch('../../api/editForm.php', {
                    method: 'POST',
                    body: formData,
                })
                .then(response => {
                    console.log('Response status:', response.status);
                    return response.text();
                })
                .then(data => {
                    let jsonResponse;
                    try {
                        jsonResponse = JSON.parse(data);
                        alert('Employee Evaluated:');
                        window.location.href = 'employees.php';
                    } catch (error) {
                        console.error("There is something wrong:", error)
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    alert(`An error occurred: ${error.message}. Please check the console for details.`);
                });

        }


        window.onload = function() {
            if (userRole !== 2) {
                disableInputs('#managerEvaluation');
            }
            if (userRole !== 1) {
                disableInputs('#hrEvaluation');
            }
            if (userRole !== 1 && userRole !== 2) {
                disableInputs('#managerEvaluation');
                disableInputs('#hrEvaluation');
            }
        };

        function disableInputs(tableSelector) {
            const inputs = document.querySelectorAll(`${tableSelector} input[type="number"]`);
            inputs.forEach(input => {
                input.disabled = true;
            });
        }

        function scale15() {
            let productivity = document.getElementById('productivity').value;
            let knowledge = document.getElementById('knowledge').value;
            let quality = document.getElementById('quality').value;

            updateRating(productivity, 'prodRate', 15);
            updateRating(knowledge, 'knowRate', 15);
            updateRating(quality, 'qualRate', 15);
        }

        function scale10() {
            let initiative = document.getElementById('initiative').value;
            let workAttitude = document.getElementById('workAttitude').value;

            updateRating(initiative, 'initRate', 10);
            updateRating(workAttitude, 'attitudeRate', 10);
        }

        function scale5() {
            let communication = document.getElementById('communication').value;
            let creativity = document.getElementById('creativity').value;

            updateRating(communication, 'commRate', 5);
            updateRating(creativity, 'creativityRate', 5);
        }

        // Initialize Bootstrap popovers
        document.addEventListener('DOMContentLoaded', function() {
            var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
            var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
                return new bootstrap.Popover(popoverTriggerEl, {
                    html: true, // Allow HTML content
                    trigger: 'focus', // Show on focus
                });
            });
        });

        function updateRating(value, rateId, scale) {
            let rateText = '';
            let color = '';
            value = parseFloat(value);

            if (scale === 15) {
                if (value >= 14.5 && value <= 15) {
                    rateText = 'Excellent';
                    color = 'green';
                } else if (value >= 13.9 && value <= 14.4) {
                    rateText = 'Very Good';
                    color = 'blue';
                } else if (value >= 12 && value <= 13.8) {
                    rateText = 'Good';
                    color = 'deepskyblue';
                } else if (value >= 11.5 && value <= 11.9) {
                    rateText = 'Fair';
                    color = 'orange';
                } else if (value <= 11.4) {
                    rateText = 'Poor';
                    color = 'red';
                }
            } else if (scale === 10) {
                if (value >= 9.5 && value <= 10) {
                    rateText = 'Excellent';
                    color = 'green';
                } else if (value >= 9 && value <= 9.4) {
                    rateText = 'Very Good';
                    color = 'blue';
                } else if (value >= 8 && value <= 8.9) {
                    rateText = 'Good';
                    color = 'deepskyblue';
                } else if (value >= 7.5 && value <= 7.9) {
                    rateText = 'Fair';
                    color = 'orange';
                } else if (value <= 7.4) {
                    rateText = 'Poor';
                    color = 'red';
                }
            } else if (scale === 5) {
                if (value == 5) {
                    rateText = 'Excellent';
                    color = 'green';
                } else if (value >= 4.5 && value <= 4.9) {
                    rateText = 'Very Good';
                    color = 'blue';
                } else if (value >= 4 && value <= 4.4) {
                    rateText = 'Good';
                    color = 'deepskyblue';
                } else if (value >= 3.5 && value <= 3.9) {
                    rateText = 'Fair';
                    color = 'orange';
                } else if (value <= 3.4) {
                    rateText = 'Poor';
                    color = 'red';
                }
            }

            let rateElement = document.getElementById(rateId);
            rateElement.textContent = rateText;
            rateElement.style.color = color;
        }

        function limitValue(input, max) {
            if (input.value > max) {
                input.value = max;
            } else if (input.value < 0) {
                input.value = 0;
            }
        }
    </script>

</body>

</html>