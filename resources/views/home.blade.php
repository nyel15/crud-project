@extends('layouts.app')

@section('content')
<!-- Delete modal -->
<div class="modal" id="deleteModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Delete Student</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete?</p>
        <input type="hidden" id="deleteId">
        <input type="hidden" id="deleteType">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="deleteStudent">Delete</button>
      </div>
    </div>
  </div>
</div>

<!-- Filter by student type -->
<div class="m-auto col-3 text-center">
    <form class="filterForm">
        <select class="form-select" name="filter" onchange="document.querySelector('.filterForm').submit();">
            <option disabled selected>filter student type</option>
            <option value="all" {{ request('filter') == 'all' ? 'selected' : '' }}>all students</option>
            <option value="local" {{ request('filter') == 'local' ? 'selected' : '' }}>local student</option>
            <option value="foreign" {{ request('filter') == 'foreign' ? 'selected' : '' }}>foreign student</option>
        </select>
    </form>
</div>

<div class="container" style="max-width:100rem;">
    <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#createModal">Add Student</button>
    <button type="button" class="btn btn-danger mb-2" id="deleteSelected">Delete selected students</button>

    <!-- Create form -->
    <div class="modal fade" id="createModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fs-5" id="staticBackdropLabel">Create Student</h2>
                </div>
                <ul class="alert alert-danger d-none" id="save_errorlist"></ul>
                <div class="modal-body">
                    <form class="row g-3" id="createForm">
                        @csrf
                        <div class="col-6">
                            <label for="inputStudentType" class="form-label">Student type</label>
                            <select id="inputStudentType" class="form-select" name="student_type">
                                <option disabled selected>Select student type</option>
                                <option {{ old('student_type') == 'local' ? 'selected' : '' }}>local</option>
                                <option {{ old('student_type') == 'foreign' ? 'selected' : '' }}>foreign</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="inputIdNumber" class="form-label">ID number</label>
                            <input type="text" class="form-control" id="inputIdNumber" name="id_number" value="{{ old('id_number') }}">
                        </div>
                        <div class="col-6">
                            <label for="inputName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="inputName" name="name" value="{{ old('name') }}">
                        </div>
                        <div class="col-2">
                            <label for="inputAge" class="form-label">Age</label>
                            <input type="text" class="form-control" id="inputAge" name="age" value="{{ old('age') }}">
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
                            <input type="text" class="form-control" id="inputCity" name="city" value="{{ old('city') }}">
                        </div>
                        <div class="col-6">
                            <label for="inputMobileNumber" class="form-label">Mobile number</label>
                            <input type="text" class="form-control" id="inputMobileNumber" name="mobile_number" value="{{ old('mobile_number') }}">
                        </div>
                        <div class="col-8">
                            <label for="inputEmail" class="form-label">Email</label>
                            <input type="text" class="form-control" id="inputEmail" name="email" value="{{ old('email') }}">
                        </div>
                        <div class="col-4">
                            <label for="inputGrades" class="form-label">Grades</label>
                            <input type="text" class="form-control" id="inputGrades" name="grades" value="{{ old('grades') }}" placeholder="optional">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="close-create-form">Close</button>
                    <button type="button" class="btn btn-primary" name="submit" id="insert">Insert</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Update form -->
    <div class="modal fade" id="updateModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fs-5" id="staticBackdropLabel">Update Student</h2>
                </div>
                <ul class="alert alert-danger d-none" id="save_errorlist_update"></ul>
                <div class="modal-body">
                    <form class="row g-3" id="updateForm">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="updateIdEdit">
                        <input type="hidden" id="updateTypeEdit">
                        <div class="col-6">
                            <label for="inputStudentType" class="form-label">Student type</label>
                            <select id="inputStudentTypeEdit"
                                class="form-select"  name="student_type">
                                <option disabled selected>Select student type</option>
                                <option>local</option>
                                <option>foreign</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="inputIdNumber" class="form-label">ID number</label>
                            <input type="text" class="form-control" id="inputIdNumberEdit" name="id_number">
                        </div>
                        <div class="col-6">
                            <label for="inputName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="inputNameEdit" name="name">
                        </div>
                        <div class="col-2">
                            <label for="inputAge" class="form-label">Age</label>
                            <input type="text" class="form-control"  id="inputAgeEdit" name="age">
                        </div>
                        <div class="col-4">
                            <label for="inputGender" class="form-label">Gender</label>
                            <select id="inputGenderEdit" class="form-select" name="gender">
                                <option disabled selected>optional</option>
                                <option>male</option>
                                <option>female</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="inputCity" class="form-label">City</label>
                            <input type="text" class="form-control" id="inputCityEdit" name="city">
                        </div>
                        <div class="col-6">
                            <label for="inputMobileNumber" class="form-label">Mobile number</label>
                            <input type="text" class="form-control" id="inputMobileNumberEdit" name="mobile_number">
                        </div>
                        <div class="col-8">
                            <label for="inputEmail" class="form-label">Email</label>
                            <input type="text" class="form-control" id="inputEmailEdit" name="email">
                        </div>
                        <div class="col-4">
                            <label for="inputGrades" class="form-label">Grades</label>
                            <input type="text" class="form-control" id="inputGradesEdit" name="grades" placeholder="optional">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="close-update-form">Close</button>
                    <button type="button" class="btn btn-primary" name="submit" id="updateStudentRecord">Update</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Data table -->
    <div class="row justify-content-center">
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
                    <th scope="col">SELECT ALL</th>
                    <th scope="col"><input type="checkbox" id="selectAll" name="student"></th>
                </tr>
            </thead>
            <tbody></tbody>
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
        columns: [
            {data: 'student_type'},
            {data: 'id_number'},
            {data: 'name'},
            {data: 'age'},
            {data: 'gender'},
            {data: 'city'},
            {data: 'mobile_number'},
            {data: 'grades',
                render: function(data, type) {
                    if (type === 'display') {
                        return parseFloat(data).toFixed(2);
                    }
                    return data;
                }
            },
            {data: 'email'},
            {data: null,
                render: function(data, type, full, meta){
                    return '<div><button id="updateBtn" class="btn btn-primary col-12" value="' + data.student_type + '/' + data.id +'">Update</button></div>';
            }},
            {data: null,
                render: function(data, type, full, meta){
                    return '<div><button id="deleteBtn" class="btn btn-danger col-12 delete-button" data-id="' + data.student_type + '/' + data.id + '">Delete</button></div>';
            }},
            {data: null,
                render: function(data, type, full, meta){
                    return '<input class="form-check-input m-auto checkboxNoLabel selectStudent" value="' + data.id_number + '" type="checkbox"> ';
            }}
        ],
        columnDefs:[{
            targets: [9, 10, 11],
            orderable: false
        }]
    });
});

