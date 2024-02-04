<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class DataController extends Controller
{
    public function getAuthUser(){
        $user=Auth::user();
        return $user;
            
            
        
    }
    public function getUsers(){ 
        $users=User::all();
        return $users;

    } 
}
