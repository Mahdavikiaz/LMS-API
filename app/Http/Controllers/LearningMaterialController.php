<?php

namespace App\Http\Controllers;

use App\Models\LearningMaterial;
use App\Models\Course;
use Illuminate\Http\Request;

class LearningMaterialController extends Controller
{
    // add materi for course
    public function addMaterial(Request $request, $courseId)
    {
        $course = Course::findOrFail($courseId);

        $material = new LearningMaterial();
        $material->course_id = $course->id;
        $material->title = $request->title;
        $material->content = $request->content;
        $material->file_path = $request->file('file')?->store('materials');
        $material->save();

        return response()->json(['message' => 'Material added successfully', 'data' => $material]);
    }

    // get material by course
    public function getMaterialsByCourse($courseId)
    {
        $materials = LearningMaterial::where('course_id', $courseId)->get();
        return response()->json(['data' => $materials]);
    }
}
