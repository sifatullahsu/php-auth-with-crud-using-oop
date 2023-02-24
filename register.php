<?php
include 'inc/header.php';

// Session::restrict_for_logged_in_users();

$user = new User;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $result = $user->userRegistration($_POST);
}


?>
<div class="main-box">
    <h3 class="page-title">Registration Form</h3>

    <?php
    if (isset($result)) {
        echo $result;
    }
    ?>

    <form action="" method="POST">
        <div class="field-box">
            <label for="name">Name</label>
            <input type="text" name="name">
        </div>
        <div class="field-box">
            <label for="username">Username</label>
            <input type="text" name="username">
        </div>
        <div class="field-box">
            <label for="email">Email</label>
            <input type="text" name="email">
        </div>
        <div class="field-box">
            <label for="password">Password</label>
            <input type="password" name="password">
        </div>
        <div class="field-box">
            <input type="submit" value="Register" name="register">
        </div>
    </form>
</div>
<?php






include 'inc/footer.php';