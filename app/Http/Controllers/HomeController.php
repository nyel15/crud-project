<?php

namespace App\Http\Controllers;

use App\AllStudents;
use App\LocalStudents;
use App\ForeignStudents;
use App\Http\Requests\StudentRequest;
use Illuminate\Http\Request;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {  
        $students = [];
        $allStudents = AllStudents::get();
        foreach($allStudents as $student){
            $localStudents = '';
            $foreignStudents = '';
            $filter = $request->input('filter', 'all');
            if($request->filter == 'local'){
                $students = LocalStudents::latest()->get();
            }elseif($request->filter  == 'foreign'){
                $students = ForeignStudents::latest()->get();
            }else{
                $localStudents = LocalStudents::latest()->get();
                $foreignStudents = ForeignStudents::latest()->get();
                $students = $localStudents->concat($foreignStudents);
            }
        }
        return view('home', compact('students')); 
    }
    
    public function create(){
        return view('create');
    }
    
    public function store(StudentRequest $request){
        $request->validated();
        
        if($request->student_type == 'local'){
            $localStudent = new LocalStudents();
            $localStudent->student_type = $request->student_type;
            $localStudent->id_number = $request->id_number;
            $localStudent->name = $request->name;
            $localStudent->age = $request->age;
            $localStudent->gender = $request->gender;
            $localStudent->city = $request->city;
            $localStudent->mobile_number = $request->mobile_number;
            $localStudent->grades = $request->grades;
            $localStudent->email = $request->email;
            $localStudent->save();
        } else {
            $foreignStudent = new ForeignStudents();
            $foreignStudent->student_type = $request->student_type;
            $foreignStudent->id_number = $request->id_number;
            $foreignStudent->name = $request->name;
            $foreignStudent->age = $request->age;
            $foreignStudent->gender = $request->gender;
            $foreignStudent->city = $request->city;
            $foreignStudent->mobile_number = $request->mobile_number;
            $foreignStudent->grades = $request->grades;
            $foreignStudent->email = $request->email;
            $foreignStudent->save();
        }
        
        $allStudent = new AllStudents();
        $allStudent->student_type = $request->student_type;
        $allStudent->student_type == 'local' ? $allStudent->local_student_id = $localStudent->id : '';
        $allStudent->student_type == 'foreign' ? $allStudent->foreign_student_id = $foreignStudent->id : '';
        $allStudent->save();
        
        return redirect()->route('home')->with('status', 'create successful');
        }

    public function edit($student_type, $id){
        $student = '';
    
        if($student_type == 'local'){
            $student = LocalStudents::findOrFail($id);
        }else{
            $student = ForeignStudents::findOrFail($id);
        }
        
        return view('update', compact('student'));
    }
    
    public function update($id, $student_type, StudentRequest $request){
        $request->validated();

        if($student_type == 'local'){
            $student = LocalStudents::findOrFail($id);
            if($request->student_type != 'local'){
                $student->delete();
                $foreignStudent = ForeignStudents::create($request->all());
                $allStudent = new AllStudents();
                $allStudent->student_type = $request->student_type;
                $allStudent->student_type == 'foreign' ? $allStudent->foreign_student_id = $foreignStudent->id : '';
                $allStudent->save();
            }else{
                $student->student_type = $request->student_type;
                $student->id_number = $request->id_number;
                $student->name = $request->name;
                $student->age = $request->age;
                $student->gender = $request->gender;
                $student->city = $request->city;
                $student->mobile_number = $request->mobile_number;
                $student->grades = $request->grades;
                $student->email = $request->email;
                $student->update();
            }
        }
        elseif($student_type == 'foreign'){
            $student = ForeignStudents::findOrFail($id);
            if($request->student_type != 'foreign'){
                $student->delete();
                $localStudents = LocalStudents::create($request->all());
                $allStudent = new AllStudents();
                $allStudent->student_type = $request->student_type;
                $allStudent->student_type == 'local' ? $allStudent->local_student_id = $localStudents->id : '';
                $allStudent->save();
            }else{
                $student->student_type = $request->student_type;
                $student->id_number = $request->id_number;
                $student->name = $request->name;
                $student->age = $request->age;
                $student->gender = $request->gender;
                $student->city = $request->city;
                $student->mobile_number = $request->mobile_number;
                $student->grades = $request->grades;
                $student->email = $request->email;
                $student->update();
            }
        }
        
        return redirect()->route('home')->with('status', 'update successful');
    }

    public function delete(Request $request){
        if($request->student_type == 'local'){
            $student = LocalStudents::findOrFail($request->id);
            $student->delete();
        }else{
            $student = ForeignStudents::findOrFail($request->id);
            $student->delete();
        }
        
        return redirect()->route('home')->with('status', 'delete successful');
    }
    
}