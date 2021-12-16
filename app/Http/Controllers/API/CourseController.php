<?php

namespace App\Http\Controllers\API;

use App\Models\Course;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Asm89\Stack\Cors;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $courses = Course::all();
        $teachers = DB::table('courses')->orderBy('teacher')->distinct()->pluck('teacher');
        $types = DB::table('courses')->orderBy('type')->distinct()->pluck('type');
        $data = [
            'semesters' => ['110學年第2學期'],
            'teachers' => $teachers,
            'types' => $types
        ];
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $courses = Course::where('semester_id',1);

        if(count($request->teachers) > 0){
            $courses->whereIn('teacher', $request->teachers);
        }

        if(count($request->types) > 0){
            $courses->whereIn('type', $request->types);
        }

        if(count($request->weeks) > 0){
            $courses->whereIn('week', $request->weeks);
        }

        $courses = $courses->get();

        $data = [
            'courses' => $courses
        ];
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        //
    }
}
