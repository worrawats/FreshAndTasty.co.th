<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * WooCommerce cart
 *
 * The WooCommerce cart class stores cart data and active coupons as well as handling customer sessions and some cart related urls.
 * The cart class also has a price calculation function which calls upon other classes to calculate totals.
 *
 * @class 		WC_Cart
 * @version		2.1.0
 * @package		WooCommerce/Classes
 * @category	Class
 * @author 		WooThemes
 */
class WC_Cart {

	/** @var array Contains an array of cart items. */
	public $cart_contents = array();

	/** @var array Contains an array of removed cart items. */
	public $removed_cart_contents = array();

	/** @var array Contains an array of coupon codes applied to the cart. */
	public $applied_coupons = array();

	/** @var array Contains an array of coupon code discounts after they have been applied. */
	public $coupon_discount_amounts = array();

	/** @var array Contains an array of coupon code discount taxes. Used for tax incl pricing. */
	public $coupon_discount_tax_amounts = array();

	/** @var array Contains an array of coupon usage counts after they have been applied. */
	public $coupon_applied_count = array();

	/** @var array Array of coupons */
	public $coupons = array();

	/** @var float The total cost of the cart items. */
	public $cart_contents_total;

	/** @var float Cart grand total. */
	public $total;

	/** @var float Cart subtotal. */
	public $subtotal;

	/** @var float Cart subtotal without tax. */
	public $subtotal_ex_tax;

	/** @var float Total cart tax. */
	public $tax_total;

	/** @var array An array of taxes/tax rates for the cart. */
	public $taxes;

	/** @var array An array of taxes/tax rates for the shipping. */
	public $shipping_taxes;

	/** @var float Discount amount before tax */
	public $discount_cart;

	/** @var float Discounted tax amount. Used predominantly for displaying tax inclusive prices correctly */
	public $discount_cart_tax;

	/** @var float Total for additional fees. */
	public $fee_total;

	/** @var float Shipping cost. */
	public $shipping_total;

	/** @var float Shipping tax. */
	public $shipping_tax_total;

	/** @var array cart_session_data. Array of data the cart calculates and stores in the session with defaults */
	public $cart_session_data = array(
		'cart_contents_total'         => 0,
		'total'                       => 0,
		'subtotal'                    => 0,
		'subtotal_ex_tax'             => 0,
		'tax_total'                   => 0,
		'taxes'                       => array(),
		'shipping_taxes'              => array(),
		'discount_cart'               => 0,
		'discount_cart_tax'           => 0,
		'shipping_total'              => 0,
		'shipping_tax_total'          => 0,
		'coupon_discount_amounts'     => array(),
		'coupon_discount_tax_amounts' => array(),
		'fee_total'                   => 0,
		'fees'                        => array()
	);

	/**
	 * An array of fees.
	 *
	 * @var array
	 */
	public $fees = array();

	/**
	 * Constructor for the cart class. Loads options and hooks in the init method.
	 */
	public function __construct() {
		add_action( 'wp_loaded', array( $this, 'init' ) ); // Get cart after WP and plugins are loaded.
		add_action( 'wp', array( $this, 'maybe_set_cart_cookies' ), 99 ); // Set cookies
		add_action( 'shutdown', array( $this, 'maybe_set_cart_cookies' ), 0 ); // Set cookies before shutdown and ob flushing
		add_action( 'woocommerce_add_to_cart', array( $this, 'calculate_totals' ), 20, 0 );
		add_action( 'woocommerce_applied_coupon', array( $this, 'calculate_totals' ), 20, 0 );
	}

	/**
	 * Auto-load in-accessible properties on demand.
	 *
	 * @param mixed $key
	 * @return mixed
	 */
	public function __get( $key ) {
		switch ( $key ) {
			case 'prices_include_tax' :
				return wc_prices_include_tax();
			break;
			case 'round_at_subtotal' :
				return 'yes' === get_option( 'woocommerce_tax_round_at_subtotal' );
			break;
			case 'tax_display_cart' :
				return get_option( 'woocommerce_tax_display_cart' );
			break;
			case 'dp' :
				return wc_get_price_decimals();
			break;
			case 'display_totals_ex_tax' :
			case 'display_cart_ex_tax' :
				return $this->tax_display_cart === 'excl';
			break;
			case 'cart_contents_weight' :
				return $this->get_cart_contents_weight();
			break;
			case 'cart_contents_count' :
				return $this->get_cart_contents_count();
			break;
			case 'tax' :
				_deprecated_argument( 'WC_Cart->tax', '2.3', 'Use WC_Tax:: directly' );
				$this->tax = new WC_Tax();
			return $this->tax;
			case 'discount_total':
				_deprecated_argument( 'WC_Cart->discount_total', '2.3', 'After tax coupons are no longer supported. For more information see: https://woocommerce.wordpress.com/2014/12/upcoming-coupon-changes-in-woocommerce-2-3/' );
			return 0;
		}
	}

	/**
	 * Loads the cart data from the PHP session during WordPress init and hooks in other methods.
	 */
	public function init() {
		$this->get_cart_from_session();

		add_action( 'woocommerce_check_cart_items', array( $this, 'check_cart_items' ), 1 );
		add_action( 'woocommerce_check_cart_items', array( $this, 'check_cart_coupons' ), 1 );
		add_action( 'woocommerce_after_checkout_validation', array( $this, 'check_customer_coupons' ), 1 );
	}

	/**
	 * Will set cart cookies if needed, once, during WP hook.
	 */
	public function maybe_set_cart_cookies() {
		if ( ! headers_sent() && did_action( 'wp_loaded' ) ) {
			if ( ! $this->is_empty() ) {
				$this->set_cart_cookies( true );
			} elseif ( isset( $_COOKIE['woocommerce_items_in_cart'] ) ) {
				$this->set_cart_cookies( false );
			}
		}
	}

	/**
	 * Set cart hash cookie and items in cart.
	 *
	 * @access private
	 * @param bool $set (default: true)
	 */
	private function set_cart_cookies( $set = true ) {
		if ( $set ) {
			wc_setcookie( 'woocommerce_items_in_cart', 1 );
			wc_setcookie( 'woocommerce_cart_hash', md5( json_encode( $this->get_cart_for_session() ) ) );
		} elseif ( isset( $_COOKIE['woocommerce_items_in_cart'] ) ) {
			wc_setcookie( 'woocommerce_items_in_cart', 0, time() - HOUR_IN_SECONDS );
			wc_setcookie( 'woocommerce_cart_hash', '', time() - HOUR_IN_SECONDS );
		}
		do_action( 'woocommerce_set_cart_cookies', $set );
	}

	/*-----------------------------------------------------------------------------------*/
	/* Cart Session Handling */
	/*-----------------------------------------------------------------------------------*/

		/**
		 * Get the cart data from the PHP session and store it in class variables.
		 */
		public function get_cart_from_session() {
			// Load cart session data from session
			foreach ( $this->cart_session_data as $key => $default ) {
				$this->$key = WC()->session->get( $key, $default );
			}

			$update_cart_session         = false;
			$this->removed_cart_contents = array_filter( WC()->session->get( 'removed_cart_contents', array() ) );
			$this->applied_coupons       = array_filter( WC()->session->get( 'applied_coupons', array() ) );

			/**
			 * Load the cart object. This defaults to the persistent cart if null.
			 */
			$cart = WC()->session->get( 'cart', null );

			if ( is_null( $cart ) && ( $saved_cart = get_user_meta( get_current_user_id(), '_woocommerce_persistent_cart', true ) ) ) {
				$cart                = $saved_cart['cart'];
				$update_cart_session = true;
			} elseif ( is_null( $cart ) ) {
				$cart = array();
			}

			if ( is_array( $cart ) ) {
				// Prime meta cache to reduce future queries
				update_meta_cache( 'post', wp_list_pluck( $cart, 'product_id' ) );

				foreach ( $cart as $key => $values ) {
					$_product = wc_get_product( $values['variation_id'] ? $values['variation_id'] : $values['product_id'] );

					if ( ! empty( $_product ) && $_product->exists() && $values['quantity'] > 0 ) {

						if ( ! $_product->is_purchasable() ) {

							// Flag to indicate the stored cart should be update
							$update_cart_session = true;
							wc_add_notice( sprintf( __( '%s has been removed from your cart because it can no longer be purchased. Please contact us if you need assistance.', 'woocommerce' ), $_product->get_title() ), 'error' );
							do_action( 'woocommerce_remove_cart_item_from_session', $key, $values );

						} else {

							// Put session data into array. Run through filter so other plugins can load their own session data
							$session_data = array_merge( $values, array( 'data' => $_product ) );
							$this->cart_contents[ $key ] = apply_filters( 'woocommerce_get_cart_item_from_session', $session_data, $values, $key );

						}
					}
				}
			}

			// Trigger action
			do_action( 'woocommerce_cart_loaded_from_session', $this );

			if ( $update_cart_session ) {
				WC()->session->cart = $this->get_cart_for_session();
			}

			// Queue re-calc if subtotal is not set
			if ( ( ! $this->subtotal && ! $this->is_empty() ) || $update_cart_session ) {
				$this->calculate_totals();
			}
		}

		/**
		 * Sets the php session data for the cart and coupons.
		 */
		public function set_session() {
			// Set cart and coupon session data
			$cart_session = $this->get_cart_for_session();

			WC()->session->set( 'cart', $cart_session );
			WC()->session->set( 'applied_coupons', $this->applied_coupons );
			WC()->session->set( 'coupon_discount_amounts', $this->coupon_discount_amounts );
			WC()->session->set( 'coupon_discount_tax_amounts', $this->coupon_discount_tax_amounts );
			WC()->session->set( 'removed_cart_contents', $this->removed_cart_contents );

			foreach ( $this->cart_session_data as $key => $default ) {
				WC()->session->set( $key, $this->$key );
			}

			if ( get_current_user_id() ) {
				$this->persistent_cart_update();
			}

			do_action( 'woocommerce_cart_updated' );
		}

