<?php
/**
 * Order Data
 *
 * Functions for displaying the order data meta box.
 *
 * @author 		WooThemes
 * @category 	Admin
 * @package 	WooCommerce/Admin/Meta Boxes
 * @version     2.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * WC_Meta_Box_Order_Data Class.
 */
class WC_Meta_Box_Order_Data {

	/**
	 * Billing fields.
	 *
	 * @var array
	 */
	protected static $billing_fields = array();

	/**
	 * Shipping fields.
	 *
	 * @var array
	 */
	protected static $shipping_fields = array();

	/**
	 * Init billing and shipping fields we display + save.
	 */
	public static function init_address_fields() {

		self::$billing_fields = apply_filters( 'woocommerce_admin_billing_fields', array(
			'first_name' => array(
				'label' => __( 'First Name', 'woocommerce' ),
				'show'  => false
			),
			'last_name' => array(
				'label' => __( 'Last Name', 'woocommerce' ),
				'show'  => false
			),
			'company' => array(
				'label' => __( 'Company', 'woocommerce' ),
				'show'  => false
			),
			'address_1' => array(
				'label' => __( 'Address 1', 'woocommerce' ),
				'show'  => false
			),
			'address_2' => array(
				'label' => __( 'Address 2', 'woocommerce' ),
				'show'  => false
			),
			'city' => array(
				'label' => __( 'City', 'woocommerce' ),
				'show'  => false
			),
			'postcode' => array(
				'label' => __( 'Postcode', 'woocommerce' ),
				'show'  => false
			),
			'country' => array(
				'label'   => __( 'Country', 'woocommerce' ),
				'show'    => false,
				'class'   => 'js_field-country select short',
				'type'    => 'select',
				'options' => array( '' => __( 'Select a country&hellip;', 'woocommerce' ) ) + WC()->countries->get_allowed_countries()
			),
			'state' => array(
				'label' => __( 'State/County', 'woocommerce' ),
				'class'   => 'js_field-state select short',
				'show'  => false
			),
			'email' => array(
				'label' => __( 'Email', 'woocommerce' ),
			),
			'phone' => array(
				'label' => __( 'Phone', 'woocommerce' ),
			),
		) );

		self::$shipping_fields = apply_filters( 'woocommerce_admin_shipping_fields', array(
			'first_name' => array(
				'label' => __( 'First Name', 'woocommerce' ),
				'show'  => false
			),
			'last_name' => array(
				'label' => __( 'Last Name', 'woocommerce' ),
				'show'  => false
			),
			'company' => array(
				'label' => __( 'Company', 'woocommerce' ),
				'show'  => false
			),
			'address_1' => array(
				'label' => __( 'Address 1', 'woocommerce' ),
				'show'  => false
			),
			'address_2' => array(
				'label' => __( 'Address 2', 'woocommerce' ),
				'show'  => false
			),
			'city' => array(
				'label' => __( 'City', 'woocommerce' ),
				'show'  => false
			),
			'postcode' => array(
				'label' => __( 'Postcode', 'woocommerce' ),
				'show'  => false
			),
			'country' => array(
				'label'   => __( 'Country', 'woocommerce' ),
				'show'    => false,
				'type'    => 'select',
				'class'   => 'js_field-country select short',
				'options' => array( '' => __( 'Select a country&hellip;', 'woocommerce' ) ) + WC()->countries->get_shipping_countries()
			),
			'state' => array(
				'label' => __( 'State/County', 'woocommerce' ),
				'class'   => 'js_field-state select short',
				'show'  => false
			),
		) );
	}

