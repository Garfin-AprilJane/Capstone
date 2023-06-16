<?php 
    include("../assets/connection/connection.php");
    session_start();
?>

<!-- ... -->

<?php
// edit account
if (isset($_GET['editAccount'])) {
    $id = $_GET['editAccount'];
    $_SESSION['editAccount'] = $id;
    $query = mysqli_query($conn, "SELECT * FROM `users` WHERE `user_id`=$id;");
    $rows = mysqli_fetch_assoc($query);
?>
    <label>Name</label>
    <input type="text" id="updateAccountName" placeholder="Name" value="<?php echo $rows['username'] ?>" readonly>
    <label>Username</label>
    <input type="text" id="updateAccountUsername" placeholder="Username" value="<?php echo $rows['username'] ?>" readonly>
    <label>Role</label>
    <select id="updateAccountRole">
        <?php
        $roles = array("admin", "registrar", "student", "cashier", "accounting");
        foreach ($roles as $role) {
            $selected = ($role === $rows['role']) ? 'selected' : '';
            echo "<option value='$role' $selected>$role</option>";
        }
        ?>
    </select>

    <label>Payment</label>
    <input type="text" id="paymentPEUniform" placeholder="PE Uniform">
    <input type="text" id="paymentSchoolUniform" placeholder="School Uniform">
    <input type="text" id="paymentMiscFees" placeholder="Miscellaneous Fees">
<?php
}
?>

<!-- ... -->
</html>