		/**
		 * Empties the cart and optionally the persistent cart too.
		 *
		 * @param bool $clear_persistent_cart (default: true)
		 */
		public function empty_cart( $clear_persistent_cart = true ) {
			$this->cart_contents = array();
			$this->reset( true );

			unset( WC()->session->order_awaiting_payment, WC()->session->applied_coupons, WC()->session->coupon_discount_amounts, WC()->session->coupon_discount_tax_amounts, WC()->session->cart );

			if ( $clear_persistent_cart && get_current_user_id() ) {
				$this->persistent_cart_destroy();
			}

			do_action( 'woocommerce_cart_emptied' );
		}

	/*-----------------------------------------------------------------------------------*/
	/* Persistent cart handling */
	/*-----------------------------------------------------------------------------------*/

		/**
		 * Save the persistent cart when the cart is updated.
		 */
		public function persistent_cart_update() {
			update_user_meta( get_current_user_id(), '_woocommerce_persistent_cart', array(
				'cart' => WC()->session->get( 'cart' )
			) );
		}

		/**
		 * Delete the persistent cart permanently.
		 */
		public function persistent_cart_destroy() {
			delete_user_meta( get_current_user_id(), '_woocommerce_persistent_cart' );
		}

	/*-----------------------------------------------------------------------------------*/
	/* Cart Data Functions */
	/*-----------------------------------------------------------------------------------*/

		/**
		 * Coupons enabled function. Filterable.
		 *
		 * @deprecated 2.5.0 in favor to wc_coupons_enabled()
		 *
		 * @return bool
		 */
		public function coupons_enabled() {
			return wc_coupons_enabled();
		}

		/**
		 * Get number of items in the cart.
		 * @return int
		 */
		public function get_cart_contents_count() {
			return apply_filters( 'woocommerce_cart_contents_count', array_sum( wp_list_pluck( $this->get_cart(), 'quantity' ) ) );
		}

		/**
		 * Get weight of items in the cart.
		 * @since 2.5.0
		 * @return int
		 */
		public function get_cart_contents_weight() {
			$weight = 0;

			foreach ( $this->get_cart() as $cart_item_key => $values ) {
				$weight += $values['data']->get_weight() * $values['quantity'];
			}

			return apply_filters( 'woocommerce_cart_contents_weight', $weight );
		}

		/**
		* Checks if the cart is empty.
		*
		* @return bool
		*/
		public function is_empty() {
			return 0 === sizeof( $this->get_cart() );
		}

		/**
		 * Check all cart items for errors.
		 */
		public function check_cart_items() {

			// Result
			$return = true;

			// Check cart item validity
			$result = $this->check_cart_item_validity();

			if ( is_wp_error( $result ) ) {
				wc_add_notice( $result->get_error_message(), 'error' );
				$return = false;
			}

			// Check item stock
			$result = $this->check_cart_item_stock();

			if ( is_wp_error( $result ) ) {
				wc_add_notice( $result->get_error_message(), 'error' );
				$return = false;
			}

			return $return;

		}

		/**
		 * Check cart coupons for errors.
		 */
		public function check_cart_coupons() {
			foreach ( $this->applied_coupons as $code ) {
				$coupon = new WC_Coupon( $code );

				if ( ! $coupon->is_valid() ) {
					// Error message
					$coupon->add_coupon_message( WC_Coupon::E_WC_COUPON_INVALID_REMOVED );

					// Remove the coupon
					$this->remove_coupon( $code );

					// Flag totals for refresh
					WC()->session->set( 'refresh_totals', true );
				}
			}
		}

		/**
		 * Get cart items quantities - merged so we can do accurate stock checks on items across multiple lines.
		 *
		 * @return array
		 */
		public function get_cart_item_quantities() {
			$quantities = array();

			foreach ( $this->get_cart() as $cart_item_key => $values ) {
				$_product = $values['data'];

				if ( $_product->is_type( 'variation' ) && true === $_product->managing_stock() ) {
					// Variation has stock levels defined so its handled individually
					$quantities[ $values['variation_id'] ] = isset( $quantities[ $values['variation_id'] ] ) ? $quantities[ $values['variation_id'] ] + $values['quantity'] : $values['quantity'];
				} else {
					$quantities[ $values['product_id'] ] = isset( $quantities[ $values['product_id'] ] ) ? $quantities[ $values['product_id'] ] + $values['quantity'] : $values['quantity'];
				}
			}

			return $quantities;
		}

		/**
		 * Looks through cart items and checks the posts are not trashed or deleted.
		 *
		 * @return bool|WP_Error
		 */
		public function check_cart_item_validity() {
			$return = true;

			foreach ( $this->get_cart() as $cart_item_key => $values ) {
				$_product = $values['data'];

				if ( ! $_product || ! $_product->exists() || 'trash' === $_product->post->post_status ) {
					$this->set_quantity( $cart_item_key, 0 );
					$return = new WP_Error( 'invalid', __( 'An item which is no longer available was removed from your cart.', 'woocommerce' ) );
				}
			}

			return $return;
		}

		/**
		 * Looks through the cart to check each item is in stock. If not, add an error.
		 *
		 * @return bool|WP_Error
		 */
		public function check_cart_item_stock() {
			global $wpdb;

			$error               = new WP_Error();
			$product_qty_in_cart = $this->get_cart_item_quantities();

			// First stock check loop
			foreach ( $this->get_cart() as $cart_item_key => $values ) {
				$_product = $values['data'];

				/**
				 * Check stock based on stock-status.
				 */
				if ( ! $_product->is_in_stock() ) {
					$error->add( 'out-of-stock', sprintf(__( 'Sorry, "%s" is not in stock. Please edit your cart and try again. We apologise for any inconvenience caused.', 'woocommerce' ), $_product->get_title() ) );
					return $error;
				}

				if ( ! $_product->managing_stock() ) {
					continue;
				}

				$check_qty = $_product->is_type( 'variation' ) && true === $_product->managing_stock() ? $product_qty_in_cart[ $values['variation_id'] ] : $product_qty_in_cart[ $values['product_id'] ];

				/**
				 * Check stock based on all items in the cart.
				 */
				if ( ! $_product->has_enough_stock( $check_qty ) ) {
					$error->add( 'out-of-stock', sprintf(__( 'Sorry, we do not have enough "%s" in stock to fulfill your order (%s in stock). Please edit your cart and try again. We apologise for any inconvenience caused.', 'woocommerce' ), $_product->get_title(), $_product->get_stock_quantity() ) );
					return $error;
				}

				/**
				 * Finally consider any held stock, from pending orders.
				 */
				if ( get_option( 'woocommerce_hold_stock_minutes' ) > 0 && ! $_product->backorders_allowed() ) {
					$order_id   = isset( WC()->session->order_awaiting_payment ) ? absint( WC()->session->order_awaiting_payment ) : 0;
					$held_stock = $wpdb->get_var(
						$wpdb->prepare( "
							SELECT SUM( order_item_meta.meta_value ) AS held_qty
							FROM {$wpdb->posts} AS posts
							LEFT JOIN {$wpdb->prefix}woocommerce_order_items as order_items ON posts.ID = order_items.order_id
							LEFT JOIN {$wpdb->prefix}woocommerce_order_itemmeta as order_item_meta ON order_items.order_item_id = order_item_meta.order_item_id
							LEFT JOIN {$wpdb->prefix}woocommerce_order_itemmeta as order_item_meta2 ON order_items.order_item_id = order_item_meta2.order_item_id
							WHERE 	order_item_meta.meta_key   = '_qty'
							AND 	order_item_meta2.meta_key  = %s AND order_item_meta2.meta_value  = %d
							AND 	posts.post_type            IN ( '" . implode( "','", wc_get_order_types() ) . "' )
							AND 	posts.post_status          = 'wc-pending'
							AND		posts.ID                   != %d;",
							$_product->is_type( 'variation' ) && true === $_product->managing_stock() ? '_variation_id' : '_product_id',
							$_product->is_type( 'variation' ) && true === $_product->managing_stock() ? $values['variation_id'] : $values['product_id'],
							$order_id
						)
					);

					$not_enough_stock = false;

					if ( $_product->is_type( 'variation' ) && 'parent' === $_product->managing_stock() && $_product->parent->get_stock_quantity() < ( $held_stock + $check_qty ) ) {
						$not_enough_stock = true;
					} elseif ( $_product->get_stock_quantity() < ( $held_stock + $check_qty ) ) {
						$not_enough_stock = true;
					}
					if ( $not_enough_stock ) {
						$error->add( 'out-of-stock', sprintf(__( 'Sorry, we do not have enough "%s" in stock to fulfill your order right now. Please try again in %d minutes or edit your cart and try again. We apologise for any inconvenience caused.', 'woocommerce' ), $_product->get_title(), get_option( 'woocommerce_hold_stock_minutes' ) ) );
						return $error;
					}
				}
			}

			return true;
		}

		/**
		 * Gets and formats a list of cart item data + variations for display on the frontend.
		 *
		 * @param array $cart_item
		 * @param bool $flat (default: false)
		 * @return string
		 */
		public function get_item_data( $cart_item, $flat = false ) {
			$item_data = array();

			// Variation data
			if ( ! empty( $cart_item['data']->variation_id ) && is_array( $cart_item['variation'] ) ) {

				foreach ( $cart_item['variation'] as $name => $value ) {

					if ( '' === $value )
						continue;

					$taxonomy = wc_attribute_taxonomy_name( str_replace( 'attribute_pa_', '', urldecode( $name ) ) );

					// If this is a term slug, get the term's nice name
					if ( taxonomy_exists( $taxonomy ) ) {
						$term = get_term_by( 'slug', $value, $taxonomy );
						if ( ! is_wp_error( $term ) && $term && $term->name ) {
							$value = $term->name;
						}
						$label = wc_attribute_label( $taxonomy );

					// If this is a custom option slug, get the options name
					} else {
						$value              = apply_filters( 'woocommerce_variation_option_name', $value );
						$product_attributes = $cart_item['data']->get_attributes();
						if ( isset( $product_attributes[ str_replace( 'attribute_', '', $name ) ] ) ) {
							$label = wc_attribute_label( $product_attributes[ str_replace( 'attribute_', '', $name ) ]['name'] );
						} else {
							$label = $name;
						}
					}

					$item_data[] = array(
						'key'   => $label,
						'value' => $value
					);
				}
			}

			// Filter item data to allow 3rd parties to add more to the array
			$item_data = apply_filters( 'woocommerce_get_item_data', $item_data, $cart_item );

			// Format item data ready to display
			foreach ( $item_data as $key => $data ) {
				// Set hidden to true to not display meta on cart.
				if ( ! empty( $data['hidden'] ) ) {
					unset( $item_data[ $key ] );
					continue;
				}
				$item_data[ $key ]['key']     = ! empty( $data['key'] ) ? $data['key'] : $data['name'];
				$item_data[ $key ]['display'] = ! empty( $data['display'] ) ? $data['display'] : $data['value'];
			}

			// Output flat or in list format
			if ( sizeof( $item_data ) > 0 ) {
				ob_start();

				if ( $flat ) {
					foreach ( $item_data as $data ) {
						echo esc_html( $data['key'] ) . ': ' . wp_kses_post( $data['display'] ) . "\n";
					}
				} else {
					wc_get_template( 'cart/cart-item-data.php', array( 'item_data' => $item_data ) );
				}

				return ob_get_clean();
			}

			return '';
		}

