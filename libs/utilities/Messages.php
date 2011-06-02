<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Messages
 *
 * @author mostafa
 */
class Messages
{
    const lvError=1;
    const lvWarning=2;
    const lvNotice=3;
    const lvSuccess=4;

    private $messages = array();
    private static $instance = null;

    /**
     * Singeltone Get Instance
     *
     * @return Messages
     */
    static public function getInstance()
    {
        if (!self::$instance)
            self::$instance = new self ( );
        return self::$instance;
    }

    public function __construct()
    {
        $this->messages = Session::getInstance()->sysMessage;
        if(!is_array($this->messages))
        {
            $this->messages=array();
        }
    }

    public function log($message, $level)
    {
        $msg = new stdClass;
        $msg->message = $message;
        $msg->level = $level;
        $this->messages[] = $msg;
    }

    public function logError($message)
    {
        $this->log($message, self::lvError);
    }

    public function logWarning($message)
    {
        $this->log($message, self::lvWarning);
    }

    public function logNotice($message)
    {
        $this->log($message, self::lvNotice);
    }

    public function logSuccess($message)
    {
        $this->log($message, self::lvSuccess);
    }

    public function __destruct()
    {
        Session::getInstance()->sysMessage = $this->messages;
    }

    public function getMessages()
    {
        return $this->messages;
    }

    public function cleen()
    {
        $this->messages = array();
    }

}
?>
