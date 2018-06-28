<?php
require_once Application::$AppData->ServerPath."/Reference/Mailer/PHPMailer.php";
require_once Application::$AppData->ServerPath."/Reference/Mailer/Exception.php";

class Email
{
    public static function Send($To, $Subject, $Body)
    {
        $From = "";
        $FriendlyName = "";
        $MailProvider = "";
        $Port = 0;
        $UserName = "";
        $Password = "";
        
        $mail = new PHPMailer();
        $mail->CharSet = 'UTF-8'   ; 
        $mail->Host = "$MailProvider";
        $mail->Port = 25;
        $mail->Username = "$UserName";
        $mail->Password = "$Password";    
        $mail->setFrom("$From", "$FriendlyName");
        $mail->addAddress("$To");
        $mail->isHTML(true);
        $mail->Subject = "$Subject";
        $mail->Body = $Body;
        $mail->AltBody= "";
        return $mail->send();
    }
}
?>