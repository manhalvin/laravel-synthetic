<?php

namespace App\Models\Demo\Package;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemoPost extends Model
{
    use HasFactory;
    protected $table = 'demo_post';
    protected $guarded = [];
}
