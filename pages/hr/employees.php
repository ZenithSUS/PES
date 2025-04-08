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
                            </ol>
                        </nav>
                    </div>

                    <div class="d-flex justify-content-end mb-3">

                        <a class="btn btn-success" href="new_employee.php">New Employee</a>

                    </div>

                    <div class="row layout-spacing">
                        <div class="col-lg-12">
                            <div class="statbox widget box box-shadow">
                                <div class="widget-content widget-content-area">
                                    <table id="style-3" class="table style-3 dt-table-hover">
                                        <thead>
                                            <tr>
                                                <th>Employee No.</th>
                                                <th class="text-center">Image</th>
                                                <th>Full Name</th>
                                                <th>Department</th>
                                                <th>Date Hired</th>
                                                <th>Status</th>
                                                <th>Evaluation</th>
                                                <th class="text-center dt-no-sorting">Action</th>
                                            </tr>
                                        </thead>

                                        <tbody id="accountsTable">
                                            <?php
                                            $u = $_SESSION['user_id'];
                                            $filter = $_GET['filter'] ?? null;

                                            if ($filter === "Evaluated") {
                                                $sql = "SELECT * FROM accounts WHERE archived = 0 AND (CURDATE() < STR_TO_DATE(for_eval, '%M %d, %Y') OR CURDATE() > DATE_ADD(STR_TO_DATE(for_eval, '%M %d, %Y'), INTERVAL 2 WEEK)) 
                                                AND (current_eval IS NOT NULL OR current_eval != '')
                                                ORDER BY date_hired DESC;";
                                            } else if ($filter === "NotEvaluated") {
                                                $sql = "SELECT * FROM accounts WHERE archived = 0 AND CURDATE() >= STR_TO_DATE(for_eval, '%M %d, %Y')
                                                    AND CURDATE() <= DATE_ADD(STR_TO_DATE(for_eval, '%M %d, %Y'), INTERVAL 2 WEEK)
                                                    ORDER BY date_hired DESC;";
                                            } else if ($filter === "Employees") {
                                                $sql = "SELECT * FROM accounts WHERE archived = 0 ORDER BY date_hired DESC";
                                            } else if ($filter === "Manager") {
                                                $sql = "SELECT * FROM accounts WHERE archived = 0 AND position = 'Manager' ORDER BY date_hired DESC";
                                            } else if ($filter === "HR") {
                                                $sql = "SELECT * FROM accounts WHERE archived = 0 AND user_level = 1 ORDER BY date_hired DESC";
                                            } else {
                                                $sql = "SELECT * FROM accounts WHERE archived = 0 ORDER BY date_hired DESC";
                                            }


                                            $result = $con->query($sql);
                                            $html = '';

                                            if ($result && $result->num_rows > 0) {
                                                while ($accounts = $result->fetch_assoc()) {
                                                    $forEvalValue = $accounts['for_eval'];
                                                    $accId = $accounts['employee_id'];

                                                    $forEvalDate = null;
                                                    $interval = null;


                                                    try {
                                                        // Get today's date
                                                        $today = new DateTime();

                                                        // Get the for_eval date from the database
                                                        if (!empty($accounts['for_eval'])) {
                                                            // First, try parsing with format "F j, Y" (e.g., "April 2, 2025")

                                                            $forEvalDate = DateTime::createFromFormat('F j, Y', $accounts['for_eval']);

                                                            // If the first attempt fails, try parsing with format "F d, Y" (e.g., "April 02, 2025")
                                                            if (!$forEvalDate) {
                                                                $forEvalDate = DateTime::createFromFormat('F d, Y', $accounts['for_eval']);
                                                            }

                                                            // Ensure the conversion was successful
                                                            if (!$forEvalDate) {
                                                                throw new Exception("Invalid for_eval format");
                                                            }
                                                        } else {
                                                            // If for_eval is empty, calculate it based on date_hired (fallback only)
                                                            if (!empty($accounts['date_hired'])) {
                                                                // Parse the date_hired
                                                                $dateHired = new DateTime($accounts['date_hired']);
                                                                // Set the evaluation date to 5 months + 2 weeks from date_hired
                                                                $forEvalDate = clone $dateHired;
                                                                $forEvalDate->modify('+5 months +2 weeks');
                                                            } else {
                                                                throw new Exception("date_hired is missing");
                                                            }
                                                        }

                                                        // Format the evaluation date properly
                                                        $forEvalValue = $forEvalDate->format('F j, Y');

                                                        // Set evaluation window range (2 weeks after for_eval)
                                                        $evalWindowStart = clone $forEvalDate;
                                                        $evalWindowEnd = clone $forEvalDate;

                                                        $evalWindowEnd->modify('+2 weeks');


                                                        // Check if today is within the evaluation window
                                                        $isInEvalWindow = ($today >= $evalWindowStart && $today <= $evalWindowEnd);

                                                        // Calculate days until evaluation date
                                                        $interval = $today->diff($forEvalDate)->days;

                                                        // Check if the evaluation date is in the past
                                                        $isPastDate = ($today > $forEvalDate);
                                                    } catch (Exception $e) {
                                                        $forEvalDate = null;
                                                        $isInEvalWindow = false;
                                                        $interval = null;
                                                        $isPastDate = false;
                                                        $forEvalValue = "Error: " . $e->getMessage();
                                                    }





                                                    $employeeId = $accounts['employee_id'];
                                                    $checkEvalSql = "SELECT 1 FROM evaluation WHERE evaluator_hr = '$u' AND account_id = '$employeeId' LIMIT 1";
                                                    $evalResult = $con->query($checkEvalSql);

                                                    $evalExists = $evalResult && $evalResult->num_rows > 0;

                                                    if ($evalExists) {
                                                        $buttonClass = 'btn-muted disabled';
                                                        $disabled = 'disabled="disabled"';
                                                        $buttonText = 'Evaluated';
                                                    } elseif ($forEvalDate && !$isInEvalWindow && (!$isPastDate || $interval > 14)) {
                                                        $buttonClass = 'btn-muted disabled';
                                                        $disabled = 'disabled="disabled"';
                                                        $buttonText = 'Evaluate';
                                                    } elseif ($accounts['position'] === 'Administrator') {
                                                        $buttonClass = 'btn-muted disabled';
                                                        $disabled = 'disabled="disabled"';
                                                        $buttonText = 'Administrator';
                                                    } elseif ($accounts['employee_id'] === $u) {
                                                        $buttonClass = 'btn-muted disabled';
                                                        $disabled = 'disabled="disabled"';
                                                        $buttonText = 'Disabled';
                                                    } else {
                                                        $buttonClass = 'btn-info';
                                                        $disabled = '';
                                                        $buttonText = 'Evaluate';
                                                    }

                                                    $html .= '<tr>';
                                                    $html .= '<td>' . htmlspecialchars($accounts['employee_id']) . '</td>';
                                                    $html .= '<td class="text-center"><span><img src="../../api/' . htmlspecialchars($accounts['img']) . '" class="profile-img rounded-circle" alt="avatar"></span></td>';
                                                    $html .= '<td><a class="text-primary" href="employee_profile.php?employee=' . htmlspecialchars($accounts['bio_userid']) . '">' . htmlspecialchars($accounts['first_name']) . ' ' . htmlspecialchars($accounts['middle_name']) . ' ' . htmlspecialchars($accounts['last_name']) . '</a></td>';
                                                    $html .= '<td>' . htmlspecialchars($accounts['department']) . '</td>';
                                                    $html .= '<td>' . htmlspecialchars($accounts['date_hired']) . '</td>';
                                                    $html .= '<td>' . htmlspecialchars($accounts['emp_status']) . '</td>';
                                                    $html .= '<td class=""><i class="badge ' . ($forEvalValue === 'Evaluated' ? 'badge-success' : 'badge-light-dark') . '">' . htmlspecialchars($forEvalValue) . '</i></td>';
                                                    $html .= '<td class="text-center">
                                                <ul class="table-controls">
                                                    <li>
                                                        <a class="btn ' . $buttonClass . '" ' . $disabled . ' data-bs-toggle="modal" data-bs-target="#evalModal" data-id=' . htmlspecialchars($accounts['employee_id']) . ' data-bs-toggle="tooltip" data-bs-placement="top" title="' . $buttonText . '" data-original-title="' . $buttonText . '">' . $buttonText . '</a>
                                                    </li>
                                                </ul>
                                            </td>';
                                                    $html .= '</tr>';
                                                }
                                                echo $html;
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- evaluate modal start -->
                    <div class="modal fade" id="evalModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h6 class="modal-title" id="exampleModalCenterTitle"><b>Evaluation Form</b></h6>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                                            <line x1="18" y1="6" x2="6" y2="18"></line>
                                            <line x1="6" y1="6" x2="18" y2="18"></line>
                                        </svg>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div>
                                        <p>Create the evaluation file for this employee?</p><br>
                                    </div>
                                    <form id="generateEvaluationForm" action="./new_evaluation.php" method="POST">
                                        <input type="hidden" name="empid" id="empid">
                                        <div class="modal-footer">
                                            <button type="submit" id="proceedEval" class="btn btn-info">Proceed</button>
                                            <button type="button" id="cancelDeleteStudent" class="btn btn-light-dark" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- evaluate modal end -->
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
            c3 = $('#style-3').DataTable({
                "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
                    "<'table-responsive'tr>" +
                    "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
                "oLanguage": {
                    "oPaginate": {
                        "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                        "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                    },
                    "sInfo": "Showing page _PAGE_ of _PAGES_",
                    "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                    "sSearchPlaceholder": "Search...",
                    "sLengthMenu": "Results :  _MENU_",
                },
                "stripeClasses": [],
                "lengthMenu": [5, 10, 20, 50],
                "pageLength": 10
            });

            multiCheck(c3);

            document.addEventListener('DOMContentLoaded', function() {

                // document.getElementById('generateEvaluationForm').addEventListener('submit', function(event) {

                //     event.preventDefault();

                //     const formData = new FormData(this);
                //     fetch('./evaluations.php', {
                //     method: 'POST',
                //     body: formData // Sending entire form data
                //     }).then(response => {
                //         if (response.ok) {
                //             // Redirect to new evaluation page after successful form submission
                //             window.location.href = './new_evaluation.php';  
                //         } else {
                //             console.error('Failed to submit the form. Server returned status:', response.status);
                //         }
                //     }).catch(error => {
                //         console.error('Error during form submission:', error);
                //     });

                // });

                // document.getElementById('proceedEval').addEventListener('click', function() {

                //     document.getElementById('generateEvaluationForm').dispatchEvent(new Event('submit'));

                // });

                $('#evalModal').on('show.bs.modal', function(event) {

                    var button = $(event.relatedTarget);
                    var dataId = button.data('id');
                    $('#empid').val(dataId);

                });

            });
        </script>

</body>

</html>