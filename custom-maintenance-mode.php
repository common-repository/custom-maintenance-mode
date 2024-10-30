<?php 
/*
   Plugin Name: Custom Maintenance Mode
   Plugin URI: http://www.wpsuperplugin.com
   Description: You can easily create a maintenance mode
   Version: 1.2
   Author: Mr.Subhash Patel
   Author URI: http://www.wpsuperplugin.com
   */
ob_start();
 $wpspandnt_options = get_option('wpspandntset');

//This function use for Create new Table
function wpspandnt_maintenancemode_creation()
{
	global $wpdb;
	$table_cmm_subscriber = $wpdb->prefix . "cmm_subscriber";
	if($wpdb->get_var('show tables like $table_cmm_subscriber') != $table_cmm_subscriber) 
	{
		$sql = "CREATE TABLE ".$table_cmm_subscriber."
                    (cmm_id BIGINT(20) NOT NULL AUTO_INCREMENT,
                    cmm_email VARCHAR(20) NOT NULL ,
                    cmm_date DATETIME NOT NULL ,
					cmm_status ENUM( '1', '0' ) NOT NULL DEFAULT '1',
                    PRIMARY KEY (cmm_id)  )";
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
	}
	
}
// this hook will cause our creation function to run when the plugin is activated
register_activation_hook( __FILE__, 'wpspandnt_maintenancemode_creation' );
	
	
function wpspandnt_maintenancemode_deactiveplugin()
{
	global $wpdb;	
}
register_deactivation_hook( __FILE__, 'wpspandnt_maintenancemode_deactiveplugin' );


//Drop Database Table
function wpspandnt_maintenancemode_dropplugin()
{
	global $wpdb;
	delete_option('wpspandntset');
	
	$table_cmm_subscriber = $wpdb->prefix . "cmm_subscriber";
	$wpdb->query("DROP TABLE IF EXISTS $table_cmm_subscriber");
}
register_uninstall_hook( __FILE__, 'wpspandnt_maintenancemode_dropplugin' );

function wpspandnt_register_settings() {

	// create whitelist of options
	register_setting( 'custom_mntmode_settings_group', 'wpspandntset', 'validate_setting' );
	
}

function validate_setting($wpspandntset) { $keys = array_keys($_FILES); $i = 0; foreach ( $_FILES as $image ) {  
 // if a files was upload 
  if ($image['size']) {  
     // if it is an image  
	    if ( preg_match('/(jpg|jpeg|png|gif)$/', $image['type']) ) {    
		   $override = array('test_form' => false); 
		         // save the file, and store an array, containing its location in $file     
				   $file = wp_handle_upload( $image, $override );    
				      $wpspandntset[$keys[$i]] = $file['url']; 
					      } 
					  else { 
					        // Not an image.        
							$options = get_option('wpspandntset');  
							     $wpspandntset[$keys[$i]] = $options[$logo];   
								       wp_die('No image was uploaded.');     }   }  
									    else {     $options = get_option('wpspandntset');  
										
										   $wpspandntset[$keys[$i]] = $options[$keys[$i]];   }   $i++; } return $wpspandntset;}




//call register settings function
add_action( 'admin_init', 'wpspandnt_register_settings' );


function wpspandnt_maintenance_menu()
{
	global $wpspandnt_options;
	//icon display on side title plugin in leftside
    $icon_url=WP_PLUGIN_URL."/custom-maintenance-mode/images/maintenancemode.png";
	add_menu_page('wpspandnt_Googlepost_Autopost', 'Custom Maintenance', 'activate_plugins', 'wpspgpap_maintenance', 'restricip',$icon_url);
	
	if($wpspandnt_options['subscriber']=='1')
	{
	add_submenu_page('wpspgpap_maintenance','Subscriber List','Subscriber List',1,'subscriber-list','cmm_subscriber_menu');
	}
}
add_action('admin_menu', 'wpspandnt_maintenance_menu');

if(!class_exists('WP_List_Table')){
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}
class cmm_subscriberlist extends WP_List_Table {
    function __construct(){
        global $status, $page;
                
        //Set parent defaults
        parent::__construct( array(
            'singular'  => 'viewid',     //singular name of the listed records
            'plural'    => 'securites',    //plural name of the listed records
            'ajax'      => false        //does this table support ajax?
        ) );
        
    }
	 function column_default($item, $column_name){
		 
			return $item[$column_name];
    }
function process_bulk_action() {
	
        
        //Detect when a bulk action is being triggered...
       if($_POST['submit']=='CSV Export')

  {  
  global $wpdb;

      //echo memory_get_usage()."\n";

     // ob_start();

      function cleanData(&$str)

  {

    if($str == 't') $str = 'TRUE';

    if($str == 'f') $str = 'FALSE';

    if(preg_match("/^0/", $str) || preg_match("/^\+?\d{8,}$/", $str) || preg_match("/^\d{4}.\d{1,2}.\d{1,2}/", $str)) {

      $str = "'$str";

    }

    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';

  }



  // filename for download

  $filename = "custom_maintenance_mode_data_" . date('Ymd') . ".csv";

//ob_clean();

  header("Content-Disposition: attachment; filename=\"$filename\"");

  header("Content-Type: text/csv;");



  $out = fopen("php://output", 'w');
ob_get_clean();
  $flag = false;

  $table = $wpdb->prefix . "cmm_subscriber";

  $result = mysql_query("SELECT cmm_id, cmm_email, cmm_date FROM ".$table." ORDER BY cmm_id") or die('Query failed!');

  while(false !== ($row = mysql_fetch_assoc($result))) {

    if(!$flag) {

      // display field/column names as first row

      fputcsv($out, array_keys($row), ',', '"');

      $flag = true;

    }

    array_walk($row, 'cleanData');

    fputcsv($out, array_values($row), ',', '"');

  }



  fclose($out);
  exit; 
    }
}
   
    
    function get_columns(){
        $columns = array(
		    'cmm_id'  => 'ID',
            'cmm_email'      => 'Email Address',
			'cmm_date'      => 'Date'		
        );
        return $columns;
    }
    
