<?php
/*
 * Logger class to collect error, calls, output from all processes
 */
class Logger
{
    private $startTime;
    private $endTime;

    private $dbQueries = [];
    private $error = [];

    private $postData = [];
    private $getData = [];
    private $files = [];
    private $cookies = [];

    function __construct($bootTime = Null)
    {
        if($bootTime == Null)
        {
            $this->startTime=$bootTime;
        } else {
            $this->startTime=microtime();
        }

        //grab all available data
        $this->postData = $_POST;
        $this->getData = $_GET;
        $this->files = $_FILES;
        $this->cookies = $_COOKIE;
    }

    public function logQuery($query)
    {
        $this->dbQueries[]=$query;
    }

    public function finalize()
    {
        $this->endTime = microtime();
    }
    public function showLog()
    {
        if($this->endTime == Null){$this->finalize();}
        print "Page was rendered in ".($this->endTime - $this->startTime)." seconds.<br />";
        //need to make this much fancier, but for now:
        print "<pre>\n";
        print_r($this->dbQueries);
        print "</pre>\n";
    }
}