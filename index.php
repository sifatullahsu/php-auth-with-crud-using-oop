<?php
include 'inc/header.php';

Session::adminProtect();

$user = new User;


if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $delete = $user->deleteUserDataById($id);
}

if (isset($delete)) {
    echo $delete;
}



$loginMsg = Session::get('loginMsg');

if (isset($loginMsg)) {
    echo $loginMsg;
    Session::set('loginMsg', NULL);
}


if (Session::get('login') == TRUE) {
?>
<div class="user-info">
    <h4>Welcome ! <?php echo userInfo::get('name'); ?></h4>
</div>
<?php

}

?>
<p style="margin-bottom: 15px; text-align: right;">
    <a href="register.php">Register a new user?</a>
</p>

<table class="border">
    <tr>
        <td style="width: 5%;">No.</td>
        <td style="width: 30%;">Name</td>
        <td style="width: 20%;">Username</td>
        <td style="width: 30%;">Email</td>
        <td style="width: 15%;">Action</td>
    </tr>
    <?php
    $result = $user->getUserData();
    $i = 0;
    foreach ($result as $data) {
        $i++;
    ?>
    <tr>
        <td><?php echo $i; ?></td>
        <td><?php echo $data['name']; ?></td>
        <td><?php echo $data['username']; ?></td>
        <td><?php echo $data['email']; ?></td>
        <td>
            <?php
                if (Session::get('id') == $data['id']) {
                ?>
            <a href="profile.php">edit</a>
            <?php } else { ?>
            <a href="profile.php?action=view&id=<?php echo $data['id']; ?>">view</a>
            <?php } ?>
            <?php
                if (Session::get('id') != $data['id']) {
                ?>
            <span> || </span>
            <a href="?action=delete&id=<?php echo $data['id']; ?>"
                onclick="return confirm('Are you sure you want to delete user?')">delete</a>
            <?php } ?>
        </td>
    </tr>
    <?php } ?>
</table>

<?php












include 'inc/footer.php';