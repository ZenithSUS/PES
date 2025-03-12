<?php

    include('../../api/database.php');
    include('../../api/session.php');

    

    if(isset($_SESSION['user_id'])) {

        $user_id = $_SESSION['user_id'];

        $retrieveUser = "SELECT * FROM accounts WHERE employee_id = $user_id";

        $result = $con->query($retrieveUser);

        if ($result->num_rows > 0) {
        
            $data = $result->fetch_assoc();

            $userFirstname = $data['first_name'];
            $userLastname = $data['last_name'];
            $userEmail = $data['email'];
            $userPhone = $data['phone'];
            $img = $data['img'];
            $role = $data['user_level'];

        }

    } else {

        echo '<script>
        
                localStorage.clear();
                window.location.href = "../../authentication/SignIn.php";

              </script>';

    }

?>


<li class="nav-item dropdown user-profile-dropdown order-lg-0 order-1">
    <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="userProfileDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <div class="avatar-container d-flex justify-content-end align-items-end">
            
            <div class="avatar avatar-sm avatar-indicators avatar-online">
                <?php

                    $base64Image = $img;
                    echo '<img src="../../api/'. $base64Image .'" class="rounded-circle" alt="avatar">';

                ?>
            </div>
        </div>
    </a>

    <div class="dropdown-menu position-absolute" aria-labelledby="userProfileDropdown">
        <div class="user-profile-section">
            <div class="media mx-auto">
                <div class="media-body">
                    <h5><?php echo $userFirstname." ".$userLastname ?></h5>
                    <p>
                        <?php 
                            echo ($role == 1) ? 'Human Resource' : 
                                (($role == 2) ? $_SESSION['department'].' Manager' : 
                                (($role == 3) ? 'Employee' : 'Administrator'));
                        ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="dropdown-item">
            <a href="./profile.php">
                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                <span>Profile</span>
            </a>
        </div>
        <div class="dropdown-item">
            <a href="../../authentication/SignIn.php" id="logoutAccount">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                    <polyline points="16 17 21 12 16 7"></polyline>
                    <line x1="21" y1="12" x2="9" y2="12"></line>
                </svg> <span>Log Out</span>
            </a>
        </div>
    </div>
    
</li>

<script>

    document.addEventListener('DOMContentLoaded', function() {

        const logout = document.getElementById('logoutAccount');

        logout.onclick = function() {
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
        };
    });

</script>