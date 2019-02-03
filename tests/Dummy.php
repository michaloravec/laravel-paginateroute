<?php

namespace MichalOravec\PaginateRoute\Test;

use Illuminate\Database\Eloquent\Model;

class Dummy extends Model
{
    protected $table = 'dummies';

    protected $guarded = [];

    public $timestamps = false;
}
