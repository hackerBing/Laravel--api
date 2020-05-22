<?php


namespace App\Http\Controllers\Api\User;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $guarded = ['id'];
    protected $table = 'user';
}
