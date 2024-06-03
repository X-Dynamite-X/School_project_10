$(document).on("click", ".send_btn_input", function () {
    var conversationId = $(this).data("conversation_id_inbut");
    var form = $("#chatForm");
    var formData = form.serialize();
    var messageText = $("#message_text").val();
    var imgAvatarConversation = $("#imgAvatarConversation").data("img_avatar1");
    const now = new Date();
    const hours = now.getHours().toString().padStart(2, '0');
    const minutes = now.getMinutes().toString().padStart(2, '0');
    const date = `Today :${hours}:${minutes}`;
        var messageElement = `<div class="flex justify-end mb-4 items-end">
        <div class="bg-green-500 text-white p-3 rounded-tl-lg rounded-bl-lg rounded-tr-lg inline-block relative min-w-40  max-w-sm w-1/5">
            <p class="break-words text-left items-end">${messageText}</p>
            <div class="absolute bottom-0 right-0 flex items-end space-x-1">
                <span class="text-gray-200 text-xs">
                    ${date}
                </span>
                <svg width="1rem" height="1rem" viewBox="0 0 24.00 24.00" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC" stroke-width="0.096"></g>
                    <g id="SVGRepo_iconCarrier">
                        <path d="M4 12.6111L8.92308 17.5L20 6.5" stroke="#fff" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"></path>
                    </g>
                </svg>
            </div>
        </div>
        <img class="h-8 w-8 rounded-full ml-2" id="imgAvatar1" src="${imgAvatarConversation}" alt="">
    </div>`;
    $(".message_spase >").last().after(messageElement);
    $("#message_text").val("");
    $(document).scrollTop($(document).height());
    // أرسل الرسالة إلى الخادم
    $(document).scrollTop($(document).height());
    $.ajax({
        url: `/message/${conversationId}/broadcast/messages`,
        type: "POST",
        data: formData,
        headers: {
            "X-Socket-ID": pusher.connection.socket_id,
        },
        success: function (response) {
            var firstConversation = $(".myContacts li").first();
            if (firstConversation.data("conversation_id") !== conversationId) {
                fetchConversations();

            }
        },
        error: function (response) {
            console.log("Error sending message:", response);
        },
    });
});









