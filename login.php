<?php
include 'inc/header.php';

Session::restrict_for_logged_in_users();

$user = new User;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $result = $user->userLogin($_POST);
}

?>
<div class="main-box">
    <h3 class="page-title">Login Form</h3>

    <?php
    if (isset($result)) {
        echo $result;
    }
    ?>

    <form action="" method="POST">
        <div class="field-box">
            <label for="username_email">Username or Email</label>
            <input type="text" name="username_email">
        </div>
        <div class="field-box">
            <label for="password">Password</label>
            <input type="password" name="password">
        </div>
        <div class="field-box">
            <input type="submit" name="login" value="Login">
        </div>
    </form>
</div>
<?php






include 'inc/footer.php';