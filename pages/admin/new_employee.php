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

    
    <link href="../../src/plugins/css/light/flatpickr/custom-flatpickr.css" rel="stylesheet" type="text/css">
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
    <link href="../../src/plugins/src/flatpickr/flatpickr.css" rel="stylesheet" type="text/css">
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
                                <li class="breadcrumb-item"><a href="employees.php">Employees</a></li>
                                <li class="breadcrumb-item"><a href="new_employee.php">New Employee</a></li>
                            </ol>
                        </nav>
                    </div>

                    <div class="row layout-spacing">
                        <div class="col-lg-12">
                            <div class="statbox widget box box-shadow">
                                <div class="widget-content widget-content-area p-5">
                                    <form id="addNewEmployeeForm">
                                        <div class="col-12">
                                            <p id="course-error" class="text-light w-100 badge badge-danger mt-2 mb-2"></p>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-4">
                                                <label for="firstname"><p>First Name</p></label>
                                                <input type="text" class="form-control" name="firstname" id="firstname" placeholder="e.g. Juan" onkeyup=generateUsername()>
                                            </div>
                                            <div class="col-4">
                                                <label for="middlename"><p>Middle Name</p></label>
                                                <input type="text" class="form-control" name="middlename" id="middlename" placeholder="e.g. Santos" onkeyup=generateUsername()>
                                            </div>
                                            <div class="col-4">
                                                <label for="lastname"><p>Last Name</p></label>
                                                <input type="text" class="form-control" name="lastname" id="lastname" placeholder="e.g. Dela Cruz" onkeyup=generateUsername()>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-4">
                                                <label for="gender"><p>Gender</p></label>
                                                <select name="gender" id="gender" class="form-select">
                                                    <option value="" selected disabled>---Select Gender---</option>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                </select>
                                            </div>
                                            <div class="col-4">
                                                <label for="department"><p>Department</p></label>
                                                <select name="department" id="department" class="form-select">
                                                    <option value="" selected disabled>---Select Department---</option>
                                                    <option value="Human Resource">Human Resource</option>
                                                    <option value="Finance">Finance</option>
                                                    <option value="Purchasing">Purchasing</option>
                                                    <option value="Warehouse">Warehouse</option>
                                                    <option value="Quality Control">Quality Control</option>
                                                    <option value="Production">Production</option>
                                                    <option value="Engineering">Engineering</option>
                                                    <option value="MIS">MIS</option>
                                                    <option value="Administration">Administration</option>
                                                </select>
                                            </div>
                                            <div class="col-4">
                                                <label for="position"><p>Position</p></label>
                                                <select name="position" id="position" class="form-select">
                                                    <option value="" selected disabled>---Select Position---</option>
                                                    <option value="Staff">Staff</option>
                                                    <option value="Operator">Operator</option>
                                                    <option value="Performance">Performance</option>
                                                    <option value="Timekeeping">Timekeeping</option>
                                                    <option value="Engineer">Engineer</option>
                                                    <option value="Technician">Technician</option>
                                                    <option value="Safety Officer">Safety Officer</option>
                                                    <option value="Driver">Driver</option>
                                                    <option value="Facility">Facility</option>
                                                    <option value="Supervisor">Supervisor</option>
                                                    <option value="Manager">Manager</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-3">
                                                <label for=""><p>Employee ID</p></label>
                                                <input type="text" class="form-control text-dark" name="employee_id" id="employee_id" readonly>
                                            </div>
                                            <div class="col-3">
                                                <label for=""><p>Employee RFID</p></label>
                                                <input type="text" class="form-control text-dark" name="rfid" id="rfid" readonly>
                                            </div>
                                            <div class="col-3">
                                                <label for=""><p>Employment Status</p></label>
                                                <select name="emps" id="emps" class="form-select">
                                                    <option value="" selected disabled>---Select Status---</option>
                                                    <option value="Regular">Regular</option>
                                                    <option value="Probationary">Probationary</option>
                                                    <option value="Intern">Intern</option>
                                                </select>
                                            </div>
                                            <div class="col-3">
                                                <label for=""><p>User Level</p></label>
                                                <select name="role" id="role" class="form-select">
                                                    <option value="" selected disabled>---Select Position---</option>
                                                    <option value="0">Admin</option>
                                                    <option value="1">Human Resource</option>
                                                    <option value="2">Manager</option>
                                                    <option value="3">User</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row profile-image  mt-4">

                                            <div class="img-uploader-content">
                                                <label for="filepond"><p>Employee Photo</p></label><br>
                                                <input type="file" class="bg-dark w-100 rounded p-2"
                                                    name="filepond" accept="image/png, image/jpeg, image/gif"/>
                                            </div>
                        
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-4 mt-3">
                                                <label for="email"><p>Email Address</p></label>
                                                <input type="text" class="form-control" name="email" id="email" placeholder="example@provider.com">
                                            </div>
                                            <div class="col-4 mt-3">
                                                <label for="phone"><p>Phone Number</p></label>
                                                <input type="text" class="form-control" name="phone" id="phone" placeholder="09XXXXXXXXX">
                                            </div>
                                            <div class="col-4 mt-3">
                                                <label for="lastname"><p>Date Hired</p></label>
                                                <input id="" class="form-control" name="dateHired" type="date" placeholder="Select Date..">
                                                <!-- <input id="rangeCalendarFlatpickr" class="form-control flatpickr flatpickr-input" name="dateHired" type="text" placeholder="Select Date.." readonly="readonly"> -->
                                            </div>
                                        </div>
                                            <div class="col">
                                                <input type="hidden" class="form-control" name="status" id="status" placeholder="status" value="1">
                                            </div>
                                            <div class="col">
                                                <label for="password"><p>Username</p></label>
                                                <input type="text" class="form-control" name="username" id="username" value="" readonly>
                                            </div>
                                            <div class="col">
                                                <label for="password"><p>Password( default: <b class="text-danger">innotor2024</b>)</p></label>
                                                <input type="password" class="form-control" name="password" id="password" placeholder="status" value="innotor2024" readonly>
                                            </div>
                                    </form>
                                    
                                    <div class="modal-footer mt-4">
                                        <button type="submit" class="btn btn-success m-3" id="submitEmployeeForm">Add Employee</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>

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

    
    <script src="../../src/plugins/src/filepond/filepond.min.js"></script>
    <script src="../../src/plugins/src/filepond/FilePondPluginFileValidateType.min.js"></script>
    <script src="../../src/plugins/src/filepond/FilePondPluginImageExifOrientation.min.js"></script>
    <script src="../../src/plugins/src/filepond/FilePondPluginImagePreview.min.js"></script>
    <script src="../../src/plugins/src/filepond/FilePondPluginImageCrop.min.js"></script>
    <script src="../../src/plugins/src/filepond/FilePondPluginImageResize.min.js"></script>
    <script src="../../src/plugins/src/filepond/FilePondPluginImageTransform.min.js"></script>
    <script src="../../src/plugins/src/filepond/filepondPluginFileValidateSize.min.js"></script>
    
    <script src="../../src/plugins/src/flatpickr/flatpickr.js"></script>

    <script src="../../src/plugins/src/flatpickr/custom-flatpickr.js"></script>

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->

    <script>
    
    function getLastEmployeeIdAndIncrement() {
        fetch('http://localhost/PES/api/fetch_record_api.php?action=getLastID')
            .then(response => response.json())
            .then(data => {
                if (data.last_employee_id) {
                    let lastEmployeeId = parseInt(data.last_employee_id, 10);
                    let newEmployeeId = lastEmployeeId + 1; 

                    document.getElementById('employee_id').value = newEmployeeId;
                } else {
                    console.error('Error retrieving the last employee ID.');
                }
            })
            .catch(error => console.error('Error:', error));
    }

    
    
    function getLastRFIDAndIncrement() {
        fetch('http://localhost/PES/api/fetch_record_api.php?action=getLastRFID')
            .then(response => response.json())
            .then(data => {
                if (data.last_employee_id) {
                    let lastEmployeeRFId = parseInt(data.last_employee_id, 10);
                    let newEmployeeRFId = lastEmployeeRFId + 1; 

                    document.getElementById('rfid').value = newEmployeeRFId;
                } else {
                    console.error('Error retrieving the last employee ID.');
                }
            })
            .catch(error => console.error('Error:', error));
    }


    document.addEventListener('DOMContentLoaded', function() {

        getLastRFIDAndIncrement();
        getLastEmployeeIdAndIncrement();

        document.getElementById('addNewEmployeeForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const formData = new FormData(this);

            for (const [key, value] of formData.entries()) {
                console.log(`${key}:`, value);
            }

            fetch('../../api/addData.php?insertion=newEmployee', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    // document.getElementById('course-error').textContent = data.error;
                    alert(data.error);
                } else {
                    console.log(data.message);
                    alert('Employee Data Added');
                    window.location.href = 'employees.php';
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });

        document.getElementById('submitEmployeeForm').addEventListener('click', function() {

            document.getElementById('addNewEmployeeForm').dispatchEvent(new Event('submit'));

        });

    });

    function generateUsername() {
        const firstname = document.getElementById('firstname').value.trim();
        const middlename = document.getElementById('middlename').value.trim();
        const lastname = document.getElementById('lastname').value.trim();
        const RFID = document.getElementById('rfid').value.trim();

        let username = '';
        if (firstname.length > 0) {
            username += firstname.charAt(0).toLowerCase();
        }
        if (middlename.length > 0) {
            username += middlename.charAt(0).toLowerCase();
        }
        if (lastname.length > 0) {
            username += lastname.replace(/\s+/g, '').toLowerCase();
        }

        username += RFID.slice(-4); // Append the last 4 digits of the RFID
        username = username.replace(/\s+/g, ''); // Remove any spaces
        username = username.replace(/[^a-zA-Z0-9]/g, ''); // Remove any special characters

        document.getElementById('username').value = username;
    }


</script>

</body>
</html>