<?php
require_once __DIR__.'/../../ValidatorClass.php';


class AddRecord extends Validator {

    private function date($value){
        $field = 'date';

        $currentData = date("d.m.Y");
        $maxDate = date("d.m.Y", strtotime($currentData. "+6 month"));

        $this->required($value, $field);

        if(!$this->errors[$field]){
            if(strtotime($value) < strtotime($currentData) || strtotime($value) > strtotime($maxDate)){
                $this->errors[$field] = 'Такая дата недоступна';  
            }
        }
    }

    private function time($value){
        $this->required($value, 'time');
    }

    // private function uniqueRecord($db, $value1, $value2){
    //     $stmt = $db->prepare("SELECT `id` FROM records WHERE `date` = ? AND `time` = ?");
    //     $stmt->execute([$value1, $value2]);
    //     $record = $stmt->fetchColumn();
    //     if($record){
    //        $this->errors['warning'] = 'Такая запись уже существует. Вы уверены что хотите создать опять?';
    //        $_SESSION['warning'] = $this->errors['warning'];
    //     }
    // }

    public function validate($db, $date, $time){
        if(!empty($date)){
           $date = date("Y-m-d", strtotime($date));
        }
        $this->date($date);
        $this->time($time);
        // $this->uniqueRecord($db, $date, $time);
        $this->validateErrors(['date' => $date, 'time' => $time]);
    }
}