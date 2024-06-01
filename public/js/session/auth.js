// إعداد Pusher
// Pusher.logToConsole = true;
var pusher = new Pusher('0593f400f770b8b42f63', {
  cluster: 'mt1',
  forceTLS: true,
  encrypted: true,

});

var channel = pusher.subscribe('users');

channel.bind('App\\Events\\UserOnline', function(data) {
    console.log('User online:', data.userId);
});

channel.bind('App\\Events\\UserOffline', function(data) {
    console.log('User offline:', data.userId);
});