//Insert Data
$(document).on("click", "#insert", function(e) {
    e.preventDefault();

    let formData = new FormData($("#createForm")[0]);
    $.ajax({
        headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
        type: "POST",
        url: '{{ route("store") }}',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.status == 400) {
                $("#save_errorlist").html("");
                $("#save_errorlist").removeClass("d-none");
                $.each(response.error, function (key, error_value) {
                    $("#save_errorlist").append("<li>" + error_value + "</li>");
                });
            }else{
                Swal.fire(
                    "created successful!", 
                    "", 
                    "success"
                    );
                resetModal();
                $("#createModal").modal("hide");
                $("#student-table").DataTable().ajax.reload();
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX request failed: ' + error);
        }
    });
});

//Resetting Create Modal
function resetModal(){
    $('#inputStudentType option').prop("selected", function(){
        return this.defaultSelected;
    });
    $('#inputGender option').prop("selected", function(){
        return this.defaultSelected;
    });
    $("#createForm").find("input").val("");
    $("#save_errorlist").addClass("d-none");
};

$("#close-create-form").click(function () {
    resetModal();
});

//Resetting Update Modal
$("#close-update-form").click(function () {
    $("#save_errorlist_update").addClass("d-none");
});

//Update Data
$(document).on('click', '#updateBtn', function() {
    let rowId = $(this).val();
    $('#updateModal').modal('show');
    $.ajax({
        headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
        url: 'edit' + '/' + rowId,
        type: 'GET',
        success: function(data){
            $('#updateIdEdit').val(data.id);
            $('#updateTypeEdit').val(data.student_type);

            const formattedGrade = Number(data.grades).toFixed(2);
            $('#inputStudentTypeEdit').val(data.student_type);
            $('#inputIdNumberEdit').val(data.id_number);
            $('#inputNameEdit').val(data.name);
            $('#inputAgeEdit').val(data.age);
            $('#inputGenderEdit').val(data.gender);
            $('#inputCityEdit').val(data.city);
            $('#inputMobileNumberEdit').val(data.mobile_number);
            $('#inputEmailEdit').val(data.email);
            $('#inputGradesEdit').val(formattedGrade);
        },
        error: function(xhr, status, error) {
            console.error('AJAX request failed: ' + error);
        }
    })
});

