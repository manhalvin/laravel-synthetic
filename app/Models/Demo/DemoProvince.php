<?php

namespace App\Models\Demo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemoProvince extends Model
{
    use HasFactory;
    protected $table = 'provinces';
    protected $guarded = [];
}
