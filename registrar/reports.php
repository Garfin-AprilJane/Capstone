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

        <section class="section-contents">
            <div class="total">
                <div class="list">
                    <div>
                        <?php
                            $query = mysqli_query($conn, "SELECT COUNT(*) FROM `students`;");
                            if(mysqli_num_rows($query)>0){
                                $rows = mysqli_fetch_array($query);
                                $totalStudent = $rows[0];?>
                                <h3><?php echo $totalStudent?></h3><?php
                            }
                        ?>
                        <p>Enrolled Students</p>
                    </div>
                </div>
            </div>
        </section>
    </body>
</html>