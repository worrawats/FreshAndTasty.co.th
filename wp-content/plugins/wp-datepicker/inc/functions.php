<?php
	defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


	//FOR QUICK DEBUGGING
	if(!function_exists('pre')){
	function pre($data){
			if(isset($_GET['debug'])){
				pree($data);
			}
		}	 
	} 
	
	if(!function_exists('pree')){
	function pree($data){
				echo '<pre>';
				print_r($data);
				echo '</pre>';	
		
		}	 
	} 




	function wpdp_menu()
	{



		 add_options_page('WP Datepicker', 'WP Datepicker', 'update_core', 'wp_dp', 'wp_dp');



	}

	function wp_dp(){ 



		if ( !current_user_can( 'update_core' ) )  {



			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );



		}



		global $wpdb, $wpdp_dir, $wpdp_pro, $wpdp_data; 

		
		include($wpdp_dir.'inc/wpdp_settings.php');
		

	}	



	
	

	function wpdp_plugin_links($links) { 
		global $wpdp_premium_link, $wpdp_pro;
		
		$settings_link = '<a href="options-general.php?page=wp_dp">Settings</a>';
		
		if($wpdp_pro){
			array_unshift($links, $settings_link); 
		}else{
			 
			$wpdp_premium_link = '<a href="'.$wpdp_premium_link.'" title="Go Premium" target=_blank>Go Premium</a>'; 
			array_unshift($links, $settings_link, $wpdp_premium_link); 
		
		}
		
		
		return $links; 
	}
	
	function register_wpdp_scripts() {
		
			
		if (is_admin ()){
		
			wp_enqueue_media ();
		
			
			 
			wp_enqueue_script(
				'wpdp-scripts1',
				plugins_url('js/scripts.js', dirname(__FILE__)),
				array('jquery')
			);	
			
			
		
			wp_register_style('wpdp-style1', plugins_url('css/admin-styles.css', dirname(__FILE__)));	
			
			wp_enqueue_style( 'wpdp-style1' );
			
			wp_enqueue_script(
				'wpdp-scripts3',
				plugins_url('js/jqColorPicker.min.js', dirname(__FILE__)),
				array('jquery')
			);					
		
		}else{
					

		}
			wp_register_style('wpdp-style2', plugins_url('css/front-styles.css', dirname(__FILE__)));	
			
			wp_enqueue_style( 'wpdp-style2' );	

			
			wp_enqueue_script(
				'wpdp-scripts2',
				plugins_url('js/scripts-front.js', dirname(__FILE__)),
				array('jquery', 'jquery-ui-datepicker')
			);	
			
		
			
			wp_register_style('wpdp-style3', plugins_url('css/jquery-ui.css', dirname(__FILE__)));	
			
			wp_enqueue_style( 'wpdp-style3' );	
			
			
			if(wp_is_mobile()){
				
				wp_enqueue_style( 'jquery.ui.datepicker.mobile', plugins_url('css/mobile/jquery.ui.datepicker.mobile.css', dirname(__FILE__)), array(), date('Yhi'));
				/*wp_enqueue_script(
					'wpdp-datepicker-ui',
					plugins_url('js/mobile/jQuery.ui.datepicker.js', dirname(__FILE__)),
					array('jquery')
				);*/	
				wp_enqueue_script(
					'wpdp-datepicker-mobile',
					plugins_url('js/mobile/jquery.ui.datepicker.mobile.js', dirname(__FILE__)),
					array('jquery')
				);	
											
			}
							
	} 
		
	if(!function_exists('wp_datepicker')){
	function wp_datepicker(){

		
		}
	}
	
	
	if(!function_exists('wpdp_footer_scripts')){
	function wpdp_footer_scripts(){
		$wpdp_selectors = get_option( 'wp_datepicker');
		
		if($wpdp_selectors!=''){ 	
			$wpdp_selectors = wpdp_slashes($wpdp_selectors);
?>	
	
	<script type="text/javascript" language="javascript">
	

	jQuery(document).ready(function($){
		
		<?php
			global $wpdp_options;
			//pree($wpdp_options);
			$options = array();
			if(!empty($wpdp_options)){
				$wpdp_options_db = get_option('wpdp_options');
				
				foreach($wpdp_options as $option=>$type){
					if(!isset($wpdp_options_db[$option])){
						$wpdp_options_db[$option] = '';
					}
					switch($type){
						default: 
							$val = $wpdp_options_db[$option];
							
							if($val==''){
								switch($option){
									case 'dateFormat':
										$val = get_option('date_format');
										$val = 'mm/dd/yy';
									break;
								}
							}
								
							$val = '"'.$val.'"';
							
						break;
						case 'checkbox':
							$val = ($wpdp_options_db[$option]==true?'true':'false');//exit;
						break;
					}
					$options[] = $option.': '.$val.'';
				}
			}
			//pree($options);
		?>
	
		$("<?php echo $wpdp_selectors; ?>").datepicker({dayNamesMin: ['S', 'M', 'T', 'W', 'T', 'F', 'S'], <?php echo implode(', ', $options); ?>});

		
	});
	
	</script>    
<?php		
		}
	}
	}
	
	function wpdp_slashes($str, $s=false){
		return str_replace(array('"'), "'", stripslashes($str));
	}