<?php
include 'inc/header.php';

Session::adminProtect();

$media = new Media;

if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $result = $media->deleteMedia($id);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['insert'])) {
    $result = $media->insertImages($_POST);
}

$data = $media->getImages();


?>

<?php
if (isset($result)) {
    echo $result;
}
?>
<form action="" method="POST" enctype="multipart/form-data">
    <input type="file" name="image">
    <input type="submit" name="insert" value="Upload Image">
</form>

<table class="border" style="margin-top: 20px;">
    <tr>
        <td>No.</td>
        <td>Name</td>
        <td>Image</td>
        <td>Action</td>
    </tr>
    <?php
    foreach ($data as $d) {
    ?>
    <tr>
        <td><?php echo $d['id'] ?></td>
        <td><?php echo $d['media'] ?></td>
        <td><img src="upload/<?php echo $d['media'] ?>" width="40px" height="40px"></td>
        <td><a href="?action=delete&id=<?php echo $d['id'] ?>">delete</a></td>
    </tr>
    <?php } ?>
</table>


<?php





include 'inc/footer.php';