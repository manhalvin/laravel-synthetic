<?php

namespace App\Models\Demo\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemoProduct extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $guarded = [];
}
