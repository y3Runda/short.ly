<?php

namespace application\models;
use application\core\Model;

class Main extends Model
{

    public function createCode($length) {
        return substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstuvwxyz', $length)), 0, $length);
    }

    public function addLink($link) {
        $params = [
            'id' => NULL,
            'link' => $link,
            'code' => $this->createCode(10),
            'zero' => 0,
        ];
        return $this->db->query('INSERT INTO links VALUES (:id, :link, :code, :zero)', $params);
    }

    public function checkCodeExists($code) {
        $params = [
            'code' => $code,
        ];
        return $this->db->column('SELECT id FROM links WHERE code = :code', $params);
    }

    public function getUrl($code) {
        $params = [
            'code' => $code,
        ];
        return $this->db->row("SELECT link FROM links WHERE code = :code", $params);
    }

}