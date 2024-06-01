// Pusher.logToConsole = true;
var pusher = new Pusher("0593f400f770b8b42f63", {
    cluster: "mt1",
    forceTLS: true,
    encrypted: true,
});
var isSending = false;

function sendMessage(conversationId) {
    if (isSending) {
        return;
    }
    var form = $("#chatForm");
    var formData = form.serialize();
    isSending = true;

    // أضف الرسالة إلى الواجهة مباشرة
    var messageText = $("#message_text").val();
    if (messageText.trim() === "") {
        isSending = false;
        return;
    }
    var imgAvatarConversation = $("#imgAvatarConversation").data("img_avatar1");
    var messageElement = `
        <div class="mb-4 text-right">
            <div class="bg-blue-500 text-white p-3  rounded-tl-lg rounded-bl-lg rounded-tr-lg inline-block">
                <p class="inline">${messageText}</p>
                <img class="h-8 w-8 rounded-full inline" id="imgAvatar1" src="${imgAvatarConversation}" alt="">
            </div>
        </div>`;
    $(".message_spase >").last().after(messageElement);
    $("#message_text").val("");
    $(document).scrollTop($(document).height());

    // أرسل الرسالة إلى الخادم
    $(document).scrollTop($(document).height());

    $.ajax({
        url: `/message/${conversationId}/broadcast/messages`,
        type: "POST",
        data: formData,
        headers: {
            "X-Socket-ID": pusher.connection.socket_id,
        },
        success: function (response) {
            var firstConversation = $(".myContacts li").first();
            if (firstConversation.data("conversation_id") !== conversationId) {
                fetchConversations();
            }
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
        sendMessage(conversationId);
    }
}
$(document).on("click", ".send_btn_input", function () {
    var conversationId = $(this).data("conversation_id_inbut");
    // conversation-id

    sendMessage(conversationId);
});


