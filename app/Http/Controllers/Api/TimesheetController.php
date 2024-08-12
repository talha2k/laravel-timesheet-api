<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Timesheet;
use Log;

class TimesheetController extends Controller
{
    public function index(Request $request)
    {
        $query = Timesheet::query();

        // Apply filters
        if ($request->has('task_name')) {
            $query->where('task_name', 'like', '%' . $request->input('task_name') . '%');
        }
        if ($request->has('date')) {
            $query->whereDate('date', $request->input('date'));
        }
        if ($request->has('user_id')) {
            $query->where('user_id', $request->input('user_id'));
        }
        if ($request->has('project_id')) {
            $query->where('project_id', $request->input('project_id'));
        }

        $timesheets = $query->get();
        return response()->json($timesheets);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'project_id' => 'required|exists:projects,id',
            'task_name' => 'required|string|max:255',
            'date' => 'required|date',
            'hours' => 'required|numeric|min:0|max:24',
        ]);

        $timesheet = Timesheet::create($validatedData);
        return response()->json($timesheet, 201);
    }

    public function show($id)
    {
        $timesheet = Timesheet::findOrFail($id);
        return response()->json($timesheet);
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|exists:timesheets,id',
            'user_id' => 'exists:users,id',
            'project_id' => 'exists:projects,id',
            'task_name' => 'string|max:255',
            'date' => 'date',
            'hours' => 'numeric|min:0|max:24',
        ]);

        $timesheet = Timesheet::findOrFail($validatedData['id']);
        $timesheet->update($validatedData);
        return response()->json($timesheet);
    }

    public function destroy(Request $request)
    {
        $validatedData = $request->validate([
            // 'id' => 'required|exists:timesheets,id',
            'id' => 'required|integer',
        ]);

        try {
            $timesheet = Timesheet::findOrFail($validatedData['id']);
            $timesheet->delete();
            return response()->json(['message' => 'Timesheet deleted successfully'], 200);
        } catch (ModelNotFoundException $e) {
            // This will be caught if the user is not found
            Log::error('ModelNotFoundException: ' . $e->getMessage());
            return response()->json(['error' => 'Timesheet not found'], 404);
        } catch (\Exception $e) {
            // This will catch any other exceptions that might occur
            Log::error('General Exception: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while deleting the timesheet'], 500);
        }
    }

}
