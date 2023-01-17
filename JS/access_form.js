// form switching function to login or signup form
function switch_form(form_type) {
  if (form_type === "sign_up") {
    $('.access_form').replaceWith(sign_up);
  } else if (form_type === "login") {
      $('.access_form').replaceWith(login);
  }
  return false;
}

//event listener for click
$( document ).on('click','.linked_text_signup', function(){
  var type = $(".access_form").attr("id");
  switch_form(type)
});

$( document ).on('submit','.access_form', function(event){
    event.preventDefault();

    $.post( $(".access_form").attr("action"),
            $(".access_form :input").serializeArray(),
            function(data) {
              if (data == "success") {
                 window.location = "/user/profile?user=" + $("#username").val();
              } else {
                $(".alert").empty();
                $(".alert").html(data);
              }
            });

});


// sign up form
var sign_up = '<form class="access_form" action="/elements/signup.php" method="POST" id="login">' +
                '<div class="logo">' +
                  '<img src="/img/brand/logo.png" alt="logo" class="brand">' +
                '</div>' +
                '<div class="form">' +
                  '<div class="input_container">' +
                    '<input type="text" placeholder="Full name" name="fullname">' +
                    '<input type="text" placeholder="Email" name="email">' +
                    '<input type="text" placeholder="Username" name="username" id="username">' +
                    '<input type="password" placeholder="Password" name="password">' +
                    '<input type="password" placeholder="Re-enter Password" name="re_password">' +
                    '<button type="submit" name="sign_up" id="submit">Sign Up</button>' +
                    '<div class="alert"></div>' +
                  '</div>' +
                  '<div class="small_container">' +
                      '<h5 class="linked_text_signup">Click here to <a class="linked_text_signup" href="">Login</a></h5>' +
                  '</div>' +
                '</div>' +
              '</form>';

// login form
var login =   '<form class="access_form" action="/elements/login.php" method="POST" id="sign_up">' +
                '<div class="logo">' +
                  '<img src="/img/brand/logo.png" alt="logo" class="brand">' +
                '</div>' +
                '<div class="form">' +
                  '<div class="input_container">' +
                    '<input type="text" placeholder="Username" name="username" id="username">' +
                    '<input type="password" placeholder="Password" name="password">' +
                    '<button type="submit" name="login" id="submit">Login</button>' +
                    '<div class="alert"></div>' +
                    '<h5 class="linked_text_forgot"><a class="linked_text_forgot" href="javascript:">Forgot your password?</a></h5>' +
                  '</div>' +
                  '<div class="small_container">' +
                      '<h5 class="linked_text_signup">Click here to <a class="linked_text_signup" href="">Sign up</a></h5>' +
                  '</div>' +
                '</div>' +
              '</form>';
