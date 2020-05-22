<?php

namespace App\Http\Controllers\Home\Test;


use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $guarded = ['id'];

    public $timestamps = true;

    public $table = 'Test';
}
