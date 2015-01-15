<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 15.01.15
 * Time: 17:56
 */

namespace AlmosBundle;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class Mailer {

    protected $mailer;


    public function Send($subj, $from, $to, $letter, $mailer)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject($subj)
            ->setFrom($from)
            ->setTo($to)
            ->setBody($letter)
        ;
        $this->mailer = $mailer;
        $this->mailer->send($message);
    }

}