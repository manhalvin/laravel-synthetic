<?php

namespace App\Models\Demo\Relationship;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleRelationship extends Model
{
    use HasFactory;
    protected $table = 'roles';
    protected $guarded = [];
    // Many to Many
    public function getUserRelation(){
        return $this->belongsToMany(UserRelationship::class,'user_role','user_id','role_id');
    }
}
