$(document).on("click", ".createConversation", function () {
    var user1_id = $(this).data("user_1");
    var user2_id = $(this).data("user_2");
    console.log(user1_id);
    console.log(user2_id);
    $.ajax({
        type: "POST",
        url: `/ConversationController/${user1_id}/${user2_id}`,
        data: {
            _token: csrf_token,
        },
        success: function (data) {
            console.log(data);
            var conversation = data.conversation;
            var messages = data.messages;
            var user = data.user;
            subscribeToChannel(conversation.id);

            $(".chat").remove();
            $.get("/templates/message/chatSbace.html", function(template) {
                var chatMessageConversation = template
                .replace(/\${userId}/g, user.id)
                .replace(/\${userName}/g, user.name)
                .replace(/\${userImage}/g, user.image)
                .replace(/\${userId}/g, user.id)
                .replace(/\${conversationId}/g, conversation.id)
                .replace(/\${csrf_token}/g, csrf_token);
                $(".chatCode").append(chatMessageConversation);
            });
            // $(".chatCode").append(data.view);
            // console.log(data.view);
            // console.log(data.conversation);



        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        },
    });
});
