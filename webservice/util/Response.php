<?php

class Response
{

    public $code;
    public $status;
    public $message;

    function __construct($code=0, $status=false, $message=null)
    {
        $this->code = $code;
        $this->status = $status;
        $this->message = $message;
    }

}

?>