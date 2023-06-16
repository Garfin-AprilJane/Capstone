<?php 
    include("../assets/connection/connection.php");
    include("../universal/reg_cookie.php");
    include("../universal/session.php");
?>

<!DOCTYPE html>
<html lang="en">

    <?php include("../universal/head.php");?>

    <body>
        <?php include("../universal/top_nav.php");?>
        <?php include("../universal/reg_left_nav.php");?>

        <section class="section-content">
            <div class="data">
            <div>
        <img src="../assets/images/logo.png" style="display:block; margin:0 auto 0 auto; width:6%;">
        <h4 style="text-align:center; font-weight:500; ">REPUBLIC OF THE PHILPPINES</h4>
        <h4 style="text-align:center; font-weight:500; ">ANTIQUE NATIONAL SCHOOL</h4>
        <h4 style="text-align:center; font-weight:500; ">T.A. FORNIER ST., SAN JOSE, ANTIQUE</h4>
        <br>
        <h4 style="text-align:center; ">ANS ENROLLMENT REPORT</h4>
        <h4 style="text-align:center; font-weight:500; ">LIST OF ALL ENROLLES</h4>
    </div>

    <br>
    <b style="text-align:right">DATE PREPARED:</b>
    <?php
    $date = date("m.d.Y", strtotime("+6 HOURS"));
    echo $date;
    ?>
    <br><br>

    <table class="sum12" style="border:1px solid black; border-collapse:collapse; width:100%">
        <tbody>
            <tr>
                <td id="colNo13" style="font-weight:bold; text-align:center; width:5%; border:1px solid black; padding:6px">ID</td>
                <td id="colSur13" style="font-weight:bold; text-align:center; width:6%; border:1px solid black; padding:6px">FIRST NAME</td>
                <td id="colFirst13" style="font-weight:bold; text-align:center; width:6%; border:1px solid black; padding:6px">MIDDLE NAME</td>
                <td id="colMid13" style="font-weight:bold; text-align:center; width:5%; border:1px solid black; padding:6px">LAST NAME</td>
                <td id="colExt13" style="font-weight:bold; text-align:center; width:6%; border:1px solid black; padding:6px">NAME EXTENSION</td>
                <td id="colGender13" style="font-weight:bold; text-align:center; width:5%; border:1px solid black; padding:6px">GENDER</td>
                <td id="colGender13" style="font-weight:bold; text-align:center; width:5%; border:1px solid black; padding:6px">ADDRESS</td>
                <td id="colGender13" style="font-weight:bold; text-align:center; width:5%; border:1px solid black; padding:6px">YEAR LEVEl</td>
                <td id="colGender13" style="font-weight:bold; text-align:center; width:5%; border:1px solid black; padding:6px">SECTION</td>
            </tr>

            <?php
            $query = $conn->query("SELECT * FROM `students` INNER JOIN `details` ON `students`.`student_id`=`details`.`student_id` INNER JOIN `school_year` ON `details`.`school_year_id`=`school_year`.`school_year_id`  ORDER BY `students`.`student_id`");
            while ($fetch = $query->fetch_array()) {
            ?>

                <tr>
                    <td id="lrn13" style="border:1px solid black; padding:1.5px; padding-top:3px; text-align:center"><?php echo $fetch['student_id'] ?></td>
                    <td id="sur13" style="border:1px solid black; padding-left:10px; padding-top:3px"><?php echo $fetch['first_name'] ?></td>
                    <td id="ext13" style="border:1px solid black; padding:1.5px; padding-top:3px; text-align:center"><?php echo $fetch['middle_name'] ?></td>
                    <td id="first13" style="border:1px solid black; padding:1.5px; padding-left:10px; padding-top:3px"><?php echo $fetch['last_name'] ?></td>
                    <td id="mid13" style="border:1px solid black; padding:1.5px; padding-left:10px; padding-top:3px"><?php echo $fetch['suffix'] ?></td>
                    <td id="gender13" style="border:1px solid black; padding:1.5px; padding-top:3px; text-align:center"><?php echo $fetch['sex'] ?></td>
                    <td id="gender13" style="border:1px solid black; padding-left:10px; padding-top:3px"><?php echo $fetch['address'] ?></td>
                    <td id="gender13" style="border:1px solid black; padding-left:10px; padding-top:3px"><?php echo $fetch['year_level'] ?></td>
                    <td id="gender13" style="border:1px solid black; padding-left:10px; padding-top:3px"><?php echo $fetch['section'] ?></td>
                </tr>

            <?php
            }
            ?>
        </tbody>
    </table>

            </div>
        </section>
        
    </body>
    <script type="text/javascript">
    function PrintPage() {
        window.print();
    }
    document.loaded = function() {}
    window.addEventListener('DOMContentLoaded', (event) => {
        PrintPage()
        setTimeout(function() {
            window.close()
        }, 750)
    });