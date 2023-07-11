<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\PlannerModel\PlannerModel;
use Illuminate\Http\Request;

class PlannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = PlannerModel::all();

        return response()->json([
            'success' => true,
            'data' => $tasks
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tasks = PlannerModel::create($request->all());

        return response()->json([
            'success' => true,
            'data' => $tasks
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tasks = PlannerModel::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $tasks
        ]);
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
        $tasks = PlannerModel::findOrFail($id);

        $tasks->update($request->all());

        return response()->json([
            'success' => true,
            'data' => $tasks
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tasks = PlannerModel::findOrFail($id);

        $tasks->delete();

        return response()->json([
            'success' => true,
            'message' => 'Task deleted successfully'
        ]);
    }
}
