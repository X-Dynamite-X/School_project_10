

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


function chatContainerScrollHeight() {
    var chatContainer = document.querySelector(".message_spase");
    if (chatContainer) {
        chatContainer.scrollTop = chatContainer.scrollHeight;
    }
}
