<?php
/*
    this class is created to simply build a message to a user,
    or display a message that they have received,
    whether from the system or from another user

*/

class Message
{
    private $messageID = 0;
    private $recipientID = 0;
    private $senderID = 0;
    private $status = 1;
    private $type = 'message';
    private $messageSubject = '';
    private $messageBody = '';
    private $priority = 0;

    public function to($userID)
    {
        $this->recipientID = $userID;
    }

    public function from($userID)
    {
        $this->senderID = $userID;
    }

    public function setType($type='message')
    {
        // valid options are message, alert, job_update, chat
        $this->type = $type;
    }

    public function setSubject($subject)
    {
        $this->messageSubject = $subject;
    }

    public function setBody($body)
    {
        $this->messageBody = $body;
    }

    public function send()
    {
        if($this->recipientID != 0)
        {
            //store message in the database
            global $db;
            $data = array(
                'user_id' => $this->recipientID,
                'sender_id' => $this->senderID,
                'created_datetime' => date("Y-m-d H:i:s"),
                'status' => $this->status,
                'message_type' => $this->type,
                'message_subject' => $this->messageSubject,
                'message_body' => $this->messageBody
            );
            //create a new record
            $this->messageID = $db->insert('user_messages', $data);
        }
    }

    public function highPriority()
    {
        $this->priority = 1;
    }

    public function normalPriority()
    {
        $this->priority = 0;
    }

    public function display($messageID)
    {
        global $db;
        $this->messageID = $messageID;
    }

}