<?php

class User {
    private $table = 'tbl_user';

    private function validation($data) {
        $data = htmlspecialchars($data);
        $data = trim($data);
        $data = stripslashes($data);

        return $data;
    }

    private function checkUsername($username) {
        $sql = "SELECT id, username FROM $this->table WHERE username=?";
        $stmt = DB::prepare($sql);
        $stmt->bindParam('1', $username);
        $stmt->execute();

        if (Session::get('login') != TRUE) {
            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } else {

            if ($stmt->rowCount() > 0) {
                $result = $stmt->fetch();

                if ($result['id'] == Session::get('id')) {
                    return false;
                } else {
                    return true;
                }
            } else {
                return false;
            }
        }
    }

    private function checkEmail($email) {
        $sql = "SELECT id, email FROM $this->table WHERE email=?";
        $stmt = DB::prepare($sql);
        $stmt->bindParam('1', $email);
        $stmt->execute();

        if (Session::get('login') != TRUE) {
            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } else {

            if ($stmt->rowCount() > 0) {
                $result = $stmt->fetch();

                if ($result['id'] == Session::get('id')) {
                    return false;
                } else {
                    return true;
                }
            } else {
                return false;
            }
        }
    }

    private function checkPassword($id, $password) {
        $pass_md5 = md5($password);

        $sql = "SELECT password FROM $this->table WHERE id=?";
        $stmt = DB::prepare($sql);
        $stmt->bindParam('1', $id);
        $stmt->execute();

        $result = $stmt->fetch();
        if ($pass_md5 == $result['password']) {
            return true;
        } else {
            return false;
        }
    }

    public function getUserData() {
        $sql = "SELECT * FROM $this->table";
        $stmt = DB::prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getUserDataById($id) {
        $sql = "SELECT * FROM $this->table WHERE id=? LIMIT 1";
        $stmt = DB::prepare($sql);
        $stmt->bindParam('1', $id);
        $stmt->execute();

        return $stmt->fetch();
    }

    public function updateUserData($id, $data) {
        $id         = $this->validation($id);
        $name       = $this->validation($data['name']);
        $username   = $this->validation(strtolower($data['username']));
        $email      = $this->validation(strtolower($data['email']));

        if ($name == '' || $username == '' || $email == '') {
            return Msg::err('Field must not be empty..');
        }

        if (strpos($username, ' ') == true) {
            return Msg::err('Username have should be no space..');
        }

        if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
            return Msg::err('Enter valid email addess..');
        }

        $check_username = $this->checkUsername($username);
        $check_email = $this->checkEmail($email);

        if ($check_username == true) {
            return Msg::err('Username already exist');
        }

        if ($check_email == true) {
            return Msg::err('Email already exist');
        }

        $sql = "UPDATE $this->table SET name=?, username=?, email=? WHERE id=?";
        $stmt = DB::prepare($sql);
        $stmt->bindParam('1', $name);
        $stmt->bindParam('2', $username);
        $stmt->bindParam('3', $email);
        $stmt->bindParam('4', $id);
        $stmt->execute();

        return Msg::succ('User update successfully..');
    }

    public function deleteUserDataById($id) {

        $is_have_any_user = $this->getUserDataById($id);

        if ($is_have_any_user == false) {
            return Msg::err('No user found to delete..');
        } else {
            $id = $is_have_any_user['id'];
        }

        if ($id == Session::get('id')) {
            return Msg::err('You can not delete yourself..');
        }

        $sql = "DELETE FROM $this->table WHERE id=?";
        $stmt = DB::prepare($sql);
        $stmt->bindParam('1', $id);
        $result = $stmt->execute();

        if ($result == true) {
            return Msg::succ('User delete successfully..');
        }
    }

    public function userRegistration($data) {
        $name       = $this->validation($data['name']);
        $username   = $this->validation(strtolower($data['username']));
        $email      = $this->validation(strtolower($data['email']));
        $password   = $this->validation($data['password']);
        $pass_md5   = $this->validation(md5($data['password']));

        if ($name == '' || $username == '' || $email == '' || $password == '') {
            return Msg::err('Field must not be empty..');
        }

        if (strpos($username, ' ') == true) {
            return Msg::err('Username have should be no space..');
        }

        if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
            return Msg::err('Enter valid email addess..');
        }

        if (strlen($password) < 6) {
            return Msg::err('Password should be 6 character');
        }

        $check_username = $this->checkUsername($username);
        $check_email = $this->checkEmail($email);

        if ($check_username == true) {
            return Msg::err('Username already exist');
        }

        if ($check_email == true) {
            return Msg::err('Email already exist');
        }

        $sql = "INSERT INTO $this->table(name, username, email, password) VALUES(?,?,?,?)";
        $stmt = DB::prepare($sql);
        $stmt->bindParam('1', $name);
        $stmt->bindParam('2', $username);
        $stmt->bindParam('3', $email);
        $stmt->bindParam('4', $pass_md5);
        $stmt->execute();

        return Msg::succ('User successfully registered..');
    }

    public function userLogin($data) {
        $username_email      = $this->validation(strtolower($data['username_email']));
        $password   = $this->validation($data['password']);
        $pass_md5   = $this->validation(md5($data['password']));

        if ($username_email == '' || $password == '') {
            return Msg::err('Field must not be empty..');
        }

        $sql = "SELECT * FROM $this->table WHERE (username=? || email=?) && password=? LIMIT 1";
        $stmt = DB::prepare($sql);
        $stmt->bindParam('1', $username_email);
        $stmt->bindParam('2', $username_email);
        $stmt->bindParam('3', $pass_md5);
        $stmt->execute();

        $result = $stmt->fetch();

        if ($result) {
            Session::init();
            Session::set("login", TRUE);
            Session::set("id", $result['id']);
            Session::set("name", $result['name']);
            Session::set("username", $result['username']);
            Session::set("loginMsg", Msg::succ('Login successful..'));

            header("Location: index.php");
        } else {
            return Msg::err('Something is wrong..');
        }
    }

    public function changePassword($id, $data) {
        $old_pass   = $this->validation($data['old_pass']);
        $new_pass   = $this->validation($data['new_pass']);

        $new_pass_md5   = md5($new_pass);

        if ($old_pass == '' || $new_pass == '') {
            return Msg::err('Field must not be empty..');
        }

        if (strlen($new_pass) < 6) {
            return Msg::err('Password should be 6 character');
        }

        $check_password = $this->checkPassword($id, $old_pass);

        if ($check_password == FALSE) {
            return Msg::err('Old password incorrect..');
        }

        $sql = "UPDATE $this->table SET password=? WHERE id=?";
        $stmt = DB::prepare($sql);
        $stmt->bindParam('1', $new_pass_md5);
        $stmt->bindParam('2', $id);
        $stmt->execute();

        return Msg::succ('Password update successfully..');
    }
}