<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class TodoController extends Controller
{
    public function showTodos()
    {
        $todos = DB::table('todos')->orderByDesc('id')->get();


        // Check if it's an API request
        if (request()->expectsJson()) {
            return response()->json(['data' => $todos]);
        }

        // If not an API request, return the view
        return view('main', ['data' => $todos]);
    }

    public function addTodo(Request $request)
    {
        // Process the form submission (save to database, etc.)
        $newTodo = $request->input('newTodo');

        $entry = DB::table('todos')->insertGetId([
            'todo' => $newTodo,
            'username' => 'Sajjad Khan'
        ]);

        return response()->json(['success' => 'Todo has been successfully added to the todos!', 'newTodo' => $newTodo, 'todoId' => $entry]);
    }


    public function deleteTodo(string $id)
    {
        $delete = DB::table('todos')
            ->where('id', $id)
            ->delete();
        return response()->json(['deletesuccess' => 'Todo has been successfully removed.']);
    }
}
