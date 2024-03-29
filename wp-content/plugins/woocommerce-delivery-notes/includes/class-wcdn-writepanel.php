<?php

/**
 * Exit if accessed directly
 */
if ( !defined( 'ABSPATH' ) ) {
	exit; 
}

/**
 * Writepanel class
 */
if ( !class_exists( 'WooCommerce_Delivery_Notes_Writepanel' ) ) {

	class WooCommerce_Delivery_Notes_Writepanel {
				
		/**
		 * Constructor
		 */
		public function __construct() {
			// Load the hooks
			add_action( 'admin_init', array( $this, 'load_admin_hooks' ) );
		}

		/**
		 * Load the admin hooks
		 */
		public function load_admin_hooks() {		
			// Hooks
			add_action( 'woocommerce_admin_order_actions_end', array( $this, 'add_listing_actions' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'add_scripts' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'add_styles' ) );
			
			add_action( 'add_meta_boxes_shop_order', array( $this, 'add_box' ) );

			add_action( 'admin_footer-edit.php', array( $this, 'add_bulk_actions' ) );
            add_action( 'load-edit.php', array( $this, 'load_bulk_actions' ) );
			add_action( 'admin_notices', array( $this, 'confirm_bulk_actions' ) );
		}

		/**
		 * Add the styles
		 */
		public function add_styles() {
			if( $this->is_order_edit_page() || $this->is_order_post_page() ) {
				wp_enqueue_style('thickbox');
				wp_enqueue_style( 'woocommerce-delivery-notes-admin', WooCommerce_Delivery_Notes::$plugin_url . 'css/admin.css' );
			}
		}
		
		/**
		 * Add the scripts
		 */
		public function add_scripts() {
			if( $this->is_order_edit_page() || $this->is_order_post_page() ) {
				wp_enqueue_script( 'thickbox' ); 
				wp_enqueue_script( 'woocommerce-delivery-notes-print-link', WooCommerce_Delivery_Notes::$plugin_url . 'js/jquery.print-link.js', array( 'jquery' ) );
				wp_enqueue_script( 'woocommerce-delivery-notes-admin', WooCommerce_Delivery_Notes::$plugin_url . 'js/admin.js', array( 'jquery', 'woocommerce-delivery-notes-print-link', 'thickbox' ) );
			}
		}	
			
		/**
		 * Is order edit page
		 */
		public function is_order_edit_page() {
			global $typenow, $pagenow;
			if( $typenow == 'shop_order' && $pagenow == 'edit.php' ) {
				return true;	
			} else {
				return false;
			}
		}	
		
		/**
		 * Is order edit page
		 */
		public function is_order_post_page() {
			global $typenow, $pagenow;
			if( $typenow == 'shop_order' && ( $pagenow == 'post.php' || $pagenow == 'post-new.php' ) ) {
				return true;	
			} else {
				return false;
			}
		}	
			
		/**
		 * Add print actions to the orders listing
		 */
		public function add_listing_actions( $order ) {
			?>
			<?php

			foreach( WooCommerce_Delivery_Notes_Print::$templates as $template ) : ?>
				<?php $option = get_option( WooCommerce_Delivery_Notes::$plugin_prefix . 'template_type_' . $template['type'] );
				$forinspect = $order->id;
				//$sta = $forinspect->post_status;
				$invoice_number = get_post_meta($forinspect, 'invoice', true);


				//var_dump($meta_query_args);
				//worrawat for download invoice
				if($invoice_number)
				{
					//var_dump($option);
					if(($option) && ($template['type']=='invoice')) { ?>

					<a href="<?php echo wcdn_get_print_link( $order->id, $template['type'] ); ?>" class="button tips print-preview-button <?php echo $template['type']; ?>" target="_blank" alt="<?php esc_attr_e( __( $template['labels']['print'], 'woocommerce-delivery-notes' ) ); ?>" data-tip="<?php esc_attr_e( __( $template['labels']['print'], 'woocommerce-delivery-notes' ) ); ?>">
						<?php _e( $template['labels']['print'], 'woocommerce-delivery-notes' ); ?>
					</a>

				<?php
								}
				}
				?>
			<?php endforeach; ?>

			<span class="print-preview-loading spinner"></span>
			<?php
		}

		/**
		 * Add bulk actions with javascript to the dropdown.
		 * This is not so pretty but WordPress does not yet
		 * offer any better solution. The JS code is inline
		 * because we can't determine the page without
		 * checking the post_type.
		 * https://core.trac.wordpress.org/ticket/16031
		 */
		public function add_bulk_actions() {
			if( $this->is_order_edit_page() ) : ?>
				<script type="text/javascript">
					jQuery(document).ready(function($) {
						<?php foreach( WooCommerce_Delivery_Notes_Print::$templates as $template ) : ?>
						<?php $option = get_option( WooCommerce_Delivery_Notes::$plugin_prefix . 'template_type_' . $template['type'] );
                        if( $option ) : ?>
						<?php //var_dump($template['type']); ?>
						<?php if ($template['type'] == "invoice") { ?>
						$('<option>').val('wcdn_print_<?php echo $template['type']; ?>').attr("selected", true).attr('title', '<?php echo $template['type']; ?>').text('Combine Invoice').appendTo('select[name="action"]');
						<?php }  endif; ?>
						<?php endforeach; ?>
					});
					jQuery('input[type=checkbox]').attr('disabled', true);
					jQuery('input[status=wc-pending]').attr('disabled', false);
					jQuery('input#cb-select-all-1').attr('disabled', false);
					jQuery('input#cb-select-all-2').attr('disabled', false);
				</script>
			<?php endif;
		}
		
		/**
		 * Add bulk print actions to the orders listing
		 */
		public function load_bulk_actions() {
			if( $this->is_order_edit_page() ) {
				// get the action staht should be started
				$wp_list_table = _get_list_table('WP_Posts_List_Table');
				$action = $wp_list_table->current_action();
											
				// stop if there are no post ids
				if( !isset( $_REQUEST['post'] ) ) {
					return;
				}
				
				// only for specified actions
				foreach( WooCommerce_Delivery_Notes_Print::$templates as $template ) {
					if( $action == 'wcdn_print_' . $template['type'] ) {
						$template_type = $template['type'];
						$report_action = 'printed_' . $template['type'];
						break;
					}
				}
				if( !isset( $report_action ) ) {
					return;
				}
				
				// security check
				check_admin_referer('bulk-posts');
				
				// get referrer
				if( !wp_get_referer() ) {
					return;
				}
				
				// filter the referer args
				$referer_args = array();
				parse_str( parse_url( wp_get_referer(), PHP_URL_QUERY ), $referer_args );
				
				// set the basic args for the sendback
				$args = array(
					'post_type' => $referer_args['post_type'] 
				);
				if( isset( $referer_args['post_status'] ) ) {
					$args = wp_parse_args( array( 'post_status' => $referer_args['post_status'] ), $args );
				}
				if( isset( $referer_args['paged'] ) ) {
					$args = wp_parse_args( array( 'paged' => $referer_args['paged'] ), $args );
				}
				if( isset( $referer_args['orderby'] ) ) {
					$args = wp_parse_args( array( 'orderby' => $referer_args['orderby'] ), $args );
				}
				if( isset( $referer_args['order'] ) ) {
					$args = wp_parse_args( array( 'orderby' => $referer_args['order'] ), $args );
				}

				// do the action
				$post_ids = array_map( 'absint', (array) $_REQUEST['post'] );
				$total = count( $post_ids );
				$url = wcdn_get_print_link( $post_ids , $template_type );
				
				// generate more args and the sendback string
				$user = new WP_User(get_current_user_id());
				if($user->roles[0]=="administrator")
				{
					$args = wp_parse_args( array( $report_action => true,  'total' => $total, 'print_url' => urlencode( $url ) ), $args );
				}
				else
				{
				$args = wp_parse_args( array( $report_action => true, 'author' => get_current_user_id(), 'total' => $total, 'print_url' => urlencode( $url ) ), $args );
				}
				$sendback = add_query_arg( $args, '' );
				wp_redirect( $sendback );
				exit;
			}
        }
        
		/**
		 * Show confirmation message that orders are printed
		 */
		public function confirm_bulk_actions() {
			if( $this->is_order_edit_page() ) {
				foreach( WooCommerce_Delivery_Notes_Print::$templates as $template ) {
					if( isset( $_REQUEST['printed_' . $template['type']] ) ) {
						// use singular or plural form
						$total = isset( $_REQUEST['total'] ) ? absint( $_REQUEST['total'] ) : 0;
						if( $total <= 1 ) {
							$message = $template['labels']['message'];
						} else {
							$message = $template['labels']['message_plural'];

						}
						if ($_REQUEST['printed_invoice'] == "1") {
							$ordertype = 'invoice';
						}
						$link = $_REQUEST['print_url'];
						$ids = substr($link, strpos($link, "print-order=") + 12);
						$ids_for_save = explode("&", $ids);
						$tags = explode('-', $ids_for_save[0]);
						$check = 1;
						foreach ($tags as $key) {
							$postaway = get_post_meta($key,'invoice',true);
							if(!empty($postaway))
							{
								$check = 0;
							}
						}


						//worrawat
						if ($_REQUEST['printed_invoice'] == "1" && $check==1) {
							$post_id = wp_insert_post(
								array(
									'comment_status' => 'closed',
									'ping_status' => 'closed',
									'post_name' => $ids_for_save[0],
									'post_status' => 'pending',
									//'post_content' => $ids_for_save[0],
									'guid' => $link,
									'post_type' => $ordertype
								)
							);
							foreach ($tags as $key) {
								$my_post = array(
									'ID' => $key,
									'post_status' => 'wc-invoicecreated'
								);
								update_post_meta($key, 'invoice', $post_id);
								wp_update_post($my_post);
							}
						}
						?>
						
						<div id="woocommerce-delivery-notes-bulk-print-message" class="updated">
							<p><?php _e( $message, 'woocommerce-delivery-notes' ); ?> <a href="<?php echo urldecode( $_REQUEST['print_url'] ); ?>" target="_blank" class="print-preview-button" id="woocommerce-delivery-notes-bulk-print-button"><?php _e( 'Print now', 'woocommerce-delivery-notes' ) ?></a> <span class="print-preview-loading spinner"></span></p>
						</div>
						
						<?php
						break;
					}
				}
			}
		}

		/**
		 * Add the meta box on the single order page
		 */
		public function add_box() {
			add_meta_box( 'woocommerce-delivery-notes-box', __( 'Order Printing', 'woocommerce-delivery-notes' ), array( $this, 'create_box_content' ), 'shop_order', 'side', 'low' );
		}

		/**
		 * Create the meta box content on the single order page
		 */
		public function create_box_content() {
			global $post_id, $wcdn;
			?>
			<div class="print-actions">
				<?php
				$value = get_post_meta($post_id,'invoice',true);
				//var_dump($value);
				$posts = get_post($post_id);
				$post = get_post($value);
				$values = $post->post_name;
				$status = $posts->post_status;
				//var_dump($post->guid);
				if($value)
				{
					echo "Invoice #".$value." (".$values.")<br/>"."<a href='".$post->guid."' class='button print-preview-button' target='_blank' alt='Print Invoice'>Print Invoice</a>";
					if($status=="wc-invoicecreated")
					{
						echo "<br /><a href='post.php?post=$post_id&action=edit&inv=deleteinv&invoice=$value' class='button' style='background-color:#aa4444;color:#fff;border-color:#aa4466' >Delete Invoice</a>";
					}
					if($status=="wc-paymentcomplete" || $status=="wc-processing" || $status=="wc-readypickup" || $status=="wc-completed")
					{
						echo "<br/><a href='".str_replace("invoice","receipt",$post->guid)."' class='button print-preview-button' target='_blank' alt='Print Receipt'>Print Receipt</a>";
					}
				}
				else
				{
					echo "invoice not found";
				}

				?>
				<span class="print-preview-loading spinner"></span>
			</div>
			<?php 
			$create_invoice_number = get_option( WooCommerce_Delivery_Notes::$plugin_prefix . 'create_invoice_number' );
			$has_invoice_number = get_post_meta( $post_id, '_' . WooCommerce_Delivery_Notes::$plugin_prefix . 'invoice_number', true );
			if( !empty( $create_invoice_number ) && $has_invoice_number ) : 
				$invoice_number = wcdn_get_order_invoice_number( $post_id );
				$invoice_date = wcdn_get_order_invoice_date( $post_id ); ?>
				
				<ul class="print-info">
					<li><strong><?php _e( 'Invoice number: ', 'woocommerce-delivery-notes' ); ?></strong> <?php echo $invoice_number; ?></li>
					<li><strong><?php _e( 'Invoice date: ', 'woocommerce-delivery-notes' ); ?></strong> <?php echo $invoice_date; ?></li>
				</ul>
				
			<?php endif; ?>
			<?php
		}
		
	}
	
}

?>