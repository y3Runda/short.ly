<?php

namespace application\models;
use application\core\Model;

class User extends Model
{
    public function validate($input, $post)
    {
        $rules = [
            'email' => [
                'pattern' => '#^([a-z0-9_.-]{1,20}+)@([a-z0-9_.-]+)\.([a-z\.]{2,10})$#',
                'message' => 'The email address is incorrect',
            ],
            'password' => [
                'pattern' => '#^[a-z0-9]{10,30}$#',
                'message' => 'Password is incorrect (only latin letters and numbers from 10 to 30 characters are allowed)',
            ],
        ];
        foreach ($input as $val) {
            if (!isset($post[$val]) or !preg_match($rules[$val]['pattern'], $post[$val])) {
                $this->error = $rules[$val]['message'];
                return false;
            }
        }
        return true;
    }

    public function checkEmailExists($email) {
        $params = ['email' => $email];
        return $this->db->column('SELECT id FROM users WHERE email = :email', $params);
    }

    public function checkTokenExists($token) {
        $params = ['token' => $token];
        return $this->db->column('SELECT id FROM users WHERE token = :token', $params);
    }

    public function activate($token) {
        $params = ['token' => $token];
        $this->db->query('UPDATE users SET status = 1, token = "" WHERE token = :token', $params);
    }

    public function createToken() {
        return substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstuvwxyz', 30)), 0, 30);
    }

    public function register($post) {
        $token = $this->createToken();
        $params = [
            'id' => '',
            'email' => $post['email'],
            'password' => password_hash($post['password'], PASSWORD_BCRYPT),
            'token' => $token,
            'status' => 0,
        ];
        $this->db->query('INSERT INTO users VALUES (:id, :email, :password, :token, :status)', $params);
        mail($post['email'], 'Register', 'Confirm: '. $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'user/confirm/'.$token);
    }

    public function checkData($email, $password) {
        $params = ['email' => $email];
        $hash = $this->db->column('SELECT password FROM users WHERE login = :login', $params);
        if (!$hash or !password_verify($password, $hash)) {
            return false;
        }
        return true;
    }

    public function checkStatus($type, $data) {
        $params = [$type => $data];
        $status = $this->db->column('SELECT status FROM users WHERE '.$type.' = :'.$type, $params);
        if ($status != 1) {
            $this->error = 'Account is waiting for confirmation by E-mail';
            return false;
        }
        return true;
    }

    public function email($email) {
        $params = ['email' => $email];
        $data = $this->db->row('SELECT * FROM users WHERE email = :email', $params);
        $_SESSION['user'] = $data[0];
    }

    public function recovery($post) {
        $token = $this->createToken();
        $params = [
            'email' => $post['email'],
            'token' => $token,
        ];
        $this->db->query('UPDATE users SET token = :token WHERE email = :email', $params);
        mail($post['email'], 'Recovery', 'Confirm: '.$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/user/reset/'.$token);
    }

    public function reset($token) {
        $new_password = $this->createToken();
        $params = [
            'token' => $token,
            'password' => password_hash($new_password, PASSWORD_BCRYPT),
        ];
        $this->db->query('UPDATE users SET status = 1, token = "", password = :password WHERE token = :token', $params);
        return $new_password;
    }
}