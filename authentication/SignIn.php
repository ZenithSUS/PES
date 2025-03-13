<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>OAS | SignIn </title>
    <link rel="icon" type="image/x-icon" href="../src/assets/img/favicon.ico"/>
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
    
</head>
<body class="form">

    <!-- BEGIN LOADER -->
    <div id="load_screen"> <div class="loader"> <div class="loader-content">
        <div class="spinner-grow align-self-center"></div>
    </div></div></div>
    <!--  END LOADER -->

    <div class="auth-container d-flex">

        <div class="container mx-auto align-self-center">
    
            <div class="row">
    
                <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-8 col-12 d-flex flex-column align-self-center mx-auto">
                    <div class="card mt-3 mb-3">
                        <div class="card-body">
    
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    
                                    <h2>Sign In</h2>
                                    <p>Innotor Inc.</p>
                                    
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <p id="login-error" class="badge badge-danger w-100 p-3"></p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Username</label>
                                        <input type="email" name="email" id="email" class="form-control">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-4">
                                        <label class="form-label">Password</label>
                                        <input type="password" name="password" id="password" class="form-control">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <div class="form-check form-check-primary form-check-inline">
                                            <input class="form-check-input me-3" type="checkbox" id="form-check-default">
                                            <label class="form-check-label" for="form-check-default">
                                                Remember me
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <div class="mb-4">
                                        <button id="signInBtn" class="btn btn-primary w-100">SIGN IN</button>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="text-center">
                                        <p class="mb-0">Forgot password? Click <a href="Reset.php" class="text-primary">here</a></p>
                                    </div>
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
            $('#signInBtn').click(function(e) {
                e.preventDefault();

                var email = $('#email').val();
                var password = $('#password').val();

                if (email.trim() == '' || password.trim() == '') {
                    alert('Please enter both email and password.');
                    return;
                }

                var data = {
                    email: email,
                    password: password
                };

                $.ajax({
                    url: '../api/authentication_api.php?auth=login',
                    type: 'POST',
                    dataType: 'json',
                    data: data,
                    success: function(response) {
                        if (response.error) {

                            alert('Login failed. ' + response.error);
                            $('#login-error').html(response.error);
                            $('#login-error').addClass('badge-danger');

                        } else {

                            $('#login-error').html(response.message).addClass(response.color).removeClass('badge-danger');

                            console.log(response.role);
                            console.log(response.employee_id);

                            localStorage.setItem('users-data', JSON.stringify(response));

                            var storedData = localStorage.getItem('users-data');

                            var userData = JSON.parse(storedData);
                             
                            let countdownValue = 2;

                            const countdownInterval = setInterval(() => {

                                countdownValue--;

                                if (countdownValue <= 0) {

                                    clearInterval(countdownInterval);
                                    
                                    if (response.role == 1) {

                                        window.location.href = '../pages/hr/dashboard.php';

                                    } else if(response.role == 0) {

                                        window.location.href = '../pages/admin/dashboard.php';

                                    } else if(response.role == 2) {

                                        window.location.href = '../pages/manager/dashboard.php';

                                    } else if(response.role == 3) {

                                        window.location.href = '../pages/user/dashboard.php';

                                    } else {

                                        alert('Unauthorized Access');

                                    }

                                }

                            }, 1000);

                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Error:', textStatus, errorThrown);
                        alert('Error occurred. Please try again.');
                    }
                });
            });
        });

        
    var storedData = localStorage.getItem('users-data');

    if (storedData) {
        var userData = JSON.parse(storedData);

        if (userData.login === true) {
            console.log('User is logged in');

            if (userData.role == 'teacher') {
                window.location.href = '../pages/hr/dashboard.php';
            } else {
                window.location.href = '../pages/admin/dashboard.php';
            }

        } else {
            window.location.href = '../../authentication/SignIn.php';
        }
    } else {
        // window.location.href = '../../authentication/SignIn.php';
    }

    </script>

</body>
</html>