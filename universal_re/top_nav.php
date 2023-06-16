<?php
    include("../assets/connection/connection.php");
    $usrId = $_COOKIE['usrId'];

    //personal details
    if(isset($_GET['personalDetails'])){
        

    } 
   
    //for change current password
    if(isset($_GET['changeCurrentPassword']) && isset($_GET['changeNewPassword'])){
        $currentPassword = mysqli_real_escape_string($conn, $_GET['changeCurrentPassword']);
        $newPassword = mysqli_real_escape_string($conn, $_GET['changeNewPassword']);
        $hashCurrent = md5(md5(md5(md5($currentPassword))));
        $hashNew = md5(md5(md5(md5($newPassword))));

        //check if current password is right
        $query = mysqli_query($conn,"SELECT * FROM `users` WHERE `user_id`=$usrId AND `password`='$hashCurrent';");

        if(mysqli_num_rows($query)>0){
            mysqli_query($conn, "UPDATE `users` SET `password`='$hashNew' WHERE `user_id`=$usrId;");
        }
        else{
            echo "false";
        }
    }

?>
