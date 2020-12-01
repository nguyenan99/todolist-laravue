<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\Todo;
use App\Http\Resources\TodoCollection;
use App\Models\Todos;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TodosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return TodoCollection
     */
    public function index()
    {
        return new TodoCollection(Todos::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->only(['content','checked','completed']);
        Todos::query()->create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy($id)
    {
        $todo = Todos::query()->findOrFail($id);
        $todo->delete();
    }

    public function deleteAll(Request $request)
    {
        $ids = $request->todoIds;
        Todos::query()->whereIn('id',$ids)->delete();
    }


}
