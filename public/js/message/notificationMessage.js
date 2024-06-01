// إعداد Pusher
// Pusher.logToConsole = true;

var pusher = new Pusher('0593f400f770b8b42f63', {
    cluster: 'mt1',
    encrypted: true,
});

var channel = pusher.subscribe('private-conversation.' + conversationId);
channel.bind('App\\Events\\MessageSent', function(data) {
    // قم بتحديث المحادثات عند تلقي رسالة جديدة
    fetchConversations();

    // عرض الإشعار للمستخدم
    alert('New message from ' + data.sender.name + ': ' + data.message.message_text);
});
