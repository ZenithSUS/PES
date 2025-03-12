<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>OAS | Profile</title>
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
    <div class="main-container h-100" id="container">

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
                    $employeeData = $_SESSION['user_id'];
                    $today = date('Y-m-d');
                 ?>
                    <div class=" layout-top-spacing">
                        <nav class="breadcrumb-style-five  mb-3" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">Account</li>
                                <li class="breadcrumb-item"><a href="profile.php?employee=<?php echo $_SESSION['user_id'] ?>">Profile</a></li>
                            </ol>
                        </nav>
                    </div>

                    <div class="d-flex justify-content-end mb-3">


                    </div>
                    <div class="row layout-spacing h-100">
                        <div class="col-lg-12">
                            <div class="statbox widget box box-shadow">
                                <div class="widget-content widget-content-area p-3" style="height: 70vh !important; ">
                                    <form id="addNewEmployeeForm">
                                        <div class="row mb-3">
                                            <div class="col-md-12 text-center">
                                                <?php
                                                    $sql = "SELECT * FROM accounts WHERE employee_id = ?";
                                                    $stmt = $con->prepare($sql);
                                                    $stmt->bind_param("s", $employeeData);
                                                    $stmt->execute();
                                                    $result = $stmt->get_result();

                                                    if ($result->num_rows > 0) {
                                                        $row = $result->fetch_assoc();
                                                        $statusClass = "";
                                                        if ($row['emp_status']) {
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
                                                                                <a class="dropdown-item" data-bs-toggle="modal" style="cursor: pointer;" data-bs-target="#regModal"  data-id='. htmlspecialchars($row['employee_id']) .'  data-bs-toggle="tooltip" data-bs-placement="top" title="Deactivate Account" data-original-title="Delete">
                                                                                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                                                                    <span>Change Password</span>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </h4>
                                                                </div>';

                                                        }

                                                        echo '<div class="text-center mb-3">';
                                                        echo '<img src="../../api/' . htmlspecialchars($row['img']) . '" class="rounded-circle profile-img mb-3" alt="avatar" width="100" height="100"><br><br>';
                                                        echo '<h5><b>' . htmlspecialchars($row['first_name']) . ' ' . htmlspecialchars($row['middle_name']) . ' ' . htmlspecialchars($row['last_name']) . '</b></h5>';
                                                        echo '<p>Email: <b>' . htmlspecialchars($row['email']) . '</b></p>';
                                                        echo '<p>Phone: <b>' . htmlspecialchars($row['phone']) . '</b></p>';
                                                        echo '<p>Department: <b>' . htmlspecialchars($row['department']) . '</b></p>';
                                                        echo '<p>Position: <b>' . htmlspecialchars($row['position']) . '</b></p>';
                                                        echo '<p>Status: <b class="'.$statusClass.'">' . htmlspecialchars($row['emp_status']) . '</b></p>';
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
                </div>
            </div>
            <!-- regularization modal start -->
            <div class="modal fade" id="regModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title" id="exampleModalCenterTitle"><b>Account Password</b></h6>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="deleteStudent">
                                <div class="mb-2">
                                    <input class="form-control" type="password" name="cur" id="cur" placeholder="Current Password">
                                    <span id="errorCur" class="text-danger" style="font-size: 12px;"></span>
                                </div>
                                <div class="mb-2">
                                    <input class="form-control" type="password" name="new" id="new" placeholder="New Password">
                                    <span id="errorNew" class="text-danger" style="font-size: 12px;"></span>
                                </div>
                                <div class="mb-2">
                                    <input class="form-control" type="password" name="cnew" id="cnew" placeholder="Confirm New Password">
                                    <span id="errorCNew" class="text-danger" style="font-size: 12px;"></span>
                                </div>
                                <input type="hidden" name="emp_id" id="emp_id">
                                <div class="modal-footer">
                                    <button type="submit" id="deleteStud" class="btn btn-success">Change Password</button>
                                    <button type="button" id="cancelDeleteStudent" class="btn btn-light-dark" data-bs-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- regularization modal end -->
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
    <!-- END GLOBAL MANDATORY SCRIPTS -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
    <script src="../../src/plugins/src/table/datatable/datatables.js"></script>
    <script src="../../src/assets/js/custom.js"></script>

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteStudentForm = document.getElementById('deleteStudent');
        const empIdInput = document.getElementById('emp_id');
        const curPasswordInput = document.getElementById('cur');
        const newPasswordInput = document.getElementById('new');
        const confirmNewPasswordInput = document.getElementById('cnew');

        const errorMessages = {
            cur: document.createElement('span'),
            new: document.createElement('span'),
            cnew: document.createElement('span'),
        };

        Object.values(errorMessages).forEach((span) => {
            span.style.color = 'red';
            span.style.fontSize = '12px';
        });

        curPasswordInput.parentNode.appendChild(errorMessages.cur);
        newPasswordInput.parentNode.appendChild(errorMessages.new);
        confirmNewPasswordInput.parentNode.appendChild(errorMessages.cnew);

        deleteStudentForm.addEventListener('submit', function (event) {
            event.preventDefault();

            errorMessages.cur.textContent = '';
            errorMessages.new.textContent = '';
            errorMessages.cnew.textContent = '';

            const formData = new FormData(deleteStudentForm);
            const empid = formData.get('emp_id');
            const cur = formData.get('cur');
            const newPass = formData.get('new');
            const confirmNewPass = formData.get('cnew');

            // ✅ Password regex: At least 8 chars, 1 letter, 1 number
            const passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;

            let valid = true;

            if (cur.trim() === '') {
                errorMessages.cur.textContent = 'Current password is required.';
                valid = false;
            }

            if (!passwordRegex.test(newPass)) {
                errorMessages.new.textContent = 'Password must be at least 8 characters long and contain at least one letter and one number.';
                valid = false;
            }

            if (newPass !== confirmNewPass) {
                errorMessages.cnew.textContent = 'Passwords do not match.';
                valid = false;
            }

            if (!valid) return;

            fetch(`../../api/deleteData.php?delete=password&id=${empid}&cur=${cur}&new=${newPass}&cnew=${confirmNewPass}`, {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
            alert(data);
            if (data === "Password updated successfully. Please log in again.") {
                // Execute logout after updating the password
                fetch('../../api/logout.php', {
                    method: 'POST'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        console.log(data.error);
                        alert(data.error);
                    } else {
                        console.log(data.message);
                        alert(data.message);
                        localStorage.clear();
                        window.location.href = '../../authentication/SignIn.php';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error updating password.');
        });
        });

        $('#regModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var dataId = button.data('id');
            $('#emp_id').val(dataId);
        });
    });


</script>

</body>
</html>