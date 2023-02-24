<?php

class userInfo {
    public static $table = 'tbl_user';

    private static function data() {
        $table  = self::$table;

        if (Session::get('login') == TRUE) {
            $id     = Session::get("id");
        } else {
            return FALSE;
        }

        $sql = "SELECT * FROM $table WHERE id=? LIMIT 1";
        $stmt = DB::prepare($sql);
        $stmt->bindValue('1', $id);
        $stmt->execute();

        return $stmt->fetch();
    }

    public static function get($key) {
        if (userInfo::data() != FALSE) {
            return userInfo::data()[$key];
        } else {
            return FALSE;
        }
    }
}