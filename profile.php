<?php
include 'inc/header.php';

Session::adminProtect();

$user = new User;

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
} else {
    $id = (int) Session::get('id');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $result = $user->updateUserData($id, $_POST);
}


?>
<div class="main-box">
    <h3 class="page-title">User Profile</h3>

    <?php
    if (isset($result)) {
        echo $result;
    }
    ?>

    <?php

    $data = $user->getUserDataById($id);

    $readonly = (Session::get('id') == $id ? '' : 'readonly');
    $readonlyMsg = (Session::get('id') == $id ? '' : '<p style="margin-bottom: 10px;">You can only read..</p>');

    if ($data) {
        echo $readonlyMsg;
    ?>

    <form action="" method="POST">
        <div class="field-box">
            <label for="name">Name</label>
            <input type="text" name="name" value="<?php echo $data['name']; ?>" <?php echo $readonly ?>>
        </div>
        <div class="field-box">
            <label for="username">Username</label>
            <input type="text" name="username" value="<?php echo $data['username']; ?>" <?php echo $readonly ?>>
        </div>
        <div class="field-box">
            <label for="email">Email</label>
            <input type="text" name="email" value="<?php echo $data['email']; ?>" <?php echo $readonly ?>>
        </div>
        <?php
            if (Session::get('id') == $id) {
            ?>
        <div class="field-box">
            <input type="submit" value="Update" name="update">
        </div>
        <?php } ?>
    </form>
    <?php } ?>
</div>
<?php






include 'inc/footer.php';