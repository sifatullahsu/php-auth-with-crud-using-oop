<?php
include 'inc/header.php';

Session::adminProtect();

$user = new User;

$id = Session::get('id');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['change'])) {
    $result = $user->changePassword($id, $_POST);
}

?>
<div class="main-box">
    <h3 class="page-title">Change Password</h3>

    <?php
    if (isset($result)) {
        echo $result;
    }
    ?>

    <form action="" method="POST">
        <div class="field-box">
            <label for="old_pass">Old Password</label>
            <input type="password" name="old_pass">
        </div>
        <div class="field-box">
            <label for="new_pass">New Password</label>
            <input type="password" name="new_pass">
        </div>
        <div class="field-box">
            <input type="submit" name="change" value="Change Password">
        </div>
    </form>
</div>
<?php






include 'inc/footer.php';