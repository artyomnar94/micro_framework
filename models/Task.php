<?php

namespace models;

/**
 * Task entity
 *
 * @author artyomnar
 */
class Task {
    public $userName;
    public $email;
    public $text;
    public $status;
    
    public function getTaskInfo(): array
    {
        $taskInfo = [
            'userName' => $this->userName,
            'email' => $this->email,
            'text' => $this->text,
            'status' => $this->status,
        ];
        
        return $taskInfo;
    }
}
