<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>PES | HR Accounts</title>
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
                                <li class="breadcrumb-item"><a href="hr.php">Human Resource</a></li>
                            </ol>
                        </nav>
                    </div>

                    <div class="d-flex justify-content-end mb-3">


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
                                                <th>Username</th>
                                                <th>Department</th>
                                                <th>Level</th>
                                                <th class="text-center dt-no-sorting">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="accountsTable">
                                        <?php
                                            
                                            $u = $_SESSION['user_id'];
                                            $sql = "SELECT * FROM accounts WHERE employee_id != $u and active = 1 and user_level = 1";
                                            $result = $con->query($sql);
                                            $html = '';

                                            if ($result && $result->num_rows > 0) {
                                                while ($accounts = $result->fetch_assoc()) {
                                                    $html .= '<tr>';
                                                    $html .= '<td>' . htmlspecialchars($accounts['employee_id']) . '</td>';
                                                    $html .= '<td class="text-center"><span><img src="../../api/' . htmlspecialchars($accounts['img']) . '" class="profile-img rounded-circle" alt="avatar"></span></td>';
                                                    $html .= '<td>' . htmlspecialchars($accounts['first_name']) . ' ' . htmlspecialchars($accounts['middle_name']) . ' ' . htmlspecialchars($accounts['last_name']) . '</td>';
                                                    $html .= '<td>' . htmlspecialchars($accounts['username']) . '</td>';
                                                    $html .= '<td>' . htmlspecialchars($accounts['department']) . '</td>';
                                                    $html .= '<td>' . htmlspecialchars($accounts['user_level']) . '</td>';
                                                    $html .= '<td class="text-center">
                                                                <ul class="table-controls">
                                                                    <li>
                                                                        <a class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#deactivateModal"  data-id='. htmlspecialchars($accounts['employee_id']) .'  data-bs-toggle="tooltip" data-bs-placement="top" title="Deactivate Account" data-original-title="Delete">Deactivate</a>
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

                </div>

                <!-- add modal start -->
                    <div class="modal fade" id="addTeacherModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h6 class="modal-title" id="exampleModalCenterTitle"><b>Add Teacher</b></h6>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="addTeacherForm">
                                        <div class="col-12">
                                            <p id="course-error" class="text-light w-100 badge badge-danger mt-2 mb-2"></p>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-6">
                                                <label for="firstname"><p>First Name</p></label>
                                                <input type="text" class="form-control" name="firstname" id="firstname" placeholder="e.g. Jane">
                                            </div>
                                            <div class="col-6">
                                                <label for="lastname"><p>Last Name</p></label>
                                                <input type="text" class="form-control" name="lastname" id="lastname" placeholder="e.g. Doe">
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col">
                                                <label for="teacherid"><p>Employee ID / Teacher ID</p></label>
                                                <input type="text" class="form-control" name="teacherid" id="teacherid" placeholder="XX-XXXX-XXX / XXXXXXXXXX">
                                            </div>
                                        </div>
                                        <div class="row profile-image  mt-4">

                                            <div class="img-uploader-content">
                                                <label for="filepond"><p>Image</p></label><br>
                                                <input type="file" class="bg-dark w-100 rounded p-2"
                                                    name="filepond" accept="image/png, image/jpeg, image/gif"/>
                                            </div>
                        
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col">
                                                <label for="email"><p>Email Address</p></label>
                                                <input type="text" class="form-control" name="email" id="email" placeholder="example@provider.com">
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col">
                                                <label for="phone"><p>Phone Number</p></label>
                                                <input type="text" class="form-control" name="phone" id="phone" placeholder="09XXXXXXXXX">
                                            </div>
                                        </div>
                                            <div class="col">
                                                <input type="hidden" class="form-control" name="role" id="role" placeholder="role" value="teacher">
                                            </div>
                                            <div class="col">
                                                <input type="hidden" class="form-control" name="status" id="status" placeholder="status" value="1">
                                            </div>
                                            <div class="col">
                                                <input type="hidden" class="form-control" name="section" id="section" placeholder="section" value="0">
                                            </div>
                                            <div class="col">
                                                <label for="password"><p>Password</p></label>
                                                <input type="password" class="form-control" name="password" id="password" placeholder="status" value="blazelearning2024" readonly>
                                            </div>
                                    </form>
                                    
                                    <div class="modal-footer">
                                        <button type="submit" id="submitAddTeacherForm" class="btn btn-success">Add Teacher</button>
                                        <button class="btn btn-light-dark" data-bs-dismiss="modal">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- add modal end -->
                <!-- edit modal start -->
                <div class="modal fade" id="editTeacherModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h6 class="modal-title" id="exampleModalCenterTitle"><b>Edit Teacher</b></h6>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="editTeacherForm">
                                        <div class="row mb-4">
                                            <div class="col-6">
                                                <label for="firstname"><p>First Name</p></label>
                                                <input type="text" class="form-control" name="firstname" id="efirstname" placeholder="e.g. Jane">
                                            </div>
                                            <div class="col-6">
                                                <label for="lastname"><p>Last Name</p></label>
                                                <input type="text" class="form-control" name="lastname" id="elastname" placeholder="e.g. Doe">
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col">
                                                <label for="teacherid"><p>Employee ID / Teacher ID</p></label>
                                                <input type="text" class="form-control" name="teacherid" id="eteacherid" placeholder="XX-XXXX-XXX / XXXXXXXXXX">
                                            </div>
                                        </div>
                                        <div class="row profile-image  mt-4">

                                            <div class="img-uploader-content">
                                                <label for="filepond"><p>Image</p></label><br>
                                                <input type="file" class="bg-dark w-100 rounded p-2"
                                                    name="filepond" accept="image/png, image/jpeg, image/gif"/>
                                            </div>
                        
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col">
                                                <label for="email"><p>Email Address</p></label>
                                                <input type="text" class="form-control" name="email" id="eemail" placeholder="example@provider.com">
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col">
                                                <label for="phone"><p>Phone Number</p></label>
                                                <input type="text" class="form-control" name="phone" id="ephone" placeholder="09XXXXXXXXX">
                                            </div>
                                        </div>
                                            <div class="col">
                                                <input type="hidden" class="form-control" name="role" id="erole" placeholder="role" value="teacher">
                                            </div>
                                            <div class="col">
                                                <input type="hidden" class="form-control" name="status" id="estatus" placeholder="status" value="1">
                                            </div>
                                            <div class="col">
                                                <input type="hidden" class="form-control" name="section" id="esection" placeholder="section" value="0">
                                            </div>
                                            <div class="col">
                                                <label for="password"><p>Password</p></label>
                                                <input type="password" class="form-control" name="password" id="epassword" placeholder="" value="">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success">Update</button>
                                                <button class="btn btn-light-dark" data-bs-dismiss="modal">Cancel</button>
                                            </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- edit modal end -->
                <!-- deactivate modal start -->
                <div class="modal fade" id="deactivateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h6 class="modal-title" id="exampleModalCenterTitle"><b>Deactivate Account</b></h6>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div>
                                        <p>Deactivate this teacher account? this process is reversible do you want to proceed?</p><br>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-dark">Deactivate</button>
                                        <button class="btn btn-light-dark" data-bs-dismiss="modal">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- deactivate modal end -->
                
                <!-- delete modal start -->
                <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h6 class="modal-title" id="exampleModalCenterTitle"><b>Delete Account</b></h6>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                    </svg>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div>
                                    <p>Delete this Teacher account? This process is non-reversible, and all records attached to this account ID will also be deleted. Do you want to proceed?</p><br>
                                </div>
                                <form id="deleteStudent">
                                    <input type="text" name="id" id="teacher_id">
                                    <div class="modal-footer">
                                        <button type="submit" id="deleteStud" class="btn btn-danger">Delete</button>
                                        <button type="button" id="cancelDeleteStudent" class="btn btn-light-dark" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </form>
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
                    <p class="">Coded with <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg></p>
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

    
    <!-- <script src="../../src/plugins/src/filepond/filepond.min.js"></script>
    <script src="../../src/plugins/src/filepond/FilePondPluginFileValidateType.min.js"></script>
    <script src="../../src/plugins/src/filepond/FilePondPluginImageExifOrientation.min.js"></script>
    <script src="../../src/plugins/src/filepond/FilePondPluginImagePreview.min.js"></script>
    <script src="../../src/plugins/src/filepond/FilePondPluginImageCrop.min.js"></script>
    <script src="../../src/plugins/src/filepond/FilePondPluginImageResize.min.js"></script>
    <script src="../../src/plugins/src/filepond/FilePondPluginImageTransform.min.js"></script>
    <script src="../../src/plugins/src/filepond/filepondPluginFileValidateSize.min.js"></script> -->
    

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->

    <script>
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
        
        document.addEventListener('DOMContentLoaded', function() {
            const deleteStudentForm = document.getElementById('deleteStudent');
            const cancelDeleteStudentForm = document.getElementById('cancelDeleteStudent');

            deleteStudentForm.addEventListener('submit', function(event) {
                event.preventDefault();

                const formData = new FormData(deleteStudentForm);
                const studentId = formData.get('id');

                fetch(`../../api/deleteData.php?delete=deleteTeacher&id=${studentId}`, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert('Error deleting Teacher Account: ' + data.error);
                    } else {
                        alert('Teacher Account deleted successfully.');
                        location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while deleting the Teacher Account.');
                });
            });

            cancelDeleteStudentForm.addEventListener('click', function() {
                const studentIdInput = document.getElementById('student_id');
                studentIdInput.value = '';
            });

            $('#deleteModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var dataId = button.data('id');
                $('#teacher_id').val(dataId);
            });
        });


        document.addEventListener('DOMContentLoaded', function() {

            document.getElementById('addTeacherForm').addEventListener('submit', function(event) {
                event.preventDefault();

                const formData = new FormData(this);

                for (const [key, value] of formData.entries()) {
                    console.log(`${key}:`, value);
                }

                fetch('../../api/addData.php?insertion=addTeacher', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        document.getElementById('course-error').textContent = data.error;
                    } else {
                        console.log(data.message);
                        alert('Teacher added successfully.');
                        location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });

            document.getElementById('submitAddTeacherForm').addEventListener('click', function() {
            document.getElementById('addTeacherForm').dispatchEvent(new Event('submit'));

            });

        });


    </script>

</body>
</html>