<?php

require_once __DIR__.'/../BaseClass.php';
require_once __DIR__. '/../config/DataBaseClass.php';

class Record{

    public function __construct()
    {
        $this->db = new DataBase;
        $this->db = $this->db->getDb();
    }

    public function getRecords(){
        $records = $this->db->query("SELECT * FROM records");
        return $records;
    }

    public function getUnbusyRecords(){
        $records = $this->db->query("SELECT * FROM records WHERE NOT EXISTS (SELECT `record_id` FROM users_records WHERE records.id = users_records.record_id) ORDER BY id DESC");
        $records = $records->fetchAll(PDO::FETCH_ASSOC);
        return $records;
    }

    public function getUserRecords(){
        $stmt = $this->db->prepare("SELECT * FROM users_records WHERE `user_id` = ?  ORDER BY id DESC");
        $stmt->execute([$_GET['id']]);
        $user_records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $user_records;
    }

    public function getUserRecordByUserId($id){
        $stmt = $this->db->prepare("SELECT * FROM users_records WHERE `id` = ?");
        $stmt->execute([$id]);
        $record = $stmt->fetch(PDO::FETCH_LAZY);
        return $record;
    }


    public function getRecordByDateAndTime(){
        $date = Base::formatDate($_POST['date']);
        $time = $_POST['time'];
        $stmt = $this->db->prepare("SELECT `id` FROM records WHERE `date` = ? AND `time` = ?");
        $stmt->execute([$date, $time]);
        $record_id = $stmt->fetchColumn();
        return $record_id;
    }

    public function getRecordById($id){
        $stmt = $this->db->prepare("SELECT * FROM records WHERE `id` = ?");
        $stmt->execute([$id]);
        $record = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $record;
    }
}