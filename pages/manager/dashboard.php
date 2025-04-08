<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>PES | Dashboard</title>
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
    <!--  -->
    <script>
        const authData = localStorage.getItem("users-data");

        if (authData) {
            let data = JSON.parse(authData);
            let role = parseInt(data.role);

            if (role !== 2) {
                if (role === 0) {
                    window.location.href = '../admin/dashboard.php';
                }

                if (role === 1) {
                    window.location.href = '../hr/dashboard.php';
                }

                if (role === 3) {
                    window.location.href = '../user/dashboard.php';
                }
            }
        } else {
            console.log("No data");
        }
    </script>

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

                <?php
                include('../../components/nav-dropdown.php');
                include('../../api/counter.php');

                ?>

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
                                <li class="breadcrumb-item">Manager</li>
                                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                            </ol>
                        </nav>
                    </div>

                    <div class="row layout-top-spacing">

                        <!-- counter -->
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="row widget-statistic">
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 layout-spacing">
                                    <div class="widget widget-one_hybrid widget-followers">
                                        <div class="widget-heading">
                                            <a href="employees.php">
                                                <div class="w-title">
                                                    <div class="w-icon">
                                                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                                            <line x1="3" y1="9" x2="21" y2="9"></line>
                                                            <line x1="9" y1="21" x2="9" y2="9"></line>
                                                        </svg>
                                                    </div>
                                                    <div class="">
                                                        <p class="w-value"><?php echo $_SESSION['department'] ?></p>
                                                        <h5 class="">Department</h5>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 layout-spacing">
                                    <div class="widget widget-one_hybrid widget-followers">
                                        <div class="widget-heading">
                                            <a href="employees.php">
                                                <div class="w-title">
                                                    <div class="w-icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users">
                                                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                                            <circle cx="9" cy="7" r="4"></circle>
                                                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                                        </svg>
                                                    </div>
                                                    <div class="">
                                                        <p class="w-value"><?php echo $dept_emp ?></p>
                                                        <h5 class=""><?php echo $_SESSION['department'] ?> Employee</h5>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 layout-spacing">
                                    <div class="widget widget-one_hybrid widget-followers">
                                        <div class="widget-heading">
                                            <a href="employees.php?filter=NotEvaluated">
                                                <div class="w-title">
                                                    <div class="w-icon">
                                                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                                            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                                                            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                                                        </svg>
                                                    </div>
                                                    <div class="">
                                                        <?php
                                                        include('../../api/counter.php');

                                                        // Fetch the manager's department
                                                        $managerDepartment = $_SESSION['department'];
                                                        $managerID = $_SESSION['user_id'];

                                                        // Query to fetch employees in the manager's department
                                                        $result = $con->query($sql);
                                                        $sql = "SELECT COUNT(*) AS for_eval FROM accounts WHERE (archived != 3 AND user_level != 0) AND (
                                                        /* For Regular employees: use 2-week window */
                                                        (emp_status != 'Probationary' AND 
                                                        CURDATE() >= STR_TO_DATE(for_eval, '%M %d, %Y') AND
                                                        CURDATE() <= DATE_ADD(STR_TO_DATE(for_eval, '%M %d, %Y'), INTERVAL 2 WEEK))
                                                        OR
                                                        /* For Probationary employees: use 1-month window */
                                                        (emp_status = 'Probationary' AND 
                                                        CURDATE() >= STR_TO_DATE(for_eval, '%M %d, %Y') AND
                                                        CURDATE() <= DATE_ADD(STR_TO_DATE(for_eval, '%M %d, %Y'), INTERVAL 1 MONTH))
                                                        )
                                                        AND (employee_id != ? AND active = 1) AND (user_level = 3 AND department = ?)
                                                    ORDER BY date_hired DESC;";

                                                        $stmt = $con->prepare($sql);
                                                        $stmt->bind_param("ss", $managerID, $managerDepartment);
                                                        $stmt->execute();
                                                        $result = $stmt->get_result();
                                                        $row = $result->fetch_assoc();
                                                        $forEvalCount = $row['for_eval'];
                                                        $stmt->close();

                                                        ?>
                                                        <p class="w-value"><?php echo $forEvalCount; ?></p>
                                                        <h5 class="">For Evaluation</h5>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- counter -->
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
    <script src="../../layouts/modern-light-menu/app.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
    <!-- <script src="../../src/plugins/src/apex/apexcharts.min.js"></script> -->
    <script src="../../src/assets/js/dashboard/dash_1.js"></script>
    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->

</body>

</html>

<script>
    var storedData = localStorage.getItem('users-data');

    if (storedData) {
        var userData = JSON.parse(storedData);

        if (userData.login === true) {

            console.log('User is logged in');

        } else {
            window.location.href = '../../authentication/SignIn.php';
        }
    } else {
        window.location.href = '../../authentication/SignIn.php';
    }
</script>