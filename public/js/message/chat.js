
Pusher.logToConsole = true;
var pusher = new Pusher('0593f400f770b8b42f63', {
    cluster: 'mt1',
    forceTLS: true

});

const channelName = `conversation${conversationId}`;

const channel = pusher.subscribe(channelName);
console.log(channel);

var isSending = false;

function sendMessage() {
    if (isSending) {
        return;
    }

    var form = $("#chatForm");
    var formData = form.serialize();
    isSending = true;
    $.ajax({
        url: `/message/1/broadcast/messages`,
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
        sendMessage();
    }
}

$(document).on("click", ".send_btn_input", function () {
    sendMessage();
});



channel.bind('conversation', function(data) {
    console.log("Message received:", data);

    $.ajax({
        url: `/message/1/receive/messages`,
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

// دالة رد النداء لخطأ الاشتراك
channel.bind('pusher:subscription_error', function(status) {
    console.error(`Subscription error: ${status}`);
});
