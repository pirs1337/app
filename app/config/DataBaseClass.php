<?php

class DataBase {

  private $db;

   public function __construct(){ 

      // require_once __DIR__ .'./config.php';

      try
         {
            $this->db = new PDO('mysql:host=localhost;dbname=beauty-lab;charset=utf8mb4', 'root', 'root');
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        }
        catch (PDOException $e)
        {
            exit('Error Connecting To DataBase');
        }

    }


    public function getDb() {
      if ($this->db instanceof PDO) {
           return $this->db;
      }
    } 
}