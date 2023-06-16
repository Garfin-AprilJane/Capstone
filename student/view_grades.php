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
                                    <th>View Grades</th>
                                    <th>LRN</th>
                                    <th>Schoolyear</th>
                                    <th>Firstname</th>
                                    <th>Middlename</th>
                                    <th>Lastname</th>
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
                                                        <img src="../assets/icons/one-closed.svg" onclick="StudentGrades1Cta(<?php echo $rows['student_id'] ?>)">
                                                    </div>
                                                    <span>|</span>
                                                    <div>
                                                        <img src="../assets/icons/two-closed.svg" onclick="StudentGrades2Cta(<?php echo $rows['student_id'] ?>)">
                                                    </div>
                                                    <span>|</span>
                                                    <div>
                                                        <img src="../assets/icons/three-closed.svg" onclick="StudentGrades3Cta(<?php echo $rows['student_id'] ?>)">
                                                    </div>
                                                    <span>|</span>
                                                    <div>
                                                        <img src="../assets/icons/four-closed.svg" onclick="StudentGrades4Cta(<?php echo $rows['student_id'] ?>)">
                                                    </div>
                                                </td>
                                                <td><?php echo $rows['lrn']?></td>
                                                <td><?php echo $rows['school_year_value']?></td>
                                                <td><?php echo $rows['first_name']?></td>
                                                <td><?php echo $rows['middle_name']?></td>
                                                <td><?php echo $rows['last_name']?></td>
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
         <!-- update grades -->
         <dialog class="dialog update-grade">
            <div class="top">
                <div class="left">
                </div>
                <div class="right">
                    <img src="../assets/icons/close.svg" alt="close" onclick="closeUpdateGradeCta()">
                </div>
            </div>
            <div class="inputs" id="updateGrade">
                <h4 class="title">First grading</h4>
                <hr>
                <div class="details">
                    <section class="column">
                    <div>
                            <label for="updateSubjectEnglish">English:</label>
                            <input type="text" id="updateSubjectEnglish">
                        </div>
                        <div>
                            <label for="updateSubjectFilipino">Filipino:</label>
                            <input type="text" id="updateSubjectFilipino">
                        </div>
                        <div>
                            <label for="updateSubjectMath">Math:</label>
                            <input type="text" id="updateSubjectMath">
                        </div>
                        <div>
                            <label for="updateSubjectScience">Science:</label>
                            <input type="text" id="updateSubjectScience">
                        </div>
                        <div>
                            <label for="updateSubjectAP">Araling Panlipunan:</label>
                            <input type="text" id="updateSubjectAP">
                        </div>
                        <div>
                            <label for="updateSubjectEsp">Edukasyon sa Pagpapakatao:</label>
                            <input type="text" id="updateSubjectEsp">
                        </div>
                        <div>
                            <label for="updateSubjectTle">Technology and Livelihood Education:</label>
                            <input type="text" id="updateSubjectTle">
                        </div>
                        <div>
                            <label for="updateSubjectMusic">Music:</label>
                            <input type="text" id="updateSubjectMusic" placeholder="Music">
                        </div>
                        <div>
                            <label for="updateSubjectArts">Arts:</label>
                            <input type="text" id="updateSubjectArts" placeholder="Arts">
                        </div>
                        <div>
                            <label for="updateSubjectArts">PE:</label>
                            <input type="text" id="updateSubjectPe" placeholder="Pe">
                        </div>
                        <div>
                            <label for="updateSubjectArts">Health:</label>
                            <input type="text" id="updateSubjectHealth" placeholder="Health">
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
                                <?php
                                    $query = mysqli_query($conn,"SELECT * FROM `school_year` ORDER BY `school_year_value` ASC;");
                                    if(mysqli_num_rows($query)>0){
                                        while($rows = mysqli_fetch_assoc($query)){?>
                                             <input type="text"value="<?php echo $rows['school_year_value']?>" readonly><?php
                                        }
                                    }
                                ?>
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
            </div>
        </dialog>

    </body>
</html>