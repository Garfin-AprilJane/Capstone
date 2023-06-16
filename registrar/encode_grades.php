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
        <header class="content-action">
                <button type="button" onclick="addStudentsGradeCta()"><img src="../assets/icons/grades.svg">Add Student Grades</button>
                <!-- <button type="button" onclick="addNewSubjectCta()"><img src="../assets/icons/subject.svg">Add New Subjects</button> -->
        </header>
        <div class="data">
                <div class="top-actions">
                    <aside class="left">
                        <label for="entriesName">Show</label>
                        <select id="entriesName" onchange="entriesNameCta()">
                            <option value="5" selected>5</option>
                            <option value="10">10</option>
                            <option value="15">15</option>
                            <option value="20">20</option>
                        </select>
                        <label for="entriesName">entries per page</label>
                    </aside>
                    <aside class="right">
                        <div class="filter-by">
                            <label for="filter">Filter by:</label>
                            <select id="filterName">
                                <option value=""></option>
                                <option value="first_name">firstname</option>
                                <option value="last_name">lastname</option>
                                
                            </select>
                        </div>
                        <div class="search-bar">
                            <input type="search" oninput="searchStudentGradeCta()" id="searchName" placeholder="Search">
                        </div>
                    </aside>
                </div>
                <div tableName>
                    <div class="table-data">
                        <table>
                            <thead>
                                <tr>
                                    <th>View Grading</th>
                                    <th>#</th>
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

                                    if(isset($_GET['pageNo']) && $_GET['pageNo'] !== ""){
                                        $pageNo = $_GET['pageNo'];
                                    }
                                    else{
                                        $pageNo = 1;
                                    }

                                    $entriesPerPage = 5;
                                    $offset = ($pageNo - 1) * $entriesPerPage;
                                    $prevPage = $pageNo - 1;
                                    $nextPage = $pageNo + 1;
                                    $countAllEntries = mysqli_query($conn, "SELECT COUNT(*) as total_records FROM `students`;");
                                    $records = mysqli_fetch_array($countAllEntries);
                                    $totalRecords = $records['total_records'];
                                    $noOfPages = ceil($totalRecords / $entriesPerPage);
                                    $sql = "SELECT * FROM `students` INNER JOIN `details` ON `students`.`student_id`=`details`.`student_id` INNER JOIN `school_year` ON `details`.`school_year_id`=`school_year`.`school_year_id`  ORDER BY `students`.`student_id` ASC LIMIT $offset, $entriesPerPage;";
                                    $query = mysqli_query($conn,$sql);

                                    if(mysqli_num_rows($query)>0){
                                        while($rows = mysqli_fetch_assoc($query)){?>
                                            <tr>
                                                <td class="td-action">
                                                    <div>
                                                        <img src="../assets/icons/one-closed.svg" onclick="updateStudentGrades1Cta(<?php echo $rows['student_id'] ?>)">
                                                    </div>
                                                    <span>|</span>
                                                    <div>
                                                        <img src="../assets/icons/two-closed.svg" onclick="updateStudentGrades2Cta(<?php echo $rows['student_id'] ?>)">
                                                    </div>
                                                    <span>|</span>
                                                    <div>
                                                        <img src="../assets/icons/three-closed.svg" onclick="updateStudentGrades3Cta(<?php echo $rows['student_id'] ?>)">
                                                    </div>
                                                    <span>|</span>
                                                    <div>
                                                        <img src="../assets/icons/four-closed.svg" onclick="updateStudentGrades4Cta(<?php echo $rows['student_id'] ?>)">
                                                    </div>
                                                </td>
                                                <td><?php echo $rows['student_id']?></td>
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
                                    }
                                    else{
                                        echo "<tr><td colspan='9'>No results or no data in the table</td></tr>";
                                        $pageNo = 0;
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="pagination">
                        <aside>
                            <p id="pageOfPage">Page <?php echo $pageNo?> of <?php echo $noOfPages?></p>
                        </aside>
                        <aside>
                            <?php
                                //buttons prev
                                if($pageNo <= 1){?>
                                    <button type="button" class="button-disabled" disabled>Previous</button><?php
                                }
                                else{?>
                                    <button type="button" onclick="prevPageNameCta(<?php echo $prevPage?>)">Previous</button><?php
                                }

                                //button next

                                if($pageNo >= $noOfPages){?>
                                    <button type="button" class="button-disabled" disabled>Next</button><?php
                                }
                                else{?>
                                    <button type="button" onclick="nextPageNameCta(<?php echo $nextPage?>)">Next</button><?php
                                }
                            ?>
                            
                            
                        </aside>
                    </div>
                </div>
                <div class="total-data">
                    <?php
                        $query = mysqli_query($conn, "SELECT COUNT(*) FROM `students`;");
                        $rows = mysqli_fetch_array($query);
                        $total = $rows[0];
                    ?>
                    <p><b>Total:</b> <?=$total?> record/s</p>
                </div>
            </div>
        </section>
        <!-- add new Subjects -->
        <dialog class="dialog new-subject diaglogActive">
            <div class="top">
                <div class="left">
                    <p>New subjects</p>
                </div>
                <div class="right">
                    <img src="../assets/icons/close.svg" alt="close" onclick="closeSubjectCta()">
                </div>
            </div>
            <div class="inputs">
                <div>
                    <label for="newSubject">Add new subjects</label>
                    <input type="text" id="newSubject" placeholder="ex:english">
                </div>
                <button type="button" onclick="submitnewSubjectCta()"><img src="../assets/icons/save.svg" alt="save">Add</button>           
            </div><br>
            <h4 class="title">Subject List</h4><br>
            <div class="inputs">
                <?php
                    $query = mysqli_query($conn,"SELECT * FROM `subjects` ORDER BY `subject_name` ASC;");
                    if(mysqli_num_rows($query)>0){
                        while($rows = mysqli_fetch_assoc($query)){?>
                                <p><?php echo $rows['subject_name']?></p><?php
                        }
                    }
                ?>
            
            </div>
           
        </dialog>
        <!-- add grades -->
        <dialog class="dialog add-grade diaglogActive">
            <div class="top">
                <div class="left">
                    <p>New grades</p>
                </div>
                <div class="right">
                    <img src="../assets/icons/close.svg" alt="close" onclick="closeGradeCta()">
                </div>
            </div>
            <div class="inputs">
                <div>
                    <label>Grading Period:</label>
                    <select id="gradingPeriod">
                        <option value="">Select...</option>
                        <option value="first_grading" >First Grading</option>
                        <option value="second_grading" >Second Grading</option>
                        <option value="third_grading" >Third Grading</option>
                        <option value="fourth_grading" >Fourth Grading</option>
                    </select>
                </div>
            </div>
            <!-- ok -->
            <div class="inputs" id="studentInfoForFirstGrading">
                    <div>
                        <select id="studentId">
                            <option value="">Select Student</option>
                                <?php
                                    $query = mysqli_query($conn,"SELECT * FROM students");
                                    while($rows = mysqli_fetch_assoc($query)){
                                        $fullName = $rows['first_name'].' '.$rows['middle_name'].' '.$rows['last_name'];?>
                                        <option value='<?php echo $rows['student_id']?>'><?php echo $fullName?></option><?php
                                    }
                                    
                                ?>                   
                        </select>
                    </div>
                    <div class="details">
                        <section class="column">
                            <div>
                                <label for="subjectEnglish">English:</label>
                                <input type="text" oninput="validateInputGrades(this)" pattern="[0-9]*\.?[0-9]*" class="grade-input" id="subjectEnglish" step="any" >
                            </div>
                            <div>
                                <label for="subjectFilipino">Filipino:</label>
                                 <input type="text" oninput="validateInputGrades(this)" pattern="[0-9]*\.?[0-9]*" class="grade-input" id="subjectFilipino" step="any">
                            </div>
                            <div>
                                <label for="subjectMath">Math:</label>
                                 <input type="text" oninput="validateInputGrades(this)" pattern="[0-9]*\.?[0-9]*" class="grade-input" id="subjectMath" step="any">
                            </div>
                            <div>
                                <label for="subjectScience">Science:</label>
                                 <input type="text" oninput="validateInputGrades(this)" pattern="[0-9]*\.?[0-9]*" class="grade-input" id="subjectScience" step="any">
                            </div>
                            <div>
                                <label for="subjectAP">Araling Panlipunan:</label>
                                 <input type="text" oninput="validateInputGrades(this)" pattern="[0-9]*\.?[0-9]*" class="grade-input" id="subjectAP" step="any">
                            </div>
                        </section>
                        <section class="column">
                            <div>
                                <label for="subjectEsp">Edukasyon sa Pagpapakatao:</label>
                                 <input type="text" oninput="validateInputGrades(this)" pattern="[0-9]*\.?[0-9]*" class="grade-input" id="subjectEsp" step="any">
                            </div>
                            <div>
                                <label for="subjectTle">Technology and Livelihood Education:</label>
                                 <input type="text" oninput="validateInputGrades(this)" pattern="[0-9]*\.?[0-9]*" class="grade-input" id="subjectTle" step="any">
                            </div>
                            <div>
                                <label for="subjectMapeh">Mapeh:</label>
                                 <input type="text" oninput="validateInputGrades(this)" pattern="[0-9]*\.?[0-9]*" class="grade-input" id="subjectMusic" placeholder="Music" step="any">
                                 <input type="text" oninput="validateInputGrades(this)" pattern="[0-9]*\.?[0-9]*" class="grade-input" id="subjectArts" placeholder="Arts" step="any">
                                 <input type="text" oninput="validateInputGrades(this)" pattern="[0-9]*\.?[0-9]*" class="grade-input" id="subjectPe" placeholder="Pe" step="any">
                                 <input type="text" oninput="validateInputGrades(this)" pattern="[0-9]*\.?[0-9]*" class="grade-input" id="subjectHealth" placeholder="Health" step="any">
                            </div>
                            <div>
                                <label for="average">Average:</label>
                                <input type="text" id="average"disabled>
                            </div>
                        </section>
                    </div>
                    <button type="button" onclick="submitGradesCta()"><img src="../assets/icons/save.svg" alt="save">Submit</button>
            </div>

        </dialog>
        <!-- update grades -->
        <dialog class="dialog update-grade">
            <div class="top">
                <div class="left">
                    <p>Student Grade</p>
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
                </div>
                <button type="button" onclick="submitNewUpdateGradeCta()"><img src="../assets/icons/save.svg" alt="save">Update</button>
            </div>
        </dialog>
        <!-- add grades -->
        <!-- <dialog class="dialog add-grade diaglogActive">
            <div class="top">
                <div class="left">
                    <p>Add grades</p>
                </div>
                <div class="right">
                    <img src="../assets/icons/close.svg" alt="close" onclick="closeGradingCta()">
                </div>
            </div>
            <div class="inputs">
                <div>
                    <label>Grading Period:</label>
                    <select onchange="gradingPeriodCta()" id="gradingPeriod">
                        <option value="">Select...</option>
                        <option value="firstgrading" id="firstgrading">First Grading</option>
                        <option value="secondgrading" id="secondgrading">Second Grading</option>
                        <option value="thirdgrading" id="thirdgrading">Third Grading</option>
                        <option value="fourthgrading" id="fourthgrading">Fourth Grading</option>
                    </select>
                </div><br>
                <!-- search student name1 -->
                <!-- <div class="input-fields display-none" id="studentInfo">
                    <div class="search-student">
                        <label for="searchStudentName">Search Student Name:</label>
                        <input type="search" id="searchStudentName" placeholder="Search" oninput="searchStudentForGradeCta()" autocomplete="off">
                        <div class="result" id="searchStudentResult" autocomplete="off"> -->
                            <!--affair if search student name -->
                        <!-- </div>
                    </div>
                </div> -->
                <!-- for first grading -->
                <!-- <section class=" display-none" id="studentInfoForFirstGrading">
                    <div>
                        <label for="studentname">Name:</label>
                        <input type="text" id="studentname" readonly>
                    </div>
                    <div>
                        <label for="subjectEnglish">English:</label>
                        <input type="text" id="subjectEnglish">
                    </div>
                    <div>
                        <label for="subjectFilipino">Filipino:</label>
                        <input type="text" id="subjectFilipino">
                    </div>
                    <div>
                        <label for="subjectMath">Math:</label>
                        <input type="text" id="subjectMath">
                    </div>
                    <div>
                        <label for="subjectScience">Science:</label>
                        <input type="text" id="subjectScience">
                    </div>
                    <div>
                        <label for="subjectAP">Araling Panlipunan:</label>
                        <input type="text" id="subjectAP">
                    </div>
                    <div>
                        <label for="subjectEsp">Edukasyon sa Pagpapakatao:</label>
                        <input type="text" id="subjectEsp">
                    </div>
                    <div>
                        <label for="subjectTle">Technology and Livelihood Education:</label>
                        <input type="text" id="subjectTle">
                    </div>
                    <div>
                        <label for="subjectMapeh">Mapeh:</label>
                        <input type="text" id="subjectMusic" placeholder="Music">
                        <input type="text" id="subjectArts" placeholder="Arts">
                        <input type="text" id="subjectPe" placeholder="Pe">
                        <input type="text" id="subjectHealth" placeholder="Health">
                    </div>
                </section> --> 
    </body>
</html>