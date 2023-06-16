<?php 
    include("../assets/connection/connection.php");
    include("../universal/stud_cookie.php");
    include("../universal/session.php");
?>

<!DOCTYPE html>
<html lang="en">

    <?php include("../universal/head.php");?>

    <body>
        <?php include("../universal/top_nav.php");?>
        <?php include("../universal/student_left_nav.php");?>

        <section class="section-content">
            <header class="content-action">
            </header>
            <div class="data">
                <div tableName>
                    <div class="table-data">
                        <table>
                            <thead>
                                <tr>
                                    <th>View Details</th>
                                    <th>LRN</th>
                                    <th>Schoolyear</th>
                                    <th>Firstname</th>
                                    <th>Middlename</th>
                                    <th>Lastname</th>
                                    <th>Address</th>
                                    <th>Yearlevel</th>
                                    <th>section</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $usrId = $_COOKIE['usrId'];
                                    $query = mysqli_query($conn, "SELECT * FROM `students` INNER JOIN `details` ON `students`.`student_id`=`details`.`student_id` INNER JOIN `school_year` ON `details`.`school_year_id`=`school_year`.`school_year_id` WHERE `user_id`= $usrId");

                                    if(mysqli_num_rows($query)>0){
                                        $rows = mysqli_fetch_assoc($query);?>
                                        <tr>
                                            <td class="td-action">
                                                <div>
                                                    <img src="../assets/icons/eye-open.svg" onclick="viewStudentInfoCta(<?php echo $rows['student_id'] ?>)">
                                                </div>
                                            </td>
                                            <td><?php echo $rows['lrn']?></td>
                                            <td><?php echo $rows['school_year_value']?></td>
                                            <td><?php echo $rows['first_name']?></td>
                                            <td><?php echo $rows['middle_name']?></td>
                                            <td><?php echo $rows['last_name']?></td>
                                            <td><?php echo $rows['address']?></td>
                                            <td><?php echo $rows['year_level']?></td>
                                            <td><?php echo $rows['section']?></td>
                                        </tr><?php
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
        <dialog class="dialog update-enrollment">
            <div class="top">
                <div class="left">
                    <p> Student Details</p>
                </div>
                <div class="right">
                    <img src="../assets/icons/close.svg" alt="close" onclick="closeUpdateInfoCta()">
                </div>
            </div>
            <div class="inputs" id="updateStudents">
                <h4 class="title">Student details</h4>
                <hr>
                <div class="details">
                    <section class="column">
                        <div>
                            <label for="updateFirstName">Firstname:</label>
                            <input type="text" id="updateFirstName" >
                        </div>
                        <div>
                            <label for="updateMiddleName">Middlename:</label>
                            <input type="text" id="updateMiddleName" >
                        </div>
                        <div>
                            <label for="updateLastName">Lastname:</label>
                            <input type="text" id="updateLastName" >
                        </div>
                        <div>
                            <label for="updateSuffix">Suffix:</label>
                            <input type="text" id="updateSuffix" >
                        </div>
                        <div>
                            <label for="updateBirthDate">Birthdate:</label>
                            <input type="date" id="updateBirthDate" >
                        </div>
                    </section>
                    <section class="column">
                        <div>
                            <label for="updateAge">Age:</label>
                            <input type="text" id="updateAge" >
                        </div>
                        <div>
                            <label for="updateSex">Sex:</label>
                            <select id="updateSex">
                                <option value="">Select...</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                        <div>
                            <label for="updateAddress">Address:</label>
                            <input type="text" id="updateAddress" >
                        </div>
                        <div>
                            <label for="updateEmailAddress">Email address:</label>
                            <input type="text" id="updateEmailAddress" >
                        </div>
                        <div>
                            <label for="updateContactNumber">Contact number:</label>
                            <input type="text" id="updateContactNumber" >
                        </div>
                    </section>
                    <section class="column">
                        <div>
                            <label for="updateYearLevel">Year level:</label>
                            <input type="text" id="updateYearLevel" >
                        </div>
                        <div>
                            <label for="updateSection">Section:</label>
                            <input type="text" id="updateSection" >
                        </div>
                        <div>
                            <label for="updateSchoolYear">School year:</label>
                        </div>
                    </section>
                </div>
                <h4 class="title">Parent details</h4>
                <hr>
                <div class="details">
                    <section class="column">
                        <div>
                            <label for="updateParentGuardian">Parent/Guardian Name:</label>
                            <input type="text" id="updateParentGuardian">
                        </div>
                        <div>
                            <label for="updateParentAddress">Parent/Guardian Address:</label>
                            <input type="text" id="updateParentAddress">
                        </div>
                        <div>
                            <label for="updateParentOccupation">Parent Occupation:</label>
                            <input type="text" id="updateParentOccupation">
                        </div>
                        <div>
                            <label for="updateParentContactNumber">Parent/Guardian Contact Number:</label>
                            <input type="text" id="updateParentContactNumber">
                        </div>
                    </section>
                    <section class="column">
                        <div>
                            <label for="updateRelation">Relation:</label>
                            <input type="text" id="updateRelation">
                        </div>
                    </section>
                </div>
                <button type="button" onclick="submitNewUpdateEnrollCta()"><img src="../assets/icons/save.svg" alt="save">Update</button>
            </div>
        </dialog>

    </body>
</html>