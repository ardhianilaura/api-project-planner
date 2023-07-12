<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PlannerModel;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class PlannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get planners
        $tasks = PlannerModel::all();

        return response()->json([
            'success'   => true,
            'message'   => 'List Todays Planner',
            'data'      => $tasks
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
        //define validation rules
        $validator = Validator::make($request->all(), [
            'task'          => 'required',
            'description'   => 'required',
            'image'         => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/data_planner', $image->hashName());

        //create post
        $tasks = PlannerModel::create([
            'task'          => $request->task,
            'description'   => $request->description,
            'image'         => $image->hashName(),
        ]);
        
        return response()->json([
            'success'   => true,
            'message'   => 'Task Berhasil Ditambahkan!',
            'data'      => $tasks
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
            'success'   => true,
            'message'   => 'Task Berhasil Ditampilkan!',
            'data'      => $tasks
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

        // $tasks->update($request->all());
        //define validation rules
        $validator = Validator::make($request->all(), [
            'task'          => 'required',
            'description'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //check if image is not empty
        if ($request->hasFile('image')) {

            //upload image
            $image = $request->file('image');
            $image->storeAs('public/data_planner', $image->hashName());

            //delete old image
            Storage::delete('public/data_planner'.$tasks->image);

            //update post with new image
            $tasks->update([
                'taks'          => $request->task,
                'description'   => $request->description,
                'image'         => $image->hashName(),
            ]);

        } else {

            //update post without image
            $tasks->update([
                'task'     => $request->task,
                'description'   => $request->description,
            ]);
        }

        return response()->json([
            'success'   => true,
            'message'   => 'Data Post Berhasil Diubah!',
            'data'      => $tasks
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

        //delete image
        Storage::delete('public/data_planner/'.$tasks->image);

        $tasks->delete();

        return response()->json([
            'success'   => true,
            'message'   => 'Task Berhasil Dihapus!',
            'data'      => null
        ]);
    }
}