	/**
	 * Output the metabox.
	 *
	 * @param WP_Post $post
	 */
	public static function output( $post ) {
		global $theorder;

		if ( ! is_object( $theorder ) ) {
			$theorder = wc_get_order( $post->ID );
		}

		$order = $theorder;

		self::init_address_fields();

		if ( WC()->payment_gateways() ) {
			$payment_gateways = WC()->payment_gateways->payment_gateways();
		} else {
			$payment_gateways = array();
		}

		$payment_method = ! empty( $order->payment_method ) ? $order->payment_method : '';

		$order_type_object = get_post_type_object( $post->post_type );
		wp_nonce_field( 'woocommerce_save_data', 'woocommerce_meta_nonce' );
		?>
		<style type="text/css">
			#post-body-content, #titlediv { display:none }
		</style>
		<div class="panel-wrap woocommerce">
			<input name="post_title" type="hidden" value="<?php echo empty( $post->post_title ) ? __( 'Order', 'woocommerce' ) : esc_attr( $post->post_title ); ?>" />
			<input name="post_status" type="hidden" value="<?php echo esc_attr( $post->post_status ); ?>" />
			<div id="order_data" class="panel">

				<h2><?php echo esc_html( sprintf( _x( '%s #%s details', 'Order #123 details', 'woocommerce' ), $order_type_object->labels->singular_name, $order->get_order_number() ) ); ?></h2>
				<p class="order_number"><?php

					if ( $payment_method ) {
						printf( __( 'Payment via %s', 'woocommerce' ), ( isset( $payment_gateways[ $payment_method ] ) ? esc_html( $payment_gateways[ $payment_method ]->get_title() ) : esc_html( $payment_method ) ) );

						if ( $transaction_id = $order->get_transaction_id() ) {
								if ( isset( $payment_gateways[ $payment_method ] ) && ( $url = $payment_gateways[ $payment_method ]->get_transaction_url( $order ) ) ) {
								echo ' (<a href="' . esc_url( $url ) . '" target="_blank">' . esc_html( $transaction_id ) . '</a>)';
							} else {
								echo ' (' . esc_html( $transaction_id ) . ')';
							}
						}

						if ( $order->paid_date ) {
							printf( ' ' . _x( 'on %s @ %s', 'on date at time', 'woocommerce' ), date_i18n( get_option( 'date_format' ), strtotime( $order->paid_date ) ), date_i18n( get_option( 'time_format' ), strtotime( $order->paid_date ) ) );
						}

						echo '. ';
					}

					if ( $ip_address = get_post_meta( $post->ID, '_customer_ip_address', true ) ) {
						echo __( 'Customer IP', 'woocommerce' ) . ': <span class="woocommerce-Order-customerIP">' . esc_html( $ip_address ) . '</span>';
					}
				?></p>

				<div class="order_data_column_container">
					<div class="order_data_column">
						<h3><?php _e( 'General Details', 'woocommerce' ); ?></h3>

						<p class="form-field form-field-wide"><label for="order_date"><?php _e( 'Order date:', 'woocommerce' ) ?></label>
							<input type="text" class="date-picker" name="order_date" id="order_date" maxlength="10" value="<?php echo date_i18n( 'Y-m-d', strtotime( $post->post_date ) ); ?>" pattern="[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])" />@<input type="number" class="hour" placeholder="<?php esc_attr_e( 'h', 'woocommerce' ) ?>" name="order_date_hour" id="order_date_hour" min="0" max="23" step="1" value="<?php echo date_i18n( 'H', strtotime( $post->post_date ) ); ?>" pattern="([01]?[0-9]{1}|2[0-3]{1})" />:<input type="number" class="minute" placeholder="<?php esc_attr_e( 'm', 'woocommerce' ) ?>" name="order_date_minute" id="order_date_minute" min="0" max="59" step="1" value="<?php echo date_i18n( 'i', strtotime( $post->post_date ) ); ?>" pattern="[0-5]{1}[0-9]{1}" />
						</p>

						<p class="form-field form-field-wide wc-order-status"><label for="order_status"><?php _e( 'Order status:', 'woocommerce' ) ?> <?php
							if ( $order->needs_payment() ) {
								printf( '<a href="%s">%s &rarr;</a>',
									esc_url( $order->get_checkout_payment_url() ),
									__( 'Customer payment page', 'woocommerce' )
								);
							}
								//var_dump($order->get_status());
						?></label>
						<select id="order_status" name="order_status" class="wc-enhanced-select">
							//worrawat
							<?php
								$user = new WP_User(get_current_user_id());
								$statuses = wc_get_order_statuses();
								foreach ( $statuses as $status => $status_name ) {
									if ($user->roles[0]!="shop_manager")
									{
									echo '<option value="' . esc_attr( $status ) . '" ' . selected( $status, 'wc-' . $order->get_status(), false ) . '>' . esc_html( $status_name ) . '</option>';
									}
									else
									{

										if('wc-'.$order->get_status()==$status)
										{
											echo '<option value="' . esc_attr( $status ) . '" ' . selected( $status, 'wc-' . $order->get_status(), false ) . '>' . esc_html( $status_name ) . '</option>';
										}
										else if($status=='wc-'."pending")
										{
											echo '<option value="' . esc_attr( $status ) . '" ' . selected( $status, 'wc-' . $order->get_status(), false ) . '>' . esc_html( $status_name ) . '</option>';
										}
									}
								}
							?>
						</select></p>

						<p class="form-field form-field-wide wc-customer-user">
							<label for="customer_user"><?php _e( 'Customer:', 'woocommerce' ) ?> <?php

								if ( ! empty( $order->customer_user ) ) {
									$args = array( 'post_status' => 'all',
										'post_type'      => 'shop_order',
										'_customer_user' => absint( $order->customer_user )
									);
									printf( '<a href="%s">%s &rarr;</a>',
										esc_url( add_query_arg( $args, admin_url( 'edit.php' ) ) ),
										__( 'View other orders', 'woocommerce' )
									);
								}

							?></label>
							<?php
							$user_string = '';
							$user_id     = '';
							if ( ! empty( $order->customer_user ) ) {
								$user_id     = absint( $order->customer_user );
								$user        = get_user_by( 'id', $user_id );
								$user_string = esc_html( $user->display_name ) . ' (#' . absint( $user->ID ) . ' &ndash; ' . esc_html( $user->user_email ) . ')';
							}
							//var_dump($user_string);
							?>
							<input type="hidden" class="wc-customer-search" id="customer_user" name="customer_user" data-placeholder="<?php esc_attr_e( 'Guest', 'woocommerce' ); ?>" data-selected="<?php echo htmlspecialchars( $user_string ); ?>" value="<?php echo $user_id; ?>" data-allow_clear="true" />
						</p>
						<?php do_action( 'woocommerce_admin_order_data_after_order_details', $order ); ?>
					</div>
					<div class="order_data_column">
						<h3>
							<?php _e( 'Billing Details', 'woocommerce' ); ?>
							<a href="#" class="edit_address"><?php _e( 'Edit', 'woocommerce' ); ?></a>
							<a href="#" class="tips load_customer_billing" data-tip="<?php esc_attr_e( 'Load billing address', 'woocommerce' ); ?>" style="display:none;"><?php _e( 'Load billing address', 'woocommerce' ); ?></a>
						</h3>
						<?php
							// Display values
							echo '<div class="address">';

								if ( $order->get_formatted_billing_address() ) {
									echo '<p><strong>' . __( 'Address', 'woocommerce' ) . ':</strong>' . wp_kses( $order->get_formatted_billing_address(), array( 'br' => array() ) ) . '</p>';
								} else {
									echo '<p class="none_set"><strong>' . __( 'Address', 'woocommerce' ) . ':</strong> ' . __( 'No billing address set.', 'woocommerce' ) . '</p>';
								}

								foreach ( self::$billing_fields as $key => $field ) {
									if ( isset( $field['show'] ) && false === $field['show'] ) {
										continue;
									}

									$field_name = 'billing_' . $key;

									if ( $order->$field_name ) {
										echo '<p><strong>' . esc_html( $field['label'] ) . ':</strong> ' . make_clickable( esc_html( $order->$field_name ) ) . '</p>';
									}
								}

							echo '</div>';

							// Display form
							echo '<div class="edit_address">';

							foreach ( self::$billing_fields as $key => $field ) {
								if ( ! isset( $field['type'] ) ) {
									$field['type'] = 'text';
								}
								if ( ! isset( $field['id'] ) ){
									$field['id'] = '_billing_' . $key;
								}
								switch ( $field['type'] ) {
									case 'select' :
										woocommerce_wp_select( $field );
									break;
									default :
										woocommerce_wp_text_input( $field );
									break;
								}
							}
							?>
							<p class="form-field form-field-wide">
								<label><?php _e( 'Payment Method:', 'woocommerce' ); ?></label>
								<select name="_payment_method" id="_payment_method" class="first">
									<option value=""><?php _e( 'N/A', 'woocommerce' ); ?></option>
									<?php
										$found_method 	= false;

										foreach ( $payment_gateways as $gateway ) {
											if ( $gateway->enabled == "yes" ) {
												echo '<option value="' . esc_attr( $gateway->id ) . '" ' . selected( $payment_method, $gateway->id, false ) . '>' . esc_html( $gateway->get_title() ) . '</option>';
												if ( $payment_method == $gateway->id ) {
													$found_method = true;
												}
											}
										}

										if ( ! $found_method && ! empty( $payment_method ) ) {
											echo '<option value="' . esc_attr( $payment_method ) . '" selected="selected">' . __( 'Other', 'woocommerce' ) . '</option>';
										} else {
											echo '<option value="other">' . __( 'Other', 'woocommerce' ) . '</option>';
										}
									?>
								</select>
							</p>
							<?php

							woocommerce_wp_text_input( array( 'id' => '_transaction_id', 'label' => __( 'Transaction ID', 'woocommerce' ) ) );

							echo '</div>';

							do_action( 'woocommerce_admin_order_data_after_billing_address', $order );
						?>
					</div>
					<div class="order_data_column">

						<h3>
							<?php _e( 'Shipping Details', 'woocommerce' ); ?>
							<a href="#" class="edit_address"><?php _e( 'Edit', 'woocommerce' ); ?></a>
							<a href="#" class="tips billing-same-as-shipping" data-tip="<?php esc_attr_e( 'Copy from billing', 'woocommerce' ); ?>" style="display:none;"><?php _e( 'Copy from billing', 'woocommerce' ); ?></a>
							<a href="#" class="tips load_customer_shipping" data-tip="<?php esc_attr_e( 'Load shipping address', 'woocommerce' ); ?>" style="display:none;"><?php _e( 'Load shipping address', 'woocommerce' ); ?></a>
						</h3>
						<?php
							// Display values
							echo '<div class="address">';

								if ( $order->get_formatted_shipping_address() ) {
									echo '<p><strong>' . __( 'Address', 'woocommerce' ) . ':</strong>' . wp_kses( $order->get_formatted_shipping_address(), array( 'br' => array() ) ) . '</p>';
								} else {
									echo '<p class="none_set"><strong>' . __( 'Address', 'woocommerce' ) . ':</strong> ' . __( 'No shipping address set.', 'woocommerce' ) . '</p>';
								}

								if ( ! empty( self::$shipping_fields ) ) {
									foreach ( self::$shipping_fields as $key => $field ) {
										if ( isset( $field['show'] ) && false === $field['show'] ) {
											continue;
										}

										$field_name = 'shipping_' . $key;

										if ( ! empty( $order->$field_name ) ) {
											echo '<p><strong>' . esc_html( $field['label'] ) . ':</strong> ' . make_clickable( esc_html( $order->$field_name ) ) . '</p>';
										}
									}
								}

								if ( apply_filters( 'woocommerce_enable_order_notes_field', 'yes' == get_option( 'woocommerce_enable_order_comments', 'yes' ) ) && $post->post_excerpt ) {
									echo '<p><strong>' . __( 'Customer Provided Note', 'woocommerce' ) . ':</strong> ' . nl2br( esc_html( $post->post_excerpt ) ) . '</p>';
								}

							echo '</div>';

							// Display form
							echo '<div class="edit_address">';

							if ( ! empty( self::$shipping_fields ) ) {
								foreach ( self::$shipping_fields as $key => $field ) {
									if ( ! isset( $field['type'] ) ) {
										$field['type'] = 'text';
									}
									if ( ! isset( $field['id'] ) ){
										$field['id'] = '_shipping_' . $key;
									}

									switch ( $field['type'] ) {
										case 'select' :
											woocommerce_wp_select( $field );
										break;
										default :
											woocommerce_wp_text_input( $field );
										break;
									}
								}
							}

							if ( apply_filters( 'woocommerce_enable_order_notes_field', 'yes' == get_option( 'woocommerce_enable_order_comments', 'yes' ) ) ) {
								?>
								<p class="form-field form-field-wide"><label for="excerpt"><?php _e( 'Customer Provided Note', 'woocommerce' ) ?>:</label>
								<textarea rows="1" cols="40" name="excerpt" tabindex="6" id="excerpt" placeholder="<?php esc_attr_e( 'Customer\'s notes about the order', 'woocommerce' ); ?>"><?php echo wp_kses_post( $post->post_excerpt ); ?></textarea></p>
								<?php
							}

							echo '</div>';

							do_action( 'woocommerce_admin_order_data_after_shipping_address', $order );
						?>
					</div>
				</div>
				<div class="clear"></div>
			</div>
		</div>
		<?php
	}

