<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::select( ['id', 'title', 'price'] )
            ->orderBy('id', 'desc')
            ->paginate(15);
        return view('courses.index', [
            'title' => 'Acá van los cursos etc',
            'courses' => $courses
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('courses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        //Validar la información.
        $request->validate([
            'title' => ['required', 'max:100'],
            'description' => ['required'],
            'price' => ['numeric', 'max:1000000']
        ]);
        
        //Creamos curso nuevo
        $course = Course::create([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price
        ]);

        return redirect()
            ->route('courses.index')
            ->with('status', 'El curso se creó correctamente.');

    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        //
    }
}