		/**
		 * Gets cross sells based on the items in the cart.
		 *
		 * @return array cross_sells (item ids)
		 */
		public function get_cross_sells() {
			$cross_sells = array();
			$in_cart = array();
			if ( ! $this->is_empty() ) {
				foreach ( $this->get_cart() as $cart_item_key => $values ) {
					if ( $values['quantity'] > 0 ) {
						$cross_sells = array_merge( $values['data']->get_cross_sells(), $cross_sells );
						$in_cart[] = $values['product_id'];
					}
				}
			}
			$cross_sells = array_diff( $cross_sells, $in_cart );
			return $cross_sells;
		}

		/**
		 * Gets the url to the cart page.
		 *
		 * @deprecated 2.5.0 in favor to wc_get_cart_url()
		 *
		 * @return string url to page
		 */
		public function get_cart_url() {
			return wc_get_cart_url();
		}

		/**
		 * Gets the url to the checkout page.
		 *
		 * @deprecated 2.5.0 in favor to wc_get_checkout_url()
		 *
		 * @return string url to page
		 */
		public function get_checkout_url() {
			return wc_get_checkout_url();
		}

		/**
		 * Gets the url to remove an item from the cart.
		 *
		 * @param string $cart_item_key contains the id of the cart item
		 * @return string url to page
		 */
		public function get_remove_url( $cart_item_key ) {
			$cart_page_url = wc_get_page_permalink( 'cart' );
			return apply_filters( 'woocommerce_get_remove_url', $cart_page_url ? wp_nonce_url( add_query_arg( 'remove_item', $cart_item_key, $cart_page_url ), 'woocommerce-cart' ) : '' );
		}

		/**
		 * Gets the url to re-add an item into the cart.
		 *
		 * @param  string $cart_item_key
		 * @return string url to page
		 */
		public function get_undo_url( $cart_item_key ) {
			$cart_page_url = wc_get_page_permalink( 'cart' );

			$query_args = array(
				'undo_item' => $cart_item_key,
			);

			return apply_filters( 'woocommerce_get_undo_url', $cart_page_url ? wp_nonce_url( add_query_arg( $query_args, $cart_page_url ), 'woocommerce-cart' ) : '', $cart_item_key );
		}

		/**
		 * Returns the contents of the cart in an array.
		 *
		 * @return array contents of the cart
		 */
		public function get_cart() {
			if ( ! did_action( 'wp_loaded' ) ) {
				_doing_it_wrong( __FUNCTION__, __( 'Get cart should not be called before the wp_loaded action.', 'woocommerce' ), '2.3' );
			}
			if ( ! did_action( 'woocommerce_cart_loaded_from_session' ) ) {
				$this->get_cart_from_session();
			}
			return array_filter( (array) $this->cart_contents );
		}

		/**
		 * Returns the contents of the cart in an array without the 'data' element.
		 *
		 * @return array contents of the cart
		 */
		public function get_cart_for_session() {
			$cart_session = array();

			if ( $this->get_cart() ) {
				foreach ( $this->get_cart() as $key => $values ) {
					$cart_session[ $key ] = $values;
					unset( $cart_session[ $key ]['data'] ); // Unset product object
				}
			}

			return $cart_session;
		}

		/**
		 * Returns a specific item in the cart.
		 *
		 * @param string $item_key Cart item key.
		 * @return array Item data
		 */
		public function get_cart_item( $item_key ) {
			if ( isset( $this->cart_contents[ $item_key ] ) ) {
				return $this->cart_contents[ $item_key ];
			}

			return array();
		}

		/**
		 * Returns the cart and shipping taxes, merged.
		 *
		 * @return array merged taxes
		 */
		public function get_taxes() {
			$taxes = array();

			// Merge
			foreach ( array_keys( $this->taxes + $this->shipping_taxes ) as $key ) {
				$taxes[ $key ] = ( isset( $this->shipping_taxes[ $key ] ) ? $this->shipping_taxes[ $key ] : 0 ) + ( isset( $this->taxes[ $key ] ) ? $this->taxes[ $key ] : 0 );
			}

			return apply_filters( 'woocommerce_cart_get_taxes', $taxes, $this );
		}

		/**
		 * Get taxes, merged by code, formatted ready for output.
		 *
		 * @return array
		 */
		public function get_tax_totals() {
			$taxes      = $this->get_taxes();
			$tax_totals = array();

			foreach ( $taxes as $key => $tax ) {
				$code = WC_Tax::get_rate_code( $key );

				if ( $code || $key === apply_filters( 'woocommerce_cart_remove_taxes_zero_rate_id', 'zero-rated' ) ) {
					if ( ! isset( $tax_totals[ $code ] ) ) {
						$tax_totals[ $code ] = new stdClass();
						$tax_totals[ $code ]->amount = 0;
					}
					$tax_totals[ $code ]->tax_rate_id       = $key;
					$tax_totals[ $code ]->is_compound       = WC_Tax::is_compound( $key );
					$tax_totals[ $code ]->label             = WC_Tax::get_rate_label( $key );
					$tax_totals[ $code ]->amount           += wc_round_tax_total( $tax );
					$tax_totals[ $code ]->formatted_amount  = wc_price( wc_round_tax_total( $tax_totals[ $code ]->amount ) );
				}
			}

			if ( apply_filters( 'woocommerce_cart_hide_zero_taxes', true ) ) {
				$amounts    = array_filter( wp_list_pluck( $tax_totals, 'amount' ) );
				$tax_totals = array_intersect_key( $tax_totals, $amounts );
			}

			return apply_filters( 'woocommerce_cart_tax_totals', $tax_totals, $this );
		}

		/**
		 * Get all tax classes for items in the cart.
		 * @return array
		 */
		public function get_cart_item_tax_classes() {
			$found_tax_classes = array();

			foreach ( WC()->cart->get_cart() as $item ) {
				$found_tax_classes[] = $item['data']->get_tax_class();
			}

			return array_unique( $found_tax_classes );
		}

		/**
		 * Determines the value that the customer spent and the subtotal
		 * displayed, used for things like coupon validation.
		 *
		 * Since the coupon lines are displayed based on the TAX DISPLAY value
		 * of cart, this is used to determine the spend.
		 *
		 * If cart totals are shown including tax, use the subtotal.
		 * If cart totals are shown excluding tax, use the subtotal ex tax
		 * (tax is shown after coupons).
		 *
		 * @since 2.6.0
		 * @return string
		 */
		public function get_displayed_subtotal() {
			if ( 'incl' === $this->tax_display_cart ) {
				return wc_format_decimal( $this->subtotal );
			} elseif ( 'excl' === $this->tax_display_cart ) {
				return wc_format_decimal( $this->subtotal_ex_tax );
			}
		}

	/*-----------------------------------------------------------------------------------*/
	/* Add to cart handling */
	/*-----------------------------------------------------------------------------------*/

		/**
		 * Check if product is in the cart and return cart item key.
		 *
		 * Cart item key will be unique based on the item and its properties, such as variations.
		 *
		 * @param mixed id of product to find in the cart
		 * @return string cart item key
		 */
		public function find_product_in_cart( $cart_id = false ) {
			if ( $cart_id !== false ) {
				if ( is_array( $this->cart_contents ) ) {
					foreach ( $this->cart_contents as $cart_item_key => $cart_item ) {
						if ( $cart_item_key == $cart_id ) {
							return $cart_item_key;
						}
					}
				}
			}
			return '';
		}

		/**
		 * Generate a unique ID for the cart item being added.
		 *
		 * @param int $product_id - id of the product the key is being generated for
		 * @param int $variation_id of the product the key is being generated for
		 * @param array $variation data for the cart item
		 * @param array $cart_item_data other cart item data passed which affects this items uniqueness in the cart
		 * @return string cart item key
		 */
		public function generate_cart_id( $product_id, $variation_id = 0, $variation = array(), $cart_item_data = array() ) {
			$id_parts = array( $product_id );

			if ( $variation_id && 0 != $variation_id ) {
				$id_parts[] = $variation_id;
			}

			if ( is_array( $variation ) && ! empty( $variation ) ) {
				$variation_key = '';
				foreach ( $variation as $key => $value ) {
					$variation_key .= trim( $key ) . trim( $value );
				}
				$id_parts[] = $variation_key;
			}

			if ( is_array( $cart_item_data ) && ! empty( $cart_item_data ) ) {
				$cart_item_data_key = '';
				foreach ( $cart_item_data as $key => $value ) {

					if ( is_array( $value ) ) {
						$value = http_build_query( $value );
					}
					$cart_item_data_key .= trim( $key ) . trim( $value );

				}
				$id_parts[] = $cart_item_data_key;
			}

			return apply_filters( 'woocommerce_cart_id', md5( implode( '_', $id_parts ) ), $product_id, $variation_id, $variation, $cart_item_data );
		}

