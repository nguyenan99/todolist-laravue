<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Todos extends Model
{
    public $table = 'todos';
    protected $fillable = ['content','checked','completed'];
}
