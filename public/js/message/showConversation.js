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
        console.error("Conversations is not an array:", conversations);
        return;
    }

    $(".myContacts").empty();

    conversations.forEach(function (conversation) {
        var id = conversation.id;

        var user_id, user_name, user_email, user_image, is_online, last_seen_at;
        if (conversation.user1_id == userId) {
            user_id = conversation.user2.id;
            user_name = conversation.user2.name;
            user_email = conversation.user2.email;
            user_image = conversation.user2.image;
            is_online = conversation.user2.is_online;
            last_seen_at = conversation.user2.last_seen_at;
        } else {
            user_id = conversation.user1.id;
            user_name = conversation.user1.name;
            user_email = conversation.user1.email;
            user_image = conversation.user1.image;
            is_online = conversation.user1.is_online;
            last_seen_at = conversation.user1.last_seen_at;
        }

        $.get("/templates/message/contact.html", function (template) {
            var contact = template
                .replace(/\${userId}/g, user_id)
                .replace(/\${userName}/g, user_name)
                .replace(/\${userImage}/g, user_image)
                .replace(/\${userEmail}/g, user_email)
                .replace(/\${conversationId}/g, id);

            // معالجة التعبيرات الشرطية
            var isOnlineContent = is_online ? `
            <span class="text-green-500 inline">
                Online
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4 inline">
                    <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14Zm3.844-8.791a.75.75 0 0 0-1.188-.918l-3.7 4.79-1.649-1.833a.75.75 0 1 0-1.114 1.004l2.25 2.5a.75.75 0 0 0 1.15-.043l4.25-5.5Z" clip-rule="evenodd" />
                </svg>
            </span>` : `
            <span class="text-red-500 inline-block flex justify-end">
                Offline
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4 inline">
                    <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14Zm2.78-4.22a.75.75 0 0 1-1.06 0L8 9.06l-1.72 1.72a.75.75 0 1 1-1.06-1.06L6.94 8 5.22 6.28a.75.75 0 0 1 1.06-1.06L8 6.94l1.72-1.72a.75.75 0 1 1 1.06 1.06L9.06 8l1.72 1.72a.75.75 0 0 1 0 1.06Z" clip-rule="evenodd" />
                </svg>
            </span>
            <span class="block">
                ${last_seen_at ? `Last seen ${new Date(last_seen_at).toLocaleString('en-US', { hour12: true, hour: 'numeric', minute: 'numeric', month: 'short', day: 'numeric' })}` : 'No data available'}
            </span>`;


            contact = contact.replace(
                "${isOnlinePlaceholder}",
                isOnlineContent
            );

            $(".myContacts").append(contact);
        });
    });
}

// todo add last message
// todo add statos user in online or ofline
// todo edit change counversion we dont in that
