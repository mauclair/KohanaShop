<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mailing
 *
 * @author snb
 */
class Mailing_Model extends Model {
    public function sendRegistrationEmail(){

    }
    /**
     *
     * @param string/array/objec $to
     * @param <type> $subject
     * @param <type> $body
     */
    public function sendEmail($to,$subject,$message){
        if(is_object($to)) $to = (array)$to;
        if(is_array($to)) $to = $to['email'];
        $from = Options_Model::ret('sending_email');

        email::send($to, $from, $subject, $message);
    }
}
?>