		/**
		 * Add a product to the cart.
		 *
		 * @param int $product_id contains the id of the product to add to the cart
		 * @param int $quantity contains the quantity of the item to add
		 * @param int $variation_id
		 * @param array $variation attribute values
		 * @param array $cart_item_data extra cart item data we want to pass into the item
		 * @return string|bool $cart_item_key
		 */
		public function add_to_cart( $product_id = 0, $quantity = 1, $variation_id = 0, $variation = array(), $cart_item_data = array() ) {
			// Wrap in try catch so plugins can throw an exception to prevent adding to cart
			try {
				$product_id   = absint( $product_id );
				$variation_id = absint( $variation_id );

				// Ensure we don't add a variation to the cart directly by variation ID
				if ( 'product_variation' == get_post_type( $product_id ) ) {
					$variation_id = $product_id;
					$product_id   = wp_get_post_parent_id( $variation_id );
				}

				// Get the product
				$product_data = wc_get_product( $variation_id ? $variation_id : $product_id );

				// Sanity check
				if ( $quantity <= 0 || ! $product_data || 'trash' === $product_data->post->post_status  ) {
					throw new Exception();
				}

				// Load cart item data - may be added by other plugins
				$cart_item_data = (array) apply_filters( 'woocommerce_add_cart_item_data', $cart_item_data, $product_id, $variation_id );

				// Generate a ID based on product ID, variation ID, variation data, and other cart item data
				$cart_id        = $this->generate_cart_id( $product_id, $variation_id, $variation, $cart_item_data );

				// Find the cart item key in the existing cart
				$cart_item_key  = $this->find_product_in_cart( $cart_id );

				// Force quantity to 1 if sold individually and check for existing item in cart
				if ( $product_data->is_sold_individually() ) {
					$quantity         = apply_filters( 'woocommerce_add_to_cart_sold_individually_quantity', 1, $quantity, $product_id, $variation_id, $cart_item_data );
					$in_cart_quantity = $cart_item_key ? $this->cart_contents[ $cart_item_key ]['quantity'] : 0;

					if ( $in_cart_quantity > 0 ) {
						throw new Exception( sprintf( '<a href="%s" class="button wc-forward">%s</a> %s', wc_get_cart_url(), __( 'View Cart', 'woocommerce' ), sprintf( __( 'You cannot add another &quot;%s&quot; to your cart.', 'woocommerce' ), $product_data->get_title() ) ) );
					}
				}

				// Check product is_purchasable
				if ( ! $product_data->is_purchasable() ) {
					throw new Exception( __( 'Sorry, this product cannot be purchased.', 'woocommerce' ) );
				}

				// Stock check - only check if we're managing stock and backorders are not allowed
				if ( ! $product_data->is_in_stock() ) {
					throw new Exception( sprintf( __( 'You cannot add &quot;%s&quot; to the cart because the product is out of stock.', 'woocommerce' ), $product_data->get_title() ) );
				}

				if ( ! $product_data->has_enough_stock( $quantity ) ) {
					throw new Exception( sprintf(__( 'You cannot add that amount of &quot;%s&quot; to the cart because there is not enough stock (%s remaining).', 'woocommerce' ), $product_data->get_title(), $product_data->get_stock_quantity() ) );
				}

				// Stock check - this time accounting for whats already in-cart
				if ( $managing_stock = $product_data->managing_stock() ) {
					$products_qty_in_cart = $this->get_cart_item_quantities();

					if ( $product_data->is_type( 'variation' ) && true === $managing_stock ) {
						$check_qty = isset( $products_qty_in_cart[ $variation_id ] ) ? $products_qty_in_cart[ $variation_id ] : 0;
					} else {
						$check_qty = isset( $products_qty_in_cart[ $product_id ] ) ? $products_qty_in_cart[ $product_id ] : 0;
					}

					/**
					 * Check stock based on all items in the cart.
					 */
					if ( ! $product_data->has_enough_stock( $check_qty + $quantity ) ) {
						throw new Exception( sprintf(
							'<a href="%s" class="button wc-forward">%s</a> %s',
							wc_get_cart_url(),
							__( 'View Cart', 'woocommerce' ),
							sprintf( __( 'You cannot add that amount to the cart &mdash; we have %s in stock and you already have %s in your cart.', 'woocommerce' ), $product_data->get_stock_quantity(), $check_qty )
						) );
					}
				}

				// If cart_item_key is set, the item is already in the cart
				if ( $cart_item_key ) {
					$new_quantity = $quantity + $this->cart_contents[ $cart_item_key ]['quantity'];
					$this->set_quantity( $cart_item_key, $new_quantity, false );
				} else {
					$cart_item_key = $cart_id;

					// Add item after merging with $cart_item_data - hook to allow plugins to modify cart item
					$this->cart_contents[ $cart_item_key ] = apply_filters( 'woocommerce_add_cart_item', array_merge( $cart_item_data, array(
						'product_id'	=> $product_id,
						'variation_id'	=> $variation_id,
						'variation' 	=> $variation,
						'quantity' 		=> $quantity,
						'data'			=> $product_data
					) ), $cart_item_key );
				}

				if ( did_action( 'wp' ) ) {
					$this->set_cart_cookies( ! $this->is_empty() );
				}

				do_action( 'woocommerce_add_to_cart', $cart_item_key, $product_id, $quantity, $variation_id, $variation, $cart_item_data );

				return $cart_item_key;

			} catch ( Exception $e ) {
				if ( $e->getMessage() ) {
					wc_add_notice( $e->getMessage(), 'error' );
				}
				return false;
			}
		}

		/**
		 * Remove a cart item.
		 *
		 * @since  2.3.0
		 * @param  string $cart_item_key
		 * @return bool
		 */
		public function remove_cart_item( $cart_item_key ) {
			if ( isset( $this->cart_contents[ $cart_item_key ] ) ) {
				$this->removed_cart_contents[ $cart_item_key ] = $this->cart_contents[ $cart_item_key ];
				unset( $this->removed_cart_contents[ $cart_item_key ]['data'] );

				do_action( 'woocommerce_remove_cart_item', $cart_item_key, $this );

				unset( $this->cart_contents[ $cart_item_key ] );

				do_action( 'woocommerce_cart_item_removed', $cart_item_key, $this );

				$this->calculate_totals();

				return true;
			}

			return false;
		}

		/**
		 * Restore a cart item.
		 *
		 * @param  string $cart_item_key
		 * @return bool
		 */
		public function restore_cart_item( $cart_item_key ) {
			if ( isset( $this->removed_cart_contents[ $cart_item_key ] ) ) {
				$this->cart_contents[ $cart_item_key ] = $this->removed_cart_contents[ $cart_item_key ];
				$this->cart_contents[ $cart_item_key ]['data'] = wc_get_product( $this->cart_contents[ $cart_item_key ]['variation_id'] ? $this->cart_contents[ $cart_item_key ]['variation_id'] : $this->cart_contents[ $cart_item_key ]['product_id'] );

				do_action( 'woocommerce_restore_cart_item', $cart_item_key, $this );

				unset( $this->removed_cart_contents[ $cart_item_key ] );

				do_action( 'woocommerce_cart_item_restored', $cart_item_key, $this );

				$this->calculate_totals();

				return true;
			}

			return false;
		}

		/**
		 * Set the quantity for an item in the cart.
		 *
		 * @param string	$cart_item_key	contains the id of the cart item
		 * @param int		$quantity		contains the quantity of the item
		 * @param bool      $refresh_totals	whether or not to calculate totals after setting the new qty
		 *
		 * @return bool
		 */
		public function set_quantity( $cart_item_key, $quantity = 1, $refresh_totals = true ) {
			if ( $quantity == 0 || $quantity < 0 ) {
				do_action( 'woocommerce_before_cart_item_quantity_zero', $cart_item_key );
				unset( $this->cart_contents[ $cart_item_key ] );
			} else {
				$old_quantity = $this->cart_contents[ $cart_item_key ]['quantity'];
				$this->cart_contents[ $cart_item_key ]['quantity'] = $quantity;
				do_action( 'woocommerce_after_cart_item_quantity_update', $cart_item_key, $quantity, $old_quantity );
			}

			if ( $refresh_totals ) {
				$this->calculate_totals();
			}

			return true;
		}

	/*-----------------------------------------------------------------------------------*/
	/* Cart Calculation Functions */
	/*-----------------------------------------------------------------------------------*/

		/**
		 * Reset cart totals to the defaults. Useful before running calculations.
		 *
		 * @param  bool  	$unset_session If true, the session data will be forced unset.
		 * @access private
		 */
		private function reset( $unset_session = false ) {
			foreach ( $this->cart_session_data as $key => $default ) {
				$this->$key = $default;
				if ( $unset_session ) {
					unset( WC()->session->$key );
				}
			}
			do_action( 'woocommerce_cart_reset', $this, $unset_session );
		}

		/**
		 * Sort by subtotal.
		 * @param  array $a
		 * @param  array $b
		 * @return int
		 */
		private function sort_by_subtotal( $a, $b ) {
			$first_item_subtotal  = isset( $a['line_subtotal'] ) ? $a['line_subtotal'] : 0;
			$second_item_subtotal = isset( $b['line_subtotal'] ) ? $b['line_subtotal'] : 0;
			if ( $first_item_subtotal === $second_item_subtotal ) {
				return 0;
			}
			return ( $first_item_subtotal < $second_item_subtotal ) ? 1 : -1;
		}

