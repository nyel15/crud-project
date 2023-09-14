$(document).on("submit", "#createForm", function (e) {
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
                $.each(response.errors, function (key, error_value) {
                    $("#save_errorlist").append("<li>" + error_value + "</li>");
                });
            } else {
                Swal.fire("created successful!", "", "success");
                $("#createForm").find("input").val("");
                $("#createModal").modal("hide");
                $("#student-table").DataTable().ajax.reload();
            }
        },
    });
});
$(document).ready(function () {
    $("#close-create-form").click(function () {
        $("#createForm").find("input").val("");
        $("#save_errorlist").addClass("d-none");
    });
});
