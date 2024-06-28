var channels = {};
var count = 0;
var reseveMessage = 0;
var messageQueue = [];

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
            // console.log(`Subscribed to conversation ${conversationId}`);
        });

        channel.bind("conversation", function (data) {
            $.ajax({
                url: `/message/${conversationId}/receive/messages`,
                method: "POST",
                data: {
                    _token: csrf_token,
                    encodedConversationId: data.encodedConversationId,
                    messageId: data.message.id,

                },
                success: function (res) {
                    reseveMessage++;
                    var conversationIdNowChat = $("#chatConversationSbace").data("conversation-id");
                    messageQueue.push(res);

                    if (messageQueue.length === 1) {
                        processMessageQueue(conversationIdNowChat);
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

function processMessageQueue(conversationIdNowChat) {
    if (messageQueue.length === 0) return;

    let res = messageQueue.shift();
    displayMessage(res, conversationIdNowChat);

    if (messageQueue.length > 0) {
        setTimeout(() => processMessageQueue(conversationIdNowChat), 0); // Next tick
    }
}

function displayMessage(res, conversationIdNowChat) {
    if (res.message.conversation_id == conversationIdNowChat) {
        $.get("/templates/message/reseve.html", function (template) {
            var reseveMessage = template
                .replace(/\${senderImage}/g, "../../imageProfile/" + res.sender.image)
                .replace(/\${messageId}/g, res.message.id)
                .replace(/\${conversationId}/g, res.message.conversation_id)
                .replace(/\${messageDate}/g, res.date)
                .replace(/\${senderId}/g, res.sender.id)
                .replace(/\${senderName}/g, res.sender.name)
                .replace(/\${receiverId}/g, res.message.receiver_user_id)
                .replace(/\${messageText}/g, res.message.message_text);
            $(".message_spase >").last().after(reseveMessage);
        });
    }
    $(document).scrollTop($(document).height());

    if (res.message.conversation_id !== conversationIdNowChat || conversationIdNowChat == undefined) {
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
