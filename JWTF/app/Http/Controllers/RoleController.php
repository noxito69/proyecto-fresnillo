<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class RoleController extends Controller
{
    public function index(){
        $roles = Role::all();
        return response()->json($roles);
    }
}
