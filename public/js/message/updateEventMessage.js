var previousConversationId = null;


$(document).on("click", ".showConversation", function () {
    var showConversationId = $(this).data("conversation_id");
    if (previousConversationId !== null && previousConversationId !== showConversationId) {
        pusher.unsubscribe('updateMessageConversation_' + previousConversationId);
    }
    previousConversationId = showConversationId;

    var updateMessage = pusher.subscribe("updateMessageConversation_" + showConversationId);
    updateMessage.bind("updateMessageConversation", function (data) {
        console.log(data.message);
        $(`#message_text_${data.message.id}`).text(data.message.message_text);
    });
});


