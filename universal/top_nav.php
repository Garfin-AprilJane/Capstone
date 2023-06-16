<header class="header-top">
    <aside class="aside-left">
        <img src="../assets/images/logo.jpeg" alt="logo">
        <p>WTCA | Computerized Enrollment System</p>
    </aside>
    <aside class="aside-right">
        <img src="../assets/icons/user.svg" onclick="logoutAccount()" alt="user">
    </aside>
    
</header>

<!-- logout -->
<div class="logout-account display-none" id="logoutAccount" >
    <p class="head">Account</p>
    <div class="user-profile">
        <img src="../assets/icons/user.svg" alt="user">
        <?php
            if(isset($_COOKIE['usrId'])){
                $usrId = $_COOKIE['usrId'];
                $query = mysqli_query($conn, "SELECT * FROM `users` WHERE `user_id`=$usrId;");

                if(mysqli_num_rows($query)>0){
                    $rows = mysqli_fetch_assoc($query);
                    
                    if ($rows['role'] === "student") {
                        $query = mysqli_query($conn, "SELECT CONCAT(`first_name`, ' ', `middle_name`, ' ', `last_name`, ' ', `suffix`) AS `fullname` FROM `students` INNER JOIN `users` ON `students`.`user_id` = `users`.`user_id` WHERE `students`.`user_id` = $usrId;");
                        $rows1 = mysqli_fetch_assoc($query);
                        if ($rows1) {
                            echo "<strong>" . strtoupper($rows1['fullname']) . "</strong>";
                        }
                    }
                    
                    
                    else{
                        $query = mysqli_query($conn, "SELECT * FROM `staffs` INNER JOIN `users` ON `staffs`.`user_id` = `users`.`user_id` WHERE `staffs`.`user_id`=$usrId;");
                        $rows1 = mysqli_fetch_assoc($query);?>
                        <strong><?php echo strtoupper($rows1['staff_name'])?></strong><?php
                    }
                }
            }
        ?>
    </div>
    <div class="account" onmouseover="manageAccountOverCta()" onmouseleave="manageAccountLeaveCta()">
        <p>Manage account</p>
        <img src="../assets/icons/right-arrow.svg" alt="right arrow">
        <div class="account-options display-none" id="accountOptions">
            <div class="option" onclick="changePasswordCta()">
                <p>Change password</p>
            </div>
            <?php
                $query = mysqli_query($conn, "SELECT * FROM `users` WHERE `user_id`=$usrId;");
                if(mysqli_num_rows($query)>0){
                    $rows = mysqli_fetch_assoc($query);
                    //admin and registrar
                    if($rows['role'] === "admin" || $rows['role'] === "registrar"){?>
                        <div class="option" onclick="personalDetailsCta()">
                            <p>Personal details</p>
                        </div><?php
                    }
                }
            ?>
        </div>
    </div>
    <div class="account" onclick="logoutAccountCta()">
        <p>Log-out account</p>
        <img src="../assets/icons/logout.svg" alt="logout">
    </div>
</div>


<!-- personal details -->
<dialog class="dialog personal-details">
    <div class="top">
        <div class="left">
            <p>Personal Details</p>
        </div>
        <div class="right">
            <img src="../assets/icons/close.svg" alt="close" onclick="closePersonalDetailsCta()">
        </div>
    </div>
    <div class="inputs" id="personalDetails">
        <input type="text" id="personalDetailsName" placeholder="Name">   
        <input type="text" id="personalDetailsUsername" placeholder="Username">
    </div>
    <button type="button" onclick="submitPersonalDetailsCta()"><img src="../assets/icons/update.svg" alt="save">Update</button>
</dialog>

<!-- change password -->
<dialog class="dialog change-password">
    <div class="top">
        <div class="left">
            <p>Change Password</p>
        </div>
        <div class="right">
            <img src="../assets/icons/close.svg" alt="close" onclick="closeChangePasswordCta()">
        </div>
    </div>
    <div class="inputs" id="changePassword">
        <div>
            <input type="password" id="changeCurrentPassword" placeholder="Current Password">   
            <input type="checkbox" id="checkChangeCurrentPassword" onclick="checkChangeCurrentPasswordCta()">
        </div>
        <div>
            <input type="password" id="changeNewPassword" placeholder="New Password">
            <input type="checkbox" id="checkChangeNewPassword" onclick="checkChangeNewPasswordCta()">
        </div>
    </div>
    <button type="button" onclick="submitChangePasswordCta()"><img src="../assets/icons/update.svg" alt="save">Update</button>
</dialog>

<!-- confirm and cancel dialog -->
<dialog class="dialog dialogActive confirm-cancel-dialog " id="statusAccountConfirmCancelDialog">
    <header>
        <p>Message confirmation</p>
    </header>
    <div class="box">
        <p id="statusAccountMsg"></p>
        <input type="number" id="statusAccountId" class="displayNone">
    </div>
    <div class="buttons">
        <button type="button" onclick="statusAccountConfirmCta()"><img src="../assets/icons/ok.svg">Confirm</button>
        <button type="button" onclick="statusAccountCancelCta()"><img src="../assets/icons/close.svg">Cancel</button>
    </div>
</dialog>
<!-- loading dialog -->
<dialog class="loading-dialog" id="loadingDialog">
    <div class="box">
        <img src="../assets/icons/loading.gif" alt="loading gif">
        <p>please wait...</p>
    </div>
</dialog>









        