// This is called with the results from from FB.getLoginStatus().
function statusChangeCallback(response) {

  if (response.status === 'connected') {
      // Logged into your app and Facebook.
      // we need to hide FB login button
      $('#fblogin').hide();
      //fetch data from facebook
      getUserInfo();
  } else if (response.status === 'not_authorized') {
      // The person is logged into Facebook, but not your app.
      $('#status').html('Please log into this app.');
  } else {
      // The person is not logged into Facebook, so we're not sure if
      // they are logged into this app or not.
      $('#status').html('Please log into facebook');
  }
}

// This function is called when someone finishes with the Login
// Button.  See the onlogin handler attached to it in the sample
// code below.
function checkLoginState() {
  FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
  });
}

  window.fbAsyncInit = function() {
    FB.init({
      appId      : '515979721894250',
      cookie     : false,  // enable cookies to allow the server to access 
                          // the session
      xfbml      : true,  // parse social plugins on this page
      version    : 'v2.3' // use version 2.3
    });

  };

    // Now that we've initialized the JavaScript SDK, we call 
  // FB.getLoginStatus().  This function gets the state of the
  // person visiting this page and can return one of three states to
  // the callback you provide.  They can be:
  //
  // 1. Logged into your app ('connected')
  // 2. Logged into Facebook, but not your app ('not_authorized')
  // 3. Not logged into Facebook and can't tell if they are logged into
  //    your app or not.
  //
  // These three cases are handled in the callback function.

  // Load the SDK asynchronously
  //do the job for fb comments integration
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));


function getUserInfo() {
    FB.api('/me', function(response) {

      $.ajax({
            type: "POST",
            dataType: 'json',
            data: response,
            url: '/fb_login',
            success: function(msg) {
             if(msg.error== 1) {
              alert('Something Went Wrong!');
             } else {
              window.open(''+phpCurUrl, '_self');
              /*
              $('#fbstatus').show();
              $('#fblogin').hide();
              $('#fbname').text("Name : "+msg.name);
              $('#fbemail').text("Email : "+msg.email);
              $('#fbfname').text("First Name : "+msg.first_name);
              $('#fblname').text("Last Name : "+msg.last_name);
              $('#fbid').text("Facebook ID : "+msg.id);
              $('#fbimg').html("<img src='http://graph.facebook.com/"+msg.id+"/picture'>");
              */
             }
            }
      });

    });
}

  function FBLogout()
  {
    FB.logout(function(response) {
         $('#fblogin').show();
          $('#fbstatus').hide();

    });
  }

function FBLogin()
{

      FB.login(function(response) {
        if (response.authResponse){
          getUserInfo(); //Get User Information.
        } else {
          alert('Authorization failed.');
        }
      },
      {scope: 'public_profile,email'}
    );

}

//FB LIKE BUTTON
(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5&appId=515979721894250";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));