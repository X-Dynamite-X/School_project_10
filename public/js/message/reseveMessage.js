$(".showConversation").click(function () {
    var conversation_id = $(this).attr("data-conversation_id");
    reseveMessageUser(conversation_id);
});
function reseveMessageUser(conversationId) {
    conversationId = conversationId;
    console.log("conversationId: " + conversationId);
    let channel = pusher.subscribe(`conversation${conversationId}`);
    channel.bind("pusher:subscription_succeeded", function () {
        console.log(`Subscribed to conversation ${conversationId}`);
    });
    channel.bind("conversation", function (data) {
        $.ajax({
            url: `/message/${conversationId}/receive/messages`,
            method: "POST",
            data: {
                _token: csrf_token,
                encodedConversationId: data.encodedConversationId,
            },
            success: function (res) {
                console.log(res);
                console.log(res.message.conversation_id);
                if (res.message.conversation_id == conversationId) {
                    console.log("done ");
                    $.get(
                        "/templates/message/reseve.html",
                        function (template) {
                            var reseveMessage = template
                                .replace(
                                    /\${senderImage}/g,
                                    "../../imageProfile/" + res.sender.image
                                )
                                .replace(/\${messageDate}/g, res.date)
                                .replace(
                                    /\${messageText}/g,
                                    res.message.message_text
                                );
                            $(".message_spase >").last().after(reseveMessage);
                        }
                    );
                }
                $(document).scrollTop($(document).height());
            },
            error: function (error) {
                console.log("Error receiving message:", error);
            },
        });
    });
    channel.bind("pusher:subscription_error", function (status) {
        console.error(`Subscription error: ${status}`);
    });
}

