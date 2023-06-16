<?php
    include("../assets/connection/connection.php");
    session_start();

    if(!isset($_COOKIE['usrId'])){
        header("location: ../index.php");
    }
    else{
        $usrId = $_COOKIE['usrId'];

        $query = mysqli_query($conn, "SELECT * FROM `users` WHERE `user_id`=$usrId;");
        if(mysqli_num_rows($query)>0){
            $rows = mysqli_fetch_assoc($query);
            if($rows['role'] !== "cashier"){
                header("location: ../index.php");
            }
        }
    }
?>