<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $perpage = $request->get('per_page', 10);
            $users = User::paginate($perpage);

            return response()->json([
                'succes' => true,
                'message' => 'Data Fetch Successfully',
                'data' => $users->items(),
                'pagination' => [
                    'current_page' => $users->currentPage(),
                    'per_page' => $users->perPage(),
                    'total_page' => $users->lastPage(),
                    'total_items' => $users->total()
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
                'username' => 'required',
                'email' => 'required',
                'password' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation Error',
                    'data' => $validator->errors()
                ], status: 403);
            }

            User::create($request->all());
            return response()->json([
                'success' => true,
                'message' => 'User Created Successfully',
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
            $users = User::findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => 'Fetch task by id successfully',
                'data' => $users
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
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $users = User::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'username' => 'required',
                'email' => 'required',
                'password' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation Error',
                    'data' => $validator->errors()
                ], status: 403);
            }

            $users->update($request->all());
            return response()->json([
                'success' => true,
                'message' => 'User Updated Successfully',
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
            $users = User::findOrFail($id);

            $users->delete();
            return response()->json([
                'success' => true,
                'message' => 'User Deleted Successfully',
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
