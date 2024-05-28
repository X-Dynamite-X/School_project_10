
function showDeleteModal(id) {
    $.ajax({
        url: '/admin/getSubjectData/' + id,
        type: 'GET',
        success: function(subject) {
            $.get("/templates/subject/deleteSubjectModle.html", function (template) {
                var deleteSubject = template
                    .replace(/\${subjectName}/g, subject.name)
                    .replace(/\${subjectCode}/g, subject.subject_code)
                    .replace(/\${successMark}/g, subject.success_mark)
                    .replace(/\${fullMark}/g, subject.full_mark)
                    .replace(/\${csrf_token}/g, csrf_token)
                    .replace(/\${subjectId}/g, subject.id);
                $(`.deleteModle`).append(deleteSubject);
            });
            hideAllModals();
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}


function closeModalDeleteSubject(subjectId) {
    var modal = document.querySelector("#DeleteSubject" + subjectId);
    modal.classList.add('hidden');
    modal.remove();

}

function hideAllModals() {
    // يجعل كل الـ Modals مخفية
    $('[id^="DeleteSubject"]').addClass('hidden');
    $('[id^="DeleteSubject"]').remove();
}


$(document).on("click", ".buttonDeleteSubject", function () {
    var id = $(this).data("id");
    var form = $("#formDeleteSubject" + id);
    // if (confirm("Are you sure to delete this subject "+subject+" ?")) {
    $.ajax({
        type: "Delete",
        url: form.attr("action"),
        data: {
            _token: form.find('input[name="_token"]').val(),
            _method: "DELETE",
            id: id,
        },
        success: function (data) {

            $("#trSubject_" + id).remove();
            $('.deleteSubjectUserModle_' + id).remove();
            $('.editSubjectUserModle_'+ id).remove();
            $('#InfoSubject'+ id).remove();
            $('#EditSubject'+ id).remove();
            $('#DeleteSubject'+ id).remove();
            $('#CreateSubjectUser'+ id).remove();




            $("openCreatSubject").addClass("hidden");
        },
        error: function (data) {
            console.log("Error:", data);
        },
    });
    // }
});
