<?php

class Msg {

    public static function err($data) {
        $msg = "<div class='msg error'><b>Error:</b> $data</div>";
        return $msg;
    }

    public static function succ($data) {
        $msg = "<div class='msg success'><b>Success:</b> $data</div>";
        return $msg;
    }
}