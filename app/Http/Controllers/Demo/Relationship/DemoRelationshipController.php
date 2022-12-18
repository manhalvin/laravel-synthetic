<?php

namespace App\Http\Controllers\Demo\Relationship;

use App\Http\Controllers\Controller;
use App\Models\Demo\Relationship\AddressRelationship;
use App\Models\Demo\Relationship\PostRelationship;
use App\Models\Demo\Relationship\UserRelationship;
use Illuminate\Http\Request;

class DemoRelationshipController extends Controller
{
    private $users;

    public function __construct()
    {
        $this->users = new UserRelationship();
    }
    public function index()
    {
        // 1.One to One

        // $users = UserRelationship::with('getAddressRelation')->get();
        // return $users;
        // $addresses =  AddressRelationship::with('getUserRelation')->get();
        // return $addresses;

        // $users = UserRelationship::findOrFail(1)->getAddressRelation;
        // return $users;
        // $addresses =  AddressRelationship::findOrFail(1)->getUserRelation;
        // return $addresses;

        // One to One

        // 2.One To Many
        // $users = UserRelationship::with('getPostRelation')->get();
        // return $users;
        // $posts = PostRelationship::with('getUserRelation')->get();
        // return $posts;

        // $users = PostRelationship::findOrFail(3)->getUserRelation;
        // return $users;
        // $posts = UserRelationship::findOrFail(1)->getPostRelation;
        // return $posts;

        // One To Many

        // 3. Many to many
        // $users = UserRelationship::with('getRolesRelation')->get();
        // return $users;
        // $roles = RoleRelationship::with('getUserRelation')->get();
        // return $roles;

        // Check xem thử với 1 cái quyền có 1 id nào ấy có bao nhiêu user đang sử dụng quyền đó
        // $user = RoleRelationship::find(1)->getUserRelation;
        // return $user;

        // $role = UserRelationship::find(2)->getRolesRelation;
        // return $role;

        // 3. Many to many

        // 4. Muliti Level

        // $users = UserRelationship::with(
        //     'getPostRelation.getCommentsRelation'
        // )->get();
        // return $users;

        // Muliti Level
    }
}
