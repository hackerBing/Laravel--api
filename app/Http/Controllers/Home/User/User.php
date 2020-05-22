<?php

namespace App\Http\Controllers\Home\User;


use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $guarded = ['id'];

    public $timestamps = true;

    public $table = 'User';
}
