<div id="loginBoxContainer" class="loginBoxContainer overlay_background none">
<div class="login_form_container">
  <div class="top_part">
    <h1>Login with wtsongs.com</h1>
    <div class="cancel_button" onclick="hideLoginBox()"><img src="/assets/img/cancel.png" title="hide your form"></div>
  </div>
  <div class="form_wrapper">
    <div class="with_fb" id="fblogin">
      <a href="javascript:void(0);" title="login with facebook" onclick="FBLogin();">
        <div class="login_with_fb">
          <div class="login_fb_icon">
            <img src="/assets/img/login_fb_icon.png"></div>
            <h2>Login with Facebook</h2>
          </div>
      </a>
    </div>
    <div class="divider">
      <div class="hr_left"></div>
      <p>OR</p>
      <div class="hr_right"></div>
    </div>
    <form id="login_form" onsubmit="return loginSubmit()">
      <input type="text" id="login_email" placeholder="enter your email id" autocomplete="off">
      <input type="password" id="login_password" placeholder="enter your password" autocomplete="off">
      <!-- <input type="checkbox" name="remember me"><label>Remember me</label><br> -->
      <input type="submit" value="Login">
      <a href="javascript:void(0);" title="fogot your password" onclick="passRec();">Forgot your password?</a>
    </form>
  </div>
  <div class="footer">Don't have an account?<a href="javascript:void(0);" title="create your account" onclick="showSignup();">  Sign Up!</a></div>
</div>
</div>

<div class="signup_form_container none" id="signUp">
  <div class="top_part">
    <h1>sign up for free today!</h1>
    <div class="cancel_button" onclick="hideSignupBox()"><img src="/assets/img/cancel.png"></div>
  </div>
  <div class="signup_form_wrapper">
    <div class="signup_with_fb">
      <a href="javascript:void(0);" title="signup with facebook" onclick="FBLogin();">
        <div class="signup_with_fb">
          <div class="signup_fb_icon">
            <img src="/assets/img/login_fb_icon.png">
          </div>
          <h2>Signup with Facebook</h2>
        </div>
      </a>
    </div>
    <div class="signup_divider">
      <div class="signup_hr_left"></div>
      <p>OR</p>
      <div class="signup_hr_right"></div>
    </div>
    <form id="signup_form" onsubmit="return signupSubmit()">
      <input type="text" placeholder="please enter your email id" id="user_email">
      <input type="text" placeholder="user name" id="user_name">
      
      <input type="password" placeholder="password" id="user_pass">
      <input type="password" placeholder="confirm password" id="user_confirm_pass">
      
      <input type="submit" value="Create account">
    </form>
  </div>
  <div class="signup_footer">Already registered?<a href="javascript:void(0);" title="create your account" onclick="hideSignup()">  Login here!</a></div>
</div>