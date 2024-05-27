$(document).ready(function() {
    $('#openCreatUser').click(function() {
        $('#CreatUser').removeClass('hidden');
    });

    $('#CreatUser').on('click', function(event) {
        if (event.target === this) {
            $(this).addClass('hidden');
        }
    });
});

function closeModal() {
    var modal = document.querySelector('#CreatUser');
    modal.classList.add('hidden');
}


$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    var form = $("#formUser");
    $("#createUser").click(function () {
        var formData = form.serialize();
        $.ajax({
            type: form.attr("method"),
            url: form.attr("action"),
            data: formData,
            success: function (data) {
                $("#user_table").DataTable().ajax.reload();
                $('meta[name="csrf-token"]').attr(
                    "content",
                    data.newCsrfToken
                );
                $("#password_confirmation").val("");
                $("#formUser").find("input").val("");
                $("#errurMessageInputUser").text("");
                $("#errurMessageInputEmailUser").text("");
                $("#errurMessageInputPassword").text("");
                $("#errurMessageInputPasswordConfirmation").text("");

                $('#CreatUser').addClass('hidden');
            },
            error: function (data) {
                var errors = data.responseJSON.message;

                $("#errurMessageInputUser").text(errors.name || "");
                $("#errurMessageInputEmailUser").text(errors.email || "");
                $("#errurMessageInputPassword").text(errors.password || "");
                $("#errurMessageInputPasswordConfirmation").text(errors.password_confirmation || "");
            },
        });
    });
});
