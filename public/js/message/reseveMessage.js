var pusher = new Pusher("0593f400f770b8b42f63", {
    cluster: "mt1",
    forceTLS: true,
    encrypted: true,
});

var channels = {};

function subscribeToAllConversations() {
    $.ajax({
        url: "/getConversations", // Endpoint to get all conversations of the user
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
                    var conversationIdNowChat = $("#chatConversationSbace").data("conversation-id");
                    console.log(res.message.conversation_id);

                    if (res.message.conversation_id == conversationIdNowChat) {
                        console.log(res.date);
                    $.get("/templates/message/reseve.html",
                        function (template) {
                            var reseveMessage = template
                                .replace(/\${senderImage}/g,"../../imageProfile/" + res.sender.image)
                                .replace(/\${messageDate}/g, res.date)
                                .replace(/\${messageText}/g,res.message.message_text);
                            $(".message_spase >").last().after(reseveMessage);
                        }
                    );
                }
                    $(document).scrollTop($(document).height());


                    if (res.message.conversation_id !== conversationIdNowChat) {
                        count++;
                        console.log(count);

                        if (count > 0) {
                            document.getElementById(
                                `notification`
                            ).style.display = "block";
                        }


                        $.get("/templates/notification/NotificationMessage.html",
                            function (template) {
                                var notification = template
                                    .replace(/\${senderImage}/g,"../../imageProfile/" + res.sender.image)
                                    .replace(/\${senderName}/g, res.sender.name)
                                    .replace(/\${messageId}/g, res.message.id)
                                    .replace(/\${conversationId}/g,data.conversation_id)
                                    .replace(/\${messageDate}/g,date)
                                    .replace(/\${senderId}/g, res.sender.id)
                                    .replace(/\${messageText}/g,res.message.message_text);
                                $(".notification").append(notification);
                            }
                        );
                        if (window.location.pathname == "/message") {
                            fetchConversations();
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
    console.log(id);
    document.getElementById(`notification_${id}`).remove();
    count--;
    console.log(count);
    if (count == 0) {
        document.getElementById(`notification`).style.display = "none";
    }
}
