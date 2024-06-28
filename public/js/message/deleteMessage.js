
function showDeleteMessageModal(id) {
    $.ajax({
        url: '/getMessage/' + id,
        type: 'GET',
        success: function(message) {
            console.log(message);
            $.get("/templates/message/deleteMessage.html", function (template) {
                var deleteMessage = template
                    .replace(/\${csrf_token}/g, csrf_token)
                    .replace(/\${messageText}/g, message.message_text)
                    .replace(/\${conversationId}/g, message.conversation_id)
                    .replace(/\${messageId}/g, message.id);
                $(`.deleteMessageTextModle`).append(deleteMessage);
            });
            hideAllModals();
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}


function closeModalDeleteMessage(messageId) {
    var modal = document.querySelector("#DeleteMessage_" + messageId);
    modal.classList.add('hidden');
    modal.remove();

}

function hideAllModals() {
    $('[id^="DeleteMessage_"]').addClass('hidden');
    $('[id^="DeleteMessage_"]').remove();
}


$(document).on("click", ".buttonDeleteMessage", function () {
    var id = $(this).data("id");
    var form = $("#formDeleteMessage_" + id);
    $.ajax({
        type: "Delete",
        url: form.attr("action"),
        data: {
            _token: form.find('input[name="_token"]').val(),
            _method: "DELETE",
            id: id,
        },
        success: function (message) {
            var message =message.data
            var messageId =`#con_${message.conversation_id}_sender_${message.sender_user_id}_receiver_${message.receiver_user_id}_message_${message.id}`;
            $(`${messageId}`).remove()
            hideAllModals()
            console.log(message);
        },
        error: function (data) {
            console.log("Error:", data);
        },
    });
    // }
});