$(document).on('click', '#updateStudentRecord', function() {
    let id = $('#updateIdEdit').val();
    let type = $('#updateTypeEdit').val();
    Swal.fire({
        title: 'Confirmation',
        text: 'Are you sure you want to update records?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes',
        cancelButtonText: 'No',
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                url: '/update/' + id + '/' + type,
                type: 'PUT',
                data: {
                    student_type: $('#inputStudentTypeEdit').val(), 
                    id_number: $('#inputIdNumberEdit').val(),
                    name: $('#inputNameEdit').val(),
                    age: $('#inputAgeEdit').val(),
                    gender: $('#inputGenderEdit').val(),
                    city: $('#inputCityEdit').val(),
                    mobile_number: $('#inputMobileNumberEdit').val(),
                    email: $('#inputEmailEdit').val(),
                    grades: $('#inputGradesEdit').val()
                },
                success: function(response){
                    if (response.status == 400) {
                        $("#save_errorlist_update").html("");
                        $("#save_errorlist_update").removeClass("d-none");
                        $.each(response.error, function (key, error_value) {
                            $("#save_errorlist_update").append("<li>" + error_value + "</li>");
                        });
                    }else{
                        Swal.fire({
                        icon: 'success',
                        title: 'Student record has been updated',
                        showConfirmButton: false,
                        timer: 1500
                    })
                        $("#save_errorlist_update").addClass("d-none");
                        $('#updateModal').modal('hide');
                        $("#student-table").DataTable().ajax.reload();
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX request failed: ' + error);
                }
            })
        }
    });
});

//Delete Data
$(document).on('click', '#deleteBtn', function() {
    $('#deleteModal').modal('show');
    let rowId = $(this).data('id');
    $.ajax({
        headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
        url: 'edit' + '/' + rowId,
        type: 'GET',
        success: function(response) {
            $('#deleteId').val(response.id);
            $('#deleteType').val(response.student_type);
        },
        error: function(xhr, status, error) {
            console.error('AJAX request failed: ' + error);
        }
    });
});

$(document).on('click', '#deleteStudent', function() {
    $.ajax({
        headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
        url: '{{ route("delete") }}',
        type: 'DELETE',
        data: {student_type: $('#deleteType').val(), id: $('#deleteId').val()},
        success: function(response) {
            Swal.fire(
            'Student Record Deleted!',
            '',
            'success'
            )
            $('#deleteModal').modal('hide');
            $("#student-table").DataTable().ajax.reload();
        },
        error: function(xhr, status, error) {
            console.error('AJAX request failed: ' + error);
        }
    });
});

//Delete Multiple Student Record
$('#selectAll').change(function(){
    $('.selectStudent').prop('checked', $(this).prop('checked'));
});

$('#deleteSelected').click(function(){
    let selectedStudents = $('.selectStudent:checked').map(function(){
        return $(this).val();
    }).get();

    Swal.fire({
        title: 'Confirmation',
        text: 'Are you sure you want to delete selected records?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes',
        cancelButtonText: 'No',
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/delete/' + selectedStudents,
                type: 'DELETE',
                headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                data: selectedStudents,
                success: function(data) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Record deleted successfully',
                        showConfirmButton: false,
                        timer: 1500,
                    });
                    $('#student-table').DataTable().ajax.reload();
                }
            }); 
        }
    });
});

function disableBtn(){
    let button = $('#deleteSelected');
    let checkboxes = $('.selectStudent');
    let selectAllCheckboxes = $('input[type="checkbox"]');
    let isChecked = checkboxes.is(':checked');
    let isCheckedAll = selectAllCheckboxes.is(':checked');

    button.prop('disabled', !isChecked);
    button.prop('disabled', !isCheckedAll);
}

disableBtn();

$('#student-table').on('change', '.selectStudent', disableBtn);
$('input[type="checkbox"]').on('change', disableBtn);

</script>
@endsection