    function get_sortable_columns() {
        $sortable_columns = array(
            'cmm_id'     => array('cmm_id',false),
			'cmm_email'     => array('cmm_email',false),
			'cmm_date'     => array('cmm_date',false)
        );
        return $sortable_columns;
    }
    
    
    function prepare_items() 
	{
        global $wpdb; //This is used only if making any database queries
        $per_page = 10;
        
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();
        $table_prefix = "cmm_subscriber";
	  
        $this->_column_headers = array($columns, $hidden, $sortable);
		$this->process_bulk_action();
		
		$query = "SELECT * FROM ".$wpdb->prefix.$table_prefix;
		
        $orderby = !empty($_GET["orderby"]) ? mysql_real_escape_string($_GET["orderby"]) : 'cmm_id';
		$order = !empty($_GET["order"]) ? mysql_real_escape_string($_GET["order"]) : 'DESC';
		if(!empty($orderby) & !empty($order)){ $query.=' ORDER BY '.$orderby.' '.$order; }
		
		$data1 = $wpdb->get_results($query);
		
		function objectToArray($ota) 
		{
			if (is_object($ota)) 
			{
				$ota = get_object_vars($ota);
			}
	 
			if (is_array($ota)) 
			{
				return array_map(__FUNCTION__, $ota);
			}
			else 
			{
				return $ota;
			}
		}
		$data = objectToArray($data1);	
			
        $current_page = $this->get_pagenum();
        $total_items = count($data);
        $data = array_slice($data,(($current_page-1)*$per_page),$per_page);
        $this->items = $data;
		
        
        $this->set_pagination_args( array(
            'total_items' => $total_items,                  //WE have to calculate the total number of items
            'per_page'    => $per_page,                     //WE have to determine how many items to show on a page
            'total_pages' => ceil($total_items/$per_page)   //WE have to calculate the total number of pages
        ) );
    }
    
}
function cmm_subscriber_menu()
{
    $cmm_sub = new cmm_subscriberlist();
    $cmm_sub->prepare_items();
     ?>
        <div class="wrap">
          <div id="icon-users" class="icon32"><br/>
          </div>
          <h2 style="border-bottom: 1px solid #DDDDDD;">Subscriber List</h2>
          <form id="removeipadd-filter" method="post" style="float: right; margin-top: 10px;"><input type="submit" value="CSV Export" class="button button-primary" id="submit" name="submit"></form>
          <?php $cmm_sub->display();   ?>
        </div>
<?php 
}

function restricip()
{
global $wpspandnt_options;
include_once WP_PLUGIN_DIR . '/custom-maintenance-mode/ipaccesspage.php';
}

function wpspandnt_restrict_access() {
	global $wpspandnt_options;
	if($wpspandnt_options['enable']) {
		if($wpspandnt_options['pageurl'] == 'page') {
			if(!is_page(intval($wpspandnt_options['page']))) {
					wp_redirect( get_permalink($wpspandnt_options['page'])); exit;
			}
		} elseif($wpspandnt_options['pageurl'] == 'url') {
			if($wpspandnt_options['redirect_url'] != '') {
				wp_redirect( $wpspandnt_options['redirect_url']); exit; 
			}
		}
	}
}



function activate_maintenance() {
	global $wpdb;
	global $wpspandnt_options;
	
	if($wpspandnt_options['enable'] && $wpspandnt_options['pageurl'] == 'url' && $wpspandnt_options['redirect_url'] == $wpspandnt_options['wpspandnt_siteurl']) 
	{
		
		$plugin_path   = plugin_dir_path(__FILE__) . 'maintenance/mn.php';
		$template_path = get_template_directory() . '/mn.php';
		$child_path    = get_stylesheet_directory() . '/mn.php';
		if ( is_user_logged_in() ) {
			
			}
			else
			{
				
				$currentpageurl = current_page_url();
				$findme12 = 'ajax_subscriber.php';
				$pos = !strpos($currentpageurl, $findme12);
				if($pos===false)
				{ }
				else
				{
						foreach ( array( 'child_path', 'template_path', 'plugin_path' ) as $var ) {
									if ( file_exists( ${$var} ) ) {
										include ${$var};
										exit();
									}
								}		
							
				}
				
			}
		
		}
		else if($wpspandnt_options['enable'] && $wpspandnt_options['pageurl'] == 'page')
		{
			if ( is_user_logged_in() ) {
			
			}
			else
			{
				add_action('template_redirect', 'wpspandnt_restrict_access');
			}
		}
	
}


// start frontend
function current_page_url() {
	$pageURL = 'http';
	if( isset($_SERVER["HTTPS"]) ) {
		if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
	}
	$pageURL .= "://";
	if ($_SERVER["SERVER_PORT"] != "80") {
		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	} else {
		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	}
	return $pageURL;
}

if( !is_admin() ) {
	global $wpdb;
	global $wpspandnt_options;
	$ips = array_map('trim', explode("\n", $wpspandnt_options['ips']));
	$currentpageurl = current_page_url();
	$findme2 = 'wp-login.php';
	$pos = !strpos($currentpageurl, $findme2);
	if($pos===false)
	{ }
	else
	{
			add_action( 'init', 'activate_maintenance');				
				
	}
}

?>
