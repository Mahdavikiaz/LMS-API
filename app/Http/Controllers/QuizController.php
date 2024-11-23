<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quizzes = Quiz::with('course')->get();
        return response()->json($quizzes);
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
        $request->validate([
            'course_id' => 'required|exists:course,id',
            'title' => 'required|string',
            'description' => 'nullable|string',
            'duration' => 'required|integer',
        ]);

        $quiz = Quiz::create($request->all());
        return response()->json(['message' => 'Quiz created successfully', 'quiz' => $quiz], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $quiz = Quiz::with('question')->findOrFail($id);
        return response()->json($quiz);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'string',
            'description' => 'string|nullable',
            'duration' => 'integer',
        ]);

        $quiz = Quiz::findOrFail($id);
        $quiz->update($request->all());
        return response()->json(['message' => 'Quiz updated successfully', 'quiz' => $quiz]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $quiz = Quiz::findOrFail($id);
        $quiz->delete();
        return response()->json(['message' => 'Quiz deleted successfully']);
    }
}
