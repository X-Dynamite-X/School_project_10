$(document).on("click", ".createConversation", function () {
    var user1_id = $(this).data("user_1");
    var user2_id = $(this).data("user_2");

    $.ajax({
        type: "POST",
        url: `/ConversationController/${user1_id}/${user2_id}`,
        data: {
            _token: csrf_token,
        },
        success: function (data) {
            var conversation = data.conversation;
            var messages = data.messages;
            var user = data.user;
            var authUser = data.authUser;
            console.log(authUser);
            subscribeToChannel(conversation.id);
            $("#search").val("");
            $(".contacts_search").empty();
            $(".myContacts").removeClass("hidden");

            $(".chat").remove();
            $(`createConversation_${user.id}`).remove();

            $.get("/templates/message/chatSbace.html", function(template) {
                var chatMessageConversation = template
                .replace(/\${userId}/g, user.id)
                .replace(/\${userName}/g, user.name)
                .replace(/\${userImage}/g, user.image)
                .replace(/\${authUserImage}/g, authUser.image)

                .replace(/\${userId}/g, user.id)
                .replace(/\${conversationId}/g, conversation.id)
                .replace(/\${csrf_token}/g, csrf_token);
                $(".chatCode").append(chatMessageConversation);
            });
            // $.get("/templates/message/countact.html", function(template) {
            //     var contact = template
            //     .replace(/\${userId}/g, user.id)
            //     .replace(/\${userName}/g, user.name)
            //     .replace(/\${userImage}/g, user.image)
            //     .replace(/\${userEmail}/g, user.email)
            //     .replace(/\${conversationId}/g, conversation.id)
            //     $(".myContacts").append(contact);
            // });





        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        },
    });
});
