<?php

namespace App\Models\Demo\Relationship;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentRelationship extends Model
{
    use HasFactory;
    protected $table = 'comments';
    protected $guarded = [];
}
