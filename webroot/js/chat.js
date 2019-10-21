var REFRESH_TIME = 3000;
var url = siteUrl;
$(function() {
      $('.user-role').click(function(){
        $(this).next('.contact-list').slideToggle(); 
      });
  refresh();
  $('.contact-list li').click(function(){
      $('li').removeClass('active'); 
      $(this).addClass('active'); 
      $('input[name="receiver_id"]').val($(this).attr('id'));
      var userid=$(this).attr('id');
      var userrole=$(this).attr('class');
      var datastring= "userid="+userid+"&userrole="+userrole ;
      $.ajax({
        data:datastring, 
        success:
            function (data) {
                $(".message-row").html(data);
                $('.message-row').animate({scrollTop: $('.message-row div.msg_container:last').offset().top});
            }, 
        type:"post", 
        url:url+"admin\/message\/getmessages"
      });
  });
    
  
  $('#MessageAddForm').submit( function() {
      if( $('input[name="receiver_id"]').val()==""){
          alert('Please select recipient.');
          return false;
      }
      if($('input[name="message"]').val()==""){
          alert('Please enter message');
          return false;
      }
  	$.ajax({
  		  data:$("#MessageAddForm").serialize(), 
  		  dataType:"json", 
  		  success:
  			function (data, textStatus) {
            //addMessage(data.Message, $("#messages-appended"));
  				  $("#Messagebox").val(''); //Empty the message text area
            refresh();
  			}, 
  		  type:"post", 
  		  url:url+"admin\/message\/add"}
  	);
	return false; //Avoids the form submit
  });
});

function refresh(){
  var messages_appended = $("#messages-appended");
  var current_last_message = messages_appended.attr("last-database-message");
  var room_id =$('input[name="receiver_id"]').val();
  var datastring= "userid="+room_id;
	$.ajax({
      data: datastring,
  		success:
  			function (data) {
          $(".message-row").html(data);
  			}, 
  		type:"post", 
  		url:url+"admin\/message\/refresh",
	});
  setTimeout(refresh, REFRESH_TIME );
}

function addMessage (message, div){
  var message_div = $("<div>");
  message_div.addClass("chat_message").val("message", message.id);
  message_div.html("<b>" + message.created + " " + message.user + ":</b> " + message.message);
  div.append(message_div);
}

