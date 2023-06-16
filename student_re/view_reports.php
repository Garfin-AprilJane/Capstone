<?php
    include("../assets/connection/connection.php"); 
    session_start();
    //view student info
    if(isset($_GET['viewStudentInfo'])){
        $id = $_GET['viewStudentInfo'];
        $_SESSION['viewStudentInfo'] =$id;
        $query = mysqli_query($conn, "SELECT * FROM `students` INNER JOIN `parents` ON `students`.`student_id`=`parents`.`student_id` INNER JOIN `details` ON `students`.`student_id`=`details`.`student_id` INNER JOIN `school_year` ON `details`.`school_year_id`=`school_year`.`school_year_id` WHERE `students`.`student_id`=$id;");
        
        if(mysqli_num_rows($query)>0){
            $rows = mysqli_fetch_assoc($query);?>

                <h4 class="title">Parent details</h4>
                <hr>
                <div class="details">
                    <section class="column">
                        <div>
                            <label for="updateParentGuardian">Parent/Guardian Name:</label>
                            <input type="text" id="myInput" value="<?php echo $rows['full_name']?>" readonly>
                        </div>
                        <div>
                            <label for="updateParentAddress">Parent/Guardian Address:</label>
                            <input type="text" id="myInput" value="<?php echo $rows['address']?>" readonly>
                        </div>
                        <div>
                            <label for="updateParentOccupation">Parent Occupation:</label>
                            <input type="text" id="myInput" value="<?php echo $rows['occupation']?>" readonly>
                        </div>
                        <div>
                            <label for="updateParentContactNumber">Parent/Guardian Contact Number:</label>
                            <input type="text" id="myInput" value="<?php echo $rows['contact_number']?>" readonly>
                        </div>
                    </section>
                    <section class="column">
                        <div>
                            <label for="updateRelation">Relation:</label>
                            <input type="text" id="myInput" value="<?php echo $rows['relation']?>" readonly>
                        </div>
                    </section>
                </div>
            
            <h4 class="title">Student details</h4>
            <hr>
            <div class="details">
                <section class="column">
                    <div>
                        <label for="updatetLRN">LRN:</label>
                        <input type="number" id="myInput" value="<?php echo $rows['lrn']?>" readonly>
                    </div>
                    <div>
                        <label for="updateFirstName">Firstname:</label>
                        <input type="text" id="myInput" value="<?php echo $rows['first_name']?>" readonly>
                    </div>
                    <div>
                        <label for="updateMiddleName">Middlename:</label>
                        <input type="text" id="myInput" value="<?php echo $rows['middle_name']?>" readonly>
                    </div>
                    <div>
                        <label for="updateLastName">Lastname:</label>
                        <input type="text" id="myInput" value="<?php echo $rows['last_name']?>" readonly>
                    </div>
                    <div>
                        <label for="updateSuffix">Suffix:</label>
                        <input type="text" id="myInput" value="<?php echo $rows['suffix']?>" readonly>
                    </div>
                    <div>
                        <label for="updateBirthDate">Birthdate:</label>
                        <input type="date" id="myInput" value="<?php echo $rows['birth_date']?>" readonly>
                    </div>
                </section>
                <section class="column">
                    <div>
                        <label for="updateAge">Age:</label>
                        <input type="text" id="myInput" value="<?php echo $rows['age']?>" readonly>
                    </div>
                    <div>
                        <label for="updateSex">Sex:</label>
                        <input type="text" id="myInput" value="<?php echo $rows['sex']?>" readonly>
                        <div>
                            <label for="updateEmailAddress">Email address:</label>
                            <input type="text" id="myInput" value="<?php echo $rows['email_address']?>" readonly>
                        </div>
                        <div>
                            <label for="updateContactNumber">Contact number:</label>
                            <input type="text" id="myInput" value="<?php echo $rows['contact_number']?>" readonly>
                        </div>
                    </div>
                    <div>
                        <label for="updateAddress">Address:</label>
                        <input type="text" id="myInput" value="<?php echo $rows['address']?>" readonly>
                    </div>
                </section>
                <section class="column">
                    <div>
                        <label for="updateYearLevel">Year level:</label>
                        <input type="text" id="myInput" value="<?php echo $rows['year_level']?>" readonly>
                    </div>
                    <div>
                        <label for="updateSection">Section:</label>
                        <input type="text" id="myInput" value="<?php echo $rows['section']?>" readonly>
                    </div>
                        <div>
                            <label for="updateSchoolYear">School year:</label>
                            <input type="text" id="myInput" value="<?php echo $rows['school_year_value']?>" readonly>
                        </div>
                </section>
            </div>
            <?php
        }

    }
?>