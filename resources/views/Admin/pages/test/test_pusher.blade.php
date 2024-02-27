<!DOCTYPE html>
<head>
  <title>Pusher Test</title>
  <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
  <script>

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = false;

    // test thì mở ra

    // var pusher = new Pusher('6d1034ea2dd1ce215057', {
    //   cluster: 'ap1'
    // });

    // var channel = pusher.subscribe('my-notification');
    // channel.bind('notification', function(data) {
    //   alert(JSON.stringify(data));
    // });
  </script>
</head>
<body>
  <h1>Pusher Test</h1>
  <p>
    Try publishing an event to channel <code>my-channel</code>
    with event name <code>my-event</code>.
  </p>
</body>
