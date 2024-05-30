function fetchConversations() {
    $.ajax({
        type: "GET",
        url: `/getConversations`,
        data: {
            _token: csrf_token,
        },
        success: function (data) {
            updateConversations(data.conversations);
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        },
    });
}



function updateConversations(conversations) {
    if (!Array.isArray(conversations)) {
        console.error('Conversations is not an array:', conversations);
        return;
    }

    $(".myContacts").empty();

    conversations.forEach(function (conversation) {
        var id = conversation.id;
        var user_id, user_name, user_email, user_image;

        if (conversation.user1_id == userId) {
            user_id = conversation.user2.id;
            user_name = conversation.user2.name;
            user_email = conversation.user2.email;
            user_image = conversation.user2.image;
        } else {
            user_id = conversation.user1.id;
            user_name = conversation.user1.name;
            user_email = conversation.user1.email;
            user_image = conversation.user1.image;
        }

        $.get("/templates/message/countact.html", function (template) {
            var contact = template
                .replace(/\${userId}/g, user_id)
                .replace(/\${userName}/g, user_name)
                .replace(/\${userImage}/g, user_image)
                .replace(/\${userEmail}/g, user_email)
                .replace(/\${conversationId}/g, id);
            $(".myContacts").append(contact);
        });
    });
}
// todo add last message
// todo add statos user in online or ofline
// todo edit change counversion we dont in that
