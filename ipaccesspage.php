<?php 
wp_enqueue_style( 'my-style', plugins_url( '/css/style.css', __FILE__ ), false, '1.0', 'all' ); // Inside a plugin
?>
<div class="wrap">
  <div id="upb-wrap" class="upb-help">
    <h2><img alt="" src="<?php echo plugins_url( '/images/maintenancemode.png', __FILE__ ); ?>" class="padr10">Custom Maintenance Mode</h2>
    <div class="mainwidth">    
    <form method="post" action="options.php" enctype="multipart/form-data" name="cntdownform" id="cntdownform" >
    <div class="leftsec">
      <?php settings_fields( 'custom_mntmode_settings_group' ); ?>
      <input type="hidden" name="urlch" id="urlch" value="<?php bloginfo( 'url' ); ?>/maintenancemode/" />
      <input type="hidden" name="expiredate" id="expiredate" value="<?php echo date("Y-m-d H:i:s", strtotime("+1 hour")); ?>" />
      <p>
        <input onClick="return autofillcheck(this.value);" id="wpspandntset[enable]" name="wpspandntset[enable]" type="checkbox" value="1" <?php checked( '1', $wpspandnt_options['enable'] ); ?>/>
        <label class="description" for="wpspandntset[enable]">
          <?php _e( 'Enable For Maintenance Mode?' ); ?>
        </label>
      </p>
      
      <?php if($wpspandnt_options['enable']=='1'){ ?>
      <div id="divone" class="disblock">
      <?php } 
	   if($wpspandnt_options['enable']==''){ ?>
      <div id="divone" class="disnone">
        <?php } ?>
        <h4>Redirect</h4>
        <p>
          <?php if($wpspandnt_options['pageurl']!='' ) { ?>
          <input type="radio" id="wpspandnt_settingpage" onClick="return selectedradio(this.value);" onchange="return changeurlandpage(this.value);" name="wpspandntset[pageurl]" value="page" <?php checked( 'page', $wpspandnt_options['pageurl'] ); ?>/>
          WP Page
          <input type="radio" id="wpspandnt_settingurl" onClick="return selectedradio(this.value);" onchange="return changeurlandpage(this.value);" name="wpspandntset[pageurl]" value="url"<?php checked( 'url', $wpspandnt_options['pageurl'] ); ?>/>
          URL
          <br/>
          <?php } else {
					?>
          <input type="radio" id="wpspandnt_settingpage" onClick="return selectedradio(this.value);" onchange="return changeurlandpage(this.value);" name="wpspandntset[pageurl]" value="page" checked="checked"/>
          WP Page
          <input type="radio" id="wpspandnt_settingurl" onClick="return selectedradio(this.value);" name="wpspandntset[pageurl]" onchange="return changeurlandpage(this.value);" value="url"/>
          URL
          <br/>
          <?php		
						}
					?>
        </p>
        <?php if($wpspandnt_options['pageurl']=='page' || $wpspandnt_options['pageurl']=='') { ?>
    <div id="rdpages" class="disblock">
      <?php } else if($wpspandnt_options['pageurl']=='url') { ?>
      <div id="rdpages" class="disnone">
        <?php } ?>
        
        <h4>Redirect Page</h4>
        <p>
          <?php $pages = get_pages(); ?>
          <select id="wpspandntset[page]" name="wpspandntset[page]">
            <?php foreach($pages as $page) { ?>
            <option value="<?php echo $page->ID; ?>" <?php if($wpspandnt_options['page'] == $page->ID) { echo 'selected="selected"'; } ?>><?php echo $page->post_title; ?></option>
            <?php } ?>
          </select>
          <label class="description" for="wpspandntset[page]">
            <?php //_e( 'Page to send users without IP access' ); ?>
          </label>
          <br/>
        </p>
        </div>
        <?php if($wpspandnt_options['pageurl']=='page' || $wpspandnt_options['pageurl']=='') { ?>
    <div id="rdurl" class="disnone">
      <?php } else if($wpspandnt_options['pageurl']=='url') { ?>
      <div id="rdurl" class="disblock">
        <?php } ?>
        
        <h4>Redirect URL<span class="starval">*</span></h4>
       	<p>
          <?php if($wpspandnt_options['redirect_url']!=""){ ?>
          <input id="redirect_url" name="wpspandntset[redirect_url]" class="validurl" type="text" value="<?php echo $wpspandnt_options['redirect_url'];?>" />
          <input id="original_url" name="wpspandntset[original_url]" type="hidden" value="<?php bloginfo( 'url' ); ?>/" />
          <label class="description">
           Default URL:  <?php echo plugins_url( '/maintenance/', __FILE__ ); ?>
          </label>
          <br/>
          <?php } else { ?>
          <input id="redirect_url" name="wpspandntset[redirect_url]" class="validurl" type="text" value="<?php echo plugins_url( '/maintenance/', __FILE__ ); ?>" />
          <input id="original_url" name="wpspandntset[original_url]" type="hidden" value="<?php bloginfo( 'url' ); ?>/" />
          <label class="description">
            Default URL: <?php echo plugins_url( '/maintenance/', __FILE__ ); ?>
          </label>
          <br/>
          <?php } ?>
        </p>
        </div>
        <?php if($wpspandnt_options['pageurl']=='page' || $wpspandnt_options['pageurl']=='') { ?>

    <div id="rdmedia" style="display:none;">

      <?php } else if($wpspandnt_options['pageurl']=='url') { ?>

      <div id="rdmedia" style="display:block;">

        <?php } ?>
      <h4>Social Media</h4>
      <p><input type="text" name="wpspandntset[facebook]" id="facebook" class="socialmedia" placeholder="Facebook" value="<?php echo $wpspandnt_options['facebook']; ?>" /></p>
      <p><input type="text" name="wpspandntset[googleplus]" id="googleplus" class="socialmedia" placeholder="Google plus" value="<?php  echo $wpspandnt_options['googleplus']; ?>" /></p>
      <p><input type="text" name="wpspandntset[twitter]" id="twitter" class="socialmedia" placeholder="Twitter" value="<?php  echo $wpspandnt_options['twitter']; ?>" /></p>
      <p><input type="text" name="wpspandntset[linkedin]" id="linkedin" class="socialmedia" placeholder="Linkedin" value="<?php  echo $wpspandnt_options['linkedin']; ?>" /></p>
      <p><input type="text" name="wpspandntset[pinterest]" id="pinterest" class="socialmedia" placeholder="Pinterest" value="<?php  echo $wpspandnt_options['pinterest']; ?>" /></p>
      
      <h4>Subscriber Form</h4>
      <p><input id="wpspandntset[subscriber]" name="wpspandntset[subscriber]" type="checkbox" value="1" <?php checked( '1', $wpspandnt_options['subscriber'] ); ?>/>
        <label class="description" for="wpspandntset[subscriber]">
          <?php _e( 'Enable For Subscriber Form?' ); ?>
        </label></p>
      </div>
      </div>
      <?php //} ?>
      
      <p class="submit">
        <input type="submit" class="button-primary" id="btn_submit" value="<?php _e( 'Submit' ); ?>" />
      </p>
      </div>
   
    <?php if(($wpspandnt_options['pageurl']=='page' || $wpspandnt_options['pageurl']=='') || ($wpspandnt_options['enable']=='')) { ?>
    <div id="countdown" class="rightsec disnone">
      <?php } if(($wpspandnt_options['pageurl']=='url' || $wpspandnt_options['pageurl']=='')) { ?>
      <div id="countdown" class="rightsec disblock">
        <?php } ?>
       
          <div>
          <h3 class="hndle"><span>Maintenance Countdown Page</span></h3>
         <input type="hidden" class="regular-text" name="wpspandntset[wpspandnt_siteurl]" id="wpspandntset[wpspandnt_siteurl]" value="<?php echo content_url('plugins/custom-maintenance-mode/maintenance/');  ?>" />
          <table class="form-table" width="100%">
          <tr valign="top">
              <th scope="row">Meta Title:</th>
              <td><input type="text" class="regular-text" name="wpspandntset[wpspandnt_maintenancemetatitle]" id="wpspandntset[wpspandnt_maintenancemetatitle]" value="<?php echo $wpspandnt_options['wpspandnt_maintenancemetatitle']; ?>" /><br /><span>Most search engines use a maximum of 60 chars for the title.</span></td>
            </tr>
            <tr valign="top">
              <th scope="row">Meta Description:</th>
              <td><input name="wpspandntset[wpspandnt_maintenancemetades]" type="text" class="regular-text" id="wpspandntset[wpspandnt_maintenancemetades]" value="<?php echo $wpspandnt_options['wpspandnt_maintenancemetades']; ?>" />
              <br />
              <span>Most search engines use a maximum of 160 chars for the description.</span>
              </td>
            </tr>
          <tr valign="top">
            <th scope="row">Logo Upload/Text:</th>
              <td><input type="file" class="regular-text" name="wpspandnt_maintenancelogo" id="wpspandnt_maintenancelogo" value="<?php echo $wpspandnt_options['wpspandnt_maintenancelogo']; ?>" />
              <?php if($wpspandnt_options['wpspandnt_maintenancelogo']!=""){ ?>
              <span class="password">
              <img src="<?php echo $wpspandnt_options['wpspandnt_maintenancelogo']; ?>" width="160" /></span>
              <?php } ?>
              <br />
              <span class="error">OR</span>
              <input type="text" class="regular-text" name="wpspandntset[wpspandnt_maintenancelogotext]" id="wpspandntset[wpspandnt_maintenancelogotext]" value="<?php echo $wpspandnt_options['wpspandnt_maintenancelogotext']; ?>" placeholder="Logo Text" />
              </td>
            </tr>
            <tr valign="top">
              <th scope="row">Display Logo Image:</th>
              <td><input type="checkbox" name="wpspandntset[wpspandnt_maintenancedisplaylogo]" id="wpspandntset[wpspandnt_maintenancedisplaylogo]" value="1" <?php checked( '1', $wpspandnt_options['wpspandnt_maintenancedisplaylogo'] ); ?> /></td>
            </tr>
            <tr valign="top">
              <th scope="row">Enter Title:</th>
              <td><input name="wpspandntset[wpspandnt_maintenancetitle]" type="text" class="regular-text" id="wpspandntset[wpspandnt_maintenancetitle]" value="<?php echo $wpspandnt_options['wpspandnt_maintenancetitle']; ?>" /></td>
            </tr>
            <tr valign="top">
              <th scope="row">Enter Subtitle:</th>
              <td><input type="text" class="regular-text" name="wpspandntset[wpspandnt_maintenancesubtitle]" id="wpspandntset[wpspandnt_maintenancesubtitle]" value="<?php echo $wpspandnt_options['wpspandnt_maintenancesubtitle']; ?>" /></td>
            </tr>
            <tr valign="top">
              <th scope="row">Enter Footer Text:</th>
              <td><input type="text" class="regular-text" name="wpspandntset[wpspandnt_maintenancefooter]" id="wpspandntset[wpspandnt_maintenancefooter]" value="<?php echo $wpspandnt_options['wpspandnt_maintenancefooter']; ?>"  /></td>
            </tr>
            <tr valign="top">
              <th scope="row">Enter Current Date & Time:</th>
              <td><input type="text" class="regular-text" name="wpspandntset[wpspandnt_maintenancestartdate]" readonly id="wpspandntset[wpspandnt_maintenancestartdate]" value="<?php echo date("Y-m-d H:i:s"); ?>" />
              <input type="hidden" name="wpspandntset[expiredate]" id="expiredate" value="<?php echo date("Y-m-d H:i:s", strtotime("+1 hour")); ?>" /></td>
            </tr>	     
          </table>
          
      </div>
    </div>
		
    <!-- save the options -->	
    </form>
	
    </div>
<div class="clear"></div>
    <p class="submit1">
        <input type="submit" class="button-primary" id="btn_submit" value="<?php _e( 'Submit' ); ?>" />
      </p>
  </div>
</div>
<?php
  wp_enqueue_script("jquery");
  wp_enqueue_script("validationjs", plugins_url( 'js/validationmnt.js' , __FILE__ ), array());
  wp_enqueue_script("functionjs", plugins_url( 'js/functionjs.js' , __FILE__ ), array());
  wp_enqueue_script("placeholders", plugins_url( '/maintenance/js/placeholders.js' , __FILE__ ), array());
 ?>