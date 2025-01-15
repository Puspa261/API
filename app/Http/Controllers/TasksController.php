<?php

namespace App\Http\Controllers;

use App\Models\Tasks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $perpage = $request->get('per_page', 10);
            $tasks = Tasks::paginate($perpage);

            return response()->json([
                'succes' => true,
                'message' => 'Data Fetch Successfully',
                'data' => $tasks->items(),
                'pagination' => [
                    'current_page' => $tasks->currentPage(),
                    'per_page' => $tasks->perPage(),
                    'total_page' => $tasks->lastPage(),
                    'total_items' => $tasks->total()
                ]
            ], status: 200);
        } catch (\Exception $e) {
            return response()->json([
                'succes' => false,
                'message' => $e->getMessage(),
                'data' => null
            ], status: 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation Error',
                    'data' => $validator->errors()
                ], status: 403);
            }

            Tasks::create($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Task Created Successfully',
                'data' => null
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data' => null
            ], status: 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $tasks = Tasks::findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => 'Fetch task by id successfully',
                'data' => $tasks
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data' => null
            ], status: 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tasks $tasks)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $tasks = Tasks::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'title' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation Error',
                    'data' => $validator->errors()
                ], status: 403);
            }

            $tasks->update($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Task Updated Successfully',
                'data' => null
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data' => null
            ], status: 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $tasks = Tasks::findOrFail($id);

            $tasks->delete();
            return response()->json([
                'success' => true,
                'message' => 'Task Deleted Successfully',
                'data' => null
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data' => null
            ], status: 500);
        }
    }
}
