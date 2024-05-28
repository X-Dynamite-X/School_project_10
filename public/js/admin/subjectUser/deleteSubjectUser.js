function showDeleteSubjectUserModal(subjectId,userId) {
    $.ajax({
        url: '/admin/getSubjectUserData/' + subjectId+'/'+userId,
        type: 'GET',
        success: function(data) {
            var subject = data[0];
            var user = data[1];
            $.get("/templates/subjectUser/deleteSubjectUserModle.html", function(template) {
                var deleteModleSubjectUser = template
                .replace(/\${subjectId}/g, subject.id)
                .replace(/\${userId}/g, user.id)
                .replace(/\${subject_name}/g, subject.name)
                .replace(/\${csrf_token}/g, csrf_token)
                .replace(/\${userName}/g, user.name);
                $(`.deleteModleSubjectUser`).append(deleteModleSubjectUser);
            });
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}
function closeModalDeleteSubjectUser(subjectId,userId) {
    $(`DeleteSubjectUser_${subjectId}_${userId}`).addClass('hidden');
    $(`DeleteSubjectUser_${subjectId}_${userId}`).remove();
    $('[id^="DeleteSubjectUser_"]').remove();

}
function hideAllModals() {
    $('[id^="DeleteSubjectUser_"]').addClass('hidden');
    $('[id^="DeleteSubjectUser_"]').remove();
}
$(document).on("click", ".buttonDeleteSubjectUser", function () {
    var subjectId = $(this).data("subject_id");
    var userId = $(this).data("user_id");
    var userName = $(this).data("user_name");
    var form = $("#formDeleteSubjectUser_" + subjectId + "_" + userId);
    $.ajax({
        type: "Delete",
        url: form.attr("action"),
        data: {
            _token: form.find('input[name="_token"]').val(),
            _method: "DELETE",
        },
        success: function (data) {
            $('[id^="DeleteSubjectUser_"]').addClass("hidden");
            $('[id^="DeleteSubjectUser_"]').remove();
            showInfoModal(subjectId)
        },
        error: function (data) {
            console.log(data);

        },
    });
});
