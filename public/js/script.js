var site_url = $("meta[name=siteurl]").attr('content');
if( $(".my-messages .messages").length ){

  /*~~~~~~~~~~~~~* GALLERY EFFECT *~~~~~~~~~~~~~*/
  $(".my-messages .messages-cat").click(function(){
    var fil_ter = $(this).attr("data-filter");
    $(".my-messages .messages .message").not("."+fil_ter).hide(400, 'swing');
    $(".my-messages .messages .message."+fil_ter).show(400, 'swing');
    $(this).addClass("active").siblings().removeClass("active");
  })

  /*~~~~~~~~~~~~~* ENABLE LOVE BUTTON *~~~~~~~~~~~~~*/
  $(".my-messages .messages span.love").click(function(){
    var MsgId = $(this).attr('data-hold');
    var element = $(this);
    $.post(
      site_url + '/Ajax/love',
      {
        'msg_id': MsgId,
        'token': $("input[name=token]").val(),
        'action': 'love'
      },
      function(data, status){
        if(status === 'success'){
          //set loved class for parent
          if(data == 'Success'){
            element.closest(".cat-all").toggleClass('loved');
            element.closest(".cat-all").toggleClass('received');
          }
        }
      }
    );
  });

  /*~~~~~~~~~~~~~* ENABLE DELETE BUTTON *~~~~~~~~~~~~~*/
  $(".my-messages .messages span.delete").click(function(){
    var MsgId = $(this).attr('data-hold');
    var element = $(this);
    $.post(
      site_url + '/Ajax/delete',
      {
        'msg_id': MsgId,
        'token': $("input[name=token]").val(),
        'action': 'delete'
      },
      function(data, status){
        if(status === 'success'){
          element.closest(".cat-all").remove();
          var int = parseInt($("#numOfMsg").html());
          $("#numOfMsg").html(int - 1);
          if(int === 1){
            location.reload();
          }
        }
      }
    );
  });

}
