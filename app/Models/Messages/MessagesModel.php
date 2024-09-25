<?php

namespace Models\Messages;

use Models\MasterModel;

Class MessagesModel extends MasterModel
{


    public function consultMessages()
    {
        $sql = "SELECT * FROM messages";
        $params = [];
        $messages = $this->select($sql, $params);
        return $messages;
    }
    public function insertMessage($recipients, $send_date, $subject, $message)
    {
        $sql = "INSERT INTO messages (recipients, send_date, subject, message) 
                VALUES (:recipients, :send_date, :subject, :message)";
        $params = [':recipients'=>$recipients,
                    ':send_date'=>$send_date, 
                    ':subject'=>$subject,
                    ':message'=> $message];
        $this->insert($sql, $params);
    }



}

?>