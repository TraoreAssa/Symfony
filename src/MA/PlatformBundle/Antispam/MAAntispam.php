<?php

namespace MA\PlatformBundle\Antispam;

class MAAntispam
{
    private $mailer;
    private $locale;
    private $minLength;

    public function _construct(\Swift_Mailler $mailer, $locale, $minLength)
    {
        $this->$mailer = $mailer;
        $this->$locale = $locale;
        $this->$minLength = (int) $minLength;
    }
    public function isSpam($text)
    {
        return strlen($text) < $minLength;
    }
}
