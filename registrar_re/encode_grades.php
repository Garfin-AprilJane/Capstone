<?php
    include("../assets/connection/connection.php"); 
    session_start();

     //add new Subjects
    if(isset($_POST['newSubject'])){

        $newSubject = mysqli_real_escape_string($conn, $_POST['newSubject']);

        //check if name exists already
        $sql = "SELECT * FROM `subjects` WHERE `subject_name`='$newSubject';";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) > 0){
            echo "Subject already exists";
        }
        else{
            $query = mysqli_query($conn,"INSERT INTO `subjects`(`subject_name`) VALUES('$newSubject');");
        }

    }
     //search Name for grade
     if(isset($_GET['filterName']) && isset($_GET['searchName']) && isset($_GET['entriesName'])){
        $filterName = mysqli_real_escape_string($conn,$_GET['filterName']);
        $searchName = mysqli_real_escape_string($conn,$_GET['searchName']);
        $entriesName = $_GET['entriesName'];
        
        //if filter is empty
        if($filterName === ""){
            $sql = "SELECT * FROM `students` INNER JOIN `details` ON `students`.`student_id`=`details`.`student_id` INNER JOIN `school_year` ON `details`.`school_year_id`=`school_year`.`school_year_id` WHERE CONCAT(`first_name`,`last_name`) LIKE '%$searchName%' ORDER BY `students`.`student_id` ASC ";
            $_SESSION['conditionName'] = "WHERE CONCAT(`first_name`,`last_name`) LIKE '%$searchName%' ORDER BY `students`.`student_id` ASC ";
        }
        //if filter has value
        else{
            $sql = "SELECT * FROM `students` INNER JOIN `details` ON `students`.`student_id`=`details`.`student_id` INNER JOIN `school_year` ON `details`.`school_year_id`=`school_year`.`school_year_id` WHERE $filterName LIKE '%$searchName%' ORDER BY `students`.`student_id` ASC ";
            $_SESSION['conditionName'] = "WHERE $filterName LIKE '%$searchName%'";
        }
        $_SESSION['searchName'] = $sql;
        $_SESSION['pageNoName'] = 1;

        //refresh table
        tableName(1,$entriesName);
    }
        //previous page
        if(isset($_GET['prevPage']) && isset($_GET['entriesName'])){
            tableName($_GET['prevPage'],$_GET['entriesName']);
            $_SESSION['pageNoName'] = $_GET['prevPage'];
        }
    
        //next page
        if(isset($_GET['nextPage']) && isset($_GET['entriesName'])){
            tableName($_GET['nextPage'],$_GET['entriesName']);
            $_SESSION['pageNoName'] = $_GET['nextPage'];
        }
    
        //show entries per page
        if(isset($_GET['entriesName']) && isset($_GET['showPerPage'])){
            tableName(1,$_GET['entriesName']);
        }
    
    //table name
        function tableName($pageNo,$entriesName){
            include("../assets/connection/connection.php");
            ?>
    
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
                            $entriesPerPage = $entriesName;
                            $offset = ($pageNo - 1) * $entriesPerPage;
                            $prevPage = $pageNo - 1;
                            $nextPage = $pageNo + 1;
    
                            //search session set
                            if(isset($_SESSION['searchName'])){
                                $conditionName = $_SESSION['conditionName'];
                                $countAllEntries = mysqli_query($conn, "SELECT COUNT(*) as total_records FROM `students` $conditionName;");
                                $records = mysqli_fetch_array($countAllEntries);
                                $totalRecords = $records['total_records'];
                                $noOfPages = ceil($totalRecords / $entriesPerPage);
                                $sql = $_SESSION['searchName'] . " LIMIT $offset, $entriesPerPage;";
                            }
                            //not set
                            else{
                                $countAllEntries = mysqli_query($conn, "SELECT COUNT(*) as total_records FROM `students`;");
                                $records = mysqli_fetch_array($countAllEntries);
                                $totalRecords = $records['total_records'];
                                $noOfPages = ceil($totalRecords / $entriesPerPage);
                                $sql = "SELECT * FROM `students` INNER JOIN `details` ON `students`.`student_id`=`details`.`student_id` INNER JOIN `school_year` ON `details`.`school_year_id`=`school_year`.`school_year_id` ORDER BY `students`.`student_id` ASC LIMIT $offset, $entriesPerPage;";
                            }
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
            </div><?php
        }
    //  //for search student name1
    if(isset($_GET['searchStudentName'])){
        $studentName = mysqli_real_escape_string($conn,$_GET['searchStudentName']);
        $sql = "SELECT `student_id`, CONCAT(`first_name`,`middle_name`,`last_name`,`suffix`) AS 'full_name' FROM `students` WHERE CONCAT(`first_name`,`middle_name`,`last_name`,`suffix`) LIKE '%$studentName%';";
        
        $query = mysqli_query($conn,$sql);

        if(mysqli_num_rows($query)>0){
            while($rows = mysqli_fetch_array($query)){
                $studentId = $rows['student_id'];
                $fullname = $rows['full_name'];?>
                <p id="studentResult" onclick="studentInfoIdCta(<?php echo $studentId?>)"><?php echo $fullname?></p><?php
            }
        }
    }
    if(isset($_GET['studentId'])){
        $id = $_GET['studentId'];
        $query = mysqli_query($conn, "SELECT CONCAT(`first_name`,' ',`middle_name`,' ',`last_name`,' ',`suffix`) AS 'fullname' FROM `students` WHERE `student_id`=$id;");

        if(mysqli_num_rows($query)>0){
            $rows = mysqli_fetch_assoc($query);?>
            <p>Enter grade:</p>
            <div>
                <label for="studentname">Name:</label>
                <input type="text" id="studentname" value="<?php echo $rows['fullname']?>" readonly>
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
                <button type="button" onclick="submitFirstgradingCta()"><img src="../assets/icons/save.svg" alt="save">Submit</button>  
            </div><?php
        }
    }
         //for search student name3
     if(isset($_GET['searchStudentName2'])){
         $studentName2 = mysqli_real_escape_string($conn,$_GET['searchStudentName2']);
         $sql = "SELECT `student_id`, CONCAT(`first_name`,`middle_name`,`last_name`,`suffix`) AS 'full_name' FROM `students` WHERE CONCAT(`first_name`,`middle_name`,`last_name`,`suffix`) LIKE '%$studentName2%';";
        
         $query = mysqli_query($conn,$sql);

         if(mysqli_num_rows($query)>0){
             while($rows = mysqli_fetch_array($query)){
                 $studentId2 = $rows['student_id'];
                 $fullname = $rows['full_name'];?>
                 <p id="studentResult2" onclick="studentInfoId2Cta(<?php echo $studentId2?>)"><?php echo $fullname?></p><?php
             }
         }
     }
     if(isset($_GET['studentId2'])){
         $id = $_GET['studentId2'];
         $query = mysqli_query($conn, "SELECT CONCAT(`first_name`,' ',`middle_name`,' ',`last_name`,' ',`suffix`) AS 'fullname' FROM `students` WHERE `student_id`=$id;");

         if(mysqli_num_rows($query)>0){
             $rows = mysqli_fetch_assoc($query);?>

             <div>
                 <label for="studentname">Name:</label>
                 <input type="text" id="studentname2" value="<?php echo $rows['fullname']?>" readonly>
             </div>
                 <div>
                     <label for="subjectEnglish">English:</label>
                     <input type="text" id="subjectEnglish2">
                 </div>
                 <div>
                     <label for="subjectFilipino">Filipino:</label>
                     <input type="text" id="subjectFilipino2">
                 </div>
                 <div>
                     <label for="subjectMath">Math:</label>
                     <input type="text" id="subjectMath2">
                 </div>
                 <div>
                     <label for="subjectScience">Science:</label>
                     <input type="text" id="subjectScience2">
                 </div>
                 <div>
                     <label for="subjectAP">Araling Panlipunan:</label>
                     <input type="text" id="subjectAP2">
                 </div>
                 <div>
                     <label for="subjectEsp">Edukasyon sa Pagpapakatao:</label>
                     <input type="text" id="subjectEsp2">
                 </div>
                 <div>
                     <label for="subjectTle">Technology and Livelihood Education:</label>
                     <input type="text" id="subjectTle2">
                 </div>
                 <div>
                     <label for="subjectMapeh">Mapeh:</label>
                     <input type="text" id="subjectMusic2" placeholder="Music">
                     <input type="text" id="subjectArts2" placeholder="Arts">
                     <input type="text" id="subjectPe2" placeholder="Pe">
                     <input type="text" id="subjectHealth2" placeholder="Health">
                 </div>
                 <button type="button" onclick="submitSecondgradingCta()"><img src="../assets/icons/save.svg" alt="save">Submit</button>  
             </div><?php
        }
     }
    //for search student name2
    if(isset($_GET['searchStudentName3'])){
         $studentName3 = mysqli_real_escape_string($conn,$_GET['searchStudentName3']);
         $sql = "SELECT `student_id`, CONCAT(`first_name`,`middle_name`,`last_name`,`suffix`) AS 'full_name' FROM `students` WHERE CONCAT(`first_name`,`middle_name`,`last_name`,`suffix`) LIKE '%$studentName3%';";
        
        $query = mysqli_query($conn,$sql);

         if(mysqli_num_rows($query)>0){
            while($rows = mysqli_fetch_array($query)){
                 $studentId3 = $rows['student_id'];
                 $fullname = $rows['full_name'];?>
                 <p id="studentResult3" onclick="studentInfoId3Cta(<?php echo $studentId3?>)"><?php echo $fullname?></p><?php
             }
         }
     }
    if(isset($_GET['studentId3'])){
         $id = $_GET['studentId3'];
         $query = mysqli_query($conn, "SELECT CONCAT(`first_name`,' ',`middle_name`,' ',`last_name`,' ',`suffix`) AS 'fullname' FROM `students` WHERE `student_id`=$id;");

         if(mysqli_num_rows($query)>0){
             $rows = mysqli_fetch_assoc($query);?>

             <div>
                 <label for="studentname">Name:</label>
                 <input type="text" id="studentname3" value="<?php echo $rows['fullname']?>" readonly>
             </div>
             <div>
                 <label for="subjectEnglish">English:</label>
                 <input type="text" id="subjectEnglish3">
             </div>
             <div>
                 <label for="subjectFilipino">Filipino:</label>
                 <input type="text" id="subjectFilipino3">
             </div>
             <div>
                     <label for="subjectMath">Math:</label>
                     <input type="text" id="subjectMath3">
                 </div>
                 <div>
                     <label for="subjectScience">Science:</label>
                     <input type="text" id="subjectScience3">
                 </div>
                 <div>
                     <label for="subjectAP">Araling Panlipunan:</label>
                     <input type="text" id="subjectAP3">
                 </div>
                 <div>
                     <label for="subjectEsp">Edukasyon sa Pagpapakatao:</label>
                     <input type="text" id="subjectEsp3">
                 </div>
                 <div>
                     <label for="subjectTle">Technology and Livelihood Education:</label>
                     <input type="text" id="subjectTle3">
                 </div>
                 <div>
                    <label for="subjectMapeh">Mapeh:</label>
                     <input type="text" id="subjectMusic3" placeholder="Music">
                     <input type="text" id="subjectArts3" placeholder="Arts">
                     <input type="text" id="subjectPe3" placeholder="Pe">
                     <input type="text" id="subjectHealth3" placeholder="Health">
                 </div>
                 <button type="button" onclick="submitThirdgradingCta()"><img src="../assets/icons/save.svg" alt="save">Submit</button>  
             </div><?php
         }
     }
      //for search student name4
      if(isset($_GET['searchStudentName4'])){
         $studentName4 = mysqli_real_escape_string($conn,$_GET['searchStudentName4']);
         $sql = "SELECT `student_id`, CONCAT(`first_name`,`middle_name`,`last_name`,`suffix`) AS 'full_name' FROM `students` WHERE CONCAT(`first_name`,`middle_name`,`last_name`,`suffix`) LIKE '%$studentName4%';";
        
         $query = mysqli_query($conn,$sql);

         if(mysqli_num_rows($query)>0){
             while($rows = mysqli_fetch_array($query)){
                 $studentId4 = $rows['student_id'];
                 $fullname = $rows['full_name'];?>
                 <p id="studentResult4" onclick="studentInfoId4Cta(<?php echo $studentId4?>)"><?php echo $fullname?></p><?php
             }
         }
     }
     if(isset($_GET['studentId4'])){
         $id = $_GET['studentId4'];
         $query = mysqli_query($conn, "SELECT CONCAT(`first_name`,' ',`middle_name`,' ',`last_name`,' ',`suffix`) AS 'fullname' FROM `students` WHERE `student_id`=$id;");

         if(mysqli_num_rows($query)>0){
             $rows = mysqli_fetch_assoc($query);?>

             <div>
                 <label for="studentname">Name:</label>
                 <input type="text" id="studentname4" value="<?php echo $rows['fullname']?>" readonly>
             </div>
                 <div>
                     <label for="subjectEnglish">English:</label>
                     <input type="text" id="subjectEnglish4">
                 </div>
                 <div>
                     <label for="subjectFilipino">Filipino:</label>
                     <input type="text" id="subjectFilipino4">
                 </div>
                 <div>
                     <label for="subjectMath">Math:</label>
                     <input type="text" id="subjectMath4">
                 </div>
                 <div>
                     <label for="subjectScience">Science:</label>
                     <input type="text" id="subjectScience4">
                 </div>
                 <div>
                     <label for="subjectAP">Araling Panlipunan:</label>
                     <input type="text" id="subjectAP4">
                 </div>
                 <div>
                     <label for="subjectEsp">Edukasyon sa Pagpapakatao:</label>
                     <input type="text" id="subjectEsp4">
                 </div>
                 <div>
                     <label for="subjectTle">Technology and Livelihood Education:</label>
                  <input type="text" id="subjectTle4">
                </div>
                <div>
                     <label for="subjectMapeh">Mapeh:</label>
                     <input type="text" id="subjectMusic4" placeholder="Music">
                     <input type="text" id="subjectArts4" placeholder="Arts">
                    <input type="text" id="subjectPe4" placeholder="Pe">
                    <input type="text" id="subjectHealth4" placeholder="Health">
                 </div>
                 <button type="button" onclick="submitFourthgradingCta()"><img src="../assets/icons/save.svg" alt="save">Submit</button>  
            </div><?php
         }
     }

    //submit first grading grade
    if(isset($_POST['subjectEnglish'])&& isset($_POST['studentId']) && isset($_POST['subjectFilipino'])&& isset($_POST['subjectMath'])&& isset($_POST['subjectScience'])&& isset($_POST['subjectAP'])&& isset($_POST['subjectEsp'])&& isset($_POST['subjectTle'])&& isset($_POST['subjectMusic'])&& isset($_POST['subjectArts'])&& isset($_POST['subjectPe'])&& isset($_POST['subjectHealth']) && isset($_POST['average']) && isset($_POST['gradingPeriod'])){
        $studentId = mysqli_real_escape_string($conn, $_POST['studentId']);
        $subjectEnglish = mysqli_real_escape_string($conn, $_POST['subjectEnglish']);
        $subjectFilipino = mysqli_real_escape_string($conn, $_POST['subjectFilipino']);
        $subjectMath = mysqli_real_escape_string($conn, $_POST['subjectMath']);
        $subjectScience = mysqli_real_escape_string($conn, $_POST['subjectScience']);
        $subjectAP = mysqli_real_escape_string($conn, $_POST['subjectAP']);
        $subjectEsp = mysqli_real_escape_string($conn, $_POST['subjectEsp']);
        $subjectTle = mysqli_real_escape_string($conn, $_POST['subjectTle']);
        $subjectMusic = mysqli_real_escape_string($conn, $_POST['subjectMusic']);
        $subjectArts = mysqli_real_escape_string($conn, $_POST['subjectArts']);
        $subjectPe = mysqli_real_escape_string($conn, $_POST['subjectPe']);
        $subjectHealth = mysqli_real_escape_string($conn, $_POST['subjectHealth']);
        $average = mysqli_real_escape_string($conn, $_POST['average']);
        $gradingPeriod = mysqli_real_escape_string($conn, $_POST['gradingPeriod']);


        $query = mysqli_query($conn,"SELECT * FROM `$gradingPeriod` WHERE `student_id` = $studentId");
        if(mysqli_num_rows($query)>0){
            echo "grade exist";
        }
        else{
            // Add grade
        mysqli_query($conn, "INSERT INTO `$gradingPeriod`(`english`, `filipino`, `math`, `science`, `ap`, `esp`, `tle`, `music`, `art`, `pe`, `health` , `avg`,`student_id`) VALUES ('$subjectEnglish','$subjectFilipino','$subjectMath','$subjectScience','$subjectAP','$subjectEsp','$subjectTle','$subjectMusic','$subjectArts','$subjectPe','$subjectHealth','$average',$studentId);");
        }

        
    }

    //update first grading
    if(isset($_GET['updateStudentGrades1'])){
        $id = $_GET['updateStudentGrades1'];
        $_SESSION['updateGradeStudentId'] =$id;
        $query = mysqli_query($conn, "SELECT * FROM `students` INNER JOIN `first_grading` ON `students`.`student_id`=`first_grading`.`student_id` WHERE `students`.`student_id`=$id;");

        if(mysqli_num_rows($query)>0){
            $rows = mysqli_fetch_assoc($query);?>

                <h4 class="title">First Grading</h4>
                <hr>
                <div class="details">
                    <section class="column">
                        <div>
                            <label for="updateSubjectEnglish">English:</label>
                            <input type="text" oninput="validateInputGrades(this)" class="grade-inputs" pattern="[0-9]*\.?[0-9]*" id="updateSubjectEnglish" value="<?php echo $rows['english']?>" >
                        </div>
                        <div>
                            <label for="updateSubjectFilipino">Filipino:</label>
                            <input type="text" oninput="validateInputGrades(this)" class="grade-inputs" pattern="[0-9]*\.?[0-9]*" id="updateSubjectFilipino" value="<?php echo $rows['filipino']?>">
                        </div>
                        <div>
                            <label for="updateSubjectMath">Math:</label>
                            <input type="text" oninput="validateInputGrades(this)" class="grade-inputs" pattern="[0-9]*\.?[0-9]*" id="updateSubjectMath" value="<?php echo $rows['math']?>">
                        </div>
                        <div>
                            <label for="updateSubjectScience">Science:</label>
                            <input type="text" oninput="validateInputGrades(this)" class="grade-inputs" pattern="[0-9]*\.?[0-9]*" id="updateSubjectScience" value="<?php echo $rows['science']?>">
                        </div>
                        <div>
                            <label for="updateSubjectAP">Araling Panlipunan:</label>
                            <input type="text" oninput="validateInputGrades(this)" class="grade-inputs" pattern="[0-9]*\.?[0-9]*" id="updateSubjectAP" value="<?php echo $rows['ap']?>">
                        </div>
                        <div>
                            <label for="updateSubjectEsp">Edukasyon sa Pagpapakatao:</label>
                            <input type="text" oninput="validateInputGrades(this)" class="grade-inputs" pattern="[0-9]*\.?[0-9]*" id="updateSubjectEsp" value="<?php echo $rows['esp']?>">
                        </div>
                    </section>
                    <section class="column">
                        <div>
                            <label for="updateSubjectTle">Technology and Livelihood Education:</label>
                            <input type="text" oninput="validateInputGrades(this)" class="grade-inputs" pattern="[0-9]*\.?[0-9]*" id="updateSubjectTle" value="<?php echo $rows['tle']?>">
                        </div>
                        <div>
                            <label for="updateSubjectMusic">Music:</label>
                            <input type="text" oninput="validateInputGrades(this)" class="grade-inputs" pattern="[0-9]*\.?[0-9]*" id="updateSubjectMusic" placeholder="Music"value="<?php echo $rows['music']?>" >
                        </div>
                        <div>
                            <label for="updateSubjectArts">Arts:</label>
                            <input type="text" oninput="validateInputGrades(this)" class="grade-inputs" pattern="[0-9]*\.?[0-9]*" id="updateSubjectArts" placeholder="Arts" value="<?php echo $rows['art']?>">
                        </div>
                        <div>
                            <label for="updateSubjectArts">PE:</label>
                            <input type="text" oninput="validateInputGrades(this)" class="grade-inputs" pattern="[0-9]*\.?[0-9]*" id="updateSubjectPe" placeholder="Pe" value="<?php echo $rows['pe']?>">
                        </div>
                        <div>
                            <label for="updateSubjectArts">Health:</label>
                            <input type="text" oninput="validateInputGrades(this)" class="grade-inputs" pattern="[0-9]*\.?[0-9]*" id="updateSubjectHealth" placeholder="Health" value="<?php echo $rows['health']?>">
                        </div>
                        <div>
                            <label for="average">Average:</label>
                            <input type="text" id="updateAverage" value="<?php echo $rows['avg']?>" disabled>
                        </div>
                    </section>
                </div>
                <button type="button" onclick="submitNewUpdateGrade1Cta()"><img src="../assets/icons/save.svg" alt="save">Update</button>
                <?php
        }

    }
    //update second grading
    if(isset($_GET['updateStudentGrades2'])){
        $id = $_GET['updateStudentGrades2'];
        $_SESSION['updateGradeStudentId'] =$id;
        $query = mysqli_query($conn, "SELECT * FROM `students` INNER JOIN `second_grading` ON `students`.`student_id`=`second_grading`.`student_id` WHERE `students`.`student_id`=$id;");

        if(mysqli_num_rows($query)>0){
            $rows = mysqli_fetch_assoc($query);?>

                <h4 class="title">Second Grading</h4>
                <hr>
                <div class="details">
                    <section class="column">
                        <div>
                            <label for="updateSubjectEnglish">English:</label>
                            <input type="text" oninput="validateInputGrades(this)" pattern="[0-9]*\.?[0-9]*" id="updateSubjectEnglish2" value="<?php echo $rows['english']?>"readonly>
                        </div>
                        <div>
                            <label for="updateSubjectFilipino">Filipino:</label>
                            <input type="text" oninput="validateInputGrades(this)" pattern="[0-9]*\.?[0-9]*" id="updateSubjectFilipino2" value="<?php echo $rows['filipino']?>"readonly>
                        </div>
                        <div>
                            <label for="updateSubjectMath">Math:</label>
                            <input type="text" oninput="validateInputGrades(this)" pattern="[0-9]*\.?[0-9]*" id="updateSubjectMath2" value="<?php echo $rows['math']?>"readonly>
                        </div>
                        <div>
                            <label for="updateSubjectScience">Science:</label>
                            <input type="text" oninput="validateInputGrades(this)" pattern="[0-9]*\.?[0-9]*" id="updateSubjectScience2" value="<?php echo $rows['science']?>"readonly>
                        </div>
                        <div>
                            <label for="updateSubjectAP">Araling Panlipunan:</label>
                            <input type="text" oninput="validateInputGrades(this)" pattern="[0-9]*\.?[0-9]*" id="updateSubjectAP2" value="<?php echo $rows['ap']?>"readonly>
                        </div>
                        <div>
                            <label for="updateSubjectEsp">Edukasyon sa Pagpapakatao:</label>
                            <input type="text" oninput="validateInputGrades(this)" pattern="[0-9]*\.?[0-9]*" id="updateSubjectEsp2" value="<?php echo $rows['esp']?>"readonly>
                        </div>
                    </section>
                    <section class="column">
                        <div>
                            <label for="updateSubjectTle">Technology and Livelihood Education:</label>
                            <input type="text" oninput="validateInputGrades(this)" pattern="[0-9]*\.?[0-9]*" id="updateSubjectTle2" value="<?php echo $rows['tle']?>"readonly>
                        </div>
                        <div>
                            <label for="updateSubjectMusic">Music:</label>
                            <input type="text" oninput="validateInputGrades(this)" pattern="[0-9]*\.?[0-9]*" id="updateSubjectMusic2" placeholder="Music"value="<?php echo $rows['music']?>" readonly>
                        </div>
                        <div>
                            <label for="updateSubjectArts">Arts:</label>
                            <input type="text" oninput="validateInputGrades(this)" pattern="[0-9]*\.?[0-9]*" id="updateSubjectArts2" placeholder="Arts" value="<?php echo $rows['art']?>"readonly>
                        </div>
                        <div>
                            <label for="updateSubjectArts">PE:</label>
                            <input type="text" oninput="validateInputGrades(this)" pattern="[0-9]*\.?[0-9]*" id="updateSubjectPe2" placeholder="Pe" value="<?php echo $rows['pe']?>"readonly>
                        </div>
                        <div>
                            <label for="updateSubjectArts">Health:</label>
                            <input type="text" oninput="validateInputGrades(this)" pattern="[0-9]*\.?[0-9]*" id="updateSubjectHealth2" placeholder="Health" value="<?php echo $rows['health']?>"readonly>
                        </div>
                        <div>
                            <label for="average">Average:</label>
                            <input type="text" id="averageTwo" value="<?php echo $rows['avg']?>" disabled>
                        </div>
                    </section>
                </div><?php
        }

    }
    //update third grading
    if(isset($_GET['updateStudentGrades3'])){
        $id = $_GET['updateStudentGrades3'];
        $_SESSION['updateGradeStudentId'] =$id;
        $query = mysqli_query($conn, "SELECT * FROM `students` INNER JOIN `third_grading` ON `students`.`student_id`=`third_grading`.`student_id` WHERE `students`.`student_id`=$id;");

        if(mysqli_num_rows($query)>0){
            $rows = mysqli_fetch_assoc($query);?>

                <h4 class="title">Third Grading</h4>
                <hr>
                <div class="details">
                    <section class="column">
                        <div>
                            <label for="updateSubjectEnglish">English:</label>
                            <input type="text" oninput="validateInputGrades(this)" pattern="[0-9]*\.?[0-9]*" id="updateSubjectEnglish3" value="<?php echo $rows['english']?>"readonly>
                        </div>
                        <div>
                            <label for="updateSubjectFilipino">Filipino:</label>
                            <input type="text" oninput="validateInputGrades(this)" pattern="[0-9]*\.?[0-9]*" id="updateSubjectFilipino3" value="<?php echo $rows['filipino']?>"readonly>
                        </div>
                        <div>
                            <label for="updateSubjectMath">Math:</label>
                            <input type="text" oninput="validateInputGrades(this)" pattern="[0-9]*\.?[0-9]*" id="updateSubjectMath3" value="<?php echo $rows['math']?>"readonly>
                        </div>
                        <div>
                            <label for="updateSubjectScience">Science:</label>
                            <input type="text" oninput="validateInputGrades(this)" pattern="[0-9]*\.?[0-9]*" id="updateSubjectScience3" value="<?php echo $rows['science']?>"readonly>
                        </div>
                        <div>
                            <label for="updateSubjectAP">Araling Panlipunan:</label>
                            <input type="text" oninput="validateInputGrades(this)" pattern="[0-9]*\.?[0-9]*" id="updateSubjectAP3" value="<?php echo $rows['ap']?>"readonly>
                        </div>
                        <div>
                            <label for="updateSubjectEsp">Edukasyon sa Pagpapakatao:</label>
                            <input type="text" oninput="validateInputGrades(this)" pattern="[0-9]*\.?[0-9]*" id="updateSubjectEsp3" value="<?php echo $rows['esp']?>"readonly>
                        </div>
                    </section>
                    <section class="column">
                        <div>
                            <label for="updateSubjectTle">Technology and Livelihood Education:</label>
                            <input type="text" oninput="validateInputGrades(this)" pattern="[0-9]*\.?[0-9]*" id="updateSubjectTle3" value="<?php echo $rows['tle']?>"readonly>
                        </div>
                        <div>
                            <label for="updateSubjectMusic">Music:</label>
                            <input type="text" oninput="validateInputGrades(this)" pattern="[0-9]*\.?[0-9]*" id="updateSubjectMusic3" placeholder="Music"value="<?php echo $rows['music']?>"readonly >
                        </div>
                        <div>
                            <label for="updateSubjectArts">Arts:</label>
                            <input type="text" oninput="validateInputGrades(this)" pattern="[0-9]*\.?[0-9]*" id="updateSubjectArts3" placeholder="Arts" value="<?php echo $rows['art']?>"readonly>
                        </div>
                        <div>
                            <label for="updateSubjectArts">PE:</label>
                            <input type="text" oninput="validateInputGrades(this)" pattern="[0-9]*\.?[0-9]*" id="updateSubjectPe3" placeholder="Pe" value="<?php echo $rows['pe']?>"readonly>
                        </div>
                        <div>
                            <label for="updateSubjectArts">Health:</label>
                            <input type="text" oninput="validateInputGrades(this)" pattern="[0-9]*\.?[0-9]*" id="updateSubjectHealth3" placeholder="Health" value="<?php echo $rows['health']?>"readonly>
                        </div>
                        <div>
                            <label for="average">Average:</label>
                            <input type="text" id="averageTwo" value="<?php echo $rows['avg']?>" disabled>
                        </div>
                    </section>
                </div><?php
        }

    }
    //update fourth grading
    if(isset($_GET['updateStudentGrades4'])){
        $id = $_GET['updateStudentGrades4'];
        $_SESSION['updateGradeStudentId'] =$id;
        $query = mysqli_query($conn, "SELECT * FROM `students` INNER JOIN `fourth_grading` ON `students`.`student_id`=`fourth_grading`.`student_id` WHERE `students`.`student_id`=$id;");

        if(mysqli_num_rows($query)>0){
            $rows = mysqli_fetch_assoc($query);?>

                <h4 class="title">Fourth Grading</h4>
                <hr>
                <div class="details">
                    <section class="column">
                        <div>
                            <label for="updateSubjectEnglish">English:</label>
                            <input type="text" oninput="validateInputGrades(this)" pattern="[0-9]*\.?[0-9]*" id="updateSubjectEnglish4" value="<?php echo $rows['english']?>"readonly>
                        </div>
                        <div>
                            <label for="updateSubjectFilipino">Filipino:</label>
                            <input type="text" oninput="validateInputGrades(this)" pattern="[0-9]*\.?[0-9]*" id="updateSubjectFilipino4" value="<?php echo $rows['filipino']?>"readonly>
                        </div>
                        <div>
                            <label for="updateSubjectMath">Math:</label>
                            <input type="text" oninput="validateInputGrades(this)" pattern="[0-9]*\.?[0-9]*" id="updateSubjectMath4" value="<?php echo $rows['math']?>"readonly>
                        </div>
                        <div>
                            <label for="updateSubjectScience">Science:</label>
                            <input type="text" oninput="validateInputGrades(this)" pattern="[0-9]*\.?[0-9]*" id="updateSubjectScience4" value="<?php echo $rows['science']?>"readonly>
                        </div>
                        <div>
                            <label for="updateSubjectAP">Araling Panlipunan:</label>
                            <input type="text" oninput="validateInputGrades(this)" pattern="[0-9]*\.?[0-9]*" id="updateSubjectAP4" value="<?php echo $rows['ap']?>"readonly>
                        </div>
                    </section>
                    <section class="column">
                        <div>
                            <label for="updateSubjectEsp">Edukasyon sa Pagpapakatao:</label>
                            <input type="text" oninput="validateInputGrades(this)" pattern="[0-9]*\.?[0-9]*" id="updateSubjectEsp4" value="<?php echo $rows['esp']?>"readonly>
                        </div>
                        <div>
                            <label for="updateSubjectTle">Technology and Livelihood Education:</label>
                            <input type="text" oninput="validateInputGrades(this)" pattern="[0-9]*\.?[0-9]*" id="updateSubjectTle4" value="<?php echo $rows['tle']?>"readonly>
                        </div>
                        <div>
                            <label for="updateSubjectMusic">Music:</label>
                            <input type="text" oninput="validateInputGrades(this)" pattern="[0-9]*\.?[0-9]*" id="updateSubjectMusic4" placeholder="Music"value="<?php echo $rows['music']?>"readonly >
                        </div>
                        <div>
                            <label for="updateSubjectArts">Arts:</label>
                            <input type="text" oninput="validateInputGrades(this)" pattern="[0-9]*\.?[0-9]*" id="updateSubjectArts4" placeholder="Arts" value="<?php echo $rows['art']?>"readonly>
                        </div>
                        <div>
                            <label for="updateSubjectArts">PE:</label>
                            <input type="text" oninput="validateInputGrades(this)" pattern="[0-9]*\.?[0-9]*" id="updateSubjectPe4" placeholder="Pe" value="<?php echo $rows['pe']?>"readonly>
                        </div>
                        <div>
                            <label for="updateSubjectArts">Health:</label>
                            <input type="text" oninput="validateInputGrades(this)" pattern="[0-9]*\.?[0-9]*" id="updateSubjectHealth4" placeholder="Health" value="<?php echo $rows['health']?>"readonly>
                        </div>
                        <div>
                            <label for="average">Average:</label>
                            <input type="text" id="averageTwo" value="<?php echo $rows['avg']?>" disabled>
                        </div>
                    </section>
                </div><?php
        }

    }
    //submit update first grading
    if(isset($_POST['updateSubjectEnglish'])&& isset($_POST['updateSubjectMath'])&& isset($_POST['updateSubjectScience'])&& isset($_POST['updateSubjectAP'])&& isset($_POST['updateSubjectEsp'])&& isset($_POST['updateSubjectTle'])&& isset($_POST['updateSubjectMusic'])&& isset($_POST['updateSubjectArts'])&& isset($_POST['updateSubjectPe'])&& isset($_POST['updateSubjectHealth'])){
      
        $studentId =  $_SESSION['updateGradeStudentId'];
        $updateSubjectEnglish = mysqli_real_escape_string($conn, $_POST['updateSubjectEnglish']);
        $updateSubjectFilipino = mysqli_real_escape_string($conn, $_POST['updateSubjectFilipino']);
        $updateSubjectMath = mysqli_real_escape_string($conn, $_POST['updateSubjectMath']);
        $updateSubjectScience = mysqli_real_escape_string($conn, $_POST['updateSubjectScience']);
        $updateSubjectAP = mysqli_real_escape_string($conn, $_POST['updateSubjectAP']);
        $updateSubjectEsp = mysqli_real_escape_string($conn, $_POST['updateSubjectEsp']);
        $updateSubjectTle = mysqli_real_escape_string($conn, $_POST['updateSubjectTle']);
        $updateSubjectMusic = mysqli_real_escape_string($conn, $_POST['updateSubjectMusic']);
        $updateSubjectArts = mysqli_real_escape_string($conn, $_POST['updateSubjectArts']);
        $updateSubjectPe = mysqli_real_escape_string($conn, $_POST['updateSubjectPe']);
        $updateSubjectHealth = mysqli_real_escape_string($conn, $_POST['updateSubjectHealth']);
    
        //for first grading
        mysqli_query($conn, "UPDATE `first_grading` SET `english`='$updateSubjectEnglish',`filipino`='$updateSubjectFilipino',`math`=' $updateSubjectMath',`science`='$updateSubjectScience',`ap`='$updateSubjectAP',`esp`='$updateSubjectEsp',`tle`='$updateSubjectTle',`music`='$updateSubjectMusic',`art`='$updateSubjectArts',`pe`='$updateSubjectPe',`health`='$updateSubjectHealth' WHERE `student_id`=$studentId;");   
    }
    
?>