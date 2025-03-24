<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>PES | Employee Profile</title>
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
                    <?php
                    $employeeData = $_GET['employee'];
                    $today = date('Y-m-d');
                    ?>
                    <div class=" layout-top-spacing">
                        <nav class="breadcrumb-style-five  mb-3" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">Management</li>
                                <li class="breadcrumb-item"><a href="employee_profile.php?employee=<?php echo $employeeData ?>">Profile</a></li>
                                <li class="breadcrumb-item"><a>Employee RFID : <?php echo $employeeData ?> </a></li>
                            </ol>
                        </nav>
                    </div>

                    <div class="d-flex justify-content-end mb-3">

                        <a class="btn btn-primary" href="employees.php">Back</a>

                    </div>
                    <div class="row layout-spacing">
                        <div class="col-lg-12">
                            <div class="statbox widget box box-shadow">
                                <div class="widget-content widget-content-area p-3">
                                    <form id="addNewEmployeeForm">
                                        <div class="col-12 mb-2">
                                            <p id="course-error" class="badge badge-danger w-100 text-center"></p>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-12 text-center">
                                                <?php
                                                $sql = "SELECT * FROM accounts WHERE bio_userid = ?";
                                                $stmt = $con->prepare($sql);
                                                $stmt->bind_param("s", $employeeData);
                                                $stmt->execute();
                                                $result = $stmt->get_result();


                                                if ($result->num_rows > 0) {
                                                    $row = $result->fetch_assoc();
                                                    $empId = $row["employee_id"];
                                                    // echo "<script>alert('".$row['employee_id']."')</script>";
                                                    // echo "<script>alert('".$employeeData."')</script>";
                                                    $statusClass = "";
                                                    if ($row['emp_status'] == "Probationary"  || $row['emp_status'] == "Contractual") {
                                                        $statusClass = "text-success";

                                                        // echo '<div class="d-flex justify-content-end">

                                                        //         <a class="btn btn-danger m-1" data-bs-toggle="modal" data-bs-target="#vioModal"  data-id='. htmlspecialchars($row['employee_id']) .'  data-bs-toggle="tooltip" data-bs-placement="top" title="Deactivate Account" data-original-title="Delete">Add Violation</a>
                                                        //         <a class="btn btn-warning m-1" data-bs-toggle="modal" data-bs-target="#vioModal"  data-id='. htmlspecialchars($row['employee_id']) .'  data-bs-toggle="tooltip" data-bs-placement="top" title="Deactivate Account" data-original-title="Delete">Update</a>

                                                        //     </div>';
                                                        echo '
                                                                    <div class="media-body">
                                                                        <h4 class="media-heading mb-0 d-flex justify-content-end">
                                                                            <div class="dropdown-list dropdown" role="group">
                                                                                <a href="javascript:void(0);" class="dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal">
                                                                                        <circle cx="12" cy="12" r="1"></circle>
                                                                                        <circle cx="19" cy="12" r="1"></circle>
                                                                                        <circle cx="5" cy="12" r="1"></circle>
                                                                                    </svg>
                                                                                </a>
                                                                                <div class="dropdown-menu left">
                                                                                    <a class="dropdown-item" href="./update_employee.php?id=' . $row['employee_id'] . '">
                                                                                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><polyline points="1 4 1 10 7 10"></polyline><polyline points="23 20 23 14 17 14"></polyline><path d="M20.49 9A9 9 0 0 0 5.64 5.64L1 10m22 4l-4.64 4.36A9 9 0 0 1 3.51 15"></path></svg>
                                                                                        <span>Update Information</span>
                                                                                    </a>
                                                                                    <a class="dropdown-item" data-bs-toggle="modal" style="cursor: pointer;" data-bs-target="#vioModal" data-id="' . htmlspecialchars($row['employee_id']) . '">
                                                                                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                                                                                        <span>Add Violation</span>
                                                                                    </a>
                                                                                    <a class="dropdown-item" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#regModal"  data-id="' . htmlspecialchars($row['employee_id']) . '" data-bs-placement="top" title="Deactivate Account" data-original-title="Delete">
                                                                                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><line x1="7" y1="17" x2="17" y2="7"></line><polyline points="7 7 17 7 17 17"></polyline></svg>
                                                                                        <span>Regularization</span>
                                                                                    </a>
                                                                                    <a class="dropdown-item" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#arcModal"  data-id="' . htmlspecialchars($row['employee_id']) . '" data-bs-placement="top" title="Deactivate Account" data-original-title="Delete">
                                                                                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><polyline points="21 8 21 21 3 21 3 8"></polyline><rect x="1" y="3" width="22" height="5"></rect><line x1="10" y1="12" x2="14" y2="12"></line></svg>
                                                                                        <span>Archive</span>
                                                                                    </a>
                                                                                </div>
                                                                            </div>
                                                                        </h4>
                                                                    </div>';
                                                    } else if ($row['emp_status'] == "Intern") {
                                                        $statusClass = "text-info";

                                                        // echo '<div class="d-flex justify-content-end">

                                                        //         <a class="btn btn-danger m-1" data-bs-toggle="modal" data-bs-target="#vioModal"  data-id='. htmlspecialchars($row['employee_id']) .'  data-bs-toggle="tooltip" data-bs-placement="top" title="Deactivate Account" data-original-title="Delete">Add Violation</a>
                                                        //         <a class="btn btn-warning m-1" data-bs-toggle="modal" data-bs-target="#vioModal"  data-id='. htmlspecialchars($row['employee_id']) .'  data-bs-toggle="tooltip" data-bs-placement="top" title="Deactivate Account" data-original-title="Delete">Update</a>

                                                        //     </div>';

                                                        echo '
                                                                    <div class="media-body">
                                                                        <h4 class="media-heading mb-0 d-flex justify-content-end">
                                                                            <div class="dropdown-list dropdown" role="group">
                                                                                <a href="javascript:void(0);" class="dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal">
                                                                                        <circle cx="12" cy="12" r="1"></circle>
                                                                                        <circle cx="19" cy="12" r="1"></circle>
                                                                                        <circle cx="5" cy="12" r="1"></circle>
                                                                                    </svg>
                                                                                </a>
                                                                                <div class="dropdown-menu left">
                                                                                    <a class="dropdown-item" href="./update_employee.php?id=' . htmlspecialchars($row['employee_id']) . '">
                                                                                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><polyline points="1 4 1 10 7 10"></polyline><polyline points="23 20 23 14 17 14"></polyline><path d="M20.49 9A9 9 0 0 0 5.64 5.64L1 10m22 4l-4.64 4.36A9 9 0 0 1 3.51 15"></path></svg>
                                                                                        <span>Update Information</span>
                                                                                    </a>
                                                                                    <a class="dropdown-item" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#arcModal"  data-id="' . htmlspecialchars($row['employee_id']) . '" data-bs-placement="top" title="Deactivate Account" data-original-title="Delete">
                                                                                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><polyline points="21 8 21 21 3 21 3 8"></polyline><rect x="1" y="3" width="22" height="5"></rect><line x1="10" y1="12" x2="14" y2="12"></line></svg>
                                                                                        <span>Archive</span>
                                                                                    </a>
                                                                                </div>
                                                                            </div>
                                                                        </h4>
                                                                    </div>';
                                                    } elseif ($row['emp_status'] == "Regular") {
                                                        $statusClass = "text-primary";

                                                        echo '
                                                                    <div class="media-body">
                                                                        <h4 class="media-heading mb-0 d-flex justify-content-end">
                                                                            <div class="dropdown-list dropdown" role="group">
                                                                                <a href="javascript:void(0);" class="dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal">
                                                                                        <circle cx="12" cy="12" r="1"></circle>
                                                                                        <circle cx="19" cy="12" r="1"></circle>
                                                                                        <circle cx="5" cy="12" r="1"></circle>
                                                                                    </svg>
                                                                                </a>
                                                                                <div class="dropdown-menu left">
                                                                                    <a class="dropdown-item" href="./update_employee.php?id=' . htmlspecialchars($row['employee_id']) . '">
                                                                                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><polyline points="1 4 1 10 7 10"></polyline><polyline points="23 20 23 14 17 14"></polyline><path d="M20.49 9A9 9 0 0 0 5.64 5.64L1 10m22 4l-4.64 4.36A9 9 0 0 1 3.51 15"></path></svg>
                                                                                        <span>Update Information</span>
                                                                                    </a>
                                                                                    <a class="dropdown-item" data-bs-toggle="modal" style="cursor: pointer;" data-bs-target="#vioModal"  data-id=' . htmlspecialchars($row['employee_id']) . '  data-bs-toggle="tooltip" data-bs-placement="top" title="Deactivate Account" data-original-title="Delete">
                                                                                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                                                                                        <span>Add Violation</span>
                                                                                    </a>
                                                                                    <a class="dropdown-item" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#arcModal"  data-id="' . htmlspecialchars($row['employee_id']) . '" data-bs-placement="top" title="Deactivate Account" data-original-title="Delete">
                                                                                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><polyline points="21 8 21 21 3 21 3 8"></polyline><rect x="1" y="3" width="22" height="5"></rect><line x1="10" y1="12" x2="14" y2="12"></line></svg>
                                                                                        <span>Archive</span>
                                                                                    </a>
                                                                                </div>
                                                                            </div>
                                                                        </h4>
                                                                    </div>';
                                                    }

                                                    echo '<div class="text-center mb-3">';
                                                    echo '<img src="../../api/' . htmlspecialchars($row['img']) . '" class="rounded-circle profile-img mb-3" alt="avatar" width="100" height="100">';
                                                    echo '<h5><b>' . htmlspecialchars($row['first_name']) . ' ' . htmlspecialchars($row['middle_name']) . ' ' . htmlspecialchars($row['last_name']) . '</b></h5>';
                                                    echo '<p>Email: <b>' . htmlspecialchars($row['email']) . '</b></p>';
                                                    echo '<p>Phone: <b>' . htmlspecialchars($row['phone']) . '</b></p>';
                                                    echo '<p>Department: <b>' . htmlspecialchars($row['department']) . '</b></p>';
                                                    echo '<p>Position: <b>' . htmlspecialchars($row['position']) . '</b></p>';
                                                    echo '<p>Status: <b class="' . $statusClass . '">' . htmlspecialchars($row['emp_status']) . '</b></p>';
                                                    echo '<p>Employee ID: <b>' . htmlspecialchars($row['employee_id']) . '</b></p>';
                                                    echo '<p>Date Hired: <b>' . htmlspecialchars($row['date_hired']) . '</b></p>';
                                                    echo '</div>';
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row layout-spacing">
                        <div class="col-lg-6">
                            <div class="statbox widget box box-shadow">
                                <div class="widget-content widget-content-area p-3">
                                    <h4 class="badge badge-secondary fs-6">Record Summary</h4>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Absent</th>
                                                <th>Late</th>
                                                <th>Undertime</th>
                                                <th>Overtime</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td id="absent">0</td>
                                                <td id="late">0</td>
                                                <td id="under">0</td>
                                                <td id="over">0</td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <div class="col-md-12 d-flex flex-column justify-content-center">
                                        <div class="form-group row mb-3">
                                            <label for="start" class="col-sm-4 col-form-label text-right"><strong>Start Date:</strong></label>
                                            <div class="col-sm-8">
                                                <input type="date" class="form-control" name="start" max="<?php echo date('Y-m-d'); ?>" required>
                                            </div>
                                        </div>

                                        <div class="form-group row mb-2">
                                            <label for="end" class="col-sm-4 col-form-label text-right"><strong>End Date:</strong></label>
                                            <div class="col-sm-8">
                                                <input type="date" class="form-control" name="end" max="<?php echo date('Y-m-d'); ?>" required>
                                                <input type="hidden" class="form-control" id="emp" name="emp" value="<?php echo $employeeData; ?>">

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-12 text-center">
                                                <br><br>
                                                <button type="button" class="btn btn-secondary w-100" onclick=filterAttendance()>Filter</button>
                                                <br><br>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="statbox widget box box-shadow">
                                <div class="widget-content widget-content-area p-3">
                                    <div class="row">
                                        <div class="col-6 d-flex justify-content-between w-100 align-items-center">
                                            <h4 class="badge badge-danger fs-6">Employee Violations</h4>
                                        </div>
                                    </div>
                                    <table id="style-4" class="table dt-table-hover">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Violation</th>
                                                <th class="text-center">Date</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="violationTable">
                                            <?php
                                            $u = $_SESSION['user_id']; // Current user ID

                                            $sql = "
                                                    SELECT uv.*, a.employee_id, a.first_name, a.last_name, a.emp_status, a.date_hired, hvl.violation_title
                                                    FROM user_violations uv
                                                    JOIN accounts a ON a.employee_id = uv.employee_id
                                                    JOIN hr_violation_list hvl ON uv.violation_id = hvl.violation_id
                                                    WHERE a.bio_userid = ?
                                                    ORDER BY uv.vdate DESC
                                                ";

                                            $stmt = $con->prepare($sql);
                                            $stmt->bind_param("s", $employeeData);
                                            $stmt->execute();
                                            $result = $stmt->get_result();

                                            $html = '';

                                            if ($result && $result->num_rows > 0) {
                                                while ($violation = $result->fetch_assoc()) {
                                                    $html .= '<tr>';
                                                    $html .= '<td>' . htmlspecialchars($violation['violation_title']) . '</td>';
                                                    $html .= '<td>' . htmlspecialchars($violation['vdate']) . '</td>';
                                                    $html .= '<td>' . htmlspecialchars($violation['status']) . '</td>';
                                                    $html .= '<td> 
                                                                <a class="btn btn-info m-1" 
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#vioModal2"  
                                                                data-id="' . htmlspecialchars($violation['employee_id']) . '"  
                                                                data-violation-id="' . htmlspecialchars($violation['violation_id']) . '"  
                                                                data-bs-toggle="tooltip" 
                                                                data-bs-placement="top" 
                                                                title="Update Violation">
                                                                Update
                                                                </a>
                                                              </td>';
                                                    $html .= '</tr>';
                                                }
                                            }

                                            echo $html;
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row layout-spacing">
                        <div class="col-lg-12">
                            <div class="statbox widget box box-shadow">
                                <div class="widget-content widget-content-area p-2">
                                    <table id="style-3" class="table dt-table-hover">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Date</th>
                                                <th class="text-center">Time-In</th>
                                                <th class="text-center">Time-Out</th>
                                                <th class="text-center">Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody id="accountsTable">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- regularization modal start -->
            <div class="modal fade" id="regModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title" id="exampleModalCenterTitle"><b>Employee Regularization</b></h6>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                </svg>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div>
                                <p>Grant '<b class="text-primary">Regular</b>' status to this employee?</p><br>
                            </div>
                            <form id="deleteStudent">
                                <input type="hidden" name="emp_id" id="emp_id">
                                <div class="modal-footer">
                                    <button type="submit" id="deleteStud" class="btn btn-success">Proceed</button>
                                    <button type="button" id="cancelDeleteStudent" class="btn btn-light-dark" data-bs-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- regularization modal end -->

            <!-- add violation modal start -->
            <div class="modal fade" id="vioModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title" id="exampleModalCenterTitle"><b>Employee Violation</b></h6>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                </svg>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="vioForm">
                                <div class="col-12 mb-2">
                                    <label for="department">
                                        <p>Violation</p>
                                    </label>
                                    <?php
                                    try {
                                        // Ensure $con is initialized before using it
                                        if (!isset($con) || !$con) {
                                            throw new Exception("Database connection not established");
                                        }

                                        $bioId = isset($_GET['employee']) ? $_GET['employee'] : '';

                                        // Validate that we have an employee ID
                                        if (empty($bioId)) {
                                            throw new Exception("No employee ID provided");
                                        }

                                        $sql = "SELECT department FROM accounts WHERE bio_userid = ?";
                                        $stmt = $con->prepare($sql);
                                        $stmt->bind_param('s', $bioId);
                                        $stmt->execute();
                                        $result = $stmt->get_result();

                                        if ($result && $row = $result->fetch_assoc()) {
                                            $department = htmlspecialchars($row['department'], ENT_QUOTES, 'UTF-8');
                                        } else {
                                            $department = '';
                                        }
                                    } catch (Exception $e) {
                                        $department = '';
                                    }
                                    ?>
                                    <input type="text" value="<?php echo $department; ?>" id="dept-val" hidden>
                                    <select name="vio" id="vio" class="form-select">
                                        <option value="" selected disabled>---Select Violation---</option>
                                        <?php

                                        $query = "SELECT * FROM hr_violation_list";
                                        $result = $con->query($query);

                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo '<option value="' . htmlspecialchars($row['violation_id']) . '">' . htmlspecialchars($row['violation_title']) . '</option>';
                                            }
                                        } else {
                                            echo '<option disabled>No violations found</option>';
                                        }

                                        ?>
                                    </select>
                                </div>
                                <div class="col-12 mb-4">
                                    <label for="department">
                                        <p>Violation Status</p>
                                    </label>
                                    <select name="stat" id="stat" class="form-select">
                                        <option value="" selected disabled>---Select Status---</option>
                                        <option value="Pending">Pending</option>
                                        <option value="Under Review">Under Review</option>
                                        <option value="Resolved">Resolved</option>
                                    </select>
                                </div>
                                <input type="hidden" name="emp_id2" id="emp_id2">
                                <div class="modal-footer">
                                    <button type="submit" id="addVio" class="btn btn-danger">Add Violation</button>
                                    <button type="button" id="cancelDeleteStudent" class="btn btn-light-dark" data-bs-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- add violation modal end -->
            <!-- upd violation modal start -->
            <div class="modal fade" id="vioModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title" id="exampleModalCenterTitle"><b>Update Status</b></h6>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                </svg>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="vioForm2">
                                <div class="col-12 mb-4">
                                    <label for="department">
                                        <p>Violation Status</p>
                                    </label>
                                    <select name="stat2" id="stat2" class="form-select" onclick="checkResolved()">
                                        <option value="" selected disabled>---Select Status---</option>
                                        <option value="Pending">Pending</option>
                                        <option value="Under Review">Under Review</option>
                                        <option value="Resolved">Resolved</option>
                                    </select>
                                </div>
                                <div class="col-12 mb-4" id="sanctionsSection" style="display: none;">
                                    <label for="sanctions">
                                        <p>Sanctions</p>
                                    </label>
                                    <select name="sanctions" id="sanctions" class="form-select">
                                        <option value="" selected disabled>---Select Sanction---</option>
                                        <option value="Verbal Warning">Verbal Warning</option>
                                        <option value="Written Warning">Written Warning</option>
                                        <option value="Final Written Warning">Final Written Warning</option>
                                        <option value="2 days suspension">2 days suspension</option>
                                        <option value="30 days suspension">30 days suspension</option>
                                    </select>
                                </div>
                                <input type="hidden" name="emp_id3" id="emp_id3">
                                <input type="hidden" name="violation_id" id="violation_id">
                                <div class="modal-footer">
                                    <button type="submit" id="updVio" class="btn btn-info">Update Status</button>
                                    <button type="button" id="sanctionsButton" class="btn btn-warning" disabled>Sanctions</button>
                                    <button type="button" id="cancelDeleteStudent" class="btn btn-light-dark" data-bs-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- upd violation modal end -->

            <!-- archive modal start -->
            <div class="modal fade" id="arcModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title" id="exampleModalCenterTitle"><b>Archive</b></h6>
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
                                    <label for="department">
                                        <p>Account Status</p>
                                    </label>
                                    <select name="stat3" id="stat3" class="form-select">
                                        <option value="" selected disabled>---Select Status---</option>
                                        <option value="Suspended">Suspended</option>
                                        <option value="Resigned">Resigned</option>
                                        <option value="Terminated">Terminated</option>
                                    </select>
                                </div>
                                <input type="hidden" name="emp_id4" id="emp_id4">
                                <div class="modal-footer">
                                    <button type="submit" id="updVio" class="btn btn-warning">Archive</button>
                                    <button type="button" id="cancelDeleteStudent" class="btn btn-light-dark" data-bs-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- archive modal end -->
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

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->


    <script>
        c3 = $('#style-4').DataTable({
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
            "lengthMenu": [3],
            "pageLength": 10
        });

        multiCheck(c3);

        document.addEventListener('DOMContentLoaded', function() {
            const deleteStudentForm = document.getElementById('deleteStudent');
            const cancelDeleteStudentForm = document.getElementById('cancelDeleteStudent');

            deleteStudentForm.addEventListener('submit', function(event) {
                event.preventDefault();

                const formData = new FormData(deleteStudentForm);
                const studentId = formData.get('emp_id');

                fetch(`../../api/deleteData.php?delete=regularization&id=${studentId}`, {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            alert('Error updating status: ' + data.error);
                        } else {
                            console.log(studentId);

                            alert('Regularization Success.');
                            location.reload();
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while deleting the Teacher Account.');
                    });
            });

            $('#regModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var dataId = button.data('id');
                $('#emp_id').val(dataId);
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const deleteStudentForm = document.getElementById('vioForm');
            const cancelDeleteStudentForm = document.getElementById('cancelDeleteStudent');

            deleteStudentForm.addEventListener('submit', function(event) {
                event.preventDefault();

                const formData = new FormData(deleteStudentForm);
                const idd = formData.get('emp_id2');
                const vio = formData.get('vio');
                const stat = formData.get('stat');
                const dept = document.getElementById('dept-val').value;
                console.log(dept)

                console.log(idd);
                console.log(vio);
                console.log(stat);

                fetch(`../../api/deleteData.php?delete=violation&id=${idd}&vio=${vio}&stat=${stat}&dept=${dept}`, {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            alert('Error updating status: ' + data.error);
                        } else {
                            alert('Violation Added.');
                            location.reload();
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An Error Occured: ' + error);
                    });
            });

            $('#vioModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var dataId = button.data('id');
                $('#emp_id2').val(dataId);
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const deleteStudentForm = document.getElementById('vioForm2');
            const cancelDeleteStudentForm = document.getElementById('cancelDeleteStudent');

            deleteStudentForm.addEventListener('submit', function(event) {
                event.preventDefault();

                const sanctionVal = document.getElementById('sanctions').value;
                const formData = new FormData(deleteStudentForm);
                const idd = formData.get('emp_id3');
                const violationId = formData.get('violation_id'); // Get the violation ID
                const stat2 = formData.get('stat2');

                console.log(idd);
                console.log(violationId); // Log the violation ID
                console.log(stat2);

                fetch(`../../api/deleteData.php?delete=updviolation&id=${idd}&stat=${stat2}&sanction=${sanctionVal}&vioId=${violationId}`, {
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
                        alert('An Error Occured: ' + error);
                    });
            });

            $('#vioModal2').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var dataId = button.data('id');
                var violationId = button.data('violation-id'); // Get the violation ID from the button
                $('#emp_id3').val(dataId);
                $('#violation_id').val(violationId); // Set the violation ID in the form
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const deleteStudentForm = document.getElementById('arcForm');
            const cancelDeleteStudentForm = document.getElementById('cancelDeleteStudent');

            deleteStudentForm.addEventListener('submit', function(event) {
                event.preventDefault();

                const formData = new FormData(deleteStudentForm);
                const idd = formData.get('emp_id4');
                const stat3 = formData.get('stat3');

                console.log(idd);
                console.log(stat3);

                fetch(`../../api/deleteData.php?delete=accStat&id=${idd}&stat=${stat3}`, {
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
                        alert('An Error Occured: ' + error);
                    });
            });

            $('#arcModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var dataId = button.data('id');
                $('#emp_id4').val(dataId);
            });
        });

        function filterAttendance() {
            const startDateInput = document.querySelector('input[name="start"]').value;
            const endDateInput = document.querySelector('input[name="end"]').value;
            const emp = document.getElementById('emp').value;

            console.log(startDateInput);

            if (!startDateInput || !endDateInput) {
                alert("Please select both start and end dates.");
                return;
            }

            const convertDateFormat = (dateStr) => {
                const [year, month, day] = dateStr.split('-');
                return `${month}/${day}/${year}`;
            };

            const startDate = convertDateFormat(startDateInput);
            const endDate = convertDateFormat(endDateInput);

            fetch('../../api/filter_attendance.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        start: startDate,
                        end: endDate,
                        emp: emp
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    document.getElementById('accountsTable').innerHTML = data.html;
                    document.getElementById('absent').innerHTML = data.absent;
                    document.getElementById('late').innerHTML = data.late;
                    document.getElementById('under').innerHTML = data.under;
                    document.getElementById('over').innerHTML = data.overtime;

                    if ($.fn.DataTable.isDataTable('#style-3')) {
                        $('#style-3').DataTable().clear().destroy();
                    }
                    $('#style-3').DataTable({
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

                })
                .catch(error => {
                    console.error("Fetch Error: ", error);
                    alert("An error occurred while filtering the data.");
                });
        }

        // JavaScript to handle the enabling/disabling of the Sanctions button and showing the sanctions dropdown


        function checkResolved() {
            const status = document.getElementById('stat2').value;
            var sanctionsButton = document.getElementById('sanctionsButton');
            var sanctionsSection = document.getElementById('sanctionsSection');

            if (status === 'Resolved') {
                sanctionsButton.disabled = false;
                sanctionsSection.style.display = 'block';
            } else {
                sanctionsButton.disabled = true;
                sanctionsSection.style.display = 'none';
            }
        }

        checkResolved();

        // JavaScript to handle the Sanctions button click
        document.getElementById('sanctionsButton').addEventListener('click', function() {
            var sanctionsSelect = document.getElementById('sanctions');
            if (sanctionsSelect.value) {
                alert('Sanction selected: ' + sanctionsSelect.value);
                // You can add further logic here to handle the selected sanction
            } else {
                alert('Please select a sanction.');
            }
        });
    </script>

</body>

</html>