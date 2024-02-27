{!! Toastr::message() !!}
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script>
    notification();
    Pusher.logToConsole = false;

    var pusher = new Pusher('6d1034ea2dd1ce215057', {
        cluster: 'ap1'
    });

    var channel = pusher.subscribe('my-notification');
    // channel.bind('my-event', function(data) {
    channel.bind('notification', function(data) {
        //   alert(JSON.stringify(data));
        // var data = "Dữ liệu mới";
        // document.getElementById("targetElement").innerHTML = data.post.author;
        console.log('test', data)
        notification();
    });

    function notification() {
        $.ajax({
            url: '{{ route('notification') }}',
            type: 'GET',
            success: function(data) {
                $('#message_body').html(data.html);
            },
            error: function(error) {
                console.log('lỗi', error);
            }
        });
    }
</script>
