<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Password Reset </title>
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
    <!-- jQuery -->
    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <!-- END GLOBAL MANDATORY STYLES -->
    <style>
        body {
            background-image: url('./innotor.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        .card-body {
            background-color: white;
        }

        .auth-container {
            margin-inline: auto;
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

    <div class="auth-container d-flex h-100">

        <div class="container mx-auto align-self-center">

            <div class="row">

                <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-8 col-12 d-flex flex-column align-self-center mx-auto">
                    <div class="card mt-3 mb-3">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-12 mb-3">

                                    <h2>Password Reset</h2>
                                    <p>Enter your email to recover used in creating your <b class="text-warning">Account</b>.</p>

                                </div>
                                <div class="col-md-12">
                                    <div class="mb-4">
                                        <label class="form-label">Email</label>
                                        <input type="email" id="email" class="form-control">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-4">
                                        <button class="btn btn-primary w-100" id="pass-reset">Send Password Reset</button>
                                    </div>
                                    <div class="text-center">
                                        <p class="mb-0">Remembered password? <a href="SignIn.php" class="text-warning">Sign In</a></p>
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
    <!-- END GLOBAL MANDATORY SCRIPTS -->


    <script>
        $(document).ready(() => {

            $('#pass-reset').click((e) => {
                e.preventDefault();
                let email = $('#email').val();

                if (email === '' || !email) {
                    showAlert("error", "Please enter your email");
                    return
                }

                handleResetPass(email);
            })

            function handleResetPass(email) {
                let data = {
                    email: email
                }
                $('#pass-reset').prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Resetting password...');

                $.ajax({
                    url: "../api/sendPasswordEmail.php",
                    type: 'POST',
                    dataType: 'json',
                    data: data,
                    success: (response) => {
                        if (response.success) {
                            showAlert("success", "Password has been reset! Please check your email for the new password.");
                            // Clear the input field after successful submission
                            $('#email').val('');
                        } else {
                            showAlert("error", response.message || "Something went wrong. Please try again.");
                        }
                    },
                    error: (xhr, status, error) => {
                        // Handle AJAX errors
                        console.error("AJAX Error:", status, error);
                        showAlert("error", "Network or server error. Please try again later.");
                    },
                    complete: () => {
                        // Re-enable the button regardless of success/failure
                        $('#pass-reset').prop('disabled', false).html('Send Password Reset');
                    }
                });
            }

            // Create alert function for better user feedback
            function showAlert(type, message) {
                // Remove any existing alerts
                $('.alert-feedback').remove();

                // Create a new alert element
                let alertClass = type === "success" ? "alert-success" : "alert-danger";
                let alertIcon = type === "success" ?
                    '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>' :
                    '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>';

                let alertElement = `
                    <div class="alert ${alertClass} alert-dismissible fade show mt-3 alert-feedback" role="alert">
                        <div class="d-flex">
                            <div class="me-2">${alertIcon}</div>
                            <div>${message}</div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `;

                // Insert the alert before the form fields
                $('.col-md-12.mb-3').after(alertElement);

                // Auto dismiss after 5 seconds
                if (type === "success") {
                    setTimeout(() => {
                        $('.alert-feedback').fadeOut('slow', function() {
                            $(this).remove();
                        });
                    }, 5000);
                }
            }
        })
    </script>

</body>

</html>