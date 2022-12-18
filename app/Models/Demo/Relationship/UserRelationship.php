<?php

namespace App\Models\Demo\Relationship;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserRelationship extends Model
{
    use HasFactory;
    protected $table = 'users';
    protected $guarded = [];

    // One to one
    public function getAddressRelation(){
        return $this->hasOne(AddressRelationship::class,'user_id','id');
    }
    // One to Many
    public function getPostRelation(){
        return $this->hasMany(PostRelationship::class,'user_id','id');
    }
    // Many to many
    public function getRolesRelation(){
        return $this->belongsToMany(RoleRelationship::class,'user_role','user_id','role_id');
    }

    public function getAllUsers(){
        $users = DB::select('SELECT * FROM users ORDER BY created_at DESC');
        return $users;
    }

    public function addUser($data){
        // DB::insert('INSERT INTO users (name,email,created_at) values(?,?,?)',$data);
        return DB::table($this->table)->insert($data);
    }

    public function getAll(){
        $users = DB::table(($this->table))
        ->orderBy('name','ASC')->get();
        return $users;
    }

    public function updateUser($data,$id){
        return User::findOrFail($id)->update($data);
    }

    public function getDetail($id){
        return User::findOrFail($id);
    }
}
