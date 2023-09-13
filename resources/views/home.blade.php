@extends('layouts.app')

@section('content')
@if(session('status'))
<div class="container float-end" style="width: 20rem;">
    <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
        <symbol id="check-circle-fill" viewBox="0 0 16 16">
            <path
                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
        </symbol>
    </svg>
    <div class="alert myAlert alert-success d-flex align-items-center alert-dismissible" role="alert">
        <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Success:">
            <use xlink:href="#check-circle-fill" />
        </svg>
        <div>
            {{ session('status') }}
        </div>
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    </div>
</div>
@endif
<div class="m-auto col-3 text-center">
    <h5 for="filterStudents" class="form-label">Filter Students</h5>
    <form method="GET" action="{{ route('home') }}" class="filterForm">
        @csrf
        <select class="form-select" name="filter" onchange="document.querySelector('.filterForm').submit();">
            <option value="all" {{ request('filter') == 'all' ? 'selected' : '' }}>all students</option>
            <option value="local" {{ request('filter') == 'local' ? 'selected' : '' }}>local student</option>
            <option value="foreign" {{ request('filter') == 'foreign' ? 'selected' : '' }}>foreign student</option>
        </select>
    </form>
</div>
<div class="container students-container">
    <h1>STUDENTS LISTasd</h1>
    <a href="{{ route('create') }}" class="btn btn-success mb-3">Add Student</a>
    <div class="row justify-content-center studentsContainer">
        <table class="table table-light">
            <thead>
                <tr>
                    <th scope="col">STUDENT TYPE</th>
                    <th scope="col">ID NUMBER</th>
                    <th scope="col">NAME</th>
                    <th scope="col">AGE</th>
                    <th scope="col">GENDER</th>
                    <th scope="col">CITY</th>
                    <th scope="col">MOBILE NUMBER</th>
                    <th scope="col">GRADES</th>
                    <th scope="col">EMAIL</th>
                    <th scope="col">ACTIONS</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <!-- all students -->
                @foreach($students as $student)
                <tr>
                    <td>{{ $student->student_type }}</td>
                    <td>{{ $student->id_number }}</td>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->age }}</td>
                    <td>{{ $student->gender }}</td>
                    <td>{{ $student->city }}</td>
                    <td>{{ $student->mobile_number }}</td>
                    <td>{{ number_format($student->grades, 2) }}</td>
                    <td>{{ $student->email }}</td>
                    <td>
                        <a href="/edit/{{ $student->student_type }}/{{ $student->id }}"
                            class="btn btn-primary col-12">Edit</a>
                    </td>
                    <td>
                        <form action="{{ route('delete') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" value="{{ $student->id }}" name="id">
                            <input type="hidden" value="{{ $student->student_type }}" name="student_type">
                            <button type="submit" class="btn btn-danger col-12"
                                onclick="return confirm('Do you want to delete?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script>
setTimeout(() => {
    $('.myAlert').alert('close');
}, 2000);
</script>
@endsection