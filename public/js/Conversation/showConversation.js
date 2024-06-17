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
        var user_id, user_name, user_email, user_image, user_status, last_seen_at;

        if (conversation.user1_id == userId) {
            user_id = conversation.user2.id;
            user_name = conversation.user2.name;
            user_email = conversation.user2.email;
            user_image = conversation.user2.image;
            user_status = conversation.user2.status;
            last_seen_at = conversation.user2.last_seen_at;
        } else {
            user_id = conversation.user1.id;
            user_name = conversation.user1.name;
            user_email = conversation.user1.email;
            user_image = conversation.user1.image;
            user_status = conversation.user1.status;
            last_seen_at = conversation.user1.last_seen_at;
        }

        $.get("/templates/message/contact.html", function (template) {
            let lastSeenText;
            if (last_seen_at) {
                const lastSeenDate = new Date(last_seen_at);
                if (!isNaN(lastSeenDate.getTime())) {
                    const now = new Date();
                    const diffInMinutes = Math.floor((now - lastSeenDate.getTime()) / 60000);

                    if (diffInMinutes < 1) {
                        lastSeenText = "Last seen Just now";
                    } else if (diffInMinutes < 60) {
                        lastSeenText = `Last seen ${diffInMinutes} m ago`;
                    } else if (diffInMinutes < 1440) {
                        const diffInHours = Math.floor(diffInMinutes / 60);
                        lastSeenText = `Last seen ${diffInHours} h ago`;
                    } else {
                        const diffInDays = Math.floor(diffInMinutes / 1440);
                        lastSeenText = `Last seen ${diffInDays} d ago`;
                    }
                } else {
                    lastSeenText = "I'm not login yeat";
                }
            } else {
                lastSeenText = "I'm not login yeat";
            }

            var isOnlineContent = user_status ? `
                <span class="text-green-500 inline">
                    Online
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4 inline">
                        <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14Zm3.844-8.791a.75.75 0 0 0-1.188-.918l-3.7 4.79-1.649-1.833a.75.75 0 1 0-1.114 1.004l2.25 2.5a.75.75 0 0 0 1.15-.043l4.25-5.5Z" clip-rule="evenodd" />
                    </svg>
                </span>` : `
                <span class="text-red-500 inline-block flex justify-end">
                    Offline
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4 inline">
                        <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14Zm3.844-8.791a.75.75 0 0 0-1.188-.918l-3.7 4.79-1.649-1.833a.75.75 0 1 0-1.114 1.004l2.25 2.5a.75.75 0 0 0 1.15-.043l4.25-5.5Z">
                        </path>
                    </svg>
                </span>
                <span class="block">
                    ${lastSeenText}
                </span>`;

            var contact = template
                .replace(/\${userId}/g, user_id)
                .replace(/\${userName}/g, user_name)
                .replace(/\${userImage}/g, user_image)
                .replace(/\${userStatus}/g, user_status)
                .replace(/\${userEmail}/g, user_email)
                .replace(/\${conversationId}/g, id)
                .replace("${isOnlinePlaceholder}", isOnlineContent);

            $(".myContacts").append(contact);
        });
    });
}


// todo add statos user in online or ofline
// todo edit change counversion we dont in that
