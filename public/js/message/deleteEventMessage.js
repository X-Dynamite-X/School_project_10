$(document).on("click", ".showConversation", function () {
    var showConversationId = $(this).data("conversation_id");
    var updateMessage = pusher.subscribe("deleteMessageConversation_" + showConversationId);
    updateMessage.bind("deleteMessageConversation", function (data) {

        var message = data.message;
        var messageId =`con_${message.conversation_id}_sender_${message.sender_user_id}_receiver_${message.receiver_user_id}_message_${message.id}`;
        console.log(message);
        console.log(messageId);

        $(`#${messageId}`).remove()

    });
});
