      new AnimOnScroll( document.getElementById( 'grid' ), {
        minDuration : 0.4,
        maxDuration : 0.7,
        viewportFactor : 0.2
      });

      function handleResize() {
      var h = $(window).height();
      $('.fullpage').css({'height':h+'px'});
      }
      $(function(){
      handleResize();

      $(window).resize(function(){
      handleResize();
      });
      });



      jQuery(document).ready(function($) {
 
    $(".scroll").click(function(event){   
    event.preventDefault();
    $('html,body').animate({scrollTop:$(this.hash).offset().top}, 800,'swing');
    });
    });

// email handler

function mail_handler() {
    var email_info = {
        name: $('#name').val(),
        email: $('#email').val(),
        message: $('#message').val()
    };

    $.ajax({
        url: 'mail_handler/mail_handler.php',
        type: 'POST',
        dataType: 'JSON',
        data: email_info,
        beforeSend: function () {
            $('#response_show').addClass('progress');
        },
        success: function (response) {
           console.log(response); $('#response_show').removeClass('progress');
            if (response.success) {
                $('#response_show').html(response.message);
                $('#name').val('');
                $('#email').val('');
                $('#message').val('');
            } else {
                $('#response_show').html("<p style='color: red'>" + response.message + "</p>");
            }
        },
        error: function (response) {
           console.log(response); $('#response_show').removeClass('progress');
            console.log("error response");
        }
    });
}

 // animation
$(window).scroll(function() {
    $('h2,h3').each(function(){
    var elementPos = $(this).offset().top;

    var topOfWindow = $(window).scrollTop();
      if (elementPos < topOfWindow+600) {
        $(this).addClass("animated slideInDown");
      }
    });
    
    $('#email_sender').on('click', function(){
        mail_handler();
        alert('hey');
    })


  });