<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>Create</title>
</head>

<body>
    <div class="container create-container mt-5">
        <a href="{{ route('home') }}" class="btn btn-primary col-2 float-end">Back</a>
        <h3>Create Student Information</h3>
        
        <form action="{{ route('store') }}" method="POST" class="row g-3 mt-3">
            @csrf
            <div class="col-6">
                <label for="inputStudentType" class="form-label">Student type</label>
                <select id="inputStudentType" class="form-select @error('studentType') border-danger @enderror"
                    name="studentType" placeholder="choose...">
                    <option selected></option>
                    <option @if (old('studentType')=='local' ) selected @endif>local</option>
                    <option @if (old('studentType')=='foreign' ) selected @endif>foreign</option>
                </select>
                @error('studentType')
                <p style="color: red;">{{ $errors->first('studentType') }}</p>
                @enderror
            </div>
            <div class="col-6">
                <label for="inputIdNumber" class="form-label">ID number</label>
                <input type="text" class="form-control @error('idNumber') border-danger @enderror" id="inputIdNumber"
                    name="idNumber" value="{{ old('idNumber') }}">
                @error('idNumber')
                <p style="color: red;">{{ $errors->first('idNumber') }}</p>
                @enderror
            </div>
            <div class="col-6">
                <label for="inputName" class="form-label">Name</label>
                <input type="text" class="form-control @error('name') border-danger @enderror" id="inputName"
                    name="name" value="{{ old('name') }}">
                @error('name')
                <p style="color: red;">{{ $errors->first('name') }}</p>
                @enderror
            </div>
            <div class="col-3">
                <label for="inputAge" class="form-label">Age</label>
                <input type="text" class="form-control @error('age') border-danger @enderror" id="inputAge" name="age"
                    value="{{ old('age') }}">
                @error('age')
                <p style="color: red;">{{ $errors->first('age') }}</p>
                @enderror
            </div>
            <div class="col-3">
                <label for="inputGender" class="form-label">Gender</label>
                <select id="inputGender" class="form-select" name="gender" value="{{ old('gender') }}">
                    <option selected></option>
                    <option @if (old('gender')=='male' ) selected @endif>male</option>
                    <option @if (old('gender')=='female' ) selected @endif>female</option>
                </select>
            </div>
            <div class="col-8">
                <label for="inputCity" class="form-label">City</label>
                <input type="text" class="form-control @error('city') border-danger @enderror" id="inputCity"
                    name="city" value="{{ old('city') }}">
                @error('city')
                <p style="color: red;">{{ $errors->first('city') }}</p>
                @enderror
            </div>
            <div class="col-4">
                <label for="inputMobileNumber" class="form-label">Mobile number</label>
                <input type="text" class="form-control @error('mobileNumber') border-danger @enderror"
                    id="inputMobileNumber" name="mobileNumber" value="{{ old('mobileNumber') }}">
                @error('mobileNumber')
                <p style="color: red;">{{ $errors->first('mobileNumber') }}</p>
                @enderror
            </div>
            <div class="col-8">
                <label for="inputEmail" class="form-label">Email</label>
                <input type="text" class="form-control @error('email') border-danger @enderror" id="inputEmail"
                    name="email" value="{{ old('email') }}">
                @error('email')
                <p style="color: red;">{{ $errors->first('email') }}</p>
                @enderror
            </div>
            <div class="col-4">
                <label for="inputGrades" class="form-label">Grades</label>
                <input type="text" class="form-control" id="inputGrades" name="grades" value="{{ old('grades') }}"
                    placeholder="optional">
            </div>
            <div class="col-12 text-center">
                <button type="submit" class="btn btn-success col-3" name="create">Create</button>
            </div>
        </form>
    </div>
</body>

</html>