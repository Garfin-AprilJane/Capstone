<?php
include("../assets/connection/connection.php");
include("../universal/cashier_cookie.php");
include("../universal/session.php");
?>

<!DOCTYPE html>
<html lang="en">

<?php include("../universal/head.php"); ?>

<body>
    <?php include("../universal/top_nav.php"); ?>
    <?php include("../universal/cashier_left_nav.php"); ?>

    <section class="section-content">
        <header class="content-action">
        </header>
        <div class="data">
            <div tableName>
                <div class="table-data">
                    <table>
                        <thead>
                            <tr>
                                <th>LRN</th>
                                <th>Schoolyear</th>
                                <th>Firstname</th>
                                <th>Middlename</th>
                                <th>Lastname</th>
                                <th>Yearlevel</th>
                                <th>Section</th>
                                <th>School Uniform</th>
                                <th>P.E Uniform</th>
                                <th>Miscellaneous Fees</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $usrId = $_COOKIE['usrId'];
                            $query = mysqli_query($conn, "SELECT * FROM `students` INNER JOIN `details` ON `students`.`student_id`=`details`.`student_id` INNER JOIN `school_year` ON `details`.`school_year_id`=`school_year`.`school_year_id` WHERE `user_id`= $usrId");
                            if (mysqli_num_rows($query) > 0) {
                                $rows = mysqli_fetch_assoc($query); ?>
                                <tr>
                                    <td><?php echo $rows['lrn'] ?></td>
                                    <td><?php echo $rows['school_year_value'] ?></td>
                                    <td><?php echo $rows['first_name'] ?></td>
                                    <td><?php echo $rows['middle_name'] ?></td>
                                    <td><?php echo $rows['last_name'] ?></td>
                                    <td><?php echo $rows['year_level'] ?></td>
                                    <td><?php echo $rows['section'] ?></td>
                                </tr>
                                <tr>
                                    <td colspan="8">
                                        <form method="POST" action="process_payment.php">
                                            <h3>Payment</h3>
                                            <table class="table table-bordered" id="paymentTable" style="text-align: left;">
                                                <thead>
                                                    <tr>
                                                        <th width="15%">School Uniform</th>
                                                        <th width="15%">PE Uniform</th>
                                                        <th width="15%">Miscellaneous Fees</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <input type="text" name="school_uniform">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="pe_uniform">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="miscellaneous_fees">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <button type="submit" name="submit" class="btn btn-primary">Submit Payment</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</body>

</html>
