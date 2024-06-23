

$(document).on("click", ".showConversation", function () {
    var showConversationId = $(this).data("conversation_id");
    $.ajax({
        type: "GET",
        url: `/message/${showConversationId}`,
        data: {
            _token: csrf_token,
        },
        success: function (data) {
            $(".chat").remove();
            $(".chatCode").append(data);
            subscribeToChannel(showConversationId);
            setTimeout(chatContainerScrollHeight, 100);
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        },
    });
});
$(document).on("click", ".goToConversation", function () {
    var showConversationId = $(this).data("conversation_id");
    var message_id = $(this).data("message_id");
    var chatConversationSbace = $("#chatConversationSbace").data("conversation-id");

    $.ajax({
        type: "GET",
        url: `/message/${showConversationId}`,
        data: {
            _token: csrf_token,
        },
        success: function (data) {
            if(chatConversationSbace !== showConversationId){
                $(".chat").remove();
                $(".chatCode").append(data);
                setTimeout(function() {
                    var messageElement = document.getElementById(message_id);
                    if (messageElement) {
                        messageElement.scrollIntoView({ behavior: 'smooth' });
                    }
                }, 100); // يمكنك تعديل الوقت إذا لزم الأمر
            } else {
                var messageElement = document.getElementById(message_id);
                if (messageElement) {
                    messageElement.scrollIntoView({ behavior: 'smooth' });
                }
            }
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        },
    });
});

function chatContainerScrollHeight() {
    var chatContainer = document.querySelector(".message_spase");
    if (chatContainer) {
        chatContainer.scrollTop = chatContainer.scrollHeight;
    }
}
