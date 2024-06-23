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
            last_seen_at =data.user.last_seen_at;

            console.log(authUser);
            subscribeToChannel(conversation.id);
            $("#search").val("");
            $(".contacts_search").empty();
            $(".myContacts").removeClass("hidden");
            $(".chat").remove();
            $(`createConversation_${user.id}`).remove();
            $.get("/templates/message/chatSbace.html", function(template) {
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
                    <span class="text-red-500 inlined">
                        Offline
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4 inline">
                            <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14Zm3.844-8.791a.75.75 0 0 0-1.188-.918l-3.7 4.79-1.649-1.833a.75.75 0 1 0-1.114 1.004l2.25 2.5a.75.75 0 0 0 1.15-.043l4.25-5.5Z">
                            </path>
                        </svg>
                    </span>
                    <span class="block ml-5">
                        ${lastSeenText}
                    </span>`;
                var chatMessageConversation = template
                .replace(/\${userId}/g, user.id)
                .replace(/\${userName}/g, user.name)
                .replace(/\${userImage}/g, user.image)
                .replace(/\${authUserImage}/g, authUser.image)
                .replace(/\${userId}/g, user.id)
                .replace(/\${conversationId}/g, conversation.id)
                .replace(/\${isOnlinePlaceholder}/g, isOnlineContent)


                .replace(/\${csrf_token}/g, csrf_token);
                $(".chatCode").append(chatMessageConversation);
            });
            var user_id ,user_name , user_image , user_status , user_email ,isOnlineContent ,id ,last_seen_at ;
            user_id =data.user.id;
            user_name =data.user.name;
            user_image =data.user.image;
            user_status =data.user.status;
            user_email =data.user.email;
            last_seen_at =data.user.last_seen_at;
            id= conversation;


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

                var newContact = template
                    .replace(/\${userId}/g, user_id)
                    .replace(/\${userName}/g, user_name)
                    .replace(/\${userImage}/g, user_image)
                    .replace(/\${userStatus}/g, user_status)
                    .replace(/\${userEmail}/g, user_email)
                    .replace(/\${conversationId}/g, id)
                    .replace("${isOnlinePlaceholder}", isOnlineContent);

                $("#myContacts").append(newContact);

            });
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        },
    });
});
