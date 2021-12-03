<?php
namespace App\Models;

class Message
{
    public $text;

    public function __construct($text)
    {
        $this->text = $text;
    }

    public function toArray()
    {
        return [
            'text' => $this->text
        ];
    }
}
