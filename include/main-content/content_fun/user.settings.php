 <?php

 if( isset($udData['email']) ):

 ?>

 <div id="user_settings"> 
  <div class="usertabHeader seogiUI">
    <div class="header_sub_tab">
      <ul class="subTab">
        <li class="sub_tab_user_details active user_details">
          <a href="javascript:void(0)" class="">User Details</a>
        </li>
        <li class="sub_tab_user_details user_config">
          <a href="javascript:void(0)" class="">User Config</a>
        </li>
        <li class="sub_tab_user_details user_email_config">
          <a href="javascript:void(0)" class="">User Email</a>
        </li>
      </ul>
    </div>
    <div class="header_sub_body">
      <div class="us_body">
        <div id="user_detail">
          <ul class="user_detail">
            <li class="user_detail_row">
              <label class="u_detail">First Name</label>
              <div class="lbl_grp">
                <input id="userFirstName" class="" type="text" value="<?php echo $udData['firstname']; ?>" disabled>
              </div>
            </li>
            <li class="user_detail_row">
              <label class="u_detail">Last Name</label>
              <div class="lbl_grp">
                <input id="user_last_name" class="" type="text" value="<?php echo $udData['lastname']; ?>" disabled>
              </div>
            </li>
            <li class="user_detail_row">
              <label class="u_detail">Profile</label>
              <div class="lbl_grp">
                <a href="<?php echo baseUrl . "/user/" . $udData['unique_user_name']; ?>"><?php echo baseUrl . "/user/" . $udData['unique_user_name'] ?></a>
              </div>
            </li>
            <li class="user_detail_row">
              <label class="u_detail">Email Id</label>
              <div class="lbl_grp">
                <input id="user_email" class="" type="text" value="<?php if( !is_numeric(user_email) ) echo $udData['email']; ?>" disabled>
              </div>
            </li>
            <li class="user_detail_row">
              <label class="u_detail"></label>
              <div class="lbl_grp">
                <a class="btn green" onclick="user_settings('user_detail');">Save Changes</a>
              </div>
            </li>
          </ul>
        </div>
        <!-- user config -->
        <?php
        if( isset($udData['show_user'][0]) ) {
          foreach ($udData['show_user'] as $key => $value) {
            if( $value == "unchecked" ) {
              $udData['show_user'][$key] = "unchecked";
            }
          }
        } else {
          $udData['show_user'][0] = "checked";
          $udData['show_user'][1] = "unchecked";
          $udData['show_user'][2] = "unchecked";
          $udData['show_user'][3] = "unchecked";
          $udData['show_user'][4] = "unchecked";
        }
        ?>
        <div id="user_config" class="none">
          <ul class="user_detail">
            <li class="user_detail_row custom_user_row">
              <label class="u_detail">Show My Profile as:</label>
              <div class="lbl_grp">
                <label class="custom_checkbox <?php echo $udData['show_user'][0]; ?>" data-type="spp" data-cat="user" data-value="<?php echo $udData['show_user'][0]; ?>">
                  <span class="toggler"></span>
                  <span class="custom_checkbox_text">Show my profile picture publicily</span>
                </label>
                <label class="custom_checkbox <?php echo $udData['show_user'][1]; ?>" data-type="sfs" data-cat="user" data-value="<?php echo $udData['show_user'][1]; ?>">
                  <span class="toggler"></span>
                  <span class="custom_checkbox_text">Show my favourite song publicily</span>
                </label>
                <label class="custom_checkbox <?php echo $udData['show_user'][2]; ?>" data-type="sep" data-cat="user" data-value="<?php echo $udData['show_user'][2]; ?>">
                  <span class="toggler"></span>
                  <span class="custom_checkbox_text">Show my email publicily</span>
                </label>
                <label class="custom_checkbox <?php echo $udData['show_user'][3]; ?>" data-type="sfa" data-cat="user" data-value="<?php echo $udData['show_user'][3]; ?>">
                  <span class="toggler"></span>
                  <span class="custom_checkbox_text">Show my favourite album publicily</span>
                </label>
                <label class="custom_checkbox <?php echo $udData['show_user'][4]; ?>" data-type="sfp" data-cat="user" data-value="<?php echo $udData['show_user'][4]; ?>">
                  <span class="toggler"></span>
                  <span class="custom_checkbox_text">Show my favourite playlist publicily</span>
                </label>
              </div>
            </li>
            <li class="user_detail_row btn_row">
              <label class="u_detail"></label>
              <div class="lbl_grp">
                <a class="btn green" onclick="user_settings('user_config');">Save Changes</a>
              </div>
            </li>
          </ul>
        </div>
        <!-- user email config -->
        <?php
        if( isset($udData['email_config'][0]) ) {
          foreach ($udData['email_config'] as $key => $value) {
            if( $value == "unchecked" ) {
              $udData['email_config'][$key] = "";
            }
          }
        } else {
          $udData['email_config'][0] = "checked";
          $udData['email_config'][1] = "checked";
          $udData['email_config'][2] = "checked";
          $udData['email_config'][3] = "checked";
        }
        ?>
        <div id="user_email_config" class="none">
          <ul class="user_detail">
            <li class="user_detail_row custom_user_email">
              <label class="u_detail">My email config:</label>
              <div class="lbl_grp">
                <label class="custom_checkbox <?php echo $udData['email_config'][0]; ?>" data-type="swn" data-cat="user" data-value="<?php echo $udData['email_config'][0]; ?>">
                  <span class="toggler"></span>
                  <span class="custom_checkbox_text">Send me weekely newsletter</span>
                </label>
                <label class="custom_checkbox <?php echo $udData['email_config'][1]; ?>" data-type="nwnar" data-cat="user" data-value="<?php echo $udData['email_config'][1]; ?>">
                  <span class="toggler"></span>
                  <span class="custom_checkbox_text">Notify me when new album released</span>
                </label>
                <label class="custom_checkbox <?php echo $udData['email_config'][2]; ?>" data-type="tuln" data-cat="user" data-value="<?php echo $udData['email_config'][2]; ?>">
                  <span class="toggler"></span>
                  <span class="custom_checkbox_text">Notify me when top user list name will be announced</span>
                </label>
                <label class="custom_checkbox <?php echo $udData['email_config'][3]; ?>" data-type="nfn" data-cat="user" data-value="<?php echo $udData['email_config'][3]; ?>">
                  <span class="toggler"></span>
                  <span class="custom_checkbox_text">Notify me when new feature is available on wtsongs.com</span>
                </label>
              </div>
            </li>
            <li class="user_detail_row btn_row">
              <label class="u_detail"></label>
              <div class="lbl_grp">
                <a class="btn green" onclick="user_settings('user_email_config');">Save Changes</a>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>

<?php endif; ?>