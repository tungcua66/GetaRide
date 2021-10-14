<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $table = 'groups';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
        'id_creator'
    ];
}
