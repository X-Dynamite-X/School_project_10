
function showEditModal(id) {
    $.ajax({
        url: '/admin/getSubjectData/' + id,
        type: 'GET',
        success: function(subject) {
            $.get("/templates/subject/editSubjectModle.html", function (template) {
                var editSubject = template
                    .replace(/\${subjectName}/g, subject.name)
                    .replace(/\${subjectCode}/g, subject.subject_code)
                    .replace(/\${successMark}/g, subject.success_mark)
                    .replace(/\${fullMark}/g, subject.full_mark)
                    .replace(/\${routSubjectEdit}/g, routSubjectEdit)

                    .replace(/\${csrf_token}/g, csrf_token)
                    .replace(/\${subjectId}/g, subject.id);
                $(`.editModle`).append(editSubject);
            });
            hideAllModals();
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}


function closeModalEditSubject(subjectId) {
    var modal = document.querySelector("#EditSubject" + subjectId);
    modal.classList.add('hidden');
    modal.remove();

}

function hideAllModals() {
    // يجعل كل الـ Modals مخفية
    $('[id^="EditSubject"]').addClass('hidden');
    $('[id^="EditSubject"]').remove();
}
$(document).on('click', '.editSubjectButton', function() {
    var id = $(this).data("id");
    var form = $("#formEditSubject" + id);
    var formData = form.serialize();
    $.ajax({
        type: form.attr("method"),
        url: form.attr("action"),
        data: formData,
        success: function (data) {
            $("#errurMessageInputSubjectEdit"+ data.id).text("");
            $("#errurMessageInputCodeSubjectEdit"+ data.id).text("");
            $("#errurMessageInputSuccessMarkEdit"+ data.id).text("");
            $("#errurMessageInputFullMarkEdit"+ data.id).text("");
            $("#subjectNameId_" + data.id).text(data.subject);
            $("#subjectCodeId_" + data.id).text(data.subject_code);
            $("#subjectSuccessMarkId_" + data.id).text(data.success_mark);
            $("#subjectFullMarkId_" + data.id).text(data.full_mark);
            $('#EditSubject'+data.id).remove();

        },
        error: function (data) {
            var errur = data.responseJSON.message;
            console.log(errur);

            $("#errurMessageInputSubjectEdit"+ id).text("");
            $("#errurMessageInputCodeSubjectEdit"+ id).text("");
            $("#errurMessageInputSuccessMarkEdit"+ id).text("");
            $("#errurMessageInputFullMarkEdit"+ id).text("");

            $("#errurMessageInputSubjectEdit"+ id).text(errur.name);
            $("#errurMessageInputCodeSubjectEdit"+ id).text(errur.subject_code);
            $("#errurMessageInputSuccessMarkEdit"+ id).text(errur.success_mark);
            $("#errurMessageInputFullMarkEdit"+ id).text(errur.full_mark);
        },
    });
});
