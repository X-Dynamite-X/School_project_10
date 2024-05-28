
// Pusher.logToConsole = true;
var pusher = new Pusher('0593f400f770b8b42f63', {
    cluster: 'mt1',
    forceTLS: true

});
var isSending = false;

function sendMessage(conversationId) {
    if (isSending) {
        return;
    }
    var form = $("#chatForm");
    var formData = form.serialize();
    isSending = true;
    $.ajax({
        url: `/message/${conversationId}/broadcast/messages`,
        type: 'POST',
        data: formData,
        headers: {
            'X-Socket-ID': pusher.connection.socket_id
        },
        success: function (response) {
            console.log("Send");
            console.log("Message sent successfully:", response);
            $(".message_spase >").last().after(response);
            $("#message_text").val("");
            $(document).scrollTop($(document).height());
        },
        error: function (response) {
            console.log("Error sending message:", response);
        },
        complete: function () {
            isSending = false;
        },
    });
}
function handleKeyPress(event) {
    if (event.key === "Enter") {
    var conversationId = $(this).data("conversation_id_inbut");
    console.log(conversationId);
        sendMessage(conversationId);
    }
}
$(document).on("click", ".send_btn_input", function () {
    var conversationId = $(this).data("conversation_id_inbut");

    // conversation-id
    console.log(conversationId);
    sendMessage(conversationId);
});
var currentChannel = null;
var currentConversationId = null;
var isSending = false;
function subscribeToChannel(conversationId) {
    if (currentChannel) {
        currentChannel.unbind_all();
        pusher.unsubscribe(`conversation${currentConversationId}`);
    }
    console.log(conversationId);
    currentConversationId = conversationId;
    currentChannel = pusher.subscribe(`conversation${conversationId}`);

    currentChannel.bind('pusher:subscription_succeeded', function() {
        console.log(`Successfully subscribed to channel: conversation${conversationId}`);
    });

    currentChannel.bind('conversation', function(data) {
        console.log("Message received:", data);
        $.ajax({
            url: `/message/${conversationId}/receive/messages`,
            method: 'POST',
            data: {
                _token: csrf_token,
                encodedConversationId: data.encodedConversationId,
            },
            success: function(res) {
                console.log(res);
                $(".message_spase >").last().after(res);

                $(document).scrollTop($(document).height());
            },
            error: function(error) {
                console.log('Error receiving message:', error);
            }
        });
    });

    currentChannel.bind('pusher:subscription_error', function(status) {
        console.error(`Subscription error: ${status}`);
    });
}


