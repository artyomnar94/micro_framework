<?php

namespace models;

use core\BaseModel;

/**
 * Task entity
 *
 * @author artyomnar
 */
class Task extends BaseModel{
    public $userName;
    public $email;
    public $text;
    public $status;
    
    public function rules() : array
    {
        return [
            ['userName', ['\core\validators\RequireValidator']]
        ];
    }
    
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