	/**
	 * Save meta box data.
	 *
	 * @param int $post_id
	 * @param WP_Post $post
	 */
	public static function save( $post_id, $post ) {
		global $wpdb;

		self::init_address_fields();

		// Ensure gateways are loaded in case they need to insert data into the emails
		WC()->payment_gateways();
		WC()->shipping();

		$customer_changed = false;

		// Add key
		add_post_meta( $post_id, '_order_key', uniqid( 'order_' ), true );

		// Update meta
		if ( update_post_meta( $post_id, '_customer_user', absint( $_POST['customer_user'] ) ) ) {
			$customer_changed = true;
		}

		if ( ! empty( self::$billing_fields ) ) {
			foreach ( self::$billing_fields as $key => $field ) {
				if ( ! isset( $field['id'] ) ){
					$field['id'] = '_billing_' . $key;
				}
				if ( update_post_meta( $post_id, $field['id'], wc_clean( $_POST[ $field['id'] ] ) ) ) {
					$customer_changed = true;
				}
			}
		}

		if ( ! empty( self::$shipping_fields ) ) {
			foreach ( self::$shipping_fields as $key => $field ) {
				if ( ! isset( $field['id'] ) ){
					$field['id'] = '_shipping_' . $key;
				}
				if ( update_post_meta( $post_id, $field['id'], wc_clean( $_POST[ $field['id'] ] ) ) ) {
					$customer_changed = true;
				}
			}
		}

		if ( isset( $_POST['_transaction_id'] ) ) {
			update_post_meta( $post_id, '_transaction_id', wc_clean( $_POST[ '_transaction_id' ] ) );
		}

		// Payment method handling
		if ( get_post_meta( $post_id, '_payment_method', true ) !== stripslashes( $_POST['_payment_method'] ) ) {

			$methods              = WC()->payment_gateways->payment_gateways();
			$payment_method       = wc_clean( $_POST['_payment_method'] );
			$payment_method_title = $payment_method;

			if ( isset( $methods) && isset( $methods[ $payment_method ] ) ) {
				$payment_method_title = $methods[ $payment_method ]->get_title();
			}

			update_post_meta( $post_id, '_payment_method', $payment_method );
			update_post_meta( $post_id, '_payment_method_title', $payment_method_title );
		}

		// Update date
		if ( empty( $_POST['order_date'] ) ) {
			$date = current_time('timestamp');
		} else {
			$date = strtotime( $_POST['order_date'] . ' ' . (int) $_POST['order_date_hour'] . ':' . (int) $_POST['order_date_minute'] . ':00' );
		}

		$date = date_i18n( 'Y-m-d H:i:s', $date );

		$wpdb->query( $wpdb->prepare( "UPDATE $wpdb->posts SET post_date = %s, post_date_gmt = %s WHERE ID = %s", $date, get_gmt_from_date( $date ), $post_id ) );

		clean_post_cache( $post_id );

		// If customer changed, update any downloadable permissions
		if ( $customer_changed ) {
			$wpdb->update( $wpdb->prefix . "woocommerce_downloadable_product_permissions",
				array(
					'user_id'    => absint( get_post_meta( $post->ID, '_customer_user', true ) ),
					'user_email' => wc_clean( get_post_meta( $post->ID, '_billing_email', true ) ),
				),
				array(
					'order_id' 		=> $post_id,
				),
				array(
					'%d',
					'%s',
				),
				array(
					'%d',
				)
			);
		}

		// Order data saved, now get it so we can manipulate status
		$order = wc_get_order( $post_id );

		// Order status
		$order->update_status( $_POST['order_status'], '', true );

		wc_delete_shop_order_transients( $post_id );
	}
}
