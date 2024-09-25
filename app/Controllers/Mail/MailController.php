<?php
require '../vendor/autoload.php';
use Models\Mail\MailModel;

class MailController
{
 
    public function SendEmail(){

        $obj=new MailModel();
        
        $obj->DataEmail("hola","iaurbina04@misena.edu.co");
    }
}

