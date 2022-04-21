<?php

require_once './libraries/Database.php';

class Mouth {
    private $db;

    public function __construct()
    {
        $this->db = new Database;   
    }

    public function getMouth() {
        $this->db->query('SELECT
        tb.id, tb.child_text,
        COALESCE(AVG(rb.stars), 0) AS rating 
FROM childs_mouth AS tb
LEFT JOIN rates_mouth AS rb ON tb.id = rb.mouth_id
GROUP BY tb.id');
        $row = $this->db->resultSet();
        if($this->db->rowCount() > 0) {
            return $row;
        } else {
            return false;
        }
    }
    public function getRatedUserMouthIds($usermail) { // username on userEmail tegelikkuses
        $this->db->query('SELECT mouth_id FROM rates_mouth WHERE username = :username GROUP BY mouth_id');
        $this->db->bind(':username', $usermail);
        $row = $this->db->resultSet();
        if($this->db->rowCount() > 0) {
            return $row;
        } else {
            return false;
        }
    }

public function findRatedMouthByIdAndEmail($mouth_id, $email) {
    $this->db->query('SELECT * FROM rates_mouth WHERE username = :username AND mouth_id = :mouth_id');
    $this->db->bind(':username', $email);
    $this->db->bind(':mouth_id', $mouth_id);
    $row = $this->db->single();
    if($this->db->rowCount() > 0) {
        return $row;
    } else {
        return false;
    }
}

public function addUserNewRatingToMouth($mouth_id, $rating, $email) {
    $this->db->query('INSERT INTO rates_mouth (mouth_id, username, stars, added) 
    VALUES (:mouth_id, :username, :stars, NOW())');
    $this->db->bind(':mouth_id', $mouth_id);
    $this->db->bind(':username', $email);
    $this->db->bind(':stars', $rating);
    if($this->db->execute()) {
        return true;
    } else {
        return false;
    }
}

public function updatedUserRatingToMouth($id, $stars) {
    $this->db->query('UPDATE rates_mouth SET stars = :stars WHERE mouth_id = :mouth_id');
    $this->db->bind(':stars', $stars);
    $this->db->bind(':mouth_id', $id);
   // return $id;
    if($this->db->execute()) {
        return true;
    } else {
        return false;
    }
}
}