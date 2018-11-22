$(document).ready(function() {
  $('#send_comment').click(function(){
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
          }
      });
      var id = $(this).val();
      var comment = $('#blog_comment').val();
      var formData = {
          id: id,
          comment: comment,
      }
      var type = "POST";
      var my_url = '/blog/send_comment';


      $.ajax({
          type: type,
          url: my_url,
          data: formData,                         // Setting the data attribute of ajax with file_data
          beforeSend: function() {
            $( "#respond" ).fadeOut( "slow", function() {
                $( "#sending" ).fadeIn( "slow", function() {
                    $( "#respond" ).hide();
                  });
              });
          },
          success: function (data) {
              $("#blog_comment").val('');
              $( "#sending" ).fadeOut( "slow", function() {
                  $( "#respond" ).fadeIn( "slow", function() {
                      $( "#first_comment" ).remove();
                      $( "#sending" ).hide();
                      $( "#respond" ).show();
                      $(".comment_count").text(data.count);
                      $("#comments_list").prepend(data.comment);
                    });
                });
          },
          error: function (data) {
            $( "#sending" ).fadeOut( "slow", function() {
                $( "#respond" ).fadeIn( "slow", function() {
                    $( "#sending" ).hide();
                    $( "#respond" ).show();
                  });
              });
          }
      });
    
  });

  $('#load_all_comments').click(function(){
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
          }
      });
      var id = $(this).val();
      
      var formData = {
          id: id,
      }
      var type = "POST";
      var my_url = '/blog/load_all_comments';


      $.ajax({
          type: type,
          url: my_url,
          data: formData,                         // Setting the data attribute of ajax with file_data
          beforeSend: function() {
            $( "#sending" ).fadeIn( "slow", function() {
                
              });
          },
          success: function (data) {
            $( "#sending" ).fadeOut( "slow", function() {
                $( "#sending" ).hide();
                $("#comments_list").html(data.comments);
              });
          },
          error: function (data) {
            $(this ).text("Error Cargando Posts");
          }
      });
    
  });
});