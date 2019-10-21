var REFRESH_TIME = 3000;
var url = siteUrl;

refresh();
$('#MessageAddForm').submit(function() {
    if ($('input[name="receiver_id"]').val() == "") {
        alert('Please select recipient.');
        return false;
    }
    if ($('input[name="message"]').val() == "") {
        alert('Please enter message');
        return false;
    }
    $.ajax({
        data: $("#MessageAddForm").serialize(),
        dataType: "json",
        success: function(data, textStatus) {
            //addMessage(data.Message, $("#messages-appended"));
            $("#Messagebox").val(''); //Empty the message text area
            refresh();
        },
        type: "post",
        url: url + "message\/add"
    });
    return false; //Avoids the form submit
});


function refresh() {
    var messages_appended = $("#messages-appended");
    var current_last_message = messages_appended.attr("last-database-message");
    var room_id = $('input[name="receiver_id"]').val();
    var datastring = "userid=" + room_id;
    $.ajax({
        data: datastring,
        success: function(data) {
            $(".message-row").html(data);
        },
        type: "post",
        url: url + "message\/refresh",
    });
    setTimeout(refresh, REFRESH_TIME);
}