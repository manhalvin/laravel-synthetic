<?php

namespace App\Models\Demo\Role;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemoRole extends Model
{
    use HasFactory;
    protected $table = 'roles';
    protected $guarded = [];
}
