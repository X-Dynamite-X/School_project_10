var countClick = 0;
var successCount = 0;

$(document).on("click", ".send_btn_input", function () {
    var conversationId = $(this).data("conversation_id_inbut");
    var form = $("#chatForm");
    var formData = form.serialize();
    var messageText = $("#message_text").val().trim();
    var imgAvatarConversation = $("#imgAvatarConversation").data("img_avatar1");
    if (messageText.length > 0) {
        countClick++;
        var messageElement = `
        <div class="flex justify-end mb-4 items-end formatMessage_${countClick}" >
            <div class="bg-green-500 text-white p-3 rounded-tl-lg rounded-bl-lg rounded-tr-lg inline-block relative min-w-40 max-w-sm w-1/5 break-words">
                <div class="relative break-words flex flex-col space-y-2 " id="temp_message_${countClick}">
                    <p class="break-words text-left items-end" id="addId_${countClick}">${messageText}</p>
                </div>
                <div class="absolute bottom-0 right-0 flex items-end space-x-1 pr-5 " id="timeCheack_${countClick}">
                    <span class="text-gray-200 text-xs" id="createdAt_${countClick}"></span>
                        <svg viewBox="0 0 20 20" width="1rem" height="1rem" xmlns="http://www.w3.org/2000/svg" fill="none" id="svgSendMessage_${countClick}">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path fill="#facc15" fill-rule="evenodd"
                                d="M1.793.793a1 1 0 011.414 1.414l-1.5 1.5A1 1 0 01.293 2.293l1.5-1.5zm15 0a1 1 0 011.414 0l1.5 1.5a1 1 0 01-1.414 1.414l-1.5-1.5a1 1 0 010-1.414zM3 10a7 7 0 1114 0 7 7 0 01-14 0zm7-9a9 9 0 100 18 9 9 0 000-18zm1 5a1 1 0 10-2 0v4.032l-2.64 2.2a1 1 0 101.28 1.536l3-2.5A1 1 0 0011 10.5V6z">
                            </path>
                        </g>
                    </svg>

                </div>
            </div>
            <img class="h-8 w-8 rounded-full ml-2" id="imgAvatar1" src="${imgAvatarConversation}" alt="">
        </div>`;

        $(".message_spase >").last().after(messageElement);
        $("#message_text").val("");
        $(document).scrollTop($(document).height());

        $.ajax({
            url: `/message/${conversationId}/broadcast/messages`,
            type: "POST",
            data: formData,
            headers: {
                "X-Socket-ID": pusher.connection.socket_id,
            },
            success: function (response) {
                successCount++;
                var firstConversation = $(".myContacts li").first();
                if (firstConversation.data("conversation_id") !== conversationId) {
                    fetchConversations();
                }
                var message = response.message;

                var newMessageElement = `
                <div class="relative inline-block text-left self-end dropdown-container">
                    <button data-message_id="${message.id}" id="menu-button-${message.id}" type="button" class="inline-flex justify-center w-full text-sm font-medium text-white menu-button" aria-expanded="true" aria-haspopup="true">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M6 10a2 2 0 114 0 2 2 0 01-4 0zm0-4a2 2 0 114 0 2 2 0 01-4 0zm0 8a2 2 0 114 0 2 2 0 01-4 0z" />
                        </svg>
                    </button>
                    <div data-message_id="${message.id}" id="dropdown-menu-${message.id}" class="hidden origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50 dropdown-menu">
                        <ul class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="menu-button">
                            <li class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center edit_button_message" data-message_con_id="con_${message.conversation_id}_sender_${message.sender_user_id}_receiver_${message.receiver_user_id}_message_${message.id}" id="editMessageTextButton_${message.id}" onclick="showEditMessageTextModal('${message.id}')" data-message_id="${message.id}" data-conversation_id="${message.conversation_id} ">
                                <svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-500 mr-2" fill="none">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path fill="#facc15" fill-rule="evenodd" d="M15.198 3.52a1.612 1.612 0 012.223 2.336L6.346 16.421l-2.854.375 1.17-3.272L15.197 3.521zm3.725-1.322a3.612 3.612 0 00-5.102-.128L3.11 12.238a1 1 0 00-.253.388l-1.8 5.037a1 1 0 001.072 1.328l4.8-.63a1 1 0 00.56-.267L18.8 7.304a3.612 3.612 0 00.122-5.106zM12 17a1 1 0 100 2h6a1 1 0 100-2h-6z"></path>
                                    </g>
                                </svg>
                                Edit
                            </li>
                            <li class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center delete-button" data-message_con_id="{{ $messageId }}" onclick="showDeleteMessageModal(${message.id})" data-message_id="${message.id}">
                                <svg class="w-5 h-5 text-red-500 mr-2" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7.10002 5H3C2.44772 5 2 5.44772 2 6C2 6.55228 2.44772 7 3 7H4.06055L4.88474 20.1871C4.98356 21.7682 6.29471 23 7.8789 23H16.1211C17.7053 23 19.0164 21.7682 19.1153 20.1871L19.9395 7H21C21.5523 7 22 6.55228 22 6C22 5.44772 21.5523 5 21 5H19.0073C19.0018 4.99995 18.9963 4.99995 18.9908 5H16.9C16.4367 2.71776 14.419 1 12 1C9.58104 1 7.56329 2.71776 7.10002 5ZM9.17071 5H14.8293C14.4175 3.83481 13.3062 3 12 3C10.6938 3 9.58254 3.83481 9.17071 5ZM17.9355 7H6.06445L6.88085 20.0624C6.91379 20.5894 7.35084 21 7.8789 21H16.1211C16.6492 21 17.0862 20.5894 17.1192 20.0624L17.9355 7ZM14.279 10.0097C14.83 10.0483 15.2454 10.5261 15.2068 11.0771L14.7883 17.0624C14.7498 17.6134 14.2719 18.0288 13.721 17.9903C13.17 17.9517 12.7546 17.4739 12.7932 16.9229L13.2117 10.9376C13.2502 10.3866 13.7281 9.97122 14.279 10.0097ZM9.721 10.0098C10.2719 9.97125 10.7498 10.3866 10.7883 10.9376L11.2069 16.923C11.2454 17.4739 10.83 17.9518 10.2791 17.9903C9.72811 18.0288 9.25026 17.6134 9.21173 17.0625L8.79319 11.0771C8.75467 10.5262 9.17006 10.0483 9.721 10.0098Z" fill="#f81717"></path>
                                    </g>
                                </svg>
                                Delete
                            </li>
                        </ul>
                    </div>
                </div>
                `;
                let svgDoneSend =`<svg width="1rem" height="1rem" viewBox="0 0 24.00 24.00" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC" stroke-width="0.096"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path d="M4 12.6111L8.92308 17.5L20 6.5" stroke="#fff" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"></path>
                        </g>
                    </svg>`;
                var now = new Date(message.created_at);
                var hours = now.getHours().toString().padStart(2, "0");
                var minutes = now.getMinutes().toString().padStart(2, "0");
                var date = `Today :${hours}:${minutes}`;
                var messageId =`con_${message.conversation_id}_sender_${message.sender_user_id}_receiver_${message.receiver_user_id}_message_${message.id}`;
                $(`.formatMessage_${successCount}`).attr('id', messageId);
                $(`#createdAt_${successCount}`).text(date);
                $(`#svgSendMessage_${successCount}`).remove();
                $(`#timeCheack_${successCount}`).append(svgDoneSend);
                $(`#temp_message_${successCount}`).prepend(newMessageElement);
                $(`#addId_${successCount}`).attr('id', `message_text_${message.id}`);


            },
            error: function (response) {
                console.log("Error sending message:", response);
            },
        });
    }
});
