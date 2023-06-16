<?php
    $server_name = "localhost";
    $user_name = "root";
    $pass_word = "";
    $database_name = "ans_db";

    $conn = mysqli_connect($server_name,$user_name,$pass_word,$database_name);

    if(!$conn){
        die("Connection failed");
    }
?>