		/**
		 * Calculate totals for the items in the cart.
		 */
		public function calculate_totals() {
			$this->reset();
			//$this->add_coupon("agent_order",1,1);
			$this->coupons = $this->get_coupons();

			do_action( 'woocommerce_before_calculate_totals', $this );

			if ( $this->is_empty() ) {
				$this->set_session();
				return;
			}

			$tax_rates      = array();
			$shop_tax_rates = array();
			$cart           = $this->get_cart();

			/**
			 * Calculate subtotals for items. This is done first so that discount logic can use the values.
			 */
			foreach ( $cart as $cart_item_key => $values ) {
				$_product          = $values['data'];
				$line_price        = $_product->get_price() * $values['quantity'];
				$line_subtotal     = 0;
				$line_subtotal_tax = 0;

				/**
				 * No tax to calculate.
				 */
				if ( ! $_product->is_taxable() ) {

					// Subtotal is the undiscounted price
					$this->subtotal += $line_price;
					$this->subtotal_ex_tax += $line_price;

				/**
				 * Prices include tax.
				 *
				 * To prevent rounding issues we need to work with the inclusive price where possible.
				 * otherwise we'll see errors such as when working with a 9.99 inc price, 20% VAT which would.
				 * be 8.325 leading to totals being 1p off.
				 *
				 * Pre tax coupons come off the price the customer thinks they are paying - tax is calculated.
				 * afterwards.
				 *
				 * e.g. $100 bike with $10 coupon = customer pays $90 and tax worked backwards from that.
				 */
				} elseif ( $this->prices_include_tax ) {

					// Get base tax rates
					if ( empty( $shop_tax_rates[ $_product->tax_class ] ) ) {
						$shop_tax_rates[ $_product->tax_class ] = WC_Tax::get_base_tax_rates( $_product->tax_class );
					}

					// Get item tax rates
					if ( empty( $tax_rates[ $_product->get_tax_class() ] ) ) {
						$tax_rates[ $_product->get_tax_class() ] = WC_Tax::get_rates( $_product->get_tax_class() );
					}

					$base_tax_rates = $shop_tax_rates[ $_product->tax_class ];
					$item_tax_rates = $tax_rates[ $_product->get_tax_class() ];

					/**
					 * ADJUST TAX - Calculations when base tax is not equal to the item tax.
					 *
 					 * The woocommerce_adjust_non_base_location_prices filter can stop base taxes being taken off when dealing with out of base locations.
 					 * e.g. If a product costs 10 including tax, all users will pay 10 regardless of location and taxes.
 					 * This feature is experimental @since 2.4.7 and may change in the future. Use at your risk.
 					 */
					if ( $item_tax_rates !== $base_tax_rates && apply_filters( 'woocommerce_adjust_non_base_location_prices', true ) ) {

						// Work out a new base price without the shop's base tax
						$taxes                 = WC_Tax::calc_tax( $line_price, $base_tax_rates, true, true );

						// Now we have a new item price (excluding TAX)
						$line_subtotal         = $line_price - array_sum( $taxes );

						// Now add modified taxes
						$tax_result            = WC_Tax::calc_tax( $line_subtotal, $item_tax_rates );
						$line_subtotal_tax     = array_sum( $tax_result );

					/**
					 * Regular tax calculation (customer inside base and the tax class is unmodified.
					 */
					} else {

						// Calc tax normally
						$taxes                 = WC_Tax::calc_tax( $line_price, $item_tax_rates, true );
						$line_subtotal_tax     = array_sum( $taxes );
						$line_subtotal         = $line_price - array_sum( $taxes );
					}

				/**
				 * Prices exclude tax.
				 *
				 * This calculation is simpler - work with the base, untaxed price.
				 */
				} else {

					// Get item tax rates
					if ( empty( $tax_rates[ $_product->get_tax_class() ] ) ) {
						$tax_rates[ $_product->get_tax_class() ] = WC_Tax::get_rates( $_product->get_tax_class() );
					}

					$item_tax_rates        = $tax_rates[ $_product->get_tax_class() ];

					// Base tax for line before discount - we will store this in the order data
					$taxes                 = WC_Tax::calc_tax( $line_price, $item_tax_rates );
					$line_subtotal_tax     = array_sum( $taxes );

					$line_subtotal         = $line_price;
				}

				// Add to main subtotal
				$this->subtotal        += $line_subtotal + $line_subtotal_tax;
				$this->subtotal_ex_tax += $line_subtotal;
			}

			// Order cart items by price so coupon logic is 'fair' for customers and not based on order added to cart.
			uasort( $cart, array( $this, 'sort_by_subtotal' ) );

			/**
			 * Calculate totals for items.
			 */
			foreach ( $cart as $cart_item_key => $values ) {

				$_product = $values['data'];

				// Prices
				$base_price = $_product->get_price();
				$line_price = $_product->get_price() * $values['quantity'];

				// Tax data
				$taxes = array();
				$discounted_taxes = array();

				/**
				 * No tax to calculate.
				 */
				if ( ! $_product->is_taxable() ) {

					// Discounted Price (price with any pre-tax discounts applied)
					$discounted_price      = $this->get_discounted_price( $values, $base_price, true );
					$line_subtotal_tax     = 0;
					$line_subtotal         = $line_price;
					$line_tax              = 0;
					$line_total            = round( $discounted_price * $values['quantity'], wc_get_rounding_precision() );

				/**
				 * Prices include tax.
				 */
				} elseif ( $this->prices_include_tax ) {

					$base_tax_rates = $shop_tax_rates[ $_product->tax_class ];
					$item_tax_rates = $tax_rates[ $_product->get_tax_class() ];

					/**
					 * ADJUST TAX - Calculations when base tax is not equal to the item tax.
					 *
 					 * The woocommerce_adjust_non_base_location_prices filter can stop base taxes being taken off when dealing with out of base locations.
 					 * e.g. If a product costs 10 including tax, all users will pay 10 regardless of location and taxes.
 					 * This feature is experimental @since 2.4.7 and may change in the future. Use at your risk.
 					 */
					if ( $item_tax_rates !== $base_tax_rates && apply_filters( 'woocommerce_adjust_non_base_location_prices', true ) ) {

						// Work out a new base price without the shop's base tax
						$taxes             = WC_Tax::calc_tax( $line_price, $base_tax_rates, true, true );

						// Now we have a new item price (excluding TAX)
						$line_subtotal     = round( $line_price - array_sum( $taxes ), wc_get_rounding_precision() );
						$taxes             = WC_Tax::calc_tax( $line_subtotal, $item_tax_rates );
						$line_subtotal_tax = array_sum( $taxes );

						// Adjusted price (this is the price including the new tax rate)
						$adjusted_price    = ( $line_subtotal + $line_subtotal_tax ) / $values['quantity'];

						// Apply discounts and get the discounted price FOR A SINGLE ITEM
						$discounted_price  = $this->get_discounted_price( $values, $adjusted_price, true );

						// Convert back to line price and round nicely
						$discounted_line_price = round( $discounted_price * $values['quantity'], $this->dp );

						// Now use rounded line price to get taxes.
						$discounted_taxes  = WC_Tax::calc_tax( $discounted_line_price, $item_tax_rates, true );
						$line_tax          = array_sum( $discounted_taxes );
						$line_total        = $discounted_line_price - $line_tax;

					/**
					 * Regular tax calculation (customer inside base and the tax class is unmodified.
					 */
					} else {

						// Work out a new base price without the item tax
						$taxes             = WC_Tax::calc_tax( $line_price, $item_tax_rates, true );

						// Now we have a new item price (excluding TAX)
						$line_subtotal     = $line_price - array_sum( $taxes );
						$line_subtotal_tax = array_sum( $taxes );

						// Calc prices and tax (discounted)
						$discounted_price = $this->get_discounted_price( $values, $base_price, true );

						// Convert back to line price and round nicely
						$discounted_line_price = round( $discounted_price * $values['quantity'], $this->dp );

						// Now use rounded line price to get taxes.
						$discounted_taxes  = WC_Tax::calc_tax( $discounted_line_price, $item_tax_rates, true );
						$line_tax          = array_sum( $discounted_taxes );
						$line_total        = $discounted_line_price - $line_tax;
					}

					// Tax rows - merge the totals we just got
					foreach ( array_keys( $this->taxes + $discounted_taxes ) as $key ) {
						$this->taxes[ $key ] = ( isset( $discounted_taxes[ $key ] ) ? $discounted_taxes[ $key ] : 0 ) + ( isset( $this->taxes[ $key ] ) ? $this->taxes[ $key ] : 0 );
					}

				/**
				 * Prices exclude tax.
				 */
				} else {

					$item_tax_rates        = $tax_rates[ $_product->get_tax_class() ];

					// Work out a new base price without the shop's base tax
					$taxes                 = WC_Tax::calc_tax( $line_price, $item_tax_rates );

					// Now we have the item price (excluding TAX)
					$line_subtotal         = $line_price;
					$line_subtotal_tax     = array_sum( $taxes );

					// Now calc product rates
					$discounted_price      = $this->get_discounted_price( $values, $base_price, true );
					$discounted_taxes      = WC_Tax::calc_tax( $discounted_price * $values['quantity'], $item_tax_rates );
					$discounted_tax_amount = array_sum( $discounted_taxes );
					$line_tax              = $discounted_tax_amount;
					$line_total            = $discounted_price * $values['quantity'];

					// Tax rows - merge the totals we just got
					foreach ( array_keys( $this->taxes + $discounted_taxes ) as $key ) {
						$this->taxes[ $key ] = ( isset( $discounted_taxes[ $key ] ) ? $discounted_taxes[ $key ] : 0 ) + ( isset( $this->taxes[ $key ] ) ? $this->taxes[ $key ] : 0 );
					}
				}

				// Cart contents total is based on discounted prices and is used for the final total calculation
				$this->cart_contents_total += $line_total;

				// Store costs + taxes for lines
				$this->cart_contents[ $cart_item_key ]['line_total']        = $line_total;
				$this->cart_contents[ $cart_item_key ]['line_tax']          = $line_tax;
				$this->cart_contents[ $cart_item_key ]['line_subtotal']     = $line_subtotal;
				$this->cart_contents[ $cart_item_key ]['line_subtotal_tax'] = $line_subtotal_tax;

				// Store rates ID and costs - Since 2.2
				$this->cart_contents[ $cart_item_key ]['line_tax_data']     = array( 'total' => $discounted_taxes, 'subtotal' => $taxes );
			}

			// Only calculate the grand total + shipping if on the cart/checkout
			if ( is_checkout() || is_cart() || defined('WOOCOMMERCE_CHECKOUT') || defined('WOOCOMMERCE_CART') ) {

				// Calculate the Shipping
				$this->calculate_shipping();

				// Trigger the fees API where developers can add fees to the cart
				$this->calculate_fees();

				// Total up/round taxes and shipping taxes
				if ( $this->round_at_subtotal ) {
					$this->tax_total          = WC_Tax::get_tax_total( $this->taxes );
					$this->shipping_tax_total = WC_Tax::get_tax_total( $this->shipping_taxes );
					$this->taxes              = array_map( array( 'WC_Tax', 'round' ), $this->taxes );
					$this->shipping_taxes     = array_map( array( 'WC_Tax', 'round' ), $this->shipping_taxes );
				} else {
					$this->tax_total          = array_sum( $this->taxes );
					$this->shipping_tax_total = array_sum( $this->shipping_taxes );
				}

				// VAT exemption done at this point - so all totals are correct before exemption
				if ( WC()->customer->is_vat_exempt() ) {
					$this->remove_taxes();
				}

				// Allow plugins to hook and alter totals before final total is calculated
				do_action( 'woocommerce_calculate_totals', $this );

				// Grand Total - Discounted product prices, discounted tax, shipping cost + tax
				$this->total = max( 0, apply_filters( 'woocommerce_calculated_total', round( $this->cart_contents_total + $this->tax_total + $this->shipping_tax_total + $this->shipping_total + $this->fee_total, $this->dp ), $this ) );

			} else {

				// Set tax total to sum of all tax rows
				$this->tax_total = WC_Tax::get_tax_total( $this->taxes );

				// VAT exemption done at this point - so all totals are correct before exemption
				if ( WC()->customer->is_vat_exempt() ) {
					$this->remove_taxes();
				}
			}

			do_action( 'woocommerce_after_calculate_totals', $this );

			$this->set_session();
		}

