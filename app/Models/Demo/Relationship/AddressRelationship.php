<?php

namespace App\Models\Demo\Relationship;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddressRelationship extends Model
{
    use HasFactory;
    protected $table = 'addresses';
    protected $guarded = [];

    // One to one
    public function getUserRelation(){
        return $this->belongsTo(UserRelationship::class,'user_id','id');
    }
}
