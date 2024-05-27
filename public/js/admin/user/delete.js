function showDeleteModal(id) {
    $.ajax({
        url: '/admin/getUserData/' + id,
        type: 'GET',
        success: function(response) {
            var user = response[0];
            var roles = response[1];
            $.get("/templates/user/deleteUserModle.html", function (template) {
                var infoUser = template
                    .replace(/\${id}/g, user.id)
                    .replace(/\${name}/g, user.name)
                    .replace(/\${email}/g, user.email)
                    .replace(/\${routUserDelete}/g, routUserDelete)
                    .replace(/\${csrf_token}/g, csrf_token);
                $(`.deleteModle`).append(infoUser);

            });
            hideAllModals();
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}
function closeModalDeleteUser(userId) {
    var modal = document.querySelector("#DeleteUser_" + userId);
    modal.classList.add("hidden");
    modal.remove();
}

function hideAllModals() {
    $('[id^="DeleteUser_"]').addClass('hidden');
    $('[id^="DeleteUser_"]').remove();

}

$(document).on('click', '.buttonDeleteUser', function() {
    var id = $(this).data("id");
    var form = $("#formDeleteUser_" + id);
    var formData = form.serialize();
    $.ajax({
        type: form.attr("method"),
        url: form.attr("action"),
        data: formData,
        success: function (data) {
            $("#errurMessageInputUserNameEdit_"+ data.id).text("");
            $("#userNameId_" + data.id).text(data.name);
            $('[id^="DeleteUser_"]').addClass('hidden');
            $('#trUser_'+id).remove();
            $('[id^="DeleteUser_"]').remove();
        },
        error: function (data) {
            var errur = data.responseJSON.message;
            console.log(errur);

        },
    });
});
