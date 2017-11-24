<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Capsule\Manager as DB;

class Book extends Model
{
    const STATUS_ACTIVE = 'active';
    const STATUS_DISABLED = 'disabled';

    protected $fillable = [
        'book_name', 'status'
    ];

}
