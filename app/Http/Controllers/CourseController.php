<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function AddCourse(){
        return view('ngo.course.add-course');
    }

    public function StoreCourse(Request $request){
        $validate = $request->validate([
            'course' => 'required|string|unique:courses',
        ]);

        $course = Course::create($validate);
        $course->save();

        return redirect()->back()->with('success','Course Added Successfully');
    }

    public function CourseList(){

        $course = Course::orderBy('course', 'asc')->get();
        return view('ngo.course.course-list',compact('course'));

    }

    public function DeleteCourse($id){
        $course = Course::findorFail($id);
        $course->delete();

        return redirect()->back()->with('success','Course Deleted Successfully');
    }
}
