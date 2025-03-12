

<div class="sidebar-wrapper sidebar-theme">

            <nav id="sidebar">

                <div class="navbar-nav theme-brand  text-center">
                    <div class="nav-logo d-flex flex-column justify-content-center align-items-center">
                        <div class=" theme-logo w-100">
                            <img src="../../src/assets/img/inno.jpg" class="img-fluid" style="width: 65%; height: 100%" alt="haaa">
                        </div>
                        <div class="nav-item theme-text">
                            <p class="mb-5"></p>
                        </div>
                    </div>
                </div>
                                
                <div class="shadow-bottom"></div>

                <ul class="list-unstyled menu-categories" id="accordionExample">
                    <li class="menu">
                        <a href="./dashboard.php" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                                <span>Dashboard</span>
                            </div>
                        </a>
                    </li>

                    <li class="menu menu-heading">
                        <div class="heading"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line></svg><span>Management</span></div>
                    </li>

                        <?php 
                            if($_SESSION['role'] == 1) {

                                echo    '<li class="menu">
                                            <a href="./accounts.php" aria-expanded="false" class="dropdown-toggle">
                                                <div class="">
                                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg>
                                                    <span>Accounts</span>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="menu">
                                            <a href="./employees.php" aria-expanded="false" class="dropdown-toggle">
                                                <div class="">
                                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                                
                                                    <span>Employees</span>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="menu">
                                            <a href="./attendances.php" aria-expanded="false" class="dropdown-toggle">
                                                <div class="">
                                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                                
                                                    <span>DTR</span>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="menu">
                                            <a href="./evaluations.php" aria-expanded="false" class="dropdown-toggle">
                                                <div class="">
                                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
                                                
                                                    <span>Evaluation</span>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="menu">
                                            <a href="./violations.php" aria-expanded="false" class="dropdown-toggle">
                                                <div class="">
                                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                                                
                                                    <span>Violations</span>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="menu">
                                            <a href="./archive.php" aria-expanded="false" class="dropdown-toggle">
                                                <div class="">
                                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><polyline points="21 8 21 21 3 21 3 8"></polyline><rect x="1" y="3" width="22" height="5"></rect><line x1="10" y1="12" x2="14" y2="12"></line></svg>
                                                
                                                    <span>Archive</span>
                                                </div>
                                            </a>
                                        </li>

                                        ';

                            }
                            if($_SESSION['role'] == 2) {

                                echo    '
                                        <li class="menu">
                                            <a href="./employees.php" aria-expanded="false" class="dropdown-toggle">
                                                <div class="">
                                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                                
                                                    <span>Employees</span>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="menu">
                                            <a href="./attendances.php" aria-expanded="false" class="dropdown-toggle">
                                                <div class="">
                                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                                
                                                    <span>DTR</span>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="menu">
                                            <a href="./evaluations.php" aria-expanded="false" class="dropdown-toggle">
                                                <div class="">
                                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
                                                
                                                    <span>Evaluation</span>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="menu">
                                            <a href="./violations.php" aria-expanded="false" class="dropdown-toggle">
                                                <div class="">
                                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                                                
                                                    <span>Violations</span>
                                                </div>
                                            </a>
                                        </li>

                                        ';

                            }
                            
                            if($_SESSION['role'] == 3) {

                                echo    '
                                        <li class="menu">
                                            <a href="./attendances.php" aria-expanded="false" class="dropdown-toggle">
                                                <div class="">
                                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                                
                                                    <span>Attendance</span>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="menu">
                                            <a href="./evaluation_summary.php" aria-expanded="false" class="dropdown-toggle">
                                                <div class="">
                                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
                                                
                                                    <span>Evaluation</span>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="menu">
                                            <a href="./violations.php" aria-expanded="false" class="dropdown-toggle">
                                                <div class="">
                                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                                                
                                                    <span>Violations</span>
                                                </div>
                                            </a>
                                        </li>

                                        ';

                            }
                            if($_SESSION['role'] == 0) {

                                echo    '<li class="menu">
                                            <a href="./accounts.php" aria-expanded="false" class="dropdown-toggle">
                                                <div class="">
                                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg>
                                                    <span>Accounts</span>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="menu">
                                            <a href="./employees.php" aria-expanded="false" class="dropdown-toggle">
                                                <div class="">
                                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                                
                                                    <span>Employees</span>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="menu">
                                            <a href="./attendances.php" aria-expanded="false" class="dropdown-toggle">
                                                <div class="">
                                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                                
                                                    <span>DTR</span>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="menu">
                                            <a href="./evaluations.php" aria-expanded="false" class="dropdown-toggle">
                                                <div class="">
                                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
                                                
                                                    <span>Evaluation</span>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="menu">
                                            <a href="./violations.php" aria-expanded="false" class="dropdown-toggle">
                                                <div class="">
                                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                                                
                                                    <span>Violations</span>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="menu">
                                            <a href="./archive.php" aria-expanded="false" class="dropdown-toggle">
                                                <div class="">
                                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><polyline points="21 8 21 21 3 21 3 8"></polyline><rect x="1" y="3" width="22" height="5"></rect><line x1="10" y1="12" x2="14" y2="12"></line></svg>
                                                
                                                    <span>Archive</span>
                                                </div>
                                            </a>
                                        </li>

                                        ';

                            }
                        ?>
                </ul>
                
            </nav>

        </div>

        <script>

            document.addEventListener('DOMContentLoaded', function() {
                const currentLocation = window.location.href;
                const menuItems = document.querySelectorAll('#accordionExample .menu a.dropdown-toggle');
                
                menuItems.forEach(item => {
                    if (item.href === currentLocation) {
                        item.parentElement.classList.add('active');  // Add active class to li.menu
                        item.classList.add('picked');  // Add picked class to a.dropdown-toggle
                    }
                });
            });

        </script>

        <style>

            .picked {
                background-color: #FD9726 !important;
            }

            .dropdown-toggle:hover, svg:hover, .menu {
                color: #FD9726 !important;
            }
            .menu a[disabled] {
                pointer-events: none;
                color: #898989;
                cursor: not-allowed;
            }

        </style>