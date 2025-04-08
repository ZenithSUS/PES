<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>PES | Violations</title>
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
                                <li class="breadcrumb-item"><a href="employees.php">Violations List</a></li>
                            </ol>
                        </nav>
                    </div>

                    <div class="d-flex justify-content-end mb-3">

                        <!-- <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addTeacherModal">New Employee</button> -->
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addViolationModal">Add Violation</button>

                    </div>

                    <div class="row layout-spacing">
                        <div class="col-lg-12">
                            <div class="statbox widget box box-shadow">
                                <div class="widget-content widget-content-area">
                                    <table id="style-3" class="table style-3 dt-table-hover">
                                        <thead>
                                            <tr>
                                                <th>Violation</th>
                                                <th>Description</th>
                                                <th class="text-center dt-no-sorting">Action</th>
                                            </tr>
                                        </thead>

                                        <tbody id="accountsTable">
                                            <?php
                                            $u = $_SESSION['user_id'];

                                            $sql = "SELECT * FROM hr_violation_list";
                                            $result = $con->query($sql);
                                            $html = '';

                                            if ($result && $result->num_rows > 0) {
                                                while ($accounts = $result->fetch_assoc()) {

                                                    $html .= '<tr>';
                                                    $html .= '<td>' . htmlspecialchars($accounts['violation_title']) . '</td>';
                                                    $html .= '<td>' . htmlspecialchars($accounts['violation_desc']) . '</td>';
                                                    $html .= '<td class="text-center">
                                                                    <ul class="table-controls">
                                                                        <li>
                                                                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="' . $accounts['violation_id'] . '">
                                                                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                                                    <line x1="10" y1="11" x2="10" y2="17"></line>
                                                                                    <line x1="14" y1="11" x2="14" y2="17"></line>
                                                                                </svg>
                                                                            </a>
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

                    <?php
                    // Fetch all users with violations and their descriptions
                    $violationSql = "
                        SELECT a.employee_id, a.first_name, a.last_name, a.department, a.position, 
                        COUNT(uv.violation_id) AS violation_count,
                        GROUP_CONCAT(hvl.violation_title SEPARATOR ', ') AS violation_descriptions,
                        GROUP_CONCAT(uv.sanction SEPARATOR ', ') AS sanctions
                        FROM accounts a
                        LEFT JOIN user_violations uv ON a.employee_id = uv.employee_id
                        LEFT JOIN hr_violation_list hvl ON uv.violation_id = hvl.violation_id
                        WHERE uv.violation_id IS NOT NULL
                        GROUP BY a.employee_id, a.first_name, a.last_name, a.department, a.position
                        ORDER BY violation_count DESC
                    ";
                    $violationResult = $con->query($violationSql);
                    $usersWithViolations = [];
                    while ($row = $violationResult->fetch_assoc()) {
                        $usersWithViolations[] = $row;
                    }
                    ?>

                    <div class="row layout-spacing">
                        <div class="col-lg-12">
                            <div class="statbox widget box box-shadow">
                                <div class="widget-content widget-content-area">
                                    <h4 class="badge badge-secondary fs-6">Users with Violations</h4>
                                    <table id="style-4" class="table style-4 dt-table-hover">
                                        <thead>
                                            <tr>
                                                <th>Employee ID</th>
                                                <th>Name</th>
                                                <th>Department</th>
                                                <th>Position</th>
                                                <th>Violation Count</th>
                                                <th>Violation Descriptions</th>
                                                <th>Sanctions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($usersWithViolations)): ?>
                                                <?php foreach ($usersWithViolations as $user):
                                                    $sanction = is_null($user['sanctions']) ? "N/A" : $user['sanctions'];
                                                ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($user['employee_id']); ?></td>
                                                        <td><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></td>
                                                        <td><?php echo htmlspecialchars($user['department']); ?></td>
                                                        <td><?php echo htmlspecialchars($user['position']); ?></td>
                                                        <td><?php echo htmlspecialchars($user['violation_count']); ?></td>
                                                        <td><?php echo htmlspecialchars($user['violation_descriptions']); ?></td>
                                                        <td><?php echo htmlspecialchars($sanction); ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="7" class="text-center">No users with violations found</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <style>
                        #style-4 th,
                        #style-4 td {
                            padding: 8px;
                            font-size: 14px;
                        }

                        #style-4 th {
                            background-color: #f8f9fa;
                        }

                        #style-4 {
                            width: 100%;
                        }
                    </style>

                </div>
                <!-- modal start -->
                <div class="modal fade" id="addViolationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h6 class="modal-title" id="exampleModalCenterTitle"><b>Add Violation</b></h6>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                    </svg>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="addViolationForm">
                                    <div class="col-12">
                                        <p id="course-error" class="text-light w-100 badge badge-danger mt-2 mb-2"></p>
                                    </div>
                                    <div class="col-12">
                                        <label for="course_name">
                                            <p>Violation</p>
                                        </label>
                                        <input type="text" class="form-control" name="violation_title" id="violation_title" placeholder="e.g. AWOL, Habitual Tardiness, etc...">
                                        <p id="course-error-name" class="text-danger mt-2"></p>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <label for="course_desc">
                                            <p>Description</p>
                                        </label>
                                        <textarea class="form-control" name="violation_description" id="violation_description" placeholder="Write a brief violation description here" rows="6"></textarea>
                                    </div>
                                </form>
                                <div class="modal-footer">
                                    <button type="submit" id="submitaddViolationForm" class="btn btn-success">Add Violation</button>
                                    <button class="btn btn-light-dark" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- modal end -->

                <!-- delete modal start -->
                <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h6 class="modal-title" id="exampleModalCenterTitle"><b>Delete Violation</b></h6>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                    </svg>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div>
                                    <p>Delete this Violation? this process is non-reversible and all records attached to this violation ID will also be deleted do you want to proceed?</p><br>
                                    <form id="deleteCourseForm">
                                        <input type="hidden" name="id" id="record-id"></input>
                                        <div class="modal-footer">
                                            <button type="submit" id="submitdeleteCourseForm" class="btn btn-danger">Delete</button>
                                            <button type="button" class="btn btn-light-dark" data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- delete modal end -->
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

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('addViolationForm').addEventListener('submit', function(event) {
                event.preventDefault();

                const formData = new FormData(this);

                fetch('../../api/addData.php?insertion=addViolation', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.text())
                    .then(text => {
                        try {
                            const data = JSON.parse(text);
                            if (data.error) {
                                document.getElementById('course-error').textContent = data.error;
                            } else {
                                alert('Violation added.');
                                location.reload();
                            }
                        } catch (e) {
                            console.error('Invalid JSON response:', text);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });

            document.getElementById('submitaddViolationForm').addEventListener('click', function() {
                document.getElementById('addViolationForm').dispatchEvent(new Event('submit'));
            });

        });

        $(document).ready(function() {

            $('#deleteModal').on('show.bs.modal', function(event) {

                var button = $(event.relatedTarget);

                var data_id = button.data('id');

                $('#record-id').val(data_id);

            });

        });

        document.addEventListener('DOMContentLoaded', function() {
            const deleteCourseForm = document.getElementById('deleteCourseForm');

            deleteCourseForm.addEventListener('submit', function(event) {
                event.preventDefault();

                const formData = new FormData(deleteCourseForm);
                const courseId = formData.get('id');

                fetch(`../../api/deleteData.php?delete=deleteCourse&id=${courseId}`, {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            alert('Error deleting violation: ' + data.error);
                        } else {
                            alert('Violation deleted.');
                            location.reload();
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while deleting the violation.');
                    });
            });
        });

        $(document).ready(function() {
            $('#style-4').DataTable({
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
        });
    </script>

</body>

</html>