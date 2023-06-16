<?php 
    include("../assets/connection/connection.php");
    include("../universal/ad_cookie.php");
    include("../universal/session.php");
?>

<!DOCTYPE html>
<html lang="en">

    <?php include("../universal/head.php");?>

    <body>
        <?php include("../universal/top_nav.php");?>
        <?php include("../universal/ad_left_nav.php");?>

        <section class="section-content">
            <header class="content-action">
                <button type="button" onclick="addNewAccountCta()"><img src="../assets/icons/add.svg">New Account</button>
            </header>

            <div class="data">
                <div class="top-actions">
                    <aside class="left">
                        <label for="entriesAccount">Show</label>
                        <select id="entriesAccount" onchange="entriesAccountCta()">
                            <option value="5" selected>5</option>
                            <option value="10">10</option>
                            <option value="15">15</option>
                            <option value="20">20</option>
                        </select>
                        <label for="entriesAccount">entries per page</label>
                    </aside>
                    <aside class="right">
                        <div class="filter-by">
                            <label for="filter">Filter by:</label>
                            <select id="filterAccount">
                                <option value=""></option>
                                <option value="username">username</option>
                                <option value="role">role</option>
                                
                            </select>
                        </div>
                        <div class="search-bar">
                            <input type="search" oninput="searchAccountCta()" id="searchAccount" placeholder="Search">
                        </div>
                    </aside>
                </div>
                <div tableAccount>
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
                                    $countAllEntries = mysqli_query($conn, "SELECT COUNT(*) as total_records FROM `users`;");
                                    $records = mysqli_fetch_array($countAllEntries);
                                    $totalRecords = $records['total_records'];
                                    $noOfPages = ceil($totalRecords / $entriesPerPage);
                                    $sql = "SELECT * FROM `users` ORDER BY `users`.`user_id` ASC LIMIT $offset, $entriesPerPage;";
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
                                                        <div><img src="../assets/icons/edit.svg" onclick="editAccountCta(<?php echo $rows['user_id'] ?>)"></div>
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
                            $query = mysqli_query($conn, "SELECT COUNT(*) FROM `users`;");
                            
                            if(mysqli_num_rows($query)>0){
                                $rows = mysqli_fetch_array($query);
                                $total = $rows[0];?>
                                <p><b>Total:</b> <?=$total?> record/s</p><?php
                            }
                        ?>
                    </div>
                </div>
            </div>
        </section>

        <!-- new account -->
        <dialog class="dialog new-account diaglogActive">
            <div class="top">
                <div class="left">
                    <p>New Account</p>
                </div>
                <div class="right">
                    <img src="../assets/icons/close.svg" alt="close" onclick="closeNewAccountCta()">
                </div>
            </div>
            <!-- choice users -->
            <div class="inputs">
                <div>
                    <label>User type:</label>
                    <select onchange="userTypeCta()" id="userType">
                        <option value="">Select...</option>
                        <option value="admin" id="admin">Admin</option>
                        <option value="registrar" id="registrar">Registrar</option>
                        <option value="cashier" id="cashier">Cashier</option>
                        <option value="accounting" id="accounting">Accounting</option>
                        <option value="student" id="student">Student</option>
                    </select>
                </div>
            </div>
            <!-- for admin & registar form -->
            <div class="input-fields display-none" id="staffForm">
                <div>
                    <label for="staffName">Name:</label>
                    <input type="text" oninput="validateInputs(this)" pattern="[a-zA-Z]*" id="staffName">
                    <label for="staffSex">Sex:</label>
                    <select id="sex">
                        <option value="">Select..</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                    <label for="staffAddress">Address:</label>
                    <input type="text" oninput="validateInputs(this)" pattern="[a-zA-Z]*" id="staffAddress">
                    <label for="staffContactNumber">Contact Number:</label>
                    <input type="text" oninput="validateInput(this)" pattern="\d{11}" id="staffContactNumber">
                    <label for="staffEmailAddress">Email Address:</label>
                    <input type="email" id="staffEmailAddress">
                    <label for="staffUsername">Username:</label>
                    <input type="text" oninput="validateInputs(this)" pattern="[a-zA-Z]*" id="staffUsername">
                    <label for="staffPassword">Password:</label>
                    <input type="password" id="staffPassword">
                    <label for="staffConfirmPassword">Confirm Password:</label>
                    <input type="password" id="staffConfirmPassword">
                </div>
                <button type="button" onclick="submitAccountAdminCta()"><img src="../assets/icons/save.svg" alt="save">Submit</button>
            </div>
            <!-- for student form -->
            <div class="input-fields display-none" id="studentForm">
                <div class="search-student">
                    <label for="searchStudentName">Search Student Name:</label>
                    <input type="search" id="searchStudentName" placeholder="Search" oninput="searchStudentNameCta()" autocomplete="off">
                    <div class="result" id="searchStudentResult" autocomplete="off">
                        <!--appear if search student name -->
                    </div>
                </div>
                <section class="display-none" id="studentAccount">
                    <div>
                        <label for="studentname">Name:</label>
                        <input type="text" id="studentname" readonly>
                    </div>
                    <div>
                        <label for="studentUsername">Username:</label>
                        <input type="text" oninput="validateInputs(this)" pattern="[a-zA-Z]*" id="studentUsername">
                    </div>
                    <div>
                    <label for="studentStatus">Status:</label>
                    <input type="text" id="studentStatus" value="activated" disabled>
                    </div>
                    
                </section>
                <button type="button" onclick="submitAccountStudentCta()"><img src="../assets/icons/save.svg" alt="save">Submit</button>
            </div>           
        </dialog>

        <!-- update account -->
        <dialog class="dialog update-account">
            <div class="top">
                <div class="left">
                    <p>Update Account</p>
                </div>
                <div class="right">
                    <img src="../assets/icons/close.svg" alt="close" onclick="closeUpdateAccountCta()">
                </div>
            </div>
            <div class="inputs" id="inputAccounts">
                <input type="text" id="updateAccountName" oninput="validateInputs(this)" placeholder="Name" >   
                <input type="text" id="updateAccountUsername" oninput="validateInputs(this)" placeholder="Username" >
                <select id="updateAccountRole">
                    <option value="admin">Admin</option>
                    <option value="registrar">Registrar</option>
                    <option value="students">Students</option>
                </select>
                <select id="updateAccountStatus">
                    <option value="activated">Activated</option>
                    <option value="deactivated">Deactivated</option>
                </select>
            </div>
            <button type="button" onclick="submitUpdateAccountCta()"><img src="../assets/icons/update.svg" alt="save">Update</button>
        </dialog>
        <!-- view user -->
        <dialog class="dialog view-account">
            <div class="top">
                <div class="left">
                    <p>View Account</p>
                </div>
                <div class="right">
                    <img src="../assets/icons/close.svg" alt="close" onclick="closeUpdateAccountCta()">
                </div>
            </div>
            <div class="inputs" id="viewInputs">
                <input type="text" placeholder="Name" >   
                <input type="text" placeholder="Username" >
                <select id="updateAccountRole">
                    <option value="admin">Admin</option>
                    <option value="registrar">Registrar</option>
                    <option value="students">Students</option>
                </select>
            </div>
        </dialog>
        
    </body>
</html>