		/**
		 * Remove taxes.
		 */
		public function remove_taxes() {
			$this->shipping_tax_total = $this->tax_total = 0;
			$this->subtotal           = $this->subtotal_ex_tax;

			foreach ( $this->cart_contents as $cart_item_key => $item ) {
				$this->cart_contents[ $cart_item_key ]['line_subtotal_tax'] = $this->cart_contents[ $cart_item_key ]['line_tax'] = 0;
				$this->cart_contents[ $cart_item_key ]['line_tax_data']     = array( 'total' => array(), 'subtotal' => array() );
			}

			// If true, zero rate is applied so '0' tax is displayed on the frontend rather than nothing.
			if ( apply_filters( 'woocommerce_cart_remove_taxes_apply_zero_rate', true ) ) {
				$this->taxes = $this->shipping_taxes = array( apply_filters( 'woocommerce_cart_remove_taxes_zero_rate_id', 'zero-rated' ) => 0 );
			} else {
				$this->taxes = $this->shipping_taxes = array();
			}
		}

		/**
		 * Looks at the totals to see if payment is actually required.
		 *
		 * @return bool
		 */
		public function needs_payment() {
			return apply_filters( 'woocommerce_cart_needs_payment', $this->total > 0, $this );
		}

	/*-----------------------------------------------------------------------------------*/
	/* Shipping related functions */
	/*-----------------------------------------------------------------------------------*/

		/**
		 * Uses the shipping class to calculate shipping then gets the totals when its finished.
		 */
		public function calculate_shipping() {
			if ( $this->needs_shipping() && $this->show_shipping() ) {
				WC()->shipping->calculate_shipping( $this->get_shipping_packages() );
			} else {
				WC()->shipping->reset_shipping();
			}

			// Get totals for the chosen shipping method
			$this->shipping_total 		= WC()->shipping->shipping_total;	// Shipping Total
			$this->shipping_taxes		= WC()->shipping->shipping_taxes;	// Shipping Taxes
		}

		/**
		 * Get packages to calculate shipping for.
		 *
		 * This lets us calculate costs for carts that are shipped to multiple locations.
		 *
		 * Shipping methods are responsible for looping through these packages.
		 *
		 * By default we pass the cart itself as a package - plugins can change this.
		 * through the filter and break it up.
		 *
		 * @since 1.5.4
		 * @return array of cart items
		 */
		public function get_shipping_packages() {
			// Packages array for storing 'carts'
			$packages = array();

			$packages[0]['contents']                 = $this->get_cart();		// Items in the package
			$packages[0]['contents_cost']            = 0;						// Cost of items in the package, set below
			$packages[0]['applied_coupons']          = $this->applied_coupons;
			$packages[0]['user']['ID']               = get_current_user_id();
			$packages[0]['destination']['country']   = WC()->customer->get_shipping_country();
			$packages[0]['destination']['state']     = WC()->customer->get_shipping_state();
			$packages[0]['destination']['postcode']  = WC()->customer->get_shipping_postcode();
			$packages[0]['destination']['city']      = WC()->customer->get_shipping_city();
			$packages[0]['destination']['address']   = WC()->customer->get_shipping_address();
			$packages[0]['destination']['address_2'] = WC()->customer->get_shipping_address_2();

			foreach ( $this->get_cart() as $item ) {
				if ( $item['data']->needs_shipping() ) {
					if ( isset( $item['line_total'] ) ) {
						$packages[0]['contents_cost'] += $item['line_total'];
					}
				}
			}

			return apply_filters( 'woocommerce_cart_shipping_packages', $packages );
		}

		/**
		 * Looks through the cart to see if shipping is actually required.
		 *
		 * @return bool whether or not the cart needs shipping
		 */
		public function needs_shipping() {
			// If shipping is disabled or not yet configured, we can skip this.
			if ( ! wc_shipping_enabled() || 0 === wc_get_shipping_method_count( true ) ) {
				return false;
			}

			$needs_shipping = false;

			if ( ! empty( $this->cart_contents ) ) {
				foreach ( $this->cart_contents as $cart_item_key => $values ) {
					$_product = $values['data'];
					if ( $_product->needs_shipping() ) {
						$needs_shipping = true;
					}
				}
			}

			return apply_filters( 'woocommerce_cart_needs_shipping', $needs_shipping );
		}

		/**
		 * Should the shipping address form be shown.
		 *
		 * @return bool
		 */
		public function needs_shipping_address() {

			$needs_shipping_address = false;

			if ( $this->needs_shipping() === true && ! wc_ship_to_billing_address_only() ) {
				$needs_shipping_address = true;
			}

			return apply_filters( 'woocommerce_cart_needs_shipping_address', $needs_shipping_address );
		}

		/**
		 * Sees if the customer has entered enough data to calc the shipping yet.
		 *
		 * @return bool
		 */
		public function show_shipping() {
			if ( ! wc_shipping_enabled() || ! is_array( $this->cart_contents ) )
				return false;

			if ( 'yes' === get_option( 'woocommerce_shipping_cost_requires_address' ) ) {
				if ( ! WC()->customer->has_calculated_shipping() ) {
					if ( ! WC()->customer->get_shipping_country() || ( ! WC()->customer->get_shipping_state() && ! WC()->customer->get_shipping_postcode() ) ) {
						return false;
					}
				}
			}

			return apply_filters( 'woocommerce_cart_ready_to_calc_shipping', true );
		}

		/**
		 * Sees if we need a shipping address.
		 *
		 * @deprecated 2.5.0 in favor to wc_ship_to_billing_address_only()
		 *
		 * @return bool
		 */
		public function ship_to_billing_address_only() {
			return wc_ship_to_billing_address_only();
		}

		/**
		 * Gets the shipping total (after calculation).
		 *
		 * @return string price or string for the shipping total
		 */
		public function get_cart_shipping_total() {
			if ( isset( $this->shipping_total ) ) {
				if ( $this->shipping_total > 0 ) {

					// Display varies depending on settings
					if ( $this->tax_display_cart == 'excl' ) {

						$return = wc_price( $this->shipping_total );

						if ( $this->shipping_tax_total > 0 && $this->prices_include_tax ) {
							$return .= ' <small class="tax_label">' . WC()->countries->ex_tax_or_vat() . '</small>';
						}

						return $return;

					} else {

						$return = wc_price( $this->shipping_total + $this->shipping_tax_total );

						if ( $this->shipping_tax_total > 0 && ! $this->prices_include_tax ) {
							$return .= ' <small class="tax_label">' . WC()->countries->inc_tax_or_vat() . '</small>';
						}

						return $return;

					}

				} else {
					return __( 'Free!', 'woocommerce' );
				}
			}

			return '';
		}

	/*-----------------------------------------------------------------------------------*/
	/* Coupons/Discount related functions */
	/*-----------------------------------------------------------------------------------*/

		/**
		 * Check for user coupons (now that we have billing email). If a coupon is invalid, add an error.
		 *
		 * Checks two types of coupons:
		 *  1. Where a list of customer emails are set (limits coupon usage to those defined).
		 *  2. Where a usage_limit_per_user is set (limits coupon usage to a number based on user ID and email).
		 *
		 * @param array $posted
		 */
		public function check_customer_coupons( $posted ) {
			if ( ! empty( $this->applied_coupons ) ) {
				foreach ( $this->applied_coupons as $code ) {
					$coupon = new WC_Coupon( $code );

					if ( $coupon->is_valid() ) {

						// Limit to defined email addresses
						if ( is_array( $coupon->customer_email ) && sizeof( $coupon->customer_email ) > 0 ) {
							$check_emails           = array();
							$coupon->customer_email = array_map( 'sanitize_email', $coupon->customer_email );

							if ( is_user_logged_in() ) {
								$current_user   = wp_get_current_user();
								$check_emails[] = $current_user->user_email;
							}
							$check_emails[] = $posted['billing_email'];
							$check_emails   = array_map( 'sanitize_email', array_map( 'strtolower', $check_emails ) );

							if ( 0 == sizeof( array_intersect( $check_emails, $coupon->customer_email ) ) ) {
								$coupon->add_coupon_message( WC_Coupon::E_WC_COUPON_NOT_YOURS_REMOVED );

								// Remove the coupon
								$this->remove_coupon( $code );

								// Flag totals for refresh
								WC()->session->set( 'refresh_totals', true );
							}
						}

						// Usage limits per user - check against billing and user email and user ID
						if ( $coupon->usage_limit_per_user > 0 ) {
							$check_emails = array();
							$used_by      = $coupon->get_used_by();

							if ( is_user_logged_in() ) {
								$current_user   = wp_get_current_user();
								$check_emails[] = sanitize_email( $current_user->user_email );
								$usage_count    = sizeof( array_keys( $used_by, get_current_user_id() ) );
							} else {
								$check_emails[] = sanitize_email( $posted['billing_email'] );
								$user           = get_user_by( 'email', $posted['billing_email'] );
								if ( $user ) {
									$usage_count = sizeof( array_keys( $used_by, $user->ID ) );
								} else {
									$usage_count = 0;
								}
							}

							foreach ( $check_emails as $check_email ) {
								$usage_count = $usage_count + sizeof( array_keys( $used_by, $check_email ) );
							}

							if ( $usage_count >= $coupon->usage_limit_per_user ) {
								$coupon->add_coupon_message( WC_Coupon::E_WC_COUPON_USAGE_LIMIT_REACHED );

								// Remove the coupon
								$this->remove_coupon( $code );

								// Flag totals for refresh
								WC()->session->set( 'refresh_totals', true );
							}
						}
					}
				}
			}
		}

