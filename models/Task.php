<?php

namespace models;

use core\models\BaseModel;

/**
 * Task entity
 *
 * @author artyomnar
 */
class Task extends BaseModel
{
    public $userName;
    public $email;
    public $text;
    public $status;
        
    public function rules() : array
    {
        return [
            [['userName', 'email'], 'require'],
            ['userName', 'string', ['min' => 3, 'max' => 5]],
            ['status', 'number', ['min' => 0, 'max' => 3]]
        ];
    }
    
    public function getAttributeLabels(): array
    {
        return [
            'userName' => 'User Name',            
            'email' => 'Email',
            'text' => 'Text',            
            'status' => 'Status',
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
