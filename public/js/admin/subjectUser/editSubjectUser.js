function showEditSubjectUserModal(subjectId,userId) {

    $.ajax({
        url: '/admin/getSubjectUserData/' + subjectId+'/'+userId,
        type: 'GET',
        success: function(data) {
            var subject = data[0];
            var user = data[1];
            var mark =  data[2];
            $.get("/templates/subjectUser/editSubjectUserModle.html", function(template) {
                var editModleSubjectUser = template
                .replace(/\${subjectId}/g, subject.id)
                .replace(/\${userId}/g, user.id)
                .replace(/\${subject_name}/g, subject.name)
                .replace(/\${mark}/g, mark)
                .replace(/\${csrf_token}/g, csrf_token)
                .replace(/\${userName}/g, user.name);
                $(`.editModleSubjectUser`).append(editModleSubjectUser);
            });
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}
function closeModalEditSubjectUser(subjectId,userId) {
    $(`#EditSubjectUser_${subjectId}_${userId}`).remove();
}
function hideAllModals() {
    $('[id^="EditSubjectUser_"]').addClass("hidden");
    $('[id^="EditSubjectUser_"]').remove();
}
$(document).on('click', '.editSubjectUserButton', function() {
    var subjectId = $(this).data("subject_id");
    var subjectUserId = $(this).data("user_id");
    var form = $("#formEditSubjectUser_" + subjectId+"_"+subjectUserId);
    var formData = form.serialize();
    $.ajax({
        type: form.attr("method"),
        url: form.attr("action"),
        data: formData,
        success: function (data) {
            $("#errurMessageInputSubjectUserMarkEdit_"+ subjectId+"_"+subjectUserId).text("");
            showInfoModal(subjectId)
        },
        error: function (data) {
            var errur = data.responseJSON.message;
            console.log(errur);
            $("#errurMessageInputSubjectUserMarkEdit_"+ subjectId+"_"+subjectUserId).text("");
            $("#errurMessageInputSubjectUserMarkEdit_"+ subjectId+"_"+subjectUserId).text(errur.mark);
        },
    });
});
