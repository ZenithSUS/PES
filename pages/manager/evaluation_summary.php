<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>PES | Evaluation Summary</title>
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
                                <li class="breadcrumb-item"><a href="">Evaluation</a></li>
                                <li class="breadcrumb-item"><a href="evaluation_summary.php">Evaluation Summary</a></li>
                            </ol>
                        </nav>
                    </div>

                    <div class="d-flex justify-content-between mb-3">
                        <div class="d-flex items-center gap-2 justify-center">
                            <h4 class="mb-0 mt-1">Filter:</h4>
                            <button id="filterByNoManagerBtn" class="btn btn-primary" onclick="filterTableByManagerRating('no_manager')">No Manager Rating</button>
                            <button id="filterByAllBtn" class="btn btn-primary" onclick="filterTableByManagerRating('all')">Show All</button>
                        </div>
                        <button type="button" id="exportExcel" class="btn btn-success btn-block">Export to Excel</button>

                    </div>

                    <div class="row layout-spacing">
                        <div class="col-lg-12">
                            <div class="statbox widget box box-shadow">
                                <div class="widget-content widget-content-area">
                                    <table id="style-3" class="table style-3 dt-table-hover">
                                        <thead>
                                            <tr>
                                                <th>Employee No.</th>
                                                <th>Full Name</th>
                                                <th>Department</th>
                                                <th>Position</th>
                                                <th>Date of Appraisal</th>
                                                <th>Manager</th>
                                                <th>Rating</th>
                                                <th>HR Rating</th>
                                                <th>Manager Rating</th>
                                                <th>Remark</th>
                                            </tr>
                                        </thead>

                                        <tbody id="accountsTable">
                                            <?php
                                            // Get the logged-in user's ID
                                            $uss = $_SESSION['user_id'];

                                            // Fetch the department of the logged-in user (manager)
                                            $managerDeptQuery = "SELECT department FROM accounts WHERE employee_id = $uss AND user_level = 2;";
                                            $managerDeptResult = $con->query($managerDeptQuery);

                                            if ($managerDeptResult && $managerDeptResult->num_rows > 0) {
                                                $managerDept = $managerDeptResult->fetch_assoc();
                                                $managerDepartment = $managerDept['department']; // Get the manager's department

                                                // Fetch employees from the manager's department
                                                $sql = "SELECT 
                                                employee.first_name AS employee_first_name, 
                                                employee.middle_name AS employee_middle_name, 
                                                employee.last_name AS employee_last_name, 
                                                employee.department AS employee_department, 
                                                employee.employee_id AS employee_id, 
                                                employee.bio_userid AS bio_userid,
                                                employee.position AS employee_position,
                                                evaluation.evaluation_date,
                                           CASE
                                                WHEN employee.position IN ('Manager', 'Supervisor') OR employee.department = 'Human Resource' THEN 'N/A'
                                                ELSE evaluator.first_name
                                            END AS evaluator_first_name,
                                            CASE
                                                WHEN employee.position IN ('Manager', 'Supervisor') OR employee.department = 'Human Resource' THEN NULL
                                                ELSE COALESCE(evaluator.middle_name, '')
                                            END AS evaluator_middle_name,
                                            CASE
                                                WHEN employee.position IN ('Manager', 'Supervisor') OR employee.department = 'Human Resource' THEN NULL
                                                ELSE evaluator.last_name
                                            END AS evaluator_last_name,
                                            CASE
                                                WHEN employee.position IN ('Manager', 'Supervisor') OR employee.department = 'Human Resource' THEN NULL
                                                    ELSE evaluator.bio_userid
                                                END AS evaluator_bio_userid,
                                                evaluator.department AS evaluator_department,
                                                evaluator.position AS evaluator_position,
                                                summ.rating,
                                                summ.hr_rating,
                                                summ.manager_rating
                                            FROM evaluation
                                            JOIN accounts AS employee ON evaluation.account_id = employee.employee_id
                                            JOIN eval_summary AS summ ON evaluation.account_id = summ.user_id
                                            LEFT JOIN accounts AS evaluator ON evaluator.department = employee.department 
                                                AND evaluator.user_level = 2
                                            WHERE employee.department = '$managerDepartment' AND employee.position != 'Supervisor' AND employee.employee_id != '$uss'
                                            GROUP BY employee.employee_id,
                                                    evaluation.evaluation_date;";

                                                $result = $con->query($sql);
                                                $html = '';

                                                if ($result && $result->num_rows > 0) {
                                                    while ($accounts = $result->fetch_assoc()) {

                                                        $rating = (int)$accounts['rating'];

                                                        // Adjust remarks logic for Manager Evaluation (0-75 scale)
                                                        if ($rating >= 97 && $rating <= 100) {
                                                            $remark = "Excellent";
                                                        } elseif ($rating >= 90 && $rating <= 96) {
                                                            $remark = "Very Good";
                                                        } elseif ($rating >= 75 && $rating <= 89) {
                                                            $remark = "Good";
                                                        } elseif ($rating >= 60 && $rating <= 74) {
                                                            $remark = "Fair";
                                                        } else {
                                                            $remark = "Poor";
                                                        }

                                                        $html .= '<tr>';
                                                        $html .= '<td>' . htmlspecialchars($accounts['employee_id']) . '</td>';
                                                        $html .= '<td><a class="">' . htmlspecialchars($accounts['employee_first_name']) . ' ' . htmlspecialchars($accounts['employee_middle_name']) . ' ' . htmlspecialchars($accounts['employee_last_name']) . '</a></td>';
                                                        $html .= '<td>' . htmlspecialchars($accounts['employee_department']) . '</td>';
                                                        $html .= '<td>' . htmlspecialchars($accounts['employee_position']) . '</td>';
                                                        $html .= '<td>' . htmlspecialchars($accounts['evaluation_date']) . '</td>';
                                                        $html .= '<td><a class="">' . htmlspecialchars($accounts['evaluator_first_name']) . ' ' . htmlspecialchars($accounts['evaluator_middle_name']) . ' ' . htmlspecialchars($accounts['evaluator_last_name']) . '</a></td>';
                                                        $html .= '<td>' . htmlspecialchars($accounts['rating']) . '</td>';
                                                        $html .= '<td>' . htmlspecialchars($accounts['hr_rating'] !== NULL ? $accounts['hr_rating'] : "N/A") . '</td>';
                                                        $html .= '<td>' . htmlspecialchars($accounts['manager_rating'] !== NULL ? $accounts['manager_rating'] : "N/A") . '</td>';
                                                        $html .= '<td>' . htmlspecialchars($remark) . '</td>';
                                                        $html .= '</tr>';
                                                    }
                                                    echo $html;
                                                } else {
                                                    echo '<tr><td colspan="10" class="text-center">No records found for the ' . htmlspecialchars($managerDepartment) . ' department.</td></tr>';
                                                }
                                            } else {
                                                echo '<tr><td colspan="10" class="text-center">You are not assigned as a manager for any department.</td></tr>';
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
                <!-- <div class="footer-wrapper">
                    <div class="footer-section f-section-1">
                        <p class="">Copyright © <span class="dynamic-year">2022</span> <a target="_blank" href="https://designreset.com/cork-admin/">DesignReset</a>, All rights reserved.</p>
                    </div>
                    <div class="footer-section f-section-2">
                        <p class="">Coded with <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart">
                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                            </svg></p>
                    </div>
                </div> -->
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

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

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
                "lengthMenu": [
                    [5, 10, 20, 50, -1],
                    [5, 10, 20, 50, "All"]
                ],
                "pageLength": 10
            });

            multiCheck(c3);


            document.getElementById("exportExcel").addEventListener("click", function() {
                let table = document.getElementById("style-3");
                let ws = XLSX.utils.table_to_sheet(table);
                let wb = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(wb, ws, "Evaluation Summary");

                XLSX.writeFile(wb, "Evaluation_Summary.xlsx");
            });

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

                // 

                $('#evalModal').on('show.bs.modal', function(event) {

                    var button = $(event.relatedTarget);
                    var dataId = button.data('id');
                    $('#empid').val(dataId);

                });

            });

            function filterTableByManagerRating(filterType) {
            var table = $('#style-3').DataTable();
            const filterByNoManagerBtn = document.getElementById('filterByNoManagerBtn');
            const filterByAllBtn = document.getElementById('filterByAllBtn');

            filterByNoManagerBtn.classList.remove('active', 'btn-success');
            filterByNoManagerBtn.classList.add('btn-primary');
            
            
            filterByAllBtn.classList.remove('active', 'btn-success');
            filterByAllBtn.classList.add('btn-primary');

            if (filterType === 'no_manager') {
                // Filter rows where Manager Rating column (index 7) is 'N/A' or empty
                table.column(7).search('^(N/A|)$', true, false).draw();
                filterByNoManagerBtn.classList.remove('btn-primary');
                filterByNoManagerBtn.classList.add('btn-success', 'active');
                
            } else {
                // Clear all filters
                table.search('').columns().search('').draw();
                filterByAllBtn.classList.remove('btn-primary');
                filterByAllBtn.classList.add('btn-success', 'active');
            }
        }
        </script>

</body>

</html>