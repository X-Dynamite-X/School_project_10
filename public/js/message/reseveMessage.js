var channels = {};
var receivedMessages = new Set();
var count = 0 ;
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

function subscribeToChannel(conversationId) {
    if (!channels[conversationId]) {
        let channel = pusher.subscribe(`conversation${conversationId}`);
        channels[conversationId] = channel;

        channel.bind("pusher:subscription_succeeded", function () {
            console.log(`Subscribed to conversation ${conversationId}`);
        });

        channel.bind("conversation", function (data) {
            if (!receivedMessages.has(data.message.id)) {
                receivedMessages.add(data.message.id);

                $.ajax({
                    url: `/message/${conversationId}/receive/messages`,
                    method: "POST",
                    data: {
                        _token: csrf_token,
                        messageId: data.message.id,
                    },
                    success: function (res) {
                        handleNewMessage(res, conversationId);
                    },
                    error: function (error) {
                        console.log("Error receiving message:", error);
                    },
                });
            }
        });

        channel.bind("pusher:subscription_error", function (status) {
            console.error(`Subscription error: ${status}`);
        });
    }
}

function handleNewMessage(res, conversationId) {
    var conversationIdNowChat = $("#chatConversationSbace").data("conversation-id");

    if (res.message.conversation_id == conversationIdNowChat) {
        $.get("/templates/message/reseve.html", function (template) {
            var reseveMessage = template
                .replace(/\${senderImage}/g, "../../imageProfile/" + res.sender.image)
                .replace(/\${messageDate}/g, res.date)
                .replace(/\${messageText}/g, res.message.message_text);

            $(".message_spase >").last().after(reseveMessage);
        });
    }
    $(document).scrollTop($(document).height());

    if (res.message.conversation_id !== conversationIdNowChat || conversationIdNowChat == undefined) {
        handleNotification(res);
    }
}

function handleNotification(res) {
    count++;
    if (userInteracted) {
        let notificationSound = document.getElementById("notification_sound");
        notificationSound.play().catch((error) => {
            console.error("Audio play failed:", error);
        });
    }

    if (count > 0) {
        document.getElementById(`notification`).style.display = "block";
    }

    $.get("/templates/notification/NotificationMessage.html", function (template) {
        var notification = template
            .replace(/\${senderImage}/g, "../../imageProfile/" + res.sender.image)
            .replace(/\${senderName}/g, res.sender.name)
            .replace(/\${messageId}/g, res.message.id)
            .replace(/\${conversationId}/g, res.message.conversation_id)
            .replace(/\${messageDate}/g, res.date)
            .replace(/\${senderId}/g, res.sender.id)
            .replace(/\${receiverId}/g, res.message.receiver_user_id)
            .replace(/\${messageText}/g, res.message.message_text);

        $(".notification").append(notification);
    });

    fetchConversations();
}

subscribeToAllConversations();

function closeNotification(id) {
    document.getElementById(`notification_${id}`).remove();
    count--;
    if (count == 0) {
        document.getElementById(`notification`).style.display = "none";
    }
}
