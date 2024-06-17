$(document).ready(function () {
    $("#openCreatSubject").click(function () {
        $("#CreatSubject").removeClass("hidden");
    });

    $("#CreatSubject").on("click", function (event) {
        if (event.target === this) {
            $(this).addClass("hidden");
        }
    });
});

function closeModalCreateSubject() {
    var modal = document.querySelector("#CreatSubject");
    modal.classList.add("hidden");
}


$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    var form = $("#formSubject");

    $("#createSubject").click(function (e) {
        var formData = form.serialize();

        $.ajax({
            type: form.attr("method"),
            url: form.attr("action"),
            data: formData,
            success: function (response) {
                $("#subject_table").DataTable().ajax.reload();
                $('meta[name="csrf-token"]').attr(
                    "content",
                    response.newCsrfToken
                );
                $("#errurMessageInputSubject").text("");
                $("#errurMessageInputCodeSubject").text("");
                $("#errurMessageInputSuccessMark").text("");
                $("#errurMessageInputFullMark").text("");
                $("#formSubject").find("input").val("");
                $("#CreatSubject").addClass("hidden");
            },
            error: function (data) {
                var errors = data.responseJSON.message;
                $("#errurMessageInputSubject").text("");
                $("#errurMessageInputCodeSubject").text("");
                $("#errurMessageInputSuccessMark").text("");
                $("#errurMessageInputFullMark").text("");

                if (errors.name) {
                    $("#errurMessageInputSubject").text(errors.name);
                }
                if (errors.subject_code) {
                    $("#errurMessageInputCodeSubject").text(
                        errors.subject_code
                    );
                }
                if (errors.success_mark) {
                    $("#errurMessageInputSuccessMark").text(
                        errors.success_mark
                    );
                }
                if (errors.full_mark) {
                    $("#errurMessageInputFullMark").text(errors.full_mark);
                }
            },
        });

    });
});
