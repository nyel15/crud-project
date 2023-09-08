@extends('layouts.app')

@section('content')
@if(session('status'))
<div class="alert alert-success text-center w-25 m-auto" role="alert">
    {{ session('status') }}
</div>
@endif
<div class="my-3 col-2 float-end">
    <label for="filterStudents" class="form-label">Filter Students</label>
    <form method="POST" action="{{ route('filter') }}">
        @csrf
        <select id="filter" class="form-select" name="filter">
            <option value="all">all students</option>
            <option value="local">local student</option>
            <option value="foreign">foreign student</option>
        </select>
        <button type="submit" class="btn btn-primary">apply</button>
    </form>

</div>
<div class="container" style="max-width: 100rem;">
    <h1 class="text-center">STUDENTS LIST</h1>
    <a href="{{ route('create') }}" class="btn btn-success mb-3">Add Student</a>

    <div class="row justify-content-center">

        <table class="table">
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
                        <a href="/update/{{ $student->student_type }}/{{ $student->id }}"
                            class="btn btn-primary col-12">Edit</a>
                        <form action="{{ route('delete') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" value="{{ $student->id }}" name="id">
                            <input type="hidden" value="{{ $student->student_type }}" name="student_type">
                            <button type="submit" class="btn btn-danger col-12 mt-2"
                                onclick="return confirm('Do you want to delete?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
setTimeout(() => {
    $('.alert').alert('close');
}, 2000);
</script>
@endsection