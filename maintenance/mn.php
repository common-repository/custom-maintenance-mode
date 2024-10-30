<?php 
	
	global $wpdb;
	global $wpspandnt_options;
	
	
	if($wpspandnt_options['enable']) 
	{
		$ips = array_map('trim', explode("\n", $wpspandnt_options['ips']));
		if($wpspandnt_options['pageurl'] == 'page') 
		{
			if(!is_page(intval($wpspandnt_options['page']))) 
			{	 ?>
					<script type="text/javascript">
                    window.location.href="<?php bloginfo( 'url' ); ?>";
                    </script>
<?php		}
		}
		elseif($wpspandnt_options['pageurl'] == 'url' && $wpspandnt_options['redirect_url'] == $wpspandnt_options['wpspandnt_siteurl']) 		{			
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <title>
        <?php if($wpspandnt_options['wpspandnt_maintenancemetatitle']!=""){ echo $wpspandnt_options['wpspandnt_maintenancemetatitle']; } else { ?>
        Maintenance Mode
        <?php } ?>
        </title>
        <?php if($wpspandnt_options['wpspandnt_maintenancemetades']!="")
		{ 
			?>
        <meta name="description" content="<?php echo $wpspandnt_options['wpspandnt_maintenancemetades']; ?>">
        <link rel="icon" href="<?php echo plugins_url( '/images/maintenancemode.png', __FILE__ );?>" type="image/png" />
        <?php 
		} 
wp_enqueue_style( 'maintenancestyle', plugins_url( '/css/wpspandntclock.css', __FILE__ ), false, '1.0', 'all' ); // Inside a plugin
wp_enqueue_style( 'jqueryjnt', plugins_url( '/css/jNotify.jquery.css', __FILE__ ), false, '1.0', 'all' ); // Inside a plugin
?>
        <!--[if IE]><script src="<?php echo plugins_url( '/js/excanvas.js', __FILE__ ); ?>"></script><![endif]-->
        <?php
		
		$currentdate2 =strtotime(date("Y-m-d H:i:s"));
		$timestampend2 = strtotime($wpspandnt_options['expiredate']);		
		
		if($timestampend2<=$currentdate2)
		{ 
			delete_option('wpspandntset');
		?>
			<script type="text/javascript">
            window.location.href="<?php bloginfo( 'url' ); ?>";
            </script>
  <?php } 
  
		$installtime = strtotime($wpspandnt_options['wpspandnt_maintenancestartdate']);
		$timestampend = strtotime($wpspandnt_options['expiredate']);
		$wpspandnt_siteurl = $wpspandnt_options['wpspandnt_siteurl'];
		$original_url = $wpspandnt_options['original_url'];

		function test()
		{       
			global $wpspandnt_options;
			$currentdate2 =strtotime(date("Y-m-d H:i:s"));
			$installtime = strtotime($wpspandnt_options['wpspandnt_maintenancestartdate']);
			$timestampend = strtotime($wpspandnt_options['wpspandnt_maintenanceenddate']);
			$wpspandnt_siteurl = $wpspandnt_options['wpspandnt_siteurl'];
			$original_url = $wpspandnt_options['original_url'];
			wp_enqueue_script("jquery");
			
			wp_enqueue_script('jnotifyjs111', plugins_url( '/jquery/jNotify.jquery.min.js', __FILE__ ), array());
			wp_enqueue_script('wpspandntclock', plugins_url( '/js/wpspandntclock.js', __FILE__ ), array());
			wp_enqueue_script("cmmvalidationcheck", plugins_url( '/js/cmmvalidationcheck.js' , __FILE__ ), array()); 
			 wp_enqueue_script("placeholders", plugins_url( '/js/placeholders.js' , __FILE__ ), array());
			
		}
		add_action('wp_footer','test');
		wp_footer(); 
 
 ?><script type="text/javascript">
            jQuery(document).ready(function(){
                wpspandntcountdn({
                    installtime : "<?php echo $installtime; ?>",
                    currentdate   : "<?php echo $currentdate2; ?>",
					expiredate   : "<?php echo $timestampend; ?>",
                    redirecturl    : "<?php echo $wpspandnt_siteurl; ?>",
					original_url   : "<?php echo $original_url; ?>"
                });
            });
        </script>
       </head>
<body>
  <div class="wrapper">
          <?php if($wpspandnt_options['wpspandnt_maintenancelogo']!="" && $wpspandnt_options['wpspandnt_maintenancedisplaylogo']=='1'){ ?>
          <div class="maintenancelogo"><img width="500" height="160" src="<?php echo $wpspandnt_options['wpspandnt_maintenancelogo'];  ?>" alt="logo"></div>
          <?php } 
		else
		{ ?>
          <div class="maintenancelogotxt">
            <h1><?php echo $wpspandnt_options['wpspandnt_maintenancelogotext']; ?></h1>
          </div>
          <?php	}
		?>
          <h2><?php echo $wpspandnt_options['wpspandnt_maintenancetitle']; ?></h2>
          <h3><?php echo $wpspandnt_options['wpspandnt_maintenancesubtitle']; ?></h3>
          
          <div class="wpspandnt_amazingclock">
            <div class="wpspandnt_day">
              <div class="wpspandnt_round">
                <canvas id="canvas_days" width="166" height="165"></canvas>
                <p class="type_days">Days</p>
                <div class="clockcounter">0</div>
              </div>
            </div>
            <div class="wpspandnt_hour">
              <div class="wpspandnt_round">
                <canvas id="canvas_hours" width="166" height="165"></canvas>
                <p class="type_hours">Hours</p>
                <div class="clockcounter">0</div>
              </div>
            </div>
            <div class="wpspandnt_minute">
              <div class="wpspandnt_round">
                <canvas id="canvas_minutes" width="166" height="165"></canvas>
                <p class="type_minutes">Minutes</p>
                <div class="clockcounter">0</div>
              </div>
            </div>
            <div class="wpspandnt_second">
              <div class="wpspandnt_round">
                <canvas id="canvas_seconds" width="166" height="165"></canvas>
                <div class="oscillate"></div>
                <p class="type_seconds">Seconds</p>
                <div class="clockcounter">0</div>
              </div>
            </div>
          </div>
          
          <div class="mainfooter"> 
          <span class="footer_text">
          <?php if(($wpspandnt_options['facebook'] || $wpspandnt_options['googleplus'] || $wpspandnt_options['twitter'] || $wpspandnt_options['linkedin'] || $wpspandnt_options['pinterest']) || ($wpspandnt_options['subscriber']=='1')){ 
		  
			  if(($wpspandnt_options['facebook'] || $wpspandnt_options['googleplus'] || $wpspandnt_options['twitter'] || $wpspandnt_options['linkedin'] || $wpspandnt_options['pinterest']) && ($wpspandnt_options['subscriber']!='1'))
			  {?>
          <div class="follow_part" style="padding-right:0px;">
          <?php }
			  else
			  { ?>
          <div class="follow_part">
          <?php }
		   }
		  else { ?>
			  <div class="follow_part" style="display:none;  ">
			 <?php } ?>
          <?php if(($wpspandnt_options['facebook'] || $wpspandnt_options['googleplus'] || $wpspandnt_options['twitter'] || $wpspandnt_options['linkedin'] || $wpspandnt_options['pinterest']) && ($wpspandnt_options['subscriber']=='1')){ ?>
         	 <ul>
             <?php } else { ?>
             <ul style="float:none;">
             <?php } ?>
          <?php if($wpspandnt_options['facebook']) {  
		  $pos = strpos($wpspandnt_options['facebook'], 'http://');
				if ($pos === false) {
					"http://".$wpspandnt_options['redirect_url']; 
				}
				else
				{
					$wpspandnt_options['redirect_url']; 
				}
		  ?>
          <li style="margin-right:10px;"><a target="_blank" href="<?php $pos = strpos($wpspandnt_options['facebook'], 'http://');
				if ($pos === false) {
					echo "http://".$wpspandnt_options['facebook']; 
				}
				else
				{
					echo $wpspandnt_options['facebook']; 
				} ?>"><img src="<?php echo plugins_url( '/images/facebook.png' , __FILE__ );  ?>" /></a></li>
                
          <?php } if($wpspandnt_options['googleplus']!="") { ?>
          <li style="margin-right:10px;"><a target="_blank" href="<?php $pos = strpos($wpspandnt_options['googleplus'], 'http://');
				if ($pos === false) {
					echo "http://".$wpspandnt_options['googleplus']; 
				}
				else
				{
					echo $wpspandnt_options['googleplus']; 
				} ?>"><img src="<?php echo plugins_url( '/images/googleplus.png' , __FILE__ );  ?>" /></a></li>
		  <?php } if($wpspandnt_options['twitter']!="") {  ?>
          <li style="margin-right:10px;"><a target="_blank" href="<?php $pos = strpos($wpspandnt_options['twitter'], 'http://');
				if ($pos === false) {
					echo "http://".$wpspandnt_options['twitter']; 
				}
				else
				{
					echo $wpspandnt_options['twitter']; 
				} ?>"><img src="<?php echo plugins_url( '/images/twitter.png' , __FILE__ );  ?>" /></a></li>
          <?php } if($wpspandnt_options['linkedin']!="") { ?>
          <li style="margin-right:10px;"><a target="_blank" href="<?php $pos = strpos($wpspandnt_options['linkedin'], 'http://');
				if ($pos === false) {
					echo "http://".$wpspandnt_options['linkedin']; 
				}
				else
				{
					echo $wpspandnt_options['linkedin']; 
				} ?>"><img src="<?php echo plugins_url( '/images/linkedin.png' , __FILE__ );  ?>" /></a></li>
          <?php } if($wpspandnt_options['pinterest']!="") { ?>
          <li style="margin-right:10px;"><a target="_blank" href="<?php $pos = strpos($wpspandnt_options['pinterest'], 'http://');
				if ($pos === false) {
					echo "http://".$wpspandnt_options['pinterest']; 
				}
				else
				{
					echo $wpspandnt_options['pinterest']; 
				} ?>"><img src="<?php echo plugins_url( '/images/pinterest.png' , __FILE__ );  ?>" /></a></li>
          <?php } ?>
                    </ul>
                    
                    <?php if($wpspandnt_options['subscriber']=='1'){ ?>
                    <?php wp_enqueue_script("jquery"); ?>
          <script type="text/javascript">
		  
		  function ValidateEmail(email) {
        var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        return expr.test(email);
    };
    jQuery("#subscribe").live("click", function () {
		if (jQuery("#cmmemail").val()=='') {
           jError('ERROR : Please Enter Email Address !');
			return false;
        }
        if (!ValidateEmail(jQuery("#cmmemail").val())) {
           jError('ERROR : Please Enter Valid Email Address !');
			return false;
        }
        else {
           
			return true;
        }
    });

		  jQuery(document).ready(function(){
          jQuery('#cmmsubscriber').submit(function(e){
			  
			var postData = jQuery(this).serializeArray();
			//alert(postData);
jQuery('.ui-progressbar').show();
    jQuery.ajax({
        type: 'POST',
        url: '<?php echo plugins_url( '/ajax_subscriber.php' , __FILE__ );  ?>',
        data: postData,
        success: function(data){
			jQuery('.ui-progressbar').hide();
			document.getElementById("cmmsubscriber").reset();
						
			if(data=='Aleardy')
			{
				jNotify('Email address already exist.');
			}
			if(data=='Success')
			{
				jSuccess('Thanks, You are successfully subscribed.');
			}
			 
        },
        error: function(){
            alert('error');
        }
    });
    e.preventDefault();
});
		  });

jQuery('#cmmsubscriber').submit();
          </script>
          	 <div class="form-newsletter subscribe">
             <form method="post" name="cmmsubscriber" id="cmmsubscriber" onsubmit= "return checkemail();">
            <input type="email" class="emails" name="cmmemail" placeholder="Email Address" id="cmmemail"/>
            <input type="submit" name="Subscribe" id="subscribe" value="Subscribe" class="submit">
            </form>
          </div>
          <?php } ?>
          <div class="clear"></div>
          </div>
          <div class="ui-progressbar" style="display: none;"><img src="<?php echo plugins_url( '/images/load.gif' , __FILE__ );  ?>" /></div>
          
          <div class="wrapper newsletter-sec" style="float:left;">
    
    	<div class="main">
        
        	<div class="align-right">
        </div>
        
        </div>
    </div>
          </p>
          
        	 <p>
            <?php if($wpspandnt_options['wpspandnt_maintenancefooter']!=""){ ?>
            Contact Email: <a href="mailto:<?php echo $wpspandnt_options['wpspandnt_maintenancefooter']; ?>" ><?php echo $wpspandnt_options['wpspandnt_maintenancefooter']; ?></a>
            <?php } ?>
          </p>
          
          
             </div>
        </div>
</body>




</html>
<?php 
		}
		else
		{
			?>
<script type="text/javascript">
window.location.href="<?php bloginfo( 'url' ); ?>";
</script>
<?php
		}
	} 
	else
		{ 
			?>
<script type="text/javascript">
window.location.href="<?php bloginfo( 'url' ); ?>";
</script>
<?php
		} ?>