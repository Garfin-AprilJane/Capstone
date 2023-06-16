<?php
    include("../assets/connection/connection.php"); 
    session_start();


    //add new account for staff
    if(isset($_POST['staffName'])&& isset($_POST['sex'])&& isset($_POST['staffAddress'])&& isset($_POST['staffContactNumber'])&& isset($_POST['staffEmailAddress'])&& isset($_POST['staffUsername'])&& isset($_POST['staffPassword'])&& isset($_POST['entriesAccount']) && isset($_POST['userType'])){ 
        $staffName = mysqli_real_escape_string($conn,$_POST['staffName']);
        $sex = mysqli_real_escape_string($conn,$_POST['sex']);
        $staffAddress = mysqli_real_escape_string($conn,$_POST['staffAddress']);
        $staffContactNumber = mysqli_real_escape_string($conn,$_POST['staffContactNumber']);
        $staffEmailAddress = mysqli_real_escape_string($conn,$_POST['staffEmailAddress']);
        $staffUsername = mysqli_real_escape_string($conn,$_POST['staffUsername']);
        $userType = mysqli_real_escape_string($conn,$_POST['userType']);
        $staffPassword = mysqli_real_escape_string($conn,$_POST['staffPassword']);
        $entriesAccount = $_POST['entriesAccount'];
        $staffPassword = md5(md5(md5(md5($staffPassword))));

        //check if username exists already
        $query = mysqli_query($conn,"SELECT * FROM `users` WHERE `username`='$staffUsername';");
        if(mysqli_num_rows($query)>0){
            echo "username already exist";
        }
        else{
            //for admin&registrar user
            mysqli_query($conn, "INSERT INTO `users`(`username`,`password`,`role`,`status`) VALUES('$staffUsername', '$staffPassword','$userType','activated');");

            $query = mysqli_query($conn, "SELECT * FROM `users` ORDER BY `user_id` DESC LIMIT 1;");
            if(mysqli_num_rows($query)>0){
                $rows =mysqli_fetch_assoc($query);
                $userId = $rows['user_id'];

                mysqli_query($conn, "INSERT INTO `staffs`(`staff_name`,`sex`,`address`,`contact_number`,`email_address`,`user_id`) VALUES('$staffName','$sex','$staffAddress','$staffContactNumber','$staffEmailAddress',$userId);");
                if(mysqli_num_rows($query)>0){

                    //refresh table
                    tableAccount(1,$entriesAccount);
                }           
            }           
        }


    }
    //add new account for student
    if(isset($_POST['studentUsername']) && isset($_POST['studentPassword']) && isset($_POST['entriesAccount']) && isset($_POST['userType']) && isset($_POST['studentStatus'])){
        $studentUsername = mysqli_real_escape_string($conn,$_POST['studentUsername']);
        $studentPassword = mysqli_real_escape_string($conn,$_POST['studentPassword']);
        $userType = mysqli_real_escape_string($conn,$_POST['userType']);
        $studentStatus = mysqli_real_escape_string($conn,$_POST['studentStatus']);
        $entriesAccount = $_POST['entriesAccount'];
        $studentPassword = md5(md5(md5(md5($studentPassword))));
        $studentId = $_SESSION['accountStudentId'];

        //check if student username exists already
        $query = mysqli_query($conn,"SELECT * FROM `users` WHERE `username`='$studentUsername';");
        if(mysqli_num_rows($query)>0){
            echo "username already exist";
        }
        else{
            //for student user
            mysqli_query($conn, "INSERT INTO `users`(`username`,`password`,`role`,`status`) VALUES('$studentUsername', '$studentPassword','$userType','$studentStatus');");

            $query = mysqli_query($conn, "SELECT * FROM `users` ORDER BY `user_id` DESC LIMIT 1;");
            if(mysqli_num_rows($query)>0){

                $userId = mysqli_fetch_assoc($query)['user_id'];

                mysqli_query($conn,"UPDATE `students` SET `user_id` = $userId WHERE `student_id`= $studentId");

                //refresh table
                tableAccount(1,$entriesAccount);
            }           
        }


    }


    //search account
    if(isset($_GET['filterAccount']) && isset($_GET['searchAccount']) && isset($_GET['entriesAccount'])){
        $filterAccount = mysqli_real_escape_string($conn,$_GET['filterAccount']);
        $searchAccount = mysqli_real_escape_string($conn,$_GET['searchAccount']);
        $entriesAccount = $_GET['entriesAccount'];
        
        //if filter is empty
        if($filterAccount === ""){
            $sql = "SELECT * FROM `users` WHERE CONCAT(`username`,`role`) LIKE '%$searchAccount%' ORDER BY `users`.`user_id` ASC ";
            $_SESSION['conditionAccount'] = "WHERE CONCAT(`username`,`role`) LIKE '%$searchAccount%' ORDER BY `users`.`user_id` ASC ";
        }
        //if filter has value
        else{
            $sql = "SELECT * FROM `users` WHERE $filterAccount LIKE '%$searchAccount%' ORDER BY `users`.`user_id` ASC ";
            $_SESSION['conditionAccount'] = "WHERE $filterAccount LIKE '%$searchAccount%'";
        }
        $_SESSION['searchAccount'] = $sql;
        $_SESSION['pageNoAccount'] = 1;

        //refresh table
        tableAccount(1,$entriesAccount);
    }

    //previous page
    if(isset($_GET['prevPage']) && isset($_GET['entriesAccount'])){
        tableAccount($_GET['prevPage'],$_GET['entriesAccount']);
        $_SESSION['pageNoAccount'] = $_GET['prevPage'];
    }

    //next page
    if(isset($_GET['nextPage']) && isset($_GET['entriesAccount'])){
        tableAccount($_GET['nextPage'],$_GET['entriesAccount']);
        $_SESSION['pageNoAccount'] = $_GET['nextPage'];
    }

    //show entries per page
    if(isset($_GET['entriesAccount']) && isset($_GET['showPerPage'])){
        tableAccount(1,$_GET['entriesAccount']);
    }
    //edit account
    if(isset($_GET['editAccount'])){
        $id = $_GET['editAccount'];
        $_SESSION['editAccount'] =$id;
        $query = mysqli_query($conn, "SELECT * FROM `users` WHERE `user_id`=$id;");
        $rows = mysqli_fetch_assoc($query);

        ?>
        <label>Name</label>
        <input type="text" id="updateAccountName" placeholder="Name" value="<?php echo $rows['username']?>" readonly> 
        <label>Username</label>  
        <input type="text" id="updateAccountUsername" placeholder="Username" value="<?php echo $rows['username']?>" readonly>
        <label>Role</label>
        <select id="updateAccountRole">
            <?php
                if($rows['role'] === "admin"){?>
                    <option value="admin" selected>Admin</option>
                    <option value="registrar">Registrar</option>
                    <option value="student">Student</option>
                    <option value="cashier">Cashier</option>
                    <option value="accounting">Accounting</option>
                    <?php
                }
                elseif($rows['role'] === "registrar"){?>
                    <option value="admin">Admin</option>
                    <option value="registrar" selected>Registrar</option>
                    <option value="cashier">Cashier</option>
                    <option value="accounting">Accounting</option>
                    <option value="student">Student</option><?php                  
                }
                elseif($rows['role'] === "student"){?>
                    <option value="admin">Admin</option>
                    <option value="registrar">Registrar</option>
                    <option value="student" selected>Student</option>
                    <option value="cashier">Cashier</option>
                    <option value="accounting">Accounting</option><?php                  
                }
                elseif($rows['role'] === "cashier"){?>
                    <option value="admin">Admin</option>
                    <option value="registrar">Registrar</option>
                    <option value="students">Students</option>
                    <option value="accounting">Accounting</option>
                    <option value="cashier" selected>Cashier</option><?php                  
                }
                elseif($rows['role'] === "accounting"){?>
                    <option value="admin">Admin</option>
                    <option value="registrar">Registrar</option>
                    <option value="accounting" selected>Accounting</option>
                    <option value="cashier">Cashier</option>
                    <option value="student">Student</option><?php                  
                }
            ?>
            
        </select>
        <label for="updateAccountStatus">Status:</label>
        <select id="updateAccountStatus">
            <?php
                if($rows['status'] === "activated"){?>
                    <option value="activated" selected>Activated</option>
                    <option value="deactivated">Deactivated</option><?php
                }
                elseif($rows['status'] === "deactivated"){?>
                    <option value="activated">Activated</option>
                    <option value="deactivated" selected>Deactivated</option><?php                  
                }
            ?>
            
        </select>
        <?php
    }
    //view user account
    if(isset($_GET['viewUser'])){
        $userId = $_GET['viewUser'];
        $query = mysqli_query($conn, "SELECT * FROM `users` WHERE `user_id`=$userId;");
        if(mysqli_num_rows($query)>0){
            $rows = mysqli_fetch_assoc($query);

            //admin or registrar
            if($rows['role'] === "admin" || $rows['role'] === "registrar"){
                $sql = "SELECT * FROM `staffs` WHERE `user_id`=$userId;";
            }
            //student
            else{
                $sql = "SELECT * FROM `students` WHERE `user_id`=$userId;";
            }

            $query = mysqli_query($conn,$sql);
            if(mysqli_num_rows($query)>0){
                $rows = mysqli_fetch_assoc($query);?>
            
                <label>Name:</label>
                <input type="text" value="<?php echo $rows['staff_name']?>" readonly>
                <label>sex:</label>
                <select>
                    <?php
                        if($rows['sex'] === "male"){?>
                            <option value="male" selected>Male</option>
                            <option value="female">Female</option><?php
                        }
                        elseif($rows['sex'] === "female"){?>
                            <option value="male">Male</option>
                            <option value="female" selected>Female</option><?php                  
                        }
                    ?>
            
        </select>
                <label>Address:</label>
                <input type="text" value="<?php echo $rows['address']?>" readonly>
                <label>Contact number:</label>
                <input type="text" value="<?php echo $rows['contact_number']?>" readonly>
                <label>Email address:</label>
                <input type="text" value="<?php echo $rows['email_address']?>" readonly>
                
                <?php
            }
        }
    }
    //update account
    if(isset($_GET['updateAccount']) && isset($_GET['entriesAccount']) && isset($_GET['updateAccountRole']) && isset($_GET['updateAccountStatus'])){
        $id =  $_SESSION['editAccount'];
        $entriesAccount = $_GET['entriesAccount'];
        $updateAccountRole = mysqli_real_escape_string($conn,$_GET['updateAccountRole']);
        $updateAccountStatus = mysqli_real_escape_string($conn,$_GET['updateAccountStatus']);

        mysqli_query($conn, "UPDATE `users` SET `role`='$updateAccountRole',`status`='$updateAccountStatus' WHERE `user_id` = $id;");
        tableAccount(1,$_GET['entriesAccount']);        
    }
    //table account
    function tableAccount($pageNo,$entriesAccount){
        include("../assets/connection/connection.php");
        ?>

        <div class="table-data">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Username</th>
                        <th>Status</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $entriesPerPage = $entriesAccount;
                        $offset = ($pageNo - 1) * $entriesPerPage;
                        $prevPage = $pageNo - 1;
                        $nextPage = $pageNo + 1;

                        //search session set
                        if(isset($_SESSION['searchAccount'])){
                            $conditionAccount = $_SESSION['conditionAccount'];
                            $countAllEntries = mysqli_query($conn, "SELECT COUNT(*) as total_records FROM `users` $conditionAccount;");
                            $records = mysqli_fetch_array($countAllEntries);
                            $totalRecords = $records['total_records'];
                            $noOfPages = ceil($totalRecords / $entriesPerPage);
                            $sql = $_SESSION['searchAccount'] . " LIMIT $offset, $entriesPerPage;";
                        }
                        //not set
                        else{
                            $countAllEntries = mysqli_query($conn, "SELECT COUNT(*) as total_records FROM `users`;");
                            $records = mysqli_fetch_array($countAllEntries);
                            $totalRecords = $records['total_records'];
                            $noOfPages = ceil($totalRecords / $entriesPerPage);
                            $sql = "SELECT * FROM `users` ORDER BY `users`.`user_id` ASC LIMIT $offset, $entriesPerPage;";
                        }
                        $query = mysqli_query($conn,$sql);

                        if(mysqli_num_rows($query)>0){
                            while($rows = mysqli_fetch_assoc($query)){
                                if(!empty($rows['username']) && !empty($rows['password'])){?>
                                    <tr>
                                        <td><?php echo $rows['user_id']?></td>
                                        <?php
                                            $sql1 ="SHOW COLUMNS FROM `users`;";
                                            $query1 = mysqli_query($conn,$sql1);
                                            if(mysqli_num_rows($query1)>0){
                                                while($rows1 = mysqli_fetch_array($query1)){
                                                    if($rows1[0] !== "password" && $rows1[3] !== "PRI" && $rows1[3] !== "MUL"){?>
                                                        <td><?php echo $rows[$rows1[0]]?></td><?php
                                                    }
                                                }
                                            }
                                        ?>
                                        <td class="td-action">
                                            <img src="../assets/icons/edit.svg" onclick="editAccountCta(<?php echo $rows['user_id'] ?>)">
                                        </td>
                                    </tr><?php
                                }
                            }
                        }
                        else{
                            echo "<tr><td colspan='6'>No results or no data in the table</td></tr>";
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
                        <button type="button" onclick="prevPageAccountCta(<?php echo $prevPage?>)">Previous</button><?php
                    }

                    //button next

                    if($pageNo >= $noOfPages){?>
                        <button type="button" class="button-disabled" disabled>Next</button><?php
                    }
                    else{?>
                        <button type="button" onclick="nextPageAccountCta(<?php echo $nextPage?>)">Next</button><?php
                    }
                ?>
                
                
            </aside>
        </div>
        <div class="total-data">
            <?php
                // kung nag search si user ka account, amu ja ubrahon na
                if(isset($_SESSION['searchAccount'])){
                    $query = mysqli_query($conn, "SELECT COUNT(*) FROM `users` ".$_SESSION['conditionAccount']);
                }
                //kung wra ng search ka account
                else{
                    $query = mysqli_query($conn, "SELECT COUNT(*) FROM `users`;");
                }
                if(mysqli_num_rows($query)>0){
                    $rows = mysqli_fetch_array($query);
                    $total = $rows[0];?>
                    <p><b>Total:</b> <?=$total?> record/s</p><?php
                }
            ?>
        </div><?php
    }
    //edit user account
 if(isset($_GET['manageAccount'])){
    $id = $_GET['manageAccount'];
    $_SESSION['manageAccount'] =$id;
    $query = mysqli_query($conn, "SELECT * FROM `users` WHERE `user_id`=$id;");
    $rows = mysqli_fetch_assoc($query);

    ?>
    <input type="text" id="updateUserAccountName" placeholder="Name" value="<?php echo $rows['name']?>">   
    <input type="text" id="updateUserAccountUsername" placeholder="Username" value="<?php echo $rows['username']?>">
    <input type="text" id="updateUserAccountPassword" placeholder="password" value="<?php echo $rows['password']?>">
    <select id="updateUserAccountRole">
        <?php
            if($rows['role'] === "admin"){?>
                <option value="admin" selected>Admin</option>
                <option value="registrar">Registrar</option>
                <option value="student">Student</option><?php
            }
            elseif($rows['role'] === "registrar"){?>
                <option value="admin">Admin</option>
                <option value="registrar" selected>Registrar</option>
                <option value="student">Student</option><?php                  
            }
            elseif($rows['role'] === "student"){?>
                <option value="admin">Admin</option>
                <option value="registrar">Registrar</option>
                <option value="student" selected>Student</option><?php                  
            }
        ?>  
    </select>
    <select id="updateAccountStatus">
        <?php
            if($rows['role'] === "admin"){?>
                <option value="admin" selected>Admin</option>
                <option value="registrar">Registrar</option>
                <option value="student">Student</option><?php
            }
            elseif($rows['role'] === "registrar"){?>
                <option value="admin">Admin</option>
                <option value="registrar" selected>Registrar</option>
                <option value="student">Student</option><?php                  
            }
            elseif($rows['role'] === "student"){?>
                <option value="admin">Admin</option>
                <option value="registrar">Registrar</option>
                <option value="student" selected>Student</option><?php                  
            }
        ?>  
    </select>
    
    <?php
    }
    //for search student name
    if(isset($_GET['searchStudentName'])){
        $studentName = mysqli_real_escape_string($conn,$_GET['searchStudentName']);
        $sql = "SELECT `student_id`, CONCAT(`first_name`,`middle_name`,`last_name`,`suffix`) AS 'full_name' FROM `students` WHERE CONCAT(`first_name`,`middle_name`,`last_name`,`suffix`) LIKE '%$studentName%';";
        
        $query = mysqli_query($conn,$sql);

        if(mysqli_num_rows($query)>0){
            while($rows = mysqli_fetch_array($query)){
                $studentId = $rows['student_id'];
                $fullname = $rows['full_name'];?>
                <p id="studentResult" onclick="studentUserIdCta(<?php echo $studentId?>)"><?php echo $fullname?></p><?php
            }
        }
    }
    if(isset($_GET['studentId'])){
        $id = $_GET['studentId'];
        $_SESSION['accountStudentId']= $id;
        $query = mysqli_query($conn, "SELECT CONCAT(`first_name`,' ',`middle_name`,' ',`last_name`,' ',`suffix`) AS 'fullname' FROM `students` WHERE `student_id`=$id;");

        if(mysqli_num_rows($query)>0){
            $rows = mysqli_fetch_assoc($query);?>

            <div>
                <label for="studentname">Name:</label>
                <input type="text" id="studentname" value="<?php echo $rows['fullname']?>" readonly>
            </div>
            <div>
                <label for="studentUsername">Username:</label>
                <input type="text" oninput="validateInputs(this)" pattern="[a-zA-Z]*" id="studentUsername">
            </div>
            <div>
                <label for="studentPassword">Password:</label>
                <input type="password" id="studentPassword">
            </div>
            <div>
                <label for="studentConfirmPassword">Confirm Password:</label>
                <input type="password" id="studentConfirmPassword">
            </div>
            <div>
                <label for="studentStatus">Status:</label>
                <input type="text" id="studentStatus" value="activated" disabled>
            </div>
            <?php
        }
    }