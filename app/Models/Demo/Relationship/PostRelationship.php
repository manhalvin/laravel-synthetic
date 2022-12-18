<?php

namespace App\Models\Demo\Relationship;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostRelationship extends Model
{
    use HasFactory;
    protected $table = 'posts';
    protected $guarded = [];

    // One to many
    public function getUserRelation(){
        return $this->belongsTo(UserRelationship::class,'user_id','id');
    }

    // Muliti Level
    public function getCommentsRelation(){
        return $this->hasMany(CommentRelationship::class,'post_id','id');
    }
}
