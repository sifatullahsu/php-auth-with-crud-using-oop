<?php
include 'inc/header.php';


$mysqli_db = new MySQLi_DB();


if (0 == 0) {
    $id = 12;

    $sql = "SELECT * FROM tbl_user WHERE id=?";
    $stmt = MySQLi_DB::prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();

    $result = $stmt->get_result()->fetch_assoc();

    var_dump($result);
}



if (0 == 0) {
    /* $sql = "SELECT * FROM tbl_user";
    $query = MySQLi_DB::query($sql);
    if ($query->num_rows > 0) {
        while ($row = $query->fetch_assoc()) {
            echo $row['id'] . ' - ' . $row['name'] . $br;
        }
    } */
}








include 'inc/footer.php';