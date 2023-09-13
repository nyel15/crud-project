@extends('layouts.app')

@section('content')
<div class="m-auto col-3 text-center">
    <form method="GET" action="{{ route('home') }}" class="filterForm">
        <select class="form-select" name="filter" onchange="document.querySelector('.filterForm').submit();">
            <option disabled selected>filter student type</option>
            <option value="all" {{ request('filter') == 'all' ? 'selected' : '' }}>all students</option>
            <option value="local" {{ request('filter') == 'local' ? 'selected' : '' }}>local student</option>
            <option value="foreign" {{ request('filter') == 'foreign' ? 'selected' : '' }}>foreign student</option>
        </select>
    </form>
</div>
<div class="container students-container">
    <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
        Add Student
    </button>
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fs-5" id="staticBackdropLabel">Create Student</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="alert alert-warning d-none" id="save_errorlist"></ul>
                    <form action="{{ route('store') }}" method="POST" class="row g-3" id="create">
                        @csrf
                        <div class="col-6">
                            <label for="inputStudentType" class="form-label">Student type</label>
                            <select id="inputStudentType"
                                class="form-select @error('student_type') border-danger @enderror" name="student_type">
                                <option disabled selected>Select student type</option>
                                <option {{ old('student_type') == 'local' ? 'selected' : '' }}>local</option>
                                <option {{ old('student_type') == 'foreign' ? 'selected' : '' }}>foreign</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="inputIdNumber" class="form-label">ID number</label>
                            <input type="text" class="form-control @error('id_number') border-danger @enderror"
                                id="inputIdNumber" name="id_number" value="{{ old('id_number') }}">
                        </div>
                        <div class="col-6">
                            <label for="inputName" class="form-label">Name</label>
                            <input type="text" class="form-control @error('name') border-danger @enderror"
                                id="inputName" name="name" value="{{ old('name') }}">
                        </div>
                        <div class="col-2">
                            <label for="inputAge" class="form-label">Age</label>
                            <input type="text" class="form-control @error('age') border-danger @enderror" id="inputAge"
                                name="age" value="{{ old('age') }}">
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
                            <input type="text" class="form-control @error('city') border-danger @enderror"
                                id="inputCity" name="city" value="{{ old('city') }}">
                        </div>
                        <div class="col-6">
                            <label for="inputMobileNumber" class="form-label">Mobile number</label>
                            <input type="text" class="form-control @error('mobileNumber') border-danger @enderror"
                                id="inputMobileNumber" name="mobile_number" value="{{ old('mobile_number') }}">
                        </div>
                        <div class="col-8">
                            <label for="inputEmail" class="form-label">Email</label>
                            <input type="text" class="form-control @error('email') border-danger @enderror"
                                id="inputEmail" name="email" value="{{ old('email') }}">
                        </div>
                        <div class="col-4">
                            <label for="inputGrades" class="form-label">Grades</label>
                            <input type="text" class="form-control @error('grades') border-danger @enderror"
                                id="inputGrades" name="grades" value="{{ old('grades') }}" placeholder="optional">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="create" id="insert">Insert</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row justify-content-center studentsContainer">
        <table class="cell-border" id="student-table">
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
            </tbody>
        </table>
    </div>
</div>
<script>
$(function() {
    new DataTable('#student-table', {
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route("display") }}',
            data: function(data) {
                data.filter = $('.form-select').val();
            }
        },
        method: 'GET',
        columns: [{
                data: 'student_type',
                name: 'student_type'
            },
            {
                data: 'id_number',
                name: 'id_number'
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'age',
                name: 'age'
            },
            {
                data: 'gender',
                name: 'gender'
            },
            {
                data: 'city',
                name: 'city'
            },
            {
                data: 'mobile_number',
                name: 'mobile_number'
            },
            {
                data: 'grades',
                name: 'grades',
                render: function(data, type, row) {
                    if (type === 'display') {
                        return parseFloat(data).toFixed(2);
                    }
                    return data;
                }
            },
            {
                data: 'email',
                name: 'email'
            },
        ]
    });
});
$(function() {
    $('#insert').on('click', function() {
        $('#create').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: '{{ route("store") }}',
                data: $('#create').serialize(),
                headers: {
                    'X-CSRF-TOKEN': 'csrf-token'
                },

                success: function(response) {
                    if (response.status == 400) {
                        $('#save_errorlist').html("");
                        $('#save_errorlist').removeClass("d-none");
                        $.each(response.error, function(key, error_value) {
                            $('#save_errorlist').append('<li>' +
                                error_value + '</li>')
                        });
                    }
                    elseif(response.status == 200) {
                        Swal.fire({
                            title: 'Are you sure?',
                            icon: 'success',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, create it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                Swal.fire(
                                    'insert success!',
                                    'Your record has been saved.',
                                    'success'
                                )
                            }
                        })
                        $('.modal').hide();
                        $('.modal-backdrop').removeClass('show');
                        $('#student-table').DataTable().ajax.reload();
                    }

                }

            });
        });
    });
});
</script>
@endsection