		/**
		 * Returns whether or not a discount has been applied.
		 * @param string $coupon_code
		 * @return bool
		 */
		public function has_discount( $coupon_code = '' ) {
			return $coupon_code ? in_array( apply_filters( 'woocommerce_coupon_code', $coupon_code ), $this->applied_coupons ) : sizeof( $this->applied_coupons ) > 0;
		}

		/**
		 * Applies a coupon code passed to the method.
		 *
		 * @param string $coupon_code - The code to apply
		 * @return bool	True if the coupon is applied, false if it does not exist or cannot be applied
		 */
		public function add_discount( $coupon_code ) {
			// Coupons are globally disabled
			if ( ! wc_coupons_enabled() ) {
				return false;
			}

			// Sanitize coupon code
			$coupon_code = apply_filters( 'woocommerce_coupon_code', $coupon_code );

			// Get the coupon
			$the_coupon = new WC_Coupon( $coupon_code );

			// Check it can be used with cart
			if ( ! $the_coupon->is_valid() ) {
				wc_add_notice( $the_coupon->get_error_message(), 'error' );
				return false;
			}

			// Check if applied
			if ( $this->has_discount( $coupon_code ) ) {
				$the_coupon->add_coupon_message( WC_Coupon::E_WC_COUPON_ALREADY_APPLIED );
				return false;
			}

			// If its individual use then remove other coupons
			if ( $the_coupon->individual_use == 'yes' ) {
				$this->applied_coupons = apply_filters( 'woocommerce_apply_individual_use_coupon', array(), $the_coupon, $this->applied_coupons );
			}

			if ( $this->applied_coupons ) {
				foreach ( $this->applied_coupons as $code ) {
					$coupon = new WC_Coupon( $code );

					if ( $coupon->individual_use == 'yes' && false === apply_filters( 'woocommerce_apply_with_individual_use_coupon', false, $the_coupon, $coupon, $this->applied_coupons ) ) {

						// Reject new coupon
						$coupon->add_coupon_message( WC_Coupon::E_WC_COUPON_ALREADY_APPLIED_INDIV_USE_ONLY );

						return false;
					}
				}
			}

			$this->applied_coupons[] = $coupon_code;

			// Choose free shipping
			if ( $the_coupon->enable_free_shipping() ) {
				$packages = WC()->shipping->get_packages();
				$chosen_shipping_methods = WC()->session->get( 'chosen_shipping_methods' );

				foreach ( $packages as $i => $package ) {
					$chosen_shipping_methods[ $i ] = 'free_shipping';
				}

				WC()->session->set( 'chosen_shipping_methods', $chosen_shipping_methods );
			}

			$the_coupon->add_coupon_message( WC_Coupon::WC_COUPON_SUCCESS );

			do_action( 'woocommerce_applied_coupon', $coupon_code );

			return true;
		}

		/**
		 * Get array of applied coupon objects and codes.
		 * @return array of applied coupons
		 */
		public function get_coupons( $deprecated = null ) {
			$coupons = array();

			if ( 'order' === $deprecated ) {
				return $coupons;
			}

			foreach ( $this->get_applied_coupons() as $code ) {
				$coupon = new WC_Coupon( $code );
				$coupons[ $code ] = $coupon;
			}

			return $coupons;
		}

		/**
		 * Gets the array of applied coupon codes.
		 *
		 * @return array of applied coupons
		 */
		public function get_applied_coupons() {
			return $this->applied_coupons;
		}

		/**
		 * Get the discount amount for a used coupon.
		 * @param  string $code coupon code
		 * @param  bool $ex_tax inc or ex tax
		 * @return float discount amount
		 */
		public function get_coupon_discount_amount( $code, $ex_tax = true ) {
			$discount_amount = isset( $this->coupon_discount_amounts[ $code ] ) ? $this->coupon_discount_amounts[ $code ] : 0;

			if ( ! $ex_tax ) {
				$discount_amount += $this->get_coupon_discount_tax_amount( $code );
			}

			return wc_cart_round_discount( $discount_amount, $this->dp );
		}

		/**
		 * Get the discount tax amount for a used coupon (for tax inclusive prices).
		 * @param  string $code coupon code
		 * @param  bool inc or ex tax
		 * @return float discount amount
		 */
		public function get_coupon_discount_tax_amount( $code ) {
			return wc_cart_round_discount( isset( $this->coupon_discount_tax_amounts[ $code ] ) ? $this->coupon_discount_tax_amounts[ $code ] : 0, $this->dp );
		}

		/**
		 * Remove coupons from the cart of a defined type. Type 1 is before tax, type 2 is after tax.
		 */
		public function remove_coupons( $deprecated = null ) {
			$this->applied_coupons = $this->coupon_discount_amounts = $this->coupon_discount_tax_amounts = $this->coupon_applied_count = array();
			WC()->session->set( 'applied_coupons', array() );
			WC()->session->set( 'coupon_discount_amounts', array() );
			WC()->session->set( 'coupon_discount_tax_amounts', array() );
		}

		/**
		 * Remove a single coupon by code.
		 * @param  string $coupon_code Code of the coupon to remove
		 * @return bool
		 */
		public function remove_coupon( $coupon_code ) {
			// Coupons are globally disabled
			if ( ! wc_coupons_enabled() ) {
				return false;
			}

			// Get the coupon
			$coupon_code  = apply_filters( 'woocommerce_coupon_code', $coupon_code );
			$position     = array_search( $coupon_code, $this->applied_coupons );

			if ( $position !== false ) {
				unset( $this->applied_coupons[ $position ] );
			}

			WC()->session->set( 'applied_coupons', $this->applied_coupons );

			do_action( 'woocommerce_removed_coupon', $coupon_code );

			return true;
		}

		/**
		 * Function to apply discounts to a product and get the discounted price (before tax is applied).
		 *
		 * @param mixed $values
		 * @param mixed $price
		 * @param bool $add_totals (default: false)
		 * @return float price
		 */
		public function get_discounted_price( $values, $price, $add_totals = false ) {
			if ( ! $price ) {
				return $price;
			}

			$undiscounted_price = $price;

			if ( ! empty( $this->coupons ) ) {
				$product = $values['data'];

				foreach ( $this->coupons as $code => $coupon ) {
					if ( $coupon->is_valid() && ( $coupon->is_valid_for_product( $product, $values ) || $coupon->is_valid_for_cart() ) ) {
						$discount_amount = $coupon->get_discount_amount( 'yes' === get_option( 'woocommerce_calc_discounts_sequentially', 'no' ) ? $price : $undiscounted_price, $values, true );
						$discount_amount = min( $price, $discount_amount );
						$price           = max( $price - $discount_amount, 0 );

						// Store the totals for DISPLAY in the cart
						if ( $add_totals ) {
							$total_discount     = $discount_amount * $values['quantity'];
							$total_discount_tax = 0;

							if ( wc_tax_enabled() ) {
								$tax_rates          = WC_Tax::get_rates( $product->get_tax_class() );
								$taxes              = WC_Tax::calc_tax( $discount_amount, $tax_rates, $this->prices_include_tax );
								$total_discount_tax = WC_Tax::get_tax_total( $taxes ) * $values['quantity'];
								$total_discount     = $this->prices_include_tax ? $total_discount - $total_discount_tax : $total_discount;
								$this->discount_cart_tax += $total_discount_tax;
							}

							$this->discount_cart     += $total_discount;
							$this->increase_coupon_discount_amount( $code, $total_discount, $total_discount_tax );
							$this->increase_coupon_applied_count( $code, $values['quantity'] );
						}
					}

					// If the price is 0, we can stop going through coupons because there is nothing more to discount for this product.
					if ( 0 >= $price ) {
						break;
					}
				}
			}

			return apply_filters( 'woocommerce_get_discounted_price', $price, $values, $this );
		}

		/**
		 * Store how much discount each coupon grants.
		 *
		 * @access private
		 * @param string $code
		 * @param double $amount
		 * @param double $tax
		 */
		private function increase_coupon_discount_amount( $code, $amount, $tax ) {
			$this->coupon_discount_amounts[ $code ]     = isset( $this->coupon_discount_amounts[ $code ] ) ? $this->coupon_discount_amounts[ $code ] + $amount : $amount;
			$this->coupon_discount_tax_amounts[ $code ] = isset( $this->coupon_discount_tax_amounts[ $code ] ) ? $this->coupon_discount_tax_amounts[ $code ] + $tax : $tax;
		}

		/**
		 * Store how many times each coupon is applied to cart/items.
		 *
		 * @access private
		 * @param string $code
		 * @param int    $count
		 */
		private function increase_coupon_applied_count( $code, $count = 1 ) {
			if ( empty( $this->coupon_applied_count[ $code ] ) ) {
				$this->coupon_applied_count[ $code ] = 0;
			}
			$this->coupon_applied_count[ $code ] += $count;
		}

	/*-----------------------------------------------------------------------------------*/
	/* Fees API to add additional costs to orders */
	/*-----------------------------------------------------------------------------------*/

		/**
		 * Add additional fee to the cart.
		 *
		 * @param string $name Unique name for the fee. Multiple fees of the same name cannot be added.
		 * @param float $amount Fee amount.
		 * @param bool $taxable (default: false) Is the fee taxable?
		 * @param string $tax_class (default: '') The tax class for the fee if taxable. A blank string is standard tax class.
		 */
		public function add_fee( $name, $amount, $taxable = false, $tax_class = '' ) {

			$new_fee_id = sanitize_title( $name );

			// Only add each fee once
			foreach ( $this->fees as $fee ) {
				if ( $fee->id == $new_fee_id ) {
					return;
				}
			}

			$new_fee            = new stdClass();
			$new_fee->id        = $new_fee_id;
			$new_fee->name      = esc_attr( $name );
			$new_fee->amount    = (float) esc_attr( $amount );
			$new_fee->tax_class = $tax_class;
			$new_fee->taxable   = $taxable ? true : false;
			$new_fee->tax       = 0;
			$new_fee->tax_data  = array();
			$this->fees[]       = $new_fee;
		}

		/**
		 * Get fees.
		 *
		 * @return array
		 */
		public function get_fees() {
			return array_filter( (array) $this->fees );
		}

