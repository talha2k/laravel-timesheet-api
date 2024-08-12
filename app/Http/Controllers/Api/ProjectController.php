<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Project;
use Log;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::query();

        // Apply filters
        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }
        if ($request->has('department')) {
            $query->where('department', $request->input('department'));
        }
        if ($request->has('status')) {
            $query->where('status', $request->input('status'));
        }

        $projects = $query->get();
        return response()->json($projects);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:active,completed,on_hold',
        ]);

        $project = Project::create($validatedData);
        return response()->json($project, 201);
    }

    public function show($id)
    {
        $project = Project::findOrFail($id);
        return response()->json($project);
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|exists:projects,id',
            'name' => 'string|max:255',
            'department' => 'string|max:255',
            'start_date' => 'date',
            'end_date' => 'date|after:start_date',
            'status' => 'in:active,completed,on_hold',
        ]);

        $project = Project::findOrFail($validatedData['id']);
        $project->update($validatedData);
        return response()->json($project);
    }

    public function destroy(Request $request)
    {
        $validatedData = $request->validate([
            //'id' => 'required|exists:projects,id',
            'id' => 'required|integer',
        ]);

        try {
            $project = Project::findOrFail($validatedData['id']);
            $project->delete();
            return response()->json(['message' => 'Project deleted successfully'], 200);
        } catch (ModelNotFoundException $e) {
            // This will be caught if the user is not found
            Log::error('ModelNotFoundException: ' . $e->getMessage());
            return response()->json(['error' => 'Project not found'], 404);
        } catch (\Exception $e) {
            // This will catch any other exceptions that might occur
            Log::error('General Exception: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while deleting the project'], 500);
        }
    }

}
