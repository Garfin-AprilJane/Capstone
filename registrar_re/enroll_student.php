<?php
    include("../assets/connection/connection.php"); 
    session_start();

    
    //add new student
    if(isset($_POST['studentLRN']) &&isset($_POST['studentFirstName']) && isset($_POST['studentMiddleName']) && isset($_POST['studentLastName']) && isset($_POST['studentBirthDate']) && isset($_POST['studentAge']) && isset($_POST['studentEmailAddress']) && isset($_POST['studentSex']) && isset($_POST['studentAddress']) && isset($_POST['studentContactNumber']) && isset($_POST['studentYearLevel']) && isset($_POST['studentSection']) && isset($_POST['studentParentGuardian']) && isset($_POST['studentParentAddress']) && isset($_POST['studentParentOccupation']) && isset($_POST['studentParentContactNumber']) && isset($_POST['studentRelation']) && isset($_POST['studentSchoolYear']) && isset($_POST['entriesName'])){

        $studentLRN = mysqli_real_escape_string($conn, $_POST['studentLRN']);
        $studentFirstName = mysqli_real_escape_string($conn, $_POST['studentFirstName']);
        $studentMiddleName = mysqli_real_escape_string($conn, $_POST['studentMiddleName']);
        $studentLastName = mysqli_real_escape_string($conn, $_POST['studentLastName']);
        $studentSuffix = mysqli_real_escape_string($conn, $_POST['studentSuffix']);
        $studentSex = mysqli_real_escape_string($conn, $_POST['studentSex']);
        $studentBirthDate = mysqli_real_escape_string($conn, $_POST['studentBirthDate']);
        $studentAge = mysqli_real_escape_string($conn, $_POST['studentAge']);
        $studentEmailAddress = mysqli_real_escape_string($conn, $_POST['studentEmailAddress']);
        $studentAddress = mysqli_real_escape_string($conn, $_POST['studentAddress']);
        $studentYearLevel = mysqli_real_escape_string($conn, $_POST['studentYearLevel']);
        $studentSection = mysqli_real_escape_string($conn, $_POST['studentSection']);
        $studentParentGuardian = mysqli_real_escape_string($conn, $_POST['studentParentGuardian']);
        $studentParentAddress = mysqli_real_escape_string($conn, $_POST['studentParentAddress']);
        $studentParentOccupation = mysqli_real_escape_string($conn, $_POST['studentParentOccupation']);
        $studentContactNumber = mysqli_real_escape_string($conn, $_POST['studentContactNumber']);
        $studentParentContactNumber = mysqli_real_escape_string($conn, $_POST['studentParentContactNumber']);
        $studentRelation = mysqli_real_escape_string($conn, $_POST['studentRelation']);
        $studentSchoolYear = mysqli_real_escape_string($conn, $_POST['studentSchoolYear']);
        $entriesName = $_POST['entriesName'];
    
        //check if name exists already
        $sql = "SELECT * FROM `students` WHERE `lrn`='$studentLRN' AND `first_name`='$studentFirstName';";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) > 0){
            echo "Lrn already exists";
        }
        else{
             
            $query = mysqli_query($conn,"SELECT * FROM `school_year` WHERE `school_year_value`='$studentSchoolYear';");
            if(mysqli_num_rows($query)>0){
                $rows = mysqli_fetch_assoc($query);
                $schoolYearId = $rows['school_year_id'];

                 //student details
                mysqli_query($conn,"INSERT INTO `students`(`lrn`,`first_name`,`middle_name`,`last_name`,`suffix`,`sex`,`birth_date`,`address`,`email_address`,`contact_number`,`age`,`user_id`) VALUES ('$studentLRN','$studentFirstName',' $studentMiddleName','$studentLastName','$studentSuffix','$studentSex','$studentBirthDate','$studentAddress','$studentEmailAddress','$studentContactNumber','$studentAge',1);");

                //get the student id
                $queryStudentId = mysqli_query($conn,"SELECT * FROM `students` ORDER BY `student_id` DESC LIMIT 1;");
                $studentId= mysqli_fetch_assoc($queryStudentId)['student_id'];

                //parent details
                mysqli_query($conn, "INSERT INTO `parents`(`full_name`,`address`,`occupation`,`contact_number`,`relation`,`student_id`) VALUES('$studentParentGuardian','$studentParentAddress','$studentParentOccupation','$studentParentContactNumber','$studentRelation',$studentId);");

                //details
                mysqli_query($conn, "INSERT INTO `details`(`school_year_id`,`year_level`,`section`,`student_id`) VALUES($schoolYearId,'$studentYearLevel','$studentSection',$studentId);");
                
                //student history
                // mysqli_query($conn, "INSERT INTO `history`(`student_id`,`school_year_vale`,`section`,`grading_period`,`english`,`filipino`,`math`,`science`,`ap`,`esp`,`tle`,`music`,`art`,`pe`,`health`) VALUES($studentId,'$studentSchoolYear','$studentSection','');");
            }


            // //refresh table
            tableName(1,$_POST['entriesName']);
        }

    }

    //search Name
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
                        <th>Action</th>
                        <th>#</th>
                        <th>LRN</th>
                        <th>Schoolyear</th>
                        <th>Firstname</th>
                        <th>Middlename</th>
                        <th>Lastname</th>
                        <th>Address</th>
                        <th>Yearlevel</th>
                        <th>Section</th>
                        <th>Contactnumber</th>
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
                                            <img src="../assets/icons/edit.svg" onclick="editStudentInfoCta(<?php echo $rows['student_id'] ?>)">
                                        </div>
                                        <span>|</span>
                                        <div>
                                        <img src="../assets/icons/eye-open.svg" onclick="viewStudentInfoCta(<?php echo $rows['student_id'] ?>)">
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
                                    <td><?php echo $rows['contact_number']?></td>
                                </tr><?php
                            }
                        }
                        else{
                            echo "<tr><td colspan='10'>No results or no data in the table</td></tr>";
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
//edit student info
    if(isset($_GET['editStudentInfo'])){
        $id = $_GET['editStudentInfo'];
        $_SESSION['editStudentInfo'] =$id;
        $query = mysqli_query($conn, "SELECT * FROM `students` INNER JOIN `parents` ON `students`.`student_id`=`parents`.`student_id` INNER JOIN `details` ON `students`.`student_id`=`details`.`student_id` INNER JOIN `school_year` ON `details`.`school_year_id`=`school_year`.`school_year_id` WHERE `students`.`student_id`=$id;");

        if(mysqli_num_rows($query)>0){
            $rows = mysqli_fetch_assoc($query);?>

                <h4 class="title">Parent details</h4>
                <hr>
                <div class="details">
                    <section class="column">
                        <div>
                            <label for="updateParentGuardian">Parent/Guardian Name:</label>
                            <input type="text" id="updateParentGuardian" value="<?php echo $rows['full_name']?>">
                        </div>
                        <div>
                            <label for="updateParentAddress">Parent/Guardian Address:</label>
                            <input type="text" id="updateParentAddress" value="<?php echo $rows['address']?>">
                        </div>
                        <div>
                            <label for="updateParentOccupation">Parent Occupation:</label>
                            <input type="text" id="updateParentOccupation" value="<?php echo $rows['occupation']?>">
                        </div>
                        <div>
                            <label for="updateParentContactNumber">Parent/Guardian Contact Number:</label>
                            <input type="text" id="updateParentContactNumber" value="<?php echo $rows['contact_number']?>">
                        </div>
                    </section>
                    <section class="column">
                        <div>
                            <label for="updateRelation">Relation:</label>
                            <select id="updateRelation">
                                <?php
                                    if($rows['relation']==="father"){?>
                                        <option value="">Select...</option>
                                        <option value="father" selected>Father</option>
                                        <option value="mother" >Mother</option>
                                        <option value="guardian" >Guardian</option><?php
                                    }
                                    elseif($rows['relation']==="mother"){?>
                                        <option value="">Select...</option>
                                        <option value="father">Father</option>
                                        <option value="mother" selected>Mother</option>
                                        <option value="guardian">Guardian</option><?php
                                        
                                    }
                                    elseif($rows['relation']==="guardian"){?>
                                        <option value="">Select...</option>
                                        <option value="father">Father</option>
                                        <option value="mother">Mother</option>
                                        <option value="guardian" selected>Guardian</option><?php
                                        
                                    }
                                    else{?>
                                        <option value="" selected>Select...</option>
                                        <option value="father">Father</option>
                                        <option value="mother">Mother</option>
                                        <option value="guardian">Guardian</option><?php

                                    }
                                ?>
                        </select>
                        </div>
                    </section>
                </div>
            
            <h4 class="title">Student details</h4>
            <hr>
            <div class="details">
                <section class="column">
                    <div>
                        <label for="updateLRN">LRN:(required)</label>
                        <input type="text" id="updateLRN"  value="<?php echo $rows['lrn']?>" readonly>
                    </div>
                    <div>
                        <label for="updateFirstName">Firstname:</label>
                        <input type="text" id="updateFirstName" value="<?php echo $rows['first_name']?>">
                    </div>
                    <div>
                        <label for="updateMiddleName">Middlename:</label>
                        <input type="text"  id="updateMiddleName" value="<?php echo $rows['middle_name']?>">
                    </div>
                    <div>
                        <label for="updateLastName">Lastname:</label>
                        <input type="text"  id="updateLastName"  value="<?php echo $rows['last_name']?>">
                    </div>
                    <div>
                        <label for="updateSuffix">Suffix:</label>
                        <select id="updateSuffix" readonly>
                            <?php
                                if($rows['suffix']==="jr."){?>
                                    <option value="">Select...</option>
                                    <option value="jr." selected>jr.</option>
                                    <option value="sr.">sr.</option>
                                    <option value="i">I</option>
                                    <option value="ii">II</option>
                                    <option value="iii">III</option>
                                    <option value="iv">IV</option>
                                    <?php
                                }
                                elseif($rows['suffix']==="sr."){?>
                                    <option value="">Select...</option>
                                    <option value="jr." >jr.</option>
                                    <option value="sr." selected>sr.</option>
                                    <option value="i">I</option>
                                    <option value="ii">II</option>
                                    <option value="iii">III</option>
                                    <option value="iv">IV</option>
                                    <?php
                                    
                                }
                                elseif($rows['suffix']==="i"){?>
                                    <option value="">Select...</option>
                                    <option value="jr." >jr.</option>
                                    <option value="sr.">sr.</option>
                                    <option value="i" selected>I</option>
                                    <option value="ii">II</option>
                                    <option value="iii">III</option>
                                    <option value="iv">IV</option>
                                    <?php
                                    
                                }
                                elseif($rows['suffix']==="ii"){?>
                                    <option value="">Select...</option>
                                    <option value="jr." >jr.</option>
                                    <option value="sr.">sr.</option>
                                    <option value="i">I</option>
                                    <option value="ii" selected>II</option>
                                    <option value="iii">III</option>
                                    <option value="iv">IV</option>
                                    <?php
                                    
                                }
                                elseif($rows['suffix']==="iii"){?>
                                    <option value="">Select...</option>
                                    <option value="jr." >jr.</option>
                                    <option value="sr.">sr.</option>
                                    <option value="i">I</option>
                                    <option value="ii">II</option>
                                    <option value="iii" selected>III</option>
                                    <option value="iv">IV</option>
                                    <?php
                                    
                                }
                                elseif($rows['suffix']==="iv"){?>
                                    <option value="">Select...</option>
                                    <option value="jr." >jr.</option>
                                    <option value="sr.">sr.</option>
                                    <option value="i">I</option>
                                    <option value="ii">II</option>
                                    <option value="iii">III</option>
                                    <option value="iv" selected>IV</option>
                                    <?php
                                    
                                }
                                else{?>
                                    <option value="" selected>Select...</option>
                                    <option value="jr." >jr.</option>
                                    <option value="sr.">sr.</option>
                                    <option value="i">I</option>
                                    <option value="ii">II</option>
                                    <option value="iii">III</option>
                                    <option value="iv">IV</option>
                                    <?php

                                }
                            ?>
                        </select>
                    </div>
                </section>
                <section class="column">
                    <div>
                        <label for="updateBirthDate">Birthdate:</label>
                        <input type="date" oninput="updatecalculateAge()" id="updateBirthDate" value="<?php echo $rows['birth_date']?>">
                    </div>
                    <div>
                        <label for="updateAge">Age:</label>
                        <input type="text" id="updateAge" value="<?php echo $rows['age']?>" readonly>
                    </div>
                    <div>
                        <label for="updateSex">Sex:</label>
                        <select id="updateSex">
                            <?php
                                if($rows['sex']==="male"){?>
                                    <option value="">Select...</option>
                                    <option value="male" selected>Male</option>
                                    <option value="female">Female</option><?php
                                }
                                elseif($rows['sex']==="female"){?>
                                    <option value="">Select...</option>
                                    <option value="male" >Male</option>
                                    <option value="female" selected>Female</option><?php
                                    
                                }
                                else{?>
                                    <option value="" selected>Select...</option>
                                    <option value="male" >Male</option>
                                    <option value="female">Female</option><?php

                                }
                            ?>
                        </select>
                        <div>
                            <label for="updateEmailAddress">Email address:</label>
                            <input type="text" id="updateEmailAddress" value="<?php echo $rows['email_address']?>">
                        </div>
                        <div>
                            <label for="updateContactNumber">Contact number:</label>
                            <input type="text" id="updateContactNumber" value="<?php echo $rows['contact_number']?>">
                        </div>
                    </div>
                </section>
                <section class="column">
                    <div>
                        <label for="updateAddress">Address:</label>
                        <input type="text" id="updateAddress" value="<?php echo $rows['address']?>">
                    </div>
                    <div>
                        <label for="updateYearLevel">Year level:</label>
                        <select id="updateYearLevel">
                            <?php
                                if($rows['year_level']==="Grade7"){?>
                                    <option value="">Select...</option>
                                    <option value="Grade7" selected>Grade7</option>
                                    <option value="Grade8">Grade8</option>
                                    <option value="Grade9">Grade9</option>
                                    <option value="Grade10">Grade10</option>
                                    <?php
                                }
                                elseif($rows['year_level']==="Grade8"){?>
                                    <option value="">Select...</option>
                                    <option value="Grade7">Grade 7</option>
                                    <option value="Grade8" selected>Grade 8</option>
                                    <option value="Grade9">Grade 9</option>
                                    <option value="Grade10">Grade 10</option>
                                    <?php
                                    
                                }
                                elseif($rows['year_level']==="Grade9"){?>
                                    <option value="">Select...</option>
                                    <option value="Grade7">Grade 7</option>
                                    <option value="Grade8">Grade 8</option>
                                    <option value="Grade9" selected>Grade 9</option>
                                    <option value="Grade10">Grade 10</option>
                                    <?php
                                    
                                }
                                elseif($rows['year_level']==="Grade10"){?>
                                    <option value="">Select...</option>
                                    <option value="Grade7">Grade 7</option>
                                    <option value="Grade8">Grade 8</option>
                                    <option value="Grade9">Grade 9</option>
                                    <option value="Grade10" selected>Grade 10</option>
                                    <?php
                                    
                                }
                                else{?>
                                    <option value="" selected>Select...</option>
                                    <option value="Grade7">Grade7</option>
                                    <option value="Grade8">Grade8</option>
                                    <option value="Grade9">Grade9</option>
                                    <option value="Grade10">Grade10</option>
                                    <?php

                                }
                            ?>
                        </select>
                    </div>
                    <div>
                        <label for="updateSection">Section:</label>
                        <input type="text" id="updateSection" value="<?php echo $rows['section']?>">
                    </div>
                        <div>
                            <label for="updateSchoolYear">School year:</label>
                            <select id="updateSchoolYear">
                                <?php
                                    $query1 = mysqli_query($conn, "SELECT * FROM `school_year` ORDER BY `school_year_value` ASC");
                                    if(mysqli_num_rows($query1)>0){
                                        while($rows1 = mysqli_fetch_assoc($query1)){
                                            if($rows1['school_year_value']===$rows['school_year_value']){?>
                                                <option selected value="<?php echo $rows1['school_year_value']?>"><?php echo $rows1['school_year_value']?></option><?php
                                            }
                                            else{?>
                                                <option selected value="<?php echo $rows1['school_year_value']?>"><?php echo $rows1['school_year_value']?></option><?php
                                            }
                                        }
                                    }
                                ?>
                                
                            </select>
                        </div>
                </section>
            </div>
            <button type="button" onclick="submitNewUpdateEnrollCta()"><img src="../assets/icons/save.svg" alt="save">Update</button><?php
        }

    }
//update student info
 if(isset($_POST['entriesName']) && isset($_POST['updateFirstName']) && isset($_POST['updateMiddleName']) && isset($_POST['updateLastName']) && isset($_POST['updateSuffix']) && isset($_POST['updateBirthDate']) && isset($_POST['updateAge']) && isset($_POST['updateSex']) && isset($_POST['updateAddress']) && isset($_POST['updateEmailAddress']) && isset($_POST['updateContactNumber']) && isset($_POST['updateYearLevel']) && isset($_POST['updateSection']) && isset($_POST['updateParentGuardian']) && isset($_POST['updateParentAddress']) && isset($_POST['updateParentOccupation']) && isset($_POST['updateParentContactNumber']) && isset($_POST['updateRelation']) && isset($_POST['updateSchoolYear'])){
    $studentId =  $_SESSION['editStudentInfo'];
    $entriesName = $_POST['entriesName'];
    $updateFirstName = mysqli_real_escape_string($conn,$_POST['updateFirstName']);
    $updateMiddleName = mysqli_real_escape_string($conn,$_POST['updateMiddleName']);
    $updateLastName = mysqli_real_escape_string($conn,$_POST['updateLastName']);
    $updateSuffix = mysqli_real_escape_string($conn,$_POST['updateSuffix']);
    $updateBirthDate = mysqli_real_escape_string($conn,$_POST['updateBirthDate']);
    $updateAge = mysqli_real_escape_string($conn,$_POST['updateAge']);
    $updateSex = mysqli_real_escape_string($conn,$_POST['updateSex']);
    $updateAddress = mysqli_real_escape_string($conn,$_POST['updateAddress']);
    $updateEmailAddress = mysqli_real_escape_string($conn,$_POST['updateEmailAddress']);
    $updateContactNumber = mysqli_real_escape_string($conn,$_POST['updateContactNumber']);
    $updateYearLevel = mysqli_real_escape_string($conn,$_POST['updateYearLevel']);
    $updateSection = mysqli_real_escape_string($conn,$_POST['updateSection']);
    $updateParentGuardian = mysqli_real_escape_string($conn,$_POST['updateParentGuardian']);
    $updateParentAddress = mysqli_real_escape_string($conn,$_POST['updateParentAddress']);
    $updateParentOccupation = mysqli_real_escape_string($conn,$_POST['updateParentOccupation']);
    $updateParentContactNumber = mysqli_real_escape_string($conn,$_POST['updateParentContactNumber']);
    $updateRelation= mysqli_real_escape_string($conn,$_POST['updateRelation']);
    $updateSchoolYear= mysqli_real_escape_string($conn,$_POST['updateSchoolYear']);

    //for students
    mysqli_query($conn, "UPDATE `students` SET `first_name`='$updateFirstName',`middle_name`='$updateMiddleName',`last_name`=' $updateLastName',`suffix`='$updateSuffix',`birth_date`='$updateBirthDate',`age`='$updateAge',`sex`='$updateSex',`address`='$updateAddress',`email_address`='$updateEmailAddress',`contact_number`='$updateContactNumber' WHERE `student_id`=$studentId;");

   
    $schoolYearId = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `school_year` WHERE `school_year_value`='$updateSchoolYear';"))['school_year_id'];

 
    //for details
    mysqli_query($conn, "UPDATE `details` SET `school_year_id`= $schoolYearId, `year_level`='$updateYearLevel',`section`='$updateSection' WHERE `student_id`=$studentId;");

    //for parents
    mysqli_query($conn, "UPDATE `parents` SET `full_name`='$updateParentGuardian',`address`='$updateParentAddress',`occupation`='$updateParentOccupation',`contact_number`='$updateParentContactNumber',`relation`='$updateRelation' WHERE `student_id`=$studentId;");




    tableName(1,$_POST['entriesName']);        
}
 //add new schoolyear
 if(isset($_POST['newSchoolYear'])){

    $newSchoolYear = mysqli_real_escape_string($conn, $_POST['newSchoolYear']);

    //check if name exists already
    $sql = "SELECT * FROM `school_year` WHERE `school_year_value`='$newSchoolYear';";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0){
        echo "School Year already exists";
    }
    else{
        $query = mysqli_query($conn,"INSERT INTO `school_year`(`school_year_value`) VALUES('$newSchoolYear');");
    }

}
?>