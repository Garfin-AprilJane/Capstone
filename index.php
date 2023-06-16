<?php
    include("./assets/connection/connection.php");

    if(isset($_COOKIE['usrId'])){
        $usrId = $_COOKIE['usrId'];
        $query = mysqli_query($conn, "SELECT * FROM `users` WHERE `user_id`=$usrId;");
        if(mysqli_num_rows($query)>0){
            $rows = mysqli_fetch_assoc($query);
            session_start();

            if($rows['role'] === "admin"){
                header("location: ./admin/user_accounts.php");
            }
            elseif($rows['role'] === "registrar"){
                header("location: ./registrar/enroll_student.php");
            }
            elseif($rows['role'] === "student"){
                header("location: ./student/view_reports.php");
            }
            elseif($rows['role'] === "cashier"){
                header("location: ./cashier/payment.php");
            }
            elseif($rows['role'] === "accounting"){
                header("location: ./student/view_reports.php");
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./assets/css/style.css">
        <link rel="icon" href="./assets/images/logo.jpeg">
        <script type="text/javascript" src="./assets/js/script.js" defer></script>
        <script type="text/javascript" src="./assets/js/admin.js" defer></script>
        <script type="text/javascript" src="./assets/js/registrar.js" defer></script>
        <script type="text/javascript" src="./assets/js/student.js" defer></script>
        <title>WTCA | Computerized Enrollment System</title>
    </head>
    <body>
        <main class="main-page">
            <div class="logo">
                <img src=./assets/images/logo.jpeg>
            </div>
            <div class="title">
                <h1>WTCA | Computerized Enrollment System</h1>
            </div>
            <div class="login-form">
                <form action="" method="post" autocomplete="off">
                    <div>
                        <input type="text" name="username" placeholder="Username" required onfocus="usernameFocusCta()">
                    </div>
                    <div>
                        <input type="password" name="password" placeholder="Password" required id="loginPassword" onfocus="passwordFocusCta()">
                        <img src="./assets/icons/eye-close.svg" onclick="eyeCloseCta()" id="eyeClose" >
                        <img src="./assets/icons/eye-open.svg" onclick="eyeOpenCta()" id="eyeOpen" class="display-none">
                    </div>

                    <?php
                        if(isset($_POST['login'])){
                            $username = mysqli_real_escape_string($conn, $_POST['username']);
                            $password = mysqli_real_escape_string($conn, $_POST['password']);
                            $hashPassword = md5(md5(md5(md5($password))));

                            $sql = "SELECT * FROM `users` WHERE BINARY `username`= '$username' AND BINARY `password`= '$hashPassword' AND `status`='activated';";
                            $query = mysqli_query($conn, $sql);

                            if(mysqli_num_rows($query)>0){
                                $rows = mysqli_fetch_assoc($query);
                                $role = $rows['role'];
                                $user_id = $rows['user_id'];
                                if($role === "admin"){
                                    setcookie("usrId", $user_id, time() + (86400 * 1), "/"); // 86400 = 1 day
                                    header("location:./admin/user_accounts.php");
                                }
                                elseif($role === "registrar"){
                                    setcookie("usrId", $user_id, time() + (86400 * 1), "/"); // 86400 = 1 day
                                    header("location:./registrar/enroll_student.php");
                                }
                                elseif($role === "student"){
                                    setcookie("usrId", $user_id, time() + (86400 * 1), "/"); // 86400 = 1 day
                                    header("location:./student/view_reports.php");
                                }
                                elseif($role === "cashier"){
                                    setcookie("usrId", $user_id, time() + (86400 * 1), "/"); // 86400 = 1 day
                                    header("location: ./cashier/payment.php");
                                }
                                elseif($role === "accounting"){
                                    setcookie("usrId", $user_id, time() + (86400 * 1), "/"); // 86400 = 1 day
                                    header("location:./accounting/reports.php");
                                }
                            }
                            else{?>
                                <p id="incorrectAccount">Incorrect Username or Password</p><?php
                            }
                        }
                    ?>
                    <button type="submit" name="login">Log in</button>
                </form>
            </div>
        </main>
    </body>
</html>