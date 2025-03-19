<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>PES | Accounts</title>
    <link rel="icon" type="image/x-icon" href="../../src/assets/img/favicon.ico"/>
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
    <link href="../../src/assets/css/light/components/tabs.css" rel="stylesheet" type="text/css">
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

    <!-- END PAGE LEVEL CUSTOM STYLES -->

</head>
<body class="layout-boxed">
    <!-- BEGIN LOADER -->
    <div id="load_screen"> <div class="loader"> <div class="loader-content">
        <div class="spinner-grow align-self-center"></div>
    </div></div></div>
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
                                <li class="breadcrumb-item"><a href="archive.php">Employee Archive</a></li>
                            </ol>
                        </nav>
                    </div>

                    <div class="d-flex justify-content-end mb-3">


                    </div>
                    <div class="row layout-spacing">
                        <div class="statbox widget box box-shadow">
                            <div class="widget-content widget-content-area p-4">
                                <div class="simple-tab">

                                    <ul class="nav nav-tabs" id="myTab" role="tablist" style="color: #fff;">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="indigency-tab" data-bs-toggle="tab" data-bs-target="#indigency-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Suspended Employees</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="residency-tab" data-bs-toggle="tab" data-bs-target="#residency-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Resigned Employees</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="clearance-tab" data-bs-toggle="tab" data-bs-target="#clearance-tab-pane" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">Terminated Employees</button>
                                        </li>
                                    </ul>

                                    <div class="tab-content" id="myTabContent">
                                        <!-- indigency tab -->
                                        <div class="tab-pane fade show active" id="indigency-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                                            <div class="col-lg-12 mt-3">
                                                <div class="statbox widget box box-shadow">
                                                    <div class="widget-content widget-content-area">
                                                        <table id="style-2" class="table style-3 dt-table-hover table-responsive">
                                                            <thead>
                                                                <tr>
                                                                    <th>Employee No.</th>
                                                                    <th class="text-center">Image</th>
                                                                    <th>Full Name</th>
                                                                    <th>Department</th>
                                                                    <th>Date Hired</th>
                                                                    <th>Status</th>
                                                                    <th class="text-center dt-no-sorting">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="indigencyTable">
                                                                <?php
                                                                    $u = $_SESSION['user_id'];

                                                                    $sql = "SELECT * FROM accounts WHERE employee_id != $u AND (active = 0 AND archived = 1) ORDER BY date_hired DESC";
                                                                    $result = $con->query($sql);
                                                                    $html = '';

                                                                    if ($result && $result->num_rows > 0) {
                                                                        while ($accounts = $result->fetch_assoc()) {
                                                                            $forEvalValue = $accounts['for_eval'];

                                                                            $forEvalDate = null;
                                                                            $interval = null;

                                                                            if ($forEvalValue !== 'Evaluated') {
                                                                                try {
                                                                                    $forEvalDate = new DateTime($forEvalValue);
                                                                                    $today = new DateTime();
                                                                                    $interval = $forEvalDate->diff($today)->days;
                                                                                } catch (Exception $e) {
                                                                                    $forEvalDate = null;
                                                                                }
                                                                            }

                                                                            $employeeId = $accounts['employee_id'];
                                                                            $checkEvalSql = "SELECT 1 FROM evaluation WHERE evaluator_hr = '$u' AND account_id = '$employeeId' LIMIT 1";
                                                                            $evalResult = $con->query($checkEvalSql);
                                                                            
                                                                            $evalExists = $evalResult && $evalResult->num_rows > 0;

                                                                            if ($forEvalValue === 'Evaluated') {
                                                                            } else {
                                                                                $buttonClass = 'btn-info';
                                                                                $disabled = '';
                                                                                $buttonText = 'Evaluate';
                                                                            }

                                                                            $html .= '<tr>';
                                                                            $html .= '<td>' . htmlspecialchars($accounts['employee_id']) . '</td>';
                                                                            $html .= '<td class="text-center"><span><img src="../../api/' . htmlspecialchars($accounts['img']) . '" class="profile-img rounded-circle" alt="avatar"></span></td>';
                                                                            $html .= '<td><a class="text-primary" href="employee_profile.php?employee='.htmlspecialchars($accounts['bio_userid']).'">' . htmlspecialchars($accounts['first_name']) . ' ' . htmlspecialchars($accounts['middle_name']) . ' ' . htmlspecialchars($accounts['last_name']) . '</a></td>';
                                                                            $html .= '<td>' . htmlspecialchars($accounts['department']) . '</td>';
                                                                            $html .= '<td>' . htmlspecialchars($accounts['date_hired']) . '</td>';
                                                                            $html .= '<td>' . htmlspecialchars($accounts['emp_status']) . '</td>';
                                                                            $html .= '<td class="text-center">
                                                                                            <ul class="table-controls">
                                                                                                <li>
                                                                                                    <a class="btn btn-info" data-bs-toggle="modal" data-bs-target="#arcModal" data-id=' . htmlspecialchars($accounts['employee_id']) . ' data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="">Revert</a>
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
                                        <!-- indigency tab -->
                                        <!-- residency tab -->
                                        <div class="tab-pane fade" id="residency-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                                            <div class="row">
                                                <div class="col-lg-12 mt-3">
                                                    <div class="statbox widget box box-shadow">
                                                        <div class="widget-content widget-content-area">
                                                            <table id="style-3" class="table style-3 dt-table-hover table-responsive">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Employee No.</th>
                                                                        <th class="text-center">Image</th>
                                                                        <th>Full Name</th>
                                                                        <th>Department</th>
                                                                        <th>Resignation Date</th>
                                                                        <th>Status</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="residencyTable">
                                                                <?php
                                                                    $u = $_SESSION['user_id'];

                                                                    $sql = "SELECT * FROM accounts WHERE employee_id != $u AND (active = 0 AND archived = 2) ORDER BY date_hired DESC";
                                                                    $result = $con->query($sql);
                                                                    $html = '';

                                                                    if ($result && $result->num_rows > 0) {
                                                                        while ($accounts = $result->fetch_assoc()) {
                                                                            $forEvalValue = $accounts['for_eval'];

                                                                            $forEvalDate = null;
                                                                            $interval = null;

                                                                            if ($forEvalValue !== 'Evaluated') {
                                                                                try {
                                                                                    $forEvalDate = new DateTime($forEvalValue);
                                                                                    $today = new DateTime();
                                                                                    $interval = $forEvalDate->diff($today)->days;
                                                                                } catch (Exception $e) {
                                                                                    $forEvalDate = null;
                                                                                }
                                                                            }

                                                                            $employeeId = $accounts['employee_id'];
                                                                            $checkEvalSql = "SELECT 1 FROM evaluation WHERE evaluator_hr = '$u' AND account_id = '$employeeId' LIMIT 1";
                                                                            $evalResult = $con->query($checkEvalSql);
                                                                            
                                                                            $evalExists = $evalResult && $evalResult->num_rows > 0;

                                                                            if ($forEvalValue === 'Evaluated') {
                                                                            } else {
                                                                                $buttonClass = 'btn-info';
                                                                                $disabled = '';
                                                                                $buttonText = 'Evaluate';
                                                                            }

                                                                            $html .= '<tr>';
                                                                            $html .= '<td>' . htmlspecialchars($accounts['employee_id']) . '</td>';
                                                                            $html .= '<td class="text-center"><span><img src="../../api/' . htmlspecialchars($accounts['img']) . '" class="profile-img rounded-circle" alt="avatar"></span></td>';
                                                                            $html .= '<td><a class="text-primary" href="employee_profile.php?employee='.htmlspecialchars($accounts['bio_userid']).'">' . htmlspecialchars($accounts['first_name']) . ' ' . htmlspecialchars($accounts['middle_name']) . ' ' . htmlspecialchars($accounts['last_name']) . '</a></td>';
                                                                            $html .= '<td>' . htmlspecialchars($accounts['department']) . '</td>';
                                                                            $html .= '<td>' . htmlspecialchars($accounts['date_hired']) . '</td>';
                                                                            $html .= '<td>' . htmlspecialchars($accounts['emp_status']) . '</td>';
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
                                        </div>
                                        <!-- residency tab -->
                                        <!-- clearance tab -->
                                        <div class="tab-pane fade" id="clearance-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                                            <div class="row">
                                                <div class="col-lg-12 mt-3">
                                                    <div class="statbox widget box box-shadow">
                                                        <div class="widget-content widget-content-area">
                                                            <table id="style-4" class="table style-3 dt-table-hover table-responsive">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Employee No.</th>
                                                                        <th class="text-center">Image</th>
                                                                        <th>Full Name</th>
                                                                        <th>Department</th>
                                                                        <th>Date Terminated</th>
                                                                        <th>Status</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="clearanceTable">
                                                                <?php
                                                                    $u = $_SESSION['user_id'];

                                                                    $sql = "SELECT * FROM accounts WHERE employee_id != $u AND (active = 0 AND archived = 3) ORDER BY date_hired DESC";
                                                                    $result = $con->query($sql);
                                                                    $html = '';

                                                                    if ($result && $result->num_rows > 0) {
                                                                        while ($accounts = $result->fetch_assoc()) {
                                                                            $forEvalValue = $accounts['for_eval'];

                                                                            $forEvalDate = null;
                                                                            $interval = null;

                                                                            if ($forEvalValue !== 'Evaluated') {
                                                                                try {
                                                                                    $forEvalDate = new DateTime($forEvalValue);
                                                                                    $today = new DateTime();
                                                                                    $interval = $forEvalDate->diff($today)->days;
                                                                                } catch (Exception $e) {
                                                                                    $forEvalDate = null;
                                                                                }
                                                                            }

                                                                            $employeeId = $accounts['employee_id'];
                                                                            $checkEvalSql = "SELECT 1 FROM evaluation WHERE evaluator_hr = '$u' AND account_id = '$employeeId' LIMIT 1";
                                                                            $evalResult = $con->query($checkEvalSql);
                                                                            
                                                                            $evalExists = $evalResult && $evalResult->num_rows > 0;

                                                                            if ($forEvalValue === 'Evaluated') {
                                                                            } else {
                                                                                $buttonClass = 'btn-info';
                                                                                $disabled = '';
                                                                                $buttonText = 'Evaluate';
                                                                            }

                                                                            $html .= '<tr>';
                                                                            $html .= '<td>' . htmlspecialchars($accounts['employee_id']) . '</td>';
                                                                            $html .= '<td class="text-center"><span><img src="../../api/' . htmlspecialchars($accounts['img']) . '" class="profile-img rounded-circle" alt="avatar"></span></td>';
                                                                            $html .= '<td><a class="text-primary" href="employee_profile.php?employee='.htmlspecialchars($accounts['bio_userid']).'">' . htmlspecialchars($accounts['first_name']) . ' ' . htmlspecialchars($accounts['middle_name']) . ' ' . htmlspecialchars($accounts['last_name']) . '</a></td>';
                                                                            $html .= '<td>' . htmlspecialchars($accounts['department']) . '</td>';
                                                                            $html .= '<td>' . htmlspecialchars($accounts['date_hired']) . '</td>';
                                                                            $html .= '<td>' . htmlspecialchars($accounts['emp_status']) . '</td>';
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
                                        </div>
                                        <!-- clearance tab -->
                                        
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- content -->

                </div>
                </div>
                <!-- archive modal start -->
                <div class="modal fade" id="arcModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h6 class="modal-title" id="exampleModalCenterTitle"><b>Account Suspension</b></h6>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                    </svg>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="arcForm">
                                    <div class="col-12 mb-4">
                                        <p>Lift account suspension?</p>
                                    </div>
                                    <input type="hidden" name="emp_id4" id="emp_id4">
                                    <div class="modal-footer">
                                        <button type="submit" id="updVio" class="btn btn-success">Confirm</button>
                                        <button type="button" id="cancelDeleteStudent" class="btn btn-light-dark" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- archive modal end -->
            </div>
            <!--  BEGIN FOOTER  -->
            <div class="footer-wrapper">
                <div class="footer-section f-section-1">
                    <p class="">Copyright © <span class="dynamic-year">2022</span> <a target="_blank" href="https://designreset.com/cork-admin/">DesignReset</a>, All rights reserved.</p>
                </div>
                <div class="footer-section f-section-2">
                    <p class="">Coded with <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg></p>
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
    <script src="../../layouts/modern-light-menu/app.js"></script>
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
        c5 = $('#style-5').DataTable({
            "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
        "<'table-responsive'tr>" +
        "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            "oLanguage": {
                "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                "sInfo": "Showing page _PAGE_ of _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Search...",
               "sLengthMenu": "Results :  _MENU_",
            },
            "stripeClasses": [],
            "lengthMenu": [5, 10, 20, 50],
            "pageLength": 10
        });

        multiCheck(c5);

        c4 = $('#style-4').DataTable({
            "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
        "<'table-responsive'tr>" +
        "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            "oLanguage": {
                "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                "sInfo": "Showing page _PAGE_ of _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Search...",
               "sLengthMenu": "Results :  _MENU_",
            },
            "stripeClasses": [],
            "lengthMenu": [5, 10, 20, 50],
            "pageLength": 10
        });

        multiCheck(c4);

        c3 = $('#style-3').DataTable({
            "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
        "<'table-responsive'tr>" +
        "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            "oLanguage": {
                "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
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

        c2 = $('#style-2').DataTable({
            "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
        "<'table-responsive'tr>" +
        "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            "oLanguage": {
                "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                "sInfo": "Showing page _PAGE_ of _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Search...",
               "sLengthMenu": "Results :  _MENU_",
            },
            "stripeClasses": [],
            "lengthMenu": [5, 10, 20, 50],
            "pageLength": 10
        });

        multiCheck(c2);

        document.addEventListener('DOMContentLoaded', function() {
            const deleteStudentForm = document.getElementById('arcForm');
            const cancelDeleteStudentForm = document.getElementById('cancelDeleteStudent');

            deleteStudentForm.addEventListener('submit', function(event) {
                event.preventDefault();

                const formData = new FormData(deleteStudentForm);
                const idd = formData.get('emp_id4');

                console.log(idd);

                fetch(`../../api/deleteData.php?delete=revert&id=${idd}`, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert('Error updating status: ' + data.error);
                    } else {
                        alert('Status Updated.');
                        location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An Error Occured: '+ error);
                });
            });

            $('#arcModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var dataId = button.data('id');
                $('#emp_id4').val(dataId);
            });
        });

    </script>

</body>
</html>