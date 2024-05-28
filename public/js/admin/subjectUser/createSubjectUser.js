function showCreateSubjectUserModal(subjectId) {
    hideAllModals(); // يخفي جميع الـ Modals أولا
    $.ajax({
        url: '/admin/getSubjectUserData/' + subjectId,
        type: 'GET',
        success: function(data) {
            var usersInSubject = data[0];
            var users = data[1];
            var subject = data[2];
            // تحميل القالب
            $.get("/templates/subjectUser/createSubjectUserModle.html", function(template) {
                // استبدال القيم في القالب
                var createSubjectUser = template
                    .replace(/\${subjectName}/g, subject.name)
                    .replace(/\${csrf_token}/g, csrf_token)
                    .replace(/\${subjectId}/g, subject.id);
                // إضافة القالب إلى الـ DOM
                $(".createSubjectUserModle").html(createSubjectUser);
                // العثور على عنصر select بعد إضافته إلى الـ DOM
                var selectElement = document.getElementById(`userNameSubjectUsers_${subject.id}`);
                if (selectElement) {
                    users.forEach(function(user) {
                        var option = document.createElement("option");
                        option.setAttribute("id", `optionUserNameInSubjectUser_${subject.id}_${user.id}`);
                        option.setAttribute("class", "shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline");
                        option.setAttribute("value", user.id);
                        option.textContent = user.name;
                        selectElement.appendChild(option);
                    });
                } else {
                    console.error("Element with id userNameSubjectUsers_" + subject.id + " not found.");
                }
                // إظهار الـ Modal
            });
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}
function hideAllModals() {
    $(".fixed.z-10").hide();
}
function closeModalCreateSubjectUser(subjectId) {
    $('#CreateSubjectUser_' + subjectId).remove();
}

$(document).on("click", ".createSubjectUser", function () {
    var subjectId = $(this).data("id");
    var subject_name = $(this).data("subject_name");
    var form = $("#formSubjectUser_" + subjectId);
    var formData = form.serialize();
    $.ajax({
        type: form.attr("method"),
        url: form.attr("action"),
        data: formData,
        success: function (data) {
            $("#errurMessageInputSubjectsNameInSubjectUser_" + subjectId).text("");
            $("#errurMessageInputUserNameInSubjectUser_" + subjectId).text("");
            $("#errurMessageInputUserNameInSubjectUsers_" + subjectId).text("");
            users = data.users;
            $('[id^="CreateSubjectUser"]').remove();
            showInfoModal(subjectId)
        },
        error: function (xhr, textStatus, errorThrown) {
            var errur = xhr.responseJSON.message;
            console.log(errur);
            $("#errurMessageInputSubjectsNameInSubjectUser_" + subjectId).text(
                ""
            );
            $("#errurMessageInputUserNameInSubjectUser_" + subjectId).text("");
            $("#errurMessageInputUserNameInSubjectUsers_" + subjectId).text("");

            $("#errurMessageInputSubjectsNameInSubjectUser_" + subjectId).text(
                errur.subjectId
            );
            $("#errurMessageInputUserNameInSubjectUser_" + subjectId).text(
                errur.user_ids
            );

            var response = xhr.responseJSON;
            if (
                response &&
                response.message &&
                response.message.user_ids &&
                response.message.user_ids[0]
            ) {
                var errorMessage = response.message.user_ids[0][0];
                $("#errurMessageInputUserNameInSubjectUsers_" + subjectId).text(
                    errorMessage
                );
            } else {
                $("#errurMessageInputUserNameInSubjectUsers_" + subjectId).text(
                    "this student is already exist!"
                );
            }
        },
    });
});


