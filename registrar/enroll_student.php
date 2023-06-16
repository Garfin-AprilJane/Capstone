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
                <button type="button" onclick="addNewFormCta()"><img src="../assets/icons/add.svg">Add Students</button>
                <button type="button" onclick="addNewSchoolYearCta()"><img src="../assets/icons/add.svg">Add New School Year</button>
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
                            <input type="search" oninput="searchStudentCta()" id="searchName" placeholder="Search">
                        </div>
                    </aside>
                </div>
                <div id="tableName">
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

        <!--enroll new student -->
        <dialog class="dialog new-enrollment diaglogActive">
            <div class="top">
                <div class="left">
                    <p>Enroll New Student</p>
                </div>
                <div class="right">
                    <img src="../assets/icons/close.svg" alt="close" onclick="closeEnrollmentFormCta()">
                </div>
            </div>
            <!-- choice for school year -->
            <div class="inputs">
                <h4 class="title">Student details</h4>
                <hr>
                <div class="details">
                    <section class="column">
                        <div>
                            <label for="studentLRN">LRN:(required)</label>
                            <input type="text" oninput="validateInputLrn(this)" pattern="\d{12}" id="studentLRN" required>
                        </div>
                        <div>
                            <label for="studentFirstName">Firstname:(required)</label>
                            <input type="text" oninput="validateInputs(this)" pattern="[A-Za-z\s]+" id="studentFirstName" required>
                        </div>
                        <div>
                            <label for="studentMiddleName">Middlename:(required)</label>
                            <input type="text" oninput="validateInputs(this)" pattern="[A-Za-z\s]+" id="studentMiddleName" required>
                        </div>
                        <div>
                            <label for="studentLastName">Lastname:(required)</label>
                            <input type="text" oninput="validateInputs(this)" pattern="[A-Za-z\s]+" id="studentLastName" required>
                        </div>
                        <div>
                            <label for="studentSuffix">Suffix:</label>
                            <select id="studentSuffix">
                                <option value="">Select...</option>
                                <option value="jr." >jr.</option>
                                <option value="sr." >sr.</option>
                                <option value="i" >I</option>
                                <option value="ii" >II</option>
                                <option value="iii" >III</option>
                                <option value="iv" >IV</option>
                            </select>
                        </div>
                    </section>
                    <section class="column">  
                        <div>
                            <label for="studentBirthDate">Birthdate:(required)</label>
                            <input type="date" oninput="calculateAge()" id="studentBirthDate" required>
                        </div>                                     
                        <div>
                            <label for="studentAge">Age:(required)</label>
                            <input type="text" id="studentAge" readonly>
                        </div>
                        <div>
                            <label for="studentSex">Sex:(required)</label>
                            <select id="studentSex" required>
                                <option value="">Select...</option>
                                <option value="male" >Male</option>
                                <option value="female" >Female</option>
                            </select>
                        </div>
                        <div>
                            <label for="studentAddress">Address:(required)</label>
                            <input type="text" oninput="validateInputsAddress(this)" pattern="[A-Za-z.\-_,\s]+" id="studentAddress" required>
                        </div>
                        <div>
                            <label for="studentEmailAddress">Email address:(required)</label>
                            <input type="text" id="studentEmailAddress" required>
                        </div>
                    </section>
                    <section class="column">
                        <div>
                            <label for="studentContactNumber">Contact number:(required start at 09..)</label>
                            <input type="text" oninput="validateInputContactNum(this)" pattern="\d{11}" id="studentContactNumber" placeholder="Only 11 number" required>
                        </div>
                        <div>
                            <label for="studentYearLevel">Year level:(required)</label>
                            <select id="studentYearLevel" required>
                                <option value="">Select...</option>
                                <option value="Grade7" >Grade 7</option>
                                <option value="Grade8" >Grade 8</option>
                                <option value="Grade9" >Grade 9</option>
                                <option value="Grade10" >Grade 10</option>
                            </select>
                        </div>
                        <div>
                            <label for="studentSection">Section:(required)</label>
                            <input type="text" oninput="validateInputs(this)" pattern="[A-Za-z\s]+" id="studentSection" required>
                        </div>
                        <div>
                            <label for="studentSchoolYear">School year:(required)</label>
                            <select id="studentSchoolYear" required>
                                <?php
                                    $query = mysqli_query($conn,"SELECT * FROM `school_year` ORDER BY `school_year_value` ASC;");
                                    if(mysqli_num_rows($query)>0){?>
                                        <option value="">Select...</option><?php
                                        while($rows = mysqli_fetch_assoc($query)){?>
                                            <option value="<?php echo $rows['school_year_value']?>"><?php echo $rows['school_year_value']?></option><?php
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </section>
                </div>
                <h4 class="title">Parent details</h4>
                <hr>
                <div class="details">
                <section class="column">
                    <div>
                        <label for="studentParentGuardian">Parent/Guardian Name:(required)</label>
                        <input type="text" oninput="validateInputs(this)" pattern="[A-Za-z\s]+"id="studentParentGuardian" required>
                    </div>
                    <div>
                        <label for="studentParentAddress">Parent/Guardian Address:(required)</label>
                        <input type="text" oninput="validateInputsAddress(this)" pattern="[A-Za-z.\-_,\s]+"id="studentParentAddress" required>
                    </div>
                    <div>
                        <label for="studentParentOccupation">Parent Occupation:(required)</label>
                        <input type="text" oninput="validateInputs(this)" pattern="[A-Za-z\s]+"id="studentParentOccupation" required>
                    </div>
                    <div>
                        <label for="studentParentContactNumber">Parent/Guardian Contact Number:(required start at 09..)</label>
                        <input type="text" oninput="validateInputContactNum(this)" pattern="\d{11}" id="studentParentContactNumber"  placeholder="Only 11 number" required>
                    </div>
                </section>
                <section class="column">
                    <div>
                        <label for="studentRelation">Relation:(required)</label>
                        <select id="studentRelation" required>
                            <option value="">Select...</option>
                            <option value="father" >Father</option>
                            <option value="mother" >Mother</option>
                            <option value="guardian" >Guardian</option>
                        </select>
                    </div>
                </section>
            </div>
            <button type="button" onclick="submitNewEnrollCta()"><img src="../assets/icons/save.svg" alt="save">Save</button>
            
            </div>
        </dialog>

        <!-- update student enfo -->
        <dialog class="dialog update-enrollment">
            <div class="top">
                <div class="left">
                    <p>Update Student Info</p>
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
                            <label for="updateLRN">LRN:(required)</label>
                            <input type="text" id="updateLRN" required>
                        </div>
                        <div>
                            <label for="updateFirstName">Firstname:</label>
                            <input type="text" id="updateFirstName" required>
                        </div>
                        <div>
                            <label for="updateMiddleName">Middlename:</label>
                            <input type="text" id="updateMiddleName" required>
                        </div>
                        <div>
                            <label for="updateLastName">Lastname:</label>
                            <input type="text" id="updateLastName" required>
                        </div>
                        <div>
                            <label for="updateSuffix">Suffix:</label>
                            <select id="updateSuffix">
                                <option value="">Select...</option>
                                <option value="jr." >jr.</option>
                                <option value="sr." >sr.</option>
                                <option value="i" >I</option>
                                <option value="ii" >II</option>
                                <option value="iii" >III</option>
                                <option value="iv" >IV</option>
                            </select>
                        </div>
                    </section>
                    <section class="column">
                         <div>
                            <label for="updateBirthDate">Birthdate:(required)</label>
                            <input type="date"  id="updateBirthDate" required>
                        </div>                                     
                        <div>
                            <label for="updateAge">Age:(required)</label>
                            <input type="text" readonly>
                        </div>
                        <div>
                            <label for="updateSex">Sex:</label>
                            <select id="updateSex" required>
                                <option value="">Select...</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                        <div>
                            <label for="updateAddress">Address:</label>
                            <input type="text" id="updateAddress" required>
                        </div>
                        <div>
                            <label for="updateEmailAddress">Email address:</label>
                            <input type="text" id="updateEmailAddress" required>
                        </div>
                    </section>
                    <section class="column">
                        <div>
                            <label for="updateContactNumber">Contact number:</label>
                            <input type="text" id="updateContactNumber" required>
                        </div>
                        <div>
                            <label for="updateYearLevel">Year level:</label>
                            <select id="updateYearLevel" required>
                                <option value="">Select...</option>
                                <option value="Grade7" >Grade 7</option>
                                <option value="Grade8" >Grade 8</option>
                                <option value="Grade9" >Grade 9</option>
                                <option value="Grade10" >Grade 10</option>
                            </select>
                        </div>
                        <div>
                            <label for="updateSection">Section:</label>
                            <input type="text" id="updateSection" required>
                        </div>
                        <div>

                        </div>
                    </section>
                </div>
                <h4 class="title">Parent details</h4>
                <hr>
                <div class="details">
                    <section class="column">
                        <div>
                            <label for="updateParentGuardian">Parent/Guardian Name:</label>
                            <input type="text" id="updateParentGuardian" required>
                        </div>
                        <div>
                            <label for="updateParentAddress">Parent/Guardian Address:</label>
                            <input type="text" id="updateParentAddress" required>
                        </div>
                        <div>
                            <label for="updateParentOccupation">Parent Occupation:</label>
                            <input type="text" id="updateParentOccupation" required>
                        </div>
                        <div>
                            <label for="updateParentContactNumber">Parent/Guardian Contact Number:</label>
                            <input type="text" id="updateParentContactNumber" required>
                        </div>
                    </section>
                    <section class="column">
                        <div>
                            <label for="updateRelation">Relation:</label>
                                <select id="updateRelation" required>
                                    <option value="">Select...</option>
                                    <option value="father" >Father</option>
                                    <option value="mother" >Mother</option>
                                    <option value="guardian" >Guardian</option>
                                </select>
                        </div>
                    </section>
                </div>
                <button type="button" onclick="submitNewUpdateEnrollCta()"><img src="../assets/icons/save.svg" alt="save">Update</button>
            </div>
        </dialog>
       <!-- add schoolyear -->
       <dialog class="dialog new-schoolyear diaglogActive">
            <div class="top">
                <div class="left">
                    <p> New School Year</p>
                </div>
                <div class="right">
                    <img src="../assets/icons/close.svg" alt="close" onclick="closeNewSchoolYearCta()">
                </div>
            </div>
            <div class="inputs">
                <div>
                    <label for="newSchoolYear">Add School Year</label>
                    <input type="text" id="newSchoolYear" placeholder="ex:2023-2024">
                </div>
                <button type="button" onclick="submitNewSchoolYearCta()"><img src="../assets/icons/save.svg" alt="save">Add</button>           
            </div><br>
            <h4 class="title">School Year List</h4><br>
            <div class="inputs">
                <?php
                    $query = mysqli_query($conn,"SELECT * FROM `school_year` ORDER BY `school_year_value` ASC;");
                    if(mysqli_num_rows($query)>0){
                        while($rows = mysqli_fetch_assoc($query)){?>
                                <p><?php echo $rows['school_year_value']?></p><?php
                        }
                    }
                ?>
            
            </div>
        </dialog>
    </body>
</html>