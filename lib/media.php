<?php

class Media {
    private $table = 'tbl_media';

    public function insertImages($data) {

        $dir = 'upload';
        $sep = '/';
        $allowed = ['jpg', 'png'];

        $file_name = $_FILES['image']['name'];
        $file_size = $_FILES['image']['size'];
        $file_temp = $_FILES['image']['tmp_name'];
        $file_type = pathinfo($file_name, PATHINFO_EXTENSION);

        $unique_name  = substr(md5(time()), 0, 10) . '.' . $file_type;

        // File Type Validation
        if (in_array($file_type, $allowed) == FALSE) {
            return Msg::err('File type not allwod');
        }

        // File Size Validation
        if ($file_size > 1000000) {
            return Msg::err('File size should be 1MB');
        }



        $is_uploaded = move_uploaded_file($file_temp, $dir . $sep . $unique_name);

        if ($is_uploaded) {
            $sql = "INSERT INTO $this->table(media) VALUES(?)";
            $stmt = DB::prepare($sql);
            $stmt->bindParam('1', $unique_name);

            $result = $stmt->execute();

            if ($result) {
                return Msg::succ('File successfully uploaded');
            }
        }
    }

    public function getImages() {
        $sql = "SELECT * FROM $this->table";
        $stmt = DB::prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function deleteMedia($id) {
        $sql = "SELECT * FROM $this->table WHERE id=?  LIMIT 1";
        $stmt = DB::prepare($sql);
        $stmt->bindParam('1', $id);
        $stmt->execute();
        $result = $stmt->fetch();

        if ($result) {
            $del_img = 'upload/' . $result['media'];
            unlink($del_img);

            $sql = "DELETE FROM $this->table WHERE id=?  LIMIT 1";
            $stmt = DB::prepare($sql);
            $stmt->bindParam('1', $result['id']);
            $result = $stmt->execute();

            if ($result = TRUE) {
                return Msg::succ('Image delete successfully..');
            } else {
                return Msg::err('Something is wrong..');
            }
        }
    }
}