<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title> PES | SignIn </title>
    <link rel="icon" type="image/x-icon" href="../src/assets/img/favicon.ico" />
    <link href="../layouts/modern-light-menu/css/light/loader.css" rel="stylesheet" type="text/css" />
    <link href="../layouts/modern-light-menu/css/dark/loader.css" rel="stylesheet" type="text/css" />
    <script src="../layouts/modern-light-menu/loader.js"></script>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="../src/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />

    <link href="../layouts/modern-light-menu/css/light/plugins.css" rel="stylesheet" type="text/css" />
    <link href="../src/assets/css/light/authentication/auth-boxed.css" rel="stylesheet" type="text/css" />

    <link href="../layouts/modern-light-menu/css/dark/plugins.css" rel="stylesheet" type="text/css" />
    <link href="../src/assets/css/dark/authentication/auth-boxed.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- jQuery -->
    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <style>
        body.form {
            background-image: url('./innotor.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .auth-container {
            width: 100%;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            border: none;
            background-color: white;
        }

        .login-wrapper {
            max-width: 450px;
            margin: 0 auto;
            padding: 20px;
        }

        .btn-primary {
            background-color: #4361ee;
            border-color: #4361ee;
            padding: 10px;
            font-weight: 600;
        }

        .btn-primary:hover {
            background-color: #3a56d4;
            border-color: #3a56d4;
        }

        .form-control {
            padding: 12px 15px;
            border-radius: 6px;
        }

        .logo-container {
            text-align: center;
            margin-bottom: 25px;
        }

        .logo-container img {
            height: 80px;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .logo-container h2 {
            color: #2c3e50;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .logo-container p {
            color: #7f8c8d;
            font-size: 1rem;
        }
    </style>
</head>

<body class="form">

    <!-- BEGIN LOADER -->
    <div id="load_screen">
        <div class="loader">
            <div class="loader-content">
                <div class="spinner-grow align-self-center"></div>
            </div>
        </div>
    </div>
    <!--  END LOADER -->

    <div class="auth-container d-flex">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-8 col-12">
                    <div class="card mt-3 mb-3">
                        <div class="card-body">
                            <div class="login-wrapper">
                                <div class="logo-container">
                                    <img src="./logo.jpg" alt="Innotor Logo">
                                    <h2>Sign In</h2>
                                    <p>Innotor Inc.</p>
                                </div>

                                <div class="mb-3">
                                    <p id="login-error" class="badge badge-danger w-100 p-3"></p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Username</label>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email">
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Password</label>
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password">
                                </div>

                                <div class="mb-3 d-flex justify-content-between align-items-center">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="form-check-default">
                                        <label class="form-check-label" for="form-check-default">
                                            Remember me
                                        </label>
                                    </div>
                                    <div>
                                        <a href="Reset.php" class="text-primary">Forgot password?</a>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <button id="signInBtn" class="btn btn-primary w-100">SIGN IN</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="../src/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../src/assets/js/custom.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->

    <script>
        $(document).ready(function() {
            // Check for existing session on page load
            checkLoginStatus();

            $('#signInBtn').click(function(e) {
                e.preventDefault();
                handleLogin();
            });

            // Allow login on Enter key press
            $('#password').keypress(function(e) {
                if (e.which === 13) {
                    handleLogin();
                }
            });
        });

        function handleLogin() {
            var email = $('#email').val();
            var password = $('#password').val();

            if (email.trim() == '' || password.trim() == '') {
                $('#login-error').html('Please enter both email and password.').addClass('badge-danger').show();
                return;
            }

            var data = {
                email: email,
                password: password
            };

            $('#signInBtn').prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Signing in...');

            $.ajax({
                url: '../api/authentication_api.php?auth=login',
                type: 'POST',
                dataType: 'json',
                data: data,
                success: function(response) {
                    $('#signInBtn').prop('disabled', false).html('SIGN IN');

                    if (response.error) {
                        $('#login-error').html(response.error).addClass('badge-danger').show();
                    } else {
                        $('#login-error').html(response.message).addClass(response.color).removeClass('badge-danger').show();

                        // Store session data
                        localStorage.setItem('users-data', JSON.stringify(response));
                        sessionStorage.setItem('session-active', 'true');

                        // Redirect after delay
                        setTimeout(() => {
                            redirectBasedOnRole(response.role);
                        }, 1000);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $('#signInBtn').prop('disabled', false).html('SIGN IN');
                    console.error('Error:', textStatus, errorThrown);
                    $('#login-error').html('Error occurred. Please try again.').addClass('badge-danger').show();
                }
            });
        }

        function redirectBasedOnRole(role) {
            switch (parseInt(role)) {
                case 1:
                    window.location.href = '../pages/hr/dashboard.php';
                    break;
                case 0:
                    window.location.href = '../pages/admin/dashboard.php';
                    break;
                case 2:
                    window.location.href = '../pages/manager/dashboard.php';
                    break;
                case 3:
                    window.location.href = '../pages/user/dashboard.php';
                    break;
                default:
                    alert('Unauthorized Access');
                    window.location.href = 'SignIn.php';
            }
        }

        function checkLoginStatus() {
            var storedData = localStorage.getItem('users-data');

            if (storedData) {
                try {
                    var userData = JSON.parse(storedData);

                    if (userData.login === true && sessionStorage.getItem('session-active') === 'true') {
                        console.log('User is logged in');
                        redirectBasedOnRole(userData.role);
                    }
                } catch (e) {
                    console.error('Error parsing user data:', e);
                    clearSession();
                }
            }
        }

        function clearSession() {
            localStorage.removeItem('users-data');
            sessionStorage.removeItem('session-active');
        }
    </script>

</body>

</html>