		/**
		 * Calculate fees.
		 */
		public function calculate_fees() {
			// Reset fees before calculation
			$this->fee_total = 0;
			$this->fees      = array();

			// Fire an action where developers can add their fees
			do_action( 'woocommerce_cart_calculate_fees', $this );

			// If fees were added, total them and calculate tax
			if ( ! empty( $this->fees ) ) {
				foreach ( $this->fees as $fee_key => $fee ) {
					$this->fee_total += $fee->amount;

					if ( $fee->taxable ) {
						// Get tax rates
						$tax_rates = WC_Tax::get_rates( $fee->tax_class );
						$fee_taxes = WC_Tax::calc_tax( $fee->amount, $tax_rates, false );

						if ( ! empty( $fee_taxes ) ) {
							// Set the tax total for this fee
							$this->fees[ $fee_key ]->tax = array_sum( $fee_taxes );

							// Set tax data - Since 2.2
							$this->fees[ $fee_key ]->tax_data = $fee_taxes;

							// Tax rows - merge the totals we just got
							foreach ( array_keys( $this->taxes + $fee_taxes ) as $key ) {
								$this->taxes[ $key ] = ( isset( $fee_taxes[ $key ] ) ? $fee_taxes[ $key ] : 0 ) + ( isset( $this->taxes[ $key ] ) ? $this->taxes[ $key ] : 0 );
							}
						}
					}
				}
			}
		}

	/*-----------------------------------------------------------------------------------*/
	/* Get Formatted Totals */
	/*-----------------------------------------------------------------------------------*/

		/**
		 * Gets the order total (after calculation).
		 *
		 * @return string formatted price
		 */
		public function get_total() {
			return apply_filters( 'woocommerce_cart_total', wc_price( $this->total ) );
		}

		/**
		 * Gets the total excluding taxes.
		 *
		 * @return string formatted price
		 */
		public function get_total_ex_tax() {
			$total = $this->total - $this->tax_total - $this->shipping_tax_total;
			if ( $total < 0 ) {
				$total = 0;
			}
			return apply_filters( 'woocommerce_cart_total_ex_tax', wc_price( $total ) );
		}

		/**
		 * Gets the cart contents total (after calculation).
		 *
		 * @return string formatted price
		 */
		public function get_cart_total() {
			if ( ! $this->prices_include_tax ) {
				$cart_contents_total = wc_price( $this->cart_contents_total );
			} else {
				$cart_contents_total = wc_price( $this->cart_contents_total + $this->tax_total );
			}

			return apply_filters( 'woocommerce_cart_contents_total', $cart_contents_total );
		}

		/**
		 * Gets the sub total (after calculation).
		 *
		 * @param bool $compound whether to include compound taxes
		 * @return string formatted price
		 */
		public function get_cart_subtotal( $compound = false ) {

			// If the cart has compound tax, we want to show the subtotal as
			// cart + shipping + non-compound taxes (after discount)
			if ( $compound ) {

				$cart_subtotal = wc_price( $this->cart_contents_total + $this->shipping_total + $this->get_taxes_total( false, false ) );

			// Otherwise we show cart items totals only (before discount)
			} else {

				// Display varies depending on settings
				if ( $this->tax_display_cart == 'excl' ) {

					$cart_subtotal = wc_price( $this->subtotal_ex_tax );

					if ( $this->tax_total > 0 && $this->prices_include_tax ) {
						$cart_subtotal .= ' <small class="tax_label">' . WC()->countries->ex_tax_or_vat() . '</small>';
					}

				} else {

					$cart_subtotal = wc_price( $this->subtotal );

					if ( $this->tax_total > 0 && !$this->prices_include_tax ) {
						$cart_subtotal .= ' <small class="tax_label">' . WC()->countries->inc_tax_or_vat() . '</small>';
					}

				}
			}

			return apply_filters( 'woocommerce_cart_subtotal', $cart_subtotal, $compound, $this );
		}

		/**
		 * Get the product row price per item.
		 *
		 * @param WC_Product $_product
		 * @return string formatted price
		 */
		public function get_product_price( $_product ) {
			if ( $this->tax_display_cart == 'excl' ) {
				$product_price = $_product->get_price_excluding_tax();
			} else {
				$product_price = $_product->get_price_including_tax();
			}

			return apply_filters( 'woocommerce_cart_product_price', wc_price( $product_price ), $_product );
		}

		/**
		 * Get the product row subtotal.
		 *
		 * Gets the tax etc to avoid rounding issues.
		 *
		 * When on the checkout (review order), this will get the subtotal based on the customer's tax rate rather than the base rate.
		 *
		 * @param WC_Product $_product
		 * @param int $quantity
		 * @return string formatted price
		 */
		public function get_product_subtotal( $_product, $quantity ) {

			$price 			= $_product->get_price();
			$taxable 		= $_product->is_taxable();

			// Taxable
			if ( $taxable ) {

				if ( $this->tax_display_cart == 'excl' ) {

					$row_price        = $_product->get_price_excluding_tax( $quantity );
					$product_subtotal = wc_price( $row_price );

					if ( $this->prices_include_tax && $this->tax_total > 0 ) {
						$product_subtotal .= ' <small class="tax_label">' . WC()->countries->ex_tax_or_vat() . '</small>';
					}

				} else {

					$row_price        = $_product->get_price_including_tax( $quantity );
					$product_subtotal = wc_price( $row_price );

					if ( ! $this->prices_include_tax && $this->tax_total > 0 ) {
						$product_subtotal .= ' <small class="tax_label">' . WC()->countries->inc_tax_or_vat() . '</small>';
					}

				}

			// Non-taxable
			} else {

				$row_price        = $price * $quantity;
				$product_subtotal = wc_price( $row_price );

			}

			return apply_filters( 'woocommerce_cart_product_subtotal', $product_subtotal, $_product, $quantity, $this );
		}

		/**
		 * Gets the cart tax (after calculation).
		 *
		 * @return string formatted price
		 */
		public function get_cart_tax() {
			$cart_total_tax = wc_round_tax_total( $this->tax_total + $this->shipping_tax_total );

			return apply_filters( 'woocommerce_get_cart_tax', $cart_total_tax ? wc_price( $cart_total_tax ) : '' );
		}

		/**
		 * Get a tax amount.
		 * @param  string $tax_rate_id
		 * @return float amount
		 */
		public function get_tax_amount( $tax_rate_id ) {
			return isset( $this->taxes[ $tax_rate_id ] ) ? $this->taxes[ $tax_rate_id ] : 0;
		}

		/**
		 * Get a tax amount.
		 * @param  string $tax_rate_id
		 * @return float amount
		 */
		public function get_shipping_tax_amount( $tax_rate_id ) {
			return isset( $this->shipping_taxes[ $tax_rate_id ] ) ? $this->shipping_taxes[ $tax_rate_id ] : 0;
		}

		/**
		 * Get tax row amounts with or without compound taxes includes.
		 *
		 * @param  bool $compound True if getting compound taxes
		 * @param  bool $display  True if getting total to display
		 * @return float price
		 */
		public function get_taxes_total( $compound = true, $display = true ) {
			$total = 0;
			foreach ( $this->taxes as $key => $tax ) {
				if ( ! $compound && WC_Tax::is_compound( $key ) ) continue;
				$total += $tax;
			}
			foreach ( $this->shipping_taxes as $key => $tax ) {
				if ( ! $compound && WC_Tax::is_compound( $key ) ) continue;
				$total += $tax;
			}
			if ( $display ) {
				$total = wc_round_tax_total( $total );
			}
			return apply_filters( 'woocommerce_cart_taxes_total', $total, $compound, $display, $this );
		}

		/**
		 * Get the total of all cart discounts.
		 *
		 * @return float
		 */
		public function get_cart_discount_total() {
			return wc_cart_round_discount( $this->discount_cart, $this->dp );
		}

		/**
		 * Get the total of all cart tax discounts (used for discounts on tax inclusive prices).
		 *
		 * @return float
		 */
		public function get_cart_discount_tax_total() {
			return wc_cart_round_discount( $this->discount_cart_tax, $this->dp );
		}

		/**
		 * Gets the total discount amount - both kinds.
		 *
		 * @return mixed formatted price or false if there are none
		 */
		public function get_total_discount() {
			if ( $this->get_cart_discount_total() ) {
				$total_discount = wc_price( $this->get_cart_discount_total() );
			} else {
				$total_discount = false;
			}
			return apply_filters( 'woocommerce_cart_total_discount', $total_discount, $this );
		}

		/**
		 * Gets the total (product) discount amount - these are applied before tax.
		 *
		 * @deprecated Order discounts (after tax) removed in 2.3 so multiple methods for discounts are no longer required.
		 * @return mixed formatted price or false if there are none
		 */
		public function get_discounts_before_tax() {
			_deprecated_function( 'get_discounts_before_tax', '2.3', 'get_total_discount' );
			if ( $this->get_cart_discount_total() ) {
				$discounts_before_tax = wc_price( $this->get_cart_discount_total() );
			} else {
				$discounts_before_tax = false;
			}
			return apply_filters( 'woocommerce_cart_discounts_before_tax', $discounts_before_tax, $this );
		}

		/**
		 * Get the total of all order discounts (after tax discounts).
		 *
		 * @deprecated Order discounts (after tax) removed in 2.3
		 * @return int
		 */
		public function get_order_discount_total() {
			_deprecated_function( 'get_order_discount_total', '2.3' );
			return 0;
		}

		/**
		 * Function to apply cart discounts after tax.
 		 * @deprecated Coupons can not be applied after tax
		 */
		public function apply_cart_discounts_after_tax( $values, $price ) {
			_deprecated_function( 'apply_cart_discounts_after_tax', '2.3' );
		}

		/**
		 * Function to apply product discounts after tax.
		 * @deprecated Coupons can not be applied after tax
		 */
		public function apply_product_discounts_after_tax( $values, $price ) {
			_deprecated_function( 'apply_product_discounts_after_tax', '2.3' );
		}

		/**
		 * Gets the order discount amount - these are applied after tax.
		 * @deprecated Coupons can not be applied after tax
		 */
		public function get_discounts_after_tax() {
			_deprecated_function( 'get_discounts_after_tax', '2.3' );
		}
}
