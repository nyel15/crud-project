<?php

namespace App\Http\Controllers;

use App\AllStudents;
use App\LocalStudents;
use App\ForeignStudents;
use Illuminate\Support\Facades\Validator;
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
    public function display(Request $request){
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
            return datatables()->of($students)->toJson();
    }

    public function index(){
        return view('home');  
    }
    
    public function create(){
        return view('create');
    }
    
    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'student_type' => 'required',
            'id_number' => 'required|numeric|digits_between:1,5|unique:local_students,id_number,1|unique:foreign_students,id_number,1',
            'name' => 'required',
            'age' => 'required|numeric|digits_between:1,2|regex:/^[^.]+$/',
            'gender' => 'nullable',
            'city' => 'required',
            'mobile_number' => 'required|numeric|regex:/^(09)\\d{9}$/',
            'email' => 'required|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix|email:rfc,dns',
            'grades' => 'nullable|numeric|min:60|max:100'
        ]);
        
        if($validator->fails()){
            return response()->json([
                'status' => 400, 
                'error' => $validator->messages()
            ]);
        }

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
        
        return redirect()->route('home');
        
        }

    public function edit($student_type, $id){
        $student = '';
    
        if($student_type == 'local'){
            $student = LocalStudents::findOrFail($id);
        }else{
            $student = ForeignStudents::findOrFail($id);
        }
        
        return response()->json($student);
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
        
        return response()->json('test');
    }

    public function delete(Request $request){
        if($request->student_type == 'local'){
            $student = LocalStudents::findOrFail($request->id);
            $student->delete();
        }else{
            $student = ForeignStudents::findOrFail($request->id);
            $student->delete();
        }
        
        return response()->json();
    }
    
}