
var previousConversationId = null;

$(document).on("click", ".showConversation", function () {
    var showConversationId = $(this).data("conversation_id");

    // إلغاء الاشتراك في القناة السابقة إذا كانت موجودة
    if (previousConversationId !== null && previousConversationId !== showConversationId) {
        pusher.unsubscribe('deleteMessageConversation_' + previousConversationId);
    }

    // تحديث قيمة previousConversationId بالقيمة الجديدة
    previousConversationId = showConversationId;
    var deleteMessage = pusher.subscribe("deleteMessageConversation_" + showConversationId);
    deleteMessage.bind("deleteMessageConversation", function (data) {
        var message = data.message;
        var messageId = `con_${message.conversation_id}_sender_${message.sender_user_id}_receiver_${message.receiver_user_id}_message_${message.id}`;
        console.log(message);
        console.log(messageId);
        $(`#${messageId}`).remove();
    });
});



