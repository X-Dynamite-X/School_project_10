function showEditMessageTextModal(id) {
    $.ajax({
        url: '/getMessage/' + id,
        type: 'GET',
        success: function(message) {
            var conversation_id = $(`#editMessageTextButton_${id}`).data('conversation_id');
            $.get("/templates/message/updateMesage.html", function (template) {
                var editMessage = template
                    .replace(/\${messageText}/g, message.message_text)
                    .replace(/\${csrf_token}/g, csrf_token)
                    .replace(/\${conversationId}/g, message.conversation_id)
                    .replace(/\${messageId}/g, message.id);
                $(`.editMessageTextModle`).append(editMessage);
            });
            hideAllModals();
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}
function closeModalEditMessageText(id) {
    var modal = document.querySelector("#EditMessageText_" + id);
    modal.classList.add('hidden');
    modal.remove();

}
function hideAllModals() {
    // يجعل كل الـ Modals مخفية
    $('[id^="EditMessageText_"]').addClass('hidden');
    $('[id^="EditMessageText_"]').remove();
}
$(document).on('click', '.editTextMessageButton', function() {
    var message_id = $(this).data("message_id");
    var conversation_id = $(this).data("conversation_id");
    var form = $("#formEditMessageText_" + message_id);
    var formData = form.serialize();

    $.ajax({
        type: 'PUT',
        url: `/message/${conversation_id}/broadcast/messages/update/${message_id}`,
        data: formData,
        success: function (data) {
            if (data.success) {
                // console.log(data);
                $("#errurMessageEditTextMessage_" + data.id).text("");
                $("#errurMessageEditTextMessage_" + data.id).text(data.message_text);
                $('#EditMessageText_' + data.id).remove();
                hideAllModals();
                $(`#message_text_${message_id}`).text(data.message_text);
            }
        },
        error: function (data) {
            if (data.status === 422) { // تحقق من رمز الحالة للتحقق من صحة البيانات
                var errors = data.responseJSON.errors;
                for (let key in errors) {
                    if (errors.hasOwnProperty(key)) {
                        $("#errurMessageEditTextMessage_" + message_id).text(errors[key]);
                    }
                }
            } else {
                var error = data.responseJSON.error;
                console.log(error);
                $("#errurMessageEditTextMessage_" + message_id).text(error);
            }
        },
    });
});

        // url: form.attr("action"),
