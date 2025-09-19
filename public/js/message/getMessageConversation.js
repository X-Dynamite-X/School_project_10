var channels = {};
function subscribeToAllConversations() {
    $.ajax({
        url: "/getConversations",
        method: "GET",
        success: function (res) {
            res.conversations.forEach((conversation) => {
                subscribeToChannel(conversation.id);
            });
        },
        error: function (error) {
            console.log("Error fetching conversations:", error);
        },
    });
}
var count = 0;
function subscribeToChannel(conversationId) {
    var fetchConversationsTest = false;
    var ferstconv = 0;
    var lastconv = 0;
    if (!channels[conversationId]) {
        let channel = pusher.subscribe(`conversation${conversationId}`);
        channels[conversationId] = channel;
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
                    var conversationIdNowChat = $("#chatConversationSbace").data("conversation-id");
                    console.log("conversationIdNowChat: "+conversationIdNowChat);
                    if ( res.message.conversation_id !== conversationIdNowChat || ferstconv === 0 && lastconv === 0) {
                        count++;
                        fetchConversationsTest = res.message.conversation_id ;
                        if (count > 0) {
                            document.getElementById(`notification`).style.display = "block";
                        }
                        $.get("/templates/notification/NotificationMessage.html",
                            function (template) {
                                var notification = template
                                    .replace(/\${senderImage}/g,"public/imageProfile/" + res.sender.image)
                                    .replace(/\${senderName}/g, res.sender.name)
                                    .replace(/\${messageId}/g, res.message.id)
                                    .replace(/\${conversationId}/g,data.conversation_id)
                                    .replace(/\${messageDate}/g, res.date)
                                    .replace(/\${senderId}/g, res.sender.id)
                                    .replace(/\${receiverId}/g, res.message.receiver_user_id)
                                    .replace(/\${messageText}/g,res.message.message_text);
                                $(".notification").append(notification);
                            }
                        );
                        ferstconv = res.message.conversation_id;
                        if (window.location.pathname == "/message"  ) {
                            if (ferstconv !== lastconv ) {
                                lastconv = res.message.conversation_id ;
                                fetchConversations();
                            }
                        }
                    }
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
}
subscribeToAllConversations();
function closeNotification(id) {
    document.getElementById(`notification_${id}`).remove();
    count--;
    if (count == 0) {
        document.getElementById(`notification`).style.display = "none";
    }
}



