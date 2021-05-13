<?php

namespace App\Http\Controllers;

use App\Http\Resources\ToDoResource;
use App\Models\ToDo;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class ToDoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        $todos = ToDo::paginate(10);

        return ToDoResource::collection($todos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return ToDoResource|null
     */
    public function store(Request $request)
    {
        $todo = $request->isMethod('put') ? ToDo::findOrFail($request->todo_id) : new ToDo();

        $todo->id = $request->input('todo_id');
        $todo->title = $request->input('title');
        $todo->body = $request->input('body');

        if ($todo->save()) {
            return new ToDoResource($todo);
        }

        return null;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return ToDoResource
     */
    public function show($id)
    {
        $todo = ToDo::findOrFail($id);

        return new ToDoResource($todo);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return ToDoResource
     */
    public function destroy($id)
    {
        $todo = ToDo::findOrFail($id);

        if ($todo->delete()) {
            return new ToDoResource($todo);
        }

        return null;
    }
}
