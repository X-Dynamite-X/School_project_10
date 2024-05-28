$(document).on("click", ".showConversation", function() {
    var showConversationId = $(this).data("conversation_id");
    console.log(showConversationId);
    $.ajax({
        type: "GET",
        url: `/message/${showConversationId}`,
        data: {
            _token: csrf_token,
        },
        success: function(data) {
            $(".chat").remove();
            $(".chatCode").append(data);
            subscribeToChannel(showConversationId);
            console.log(data);
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        },
    });
});
