<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrasaranaJalan extends Model
{
    protected $primaryKey = 'id_prasarana_jalan';
    protected $guarded = ['id_prasarana_jalan'];
    public $timestamps = false;
    protected $table = 'prasarana_jalans';
}
