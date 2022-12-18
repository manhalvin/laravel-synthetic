<?php

namespace App\Models\Demo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemoWard extends Model
{
    use HasFactory;
    protected $table = 'wards';
    protected $guarded = [];
}
