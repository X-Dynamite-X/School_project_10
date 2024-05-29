$(document).on("click", ".showConversation", function() {
    var showConversationId = $(this).data("conversation_id");
    $.ajax({
        type: "GET",
        url: `/message/${showConversationId}`,
        data: {
            _token: csrf_token,
        },
        success: function(data) {
            $(".chat").remove();
            $(".chatCode").append(data);
            console.log(data);
            subscribeToChannel(showConversationId);
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        },
    });
});
