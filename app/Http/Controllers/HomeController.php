<?php

namespace App\Http\Controllers;

use App\AllStudents;
use App\LocalStudents;
use App\ForeignStudents;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
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
    
    public function store(StoreStudentRequest $request){
        $request->validated();
        
        if(request('studentType') === 'local'){
            $localStudent = new LocalStudents();
            $localStudent->student_type = request('studentType');
            $localStudent->id_number = request('idNumber');
            $localStudent->name = request('name');
            $localStudent->age = request('age');
            $localStudent->gender = request('gender');
            $localStudent->city = request('city');
            $localStudent->mobile_number = request('mobileNumber');
            $localStudent->grades = request('grades');
            $localStudent->email = request('email');
            $localStudent->save();
        } else {
            $foreignStudent = new ForeignStudents();
            $foreignStudent->student_type = request('studentType');
            $foreignStudent->id_number = request('idNumber');
            $foreignStudent->name = request('name');
            $foreignStudent->age = request('age');
            $foreignStudent->gender = request('gender');
            $foreignStudent->city = request('city');
            $foreignStudent->mobile_number = request('mobileNumber');
            $foreignStudent->grades = request('grades');
            $foreignStudent->email = request('email');
            $foreignStudent->save();
        }
        
        $allStudent = new AllStudents();
        $allStudent->student_type = request('studentType');
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
    
    public function update($id, UpdateStudentRequest $request){
        $request->validated();

        if(request('studentType') == 'local'){
            $localStudent = LocalStudents::findOrFail($id);
            $localStudent->student_type = request('studentType');
            $localStudent->id_number = request('idNumber');
            $localStudent->name = request('name');
            $localStudent->age = request('age');
            $localStudent->gender = request('gender');
            $localStudent->city = request('city');
            $localStudent->mobile_number = request('mobileNumber');
            $localStudent->grades = request('grades');
            $localStudent->email = request('email');
            $localStudent->save();
        }else{
            $foreignStudent = ForeignStudents::findOrFail($id);
            $foreignStudent->student_type = request('studentType');
            $foreignStudent->id_number = request('idNumber');
            $foreignStudent->name = request('name');
            $foreignStudent->age = request('age');
            $foreignStudent->gender = request('gender');
            $foreignStudent->city = request('city');
            $foreignStudent->mobile_number = request('mobileNumber');
            $foreignStudent->grades = request('grades');
            $foreignStudent->email = request('email');
            $foreignStudent->save();
        }
        
        return redirect()->route('home')->with('status', 'update successful');
    }

    public function delete(Request $request){
        if($request->student_type == 'local'){
            $student = LocalStudents::findOrFail($request->id);
            $student->delete();
        }elseif($request->student_type == 'foreign'){
            $student = ForeignStudents::findOrFail($request->id);
            $student->delete();
        }
        
        return redirect()->route('home')->with('status', 'delete successful');
    }
    
}