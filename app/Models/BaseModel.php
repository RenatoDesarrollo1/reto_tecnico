<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    protected $messages = [
        'notfound' => "Este registro no existe"
    ];

    public function getMessage($property)
    {
        return $this->messages[$property] ?? "";
    }
}
