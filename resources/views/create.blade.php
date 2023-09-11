<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <title>Create</title>
</head>

<body>
    <div class="container create-container mt-5">
        <a href="{{ route('home') }}" class="btn btn-primary col-2 float-end">Back</a>
        <h3>Create Student Information</h3>
        @if ($errors->any())
        <div class="alert alert-danger mt-3">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <form action="{{ route('store') }}" method="POST" class="row g-3 mt-3">
            @csrf
            <div class="col-6">
                <label for="inputStudentType" class="form-label">Student type</label>
                <select id="inputStudentType" class="form-select @error('student_type') border-danger @enderror"
                    name="student_type">
                    <option disabled selected>Select student type</option>
                    <option {{ old('student_type') == 'local' ? 'selected' : '' }}>local</option>
                    <option {{ old('student_type') == 'foreign' ? 'selected' : '' }}>foreign</option>
                </select>
            </div>
            <div class="col-6">
                <label for="inputIdNumber" class="form-label">ID number</label>
                <input type="text" class="form-control @error('id_number') border-danger @enderror" id="inputIdNumber"
                    name="id_number" value="{{ old('id_number') }}">
            </div>
            <div class="col-6">
                <label for="inputName" class="form-label">Name</label>
                <input type="text" class="form-control @error('name') border-danger @enderror" id="inputName"
                    name="name" value="{{ old('name') }}">
            </div>
            <div class="col-2">
                <label for="inputAge" class="form-label">Age</label>
                <input type="text" class="form-control @error('age') border-danger @enderror" id="inputAge" name="age"
                    value="{{ old('age') }}">
            </div>
            <div class="col-4">
                <label for="inputGender" class="form-label">Gender</label>
                <select id="inputGender" class="form-select" name="gender" value="{{ old('gender') }}">
                    <option disabled selected>optional</option>
                    <option {{ old('gender') == 'male' ? 'selected' : ''}}>male</option>
                    <option {{ old('gender') == 'female' ? 'selected' : ''}}>female</option>
                </select>
            </div>
            <div class="col-6">
                <label for="inputCity" class="form-label">City</label>
                <input type="text" class="form-control @error('city') border-danger @enderror" id="inputCity"
                    name="city" value="{{ old('city') }}">
            </div>
            <div class="col-6">
                <label for="inputMobileNumber" class="form-label">Mobile number</label>
                <input type="text" class="form-control @error('mobileNumber') border-danger @enderror"
                    id="inputMobileNumber" name="mobile_number" value="{{ old('mobile_number') }}">
            </div>
            <div class="col-8">
                <label for="inputEmail" class="form-label">Email</label>
                <input type="text" class="form-control @error('email') border-danger @enderror" id="inputEmail"
                    name="email" value="{{ old('email') }}">
            </div>
            <div class="col-4">
                <label for="inputGrades" class="form-label">Grades</label>
                <input type="text" class="form-control @error('grades') border-danger @enderror" id="inputGrades"
                    name="grades" value="{{ old('grades') }}" placeholder="optional">
            </div>
            <div class="col-12 text-center">
                <button type="submit" class="btn btn-success col-3" name="create">Create</button>
            </div>
        </form>
    </div>
</body>

</html>