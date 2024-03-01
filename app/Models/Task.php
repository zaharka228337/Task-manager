<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public $timestamps = false;

    protected $table = 'tasks';
    protected $dateFormat = 'Y-m-d';

    protected $casts = [
        'status' => 'boolean'
    ];
    protected $fillable = [
        'name',
        'description',
        'status',
        'date_start',
        'date_deadline'
    ];
}
