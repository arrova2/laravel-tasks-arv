<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    // GET /api/users
    public function index()
    {
        // Listar todos.
        return response()->json(
            User::select('id','name','email','created_at','updated_at')->get()
        );
    }

    // GET /api/users/{id}/tasks
    public function tasks($id)
    {
        $user = User::findOrFail($id);
        $tasks = $user->tasks()->select('id','title','description','status','user_id','created_at','updated_at')->get();
        return response()->json($tasks);
    }
}
