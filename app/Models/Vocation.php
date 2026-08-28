<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vocation extends Model
{
    /** @use HasFactory<\Database\Factories\VocationFactory> */
    use HasFactory;

    protected $primaryKey = 'vocation_code';
    protected $keyType = 'string';
    public $incrementing = false;
}
