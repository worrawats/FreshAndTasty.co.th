﻿<?php
/**
 * Post Types Admin
 *
 * @author   WooThemes
 * @category Admin
 * @package  WooCommerce/Admin
 * @version  2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'WC_Admin_Post_Types' ) ) :

/**
 * WC_Admin_Post_Types Class.
 *
 * Handles the edit posts views and some functionality on the edit post screen for WC post types.
 */
class WC_Admin_Post_Types {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_filter( 'post_updated_messages', array( $this, 'post_updated_messages' ) );
		add_filter( 'bulk_post_updated_messages', array( $this, 'bulk_post_updated_messages' ), 10, 2 );

		// Disable Auto Save
		add_action( 'admin_print_scripts', array( $this, 'disable_autosave' ) );

		// WP List table columns. Defined here so they are always available for events such as inline editing.
		add_filter( 'manage_product_posts_columns', array( $this, 'product_columns' ) );
		add_filter( 'manage_shop_coupon_posts_columns', array( $this, 'shop_coupon_columns' ) );
		add_filter( 'manage_shop_order_posts_columns', array( $this, 'shop_order_columns' ) );

		add_action( 'manage_product_posts_custom_column', array( $this, 'render_product_columns' ), 2 );
		add_action( 'manage_shop_coupon_posts_custom_column', array( $this, 'render_shop_coupon_columns' ), 2 );
		add_action( 'manage_shop_order_posts_custom_column', array( $this, 'render_shop_order_columns' ), 2 );

		add_filter( 'manage_edit-product_sortable_columns', array( $this, 'product_sortable_columns' ) );
		add_filter( 'manage_edit-shop_coupon_sortable_columns', array( $this, 'shop_coupon_sortable_columns' ) );
		add_filter( 'manage_edit-shop_order_sortable_columns', array( $this, 'shop_order_sortable_columns' ) );

		add_filter( 'bulk_actions-edit-shop_order', array( $this, 'shop_order_bulk_actions' ) );

		add_filter( 'list_table_primary_column', array( $this, 'list_table_primary_column' ), 10, 2 );
		add_filter( 'post_row_actions', array( $this, 'row_actions' ), 2, 100 );

		// Views
		add_filter( 'views_edit-product', array( $this, 'product_sorting_link' ) );

		// Bulk / quick edit
		add_action( 'bulk_edit_custom_box', array( $this, 'bulk_edit' ), 10, 2 );
		add_action( 'quick_edit_custom_box',  array( $this, 'quick_edit' ), 10, 2 );
		add_action( 'save_post', array( $this, 'bulk_and_quick_edit_save_post' ), 10, 2 );
		add_action( 'admin_footer', array( $this, 'bulk_admin_footer' ), 10 );
		add_action( 'load-edit.php', array( $this, 'bulk_action' ) );
		add_action( 'admin_notices', array( $this, 'bulk_admin_notices' ) );

		// Order Search
		add_filter( 'get_search_query', array( $this, 'shop_order_search_label' ) );
		add_filter( 'query_vars', array( $this, 'add_custom_query_var' ) );
		add_action( 'parse_query', array( $this, 'shop_order_search_custom_fields' ) );

		// Filters
		add_action( 'restrict_manage_posts', array( $this, 'restrict_manage_posts' ) );
		add_filter( 'request', array( $this, 'request_query' ) );
		add_filter( 'parse_query', array( $this, 'product_filters_query' ) );
		add_filter( 'posts_search', array( $this, 'product_search' ) );

		// Status transitions
		add_action( 'delete_post', array( $this, 'delete_post' ) );
		add_action( 'wp_trash_post', array( $this, 'trash_post' ) );
		add_action( 'untrash_post', array( $this, 'untrash_post' ) );
		add_action( 'before_delete_post', array( $this, 'delete_order_items' ) );
		add_action( 'before_delete_post', array( $this, 'delete_order_downloadable_permissions' ) );

		// Edit post screens
		add_filter( 'enter_title_here', array( $this, 'enter_title_here' ), 1, 2 );
		add_action( 'edit_form_after_title', array( $this, 'edit_form_after_title' ) );
		add_filter( 'default_hidden_meta_boxes', array( $this, 'hidden_meta_boxes' ), 10, 2 );
		add_action( 'post_submitbox_misc_actions', array( $this, 'product_data_visibility' ) );

		// Uploads
		add_filter( 'upload_dir', array( $this, 'upload_dir' ) );
		add_action( 'media_upload_downloadable_product', array( $this, 'media_upload_downloadable_product' ) );

		if ( ! function_exists( 'duplicate_post_plugin_activation' ) ) {
			include( 'class-wc-admin-duplicate-product.php' );
		}

		// Meta-Box Class
		include_once( 'class-wc-admin-meta-boxes.php' );

		// Download permissions
		add_action( 'woocommerce_process_product_file_download_paths', array( $this, 'process_product_file_download_paths' ), 10, 3 );

		// Disable DFW feature pointer
		add_action( 'admin_footer', array( $this, 'disable_dfw_feature_pointer' ) );

		// Disable post type view mode options
		add_filter( 'view_mode_post_types', array( $this, 'disable_view_mode_options' ) );

		// If first time editing, disable columns by default.
		if ( false === get_user_option( 'manageedit-shop_ordercolumnshidden' ) ) {
			$user = wp_get_current_user();
			update_user_option( $user->ID, 'manageedit-shop_ordercolumnshidden', array( 0 => 'billing_address' ), true );
		}

		// Show blank state
		add_action( 'manage_posts_extra_tablenav', array( $this, 'maybe_render_blank_state' ) );
	}

	/**
	 * Change messages when a post type is updated.
	 * @param  array $messages
	 * @return array
	 */
	public function post_updated_messages( $messages ) {
		global $post, $post_ID;

		$messages['product'] = array(
			0 => '', // Unused. Messages start at index 1.
			1 => sprintf( __( 'Product updated. <a href="%s">View Product</a>', 'woocommerce' ), esc_url( get_permalink( $post_ID ) ) ),
			2 => __( 'Custom field updated.', 'woocommerce' ),
			3 => __( 'Custom field deleted.', 'woocommerce' ),
			4 => __( 'Product updated.', 'woocommerce' ),
			5 => isset( $_GET['revision'] ) ? sprintf( __( 'Product restored to revision from %s', 'woocommerce' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6 => sprintf( __( 'Product published. <a href="%s">View Product</a>', 'woocommerce' ), esc_url( get_permalink( $post_ID ) ) ),
			7 => __( 'Product saved.', 'woocommerce' ),
			8 => sprintf( __( 'Product submitted. <a target="_blank" href="%s">Preview Product</a>', 'woocommerce' ), esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) ) ),
			9 => sprintf( __( 'Product scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Product</a>', 'woocommerce' ),
			  date_i18n( __( 'M j, Y @ G:i', 'woocommerce' ), strtotime( $post->post_date ) ), esc_url( get_permalink( $post_ID ) ) ),
			10 => sprintf( __( 'Product draft updated. <a target="_blank" href="%s">Preview Product</a>', 'woocommerce' ), esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) ) ),
		);

		$messages['shop_order'] = array(
			0 => '', // Unused. Messages start at index 1.
			1 => __( 'Order updated.', 'woocommerce' ),
			2 => __( 'Custom field updated.', 'woocommerce' ),
			3 => __( 'Custom field deleted.', 'woocommerce' ),
			4 => __( 'Order updated.', 'woocommerce' ),
			5 => isset( $_GET['revision'] ) ? sprintf( __( 'Order restored to revision from %s', 'woocommerce' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6 => __( 'Order updated.', 'woocommerce' ),
			7 => __( 'Order saved.', 'woocommerce' ),
			8 => __( 'Order submitted.', 'woocommerce' ),
			9 => sprintf( __( 'Order scheduled for: <strong>%1$s</strong>.', 'woocommerce' ),
			  date_i18n( __( 'M j, Y @ G:i', 'woocommerce' ), strtotime( $post->post_date ) ) ),
			10 => __( 'Order draft updated.', 'woocommerce' ),
			11 => __( 'Order updated and email sent.', 'woocommerce' )
		);

		$messages['shop_coupon'] = array(
			0 => '', // Unused. Messages start at index 1.
			1 => __( 'Coupon updated.', 'woocommerce' ),
			2 => __( 'Custom field updated.', 'woocommerce' ),
			3 => __( 'Custom field deleted.', 'woocommerce' ),
			4 => __( 'Coupon updated.', 'woocommerce' ),
			5 => isset( $_GET['revision'] ) ? sprintf( __( 'Coupon restored to revision from %s', 'woocommerce' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6 => __( 'Coupon updated.', 'woocommerce' ),
			7 => __( 'Coupon saved.', 'woocommerce' ),
			8 => __( 'Coupon submitted.', 'woocommerce' ),
			9 => sprintf( __( 'Coupon scheduled for: <strong>%1$s</strong>.', 'woocommerce' ),
			  date_i18n( __( 'M j, Y @ G:i', 'woocommerce' ), strtotime( $post->post_date ) ) ),
			10 => __( 'Coupon draft updated.', 'woocommerce' )
		);

		return $messages;
	}

	/**
	 * Specify custom bulk actions messages for different post types.
	 * @param  array $bulk_messages
	 * @param  array $bulk_counts
	 * @return array
	 */
	public function bulk_post_updated_messages( $bulk_messages, $bulk_counts ) {

		$bulk_messages['product'] = array(
			'updated'   => _n( '%s product updated.', '%s products updated.', $bulk_counts['updated'], 'woocommerce' ),
			'locked'    => _n( '%s product not updated, somebody is editing it.', '%s products not updated, somebody is editing them.', $bulk_counts['locked'], 'woocommerce' ),
			'deleted'   => _n( '%s product permanently deleted.', '%s products permanently deleted.', $bulk_counts['deleted'], 'woocommerce' ),
			'trashed'   => _n( '%s product moved to the Trash.', '%s products moved to the Trash.', $bulk_counts['trashed'], 'woocommerce' ),
			'untrashed' => _n( '%s product restored from the Trash.', '%s products restored from the Trash.', $bulk_counts['untrashed'], 'woocommerce' ),
		);

		$bulk_messages['shop_order'] = array(
			'updated'   => _n( '%s order updated.', '%s orders updated.', $bulk_counts['updated'], 'woocommerce' ),
			'locked'    => _n( '%s order not updated, somebody is editing it.', '%s orders not updated, somebody is editing them.', $bulk_counts['locked'], 'woocommerce' ),
			'deleted'   => _n( '%s order permanently deleted.', '%s orders permanently deleted.', $bulk_counts['deleted'], 'woocommerce' ),
			'trashed'   => _n( '%s order moved to the Trash.', '%s orders moved to the Trash.', $bulk_counts['trashed'], 'woocommerce' ),
			'untrashed' => _n( '%s order restored from the Trash.', '%s orders restored from the Trash.', $bulk_counts['untrashed'], 'woocommerce' ),
		);

		$bulk_messages['shop_coupon'] = array(
			'updated'   => _n( '%s coupon updated.', '%s coupons updated.', $bulk_counts['updated'], 'woocommerce' ),
			'locked'    => _n( '%s coupon not updated, somebody is editing it.', '%s coupons not updated, somebody is editing them.', $bulk_counts['locked'], 'woocommerce' ),
			'deleted'   => _n( '%s coupon permanently deleted.', '%s coupons permanently deleted.', $bulk_counts['deleted'], 'woocommerce' ),
			'trashed'   => _n( '%s coupon moved to the Trash.', '%s coupons moved to the Trash.', $bulk_counts['trashed'], 'woocommerce' ),
			'untrashed' => _n( '%s coupon restored from the Trash.', '%s coupons restored from the Trash.', $bulk_counts['untrashed'], 'woocommerce' ),
		);

		return $bulk_messages;
	}

	/**
	 * Define custom columns for products.
	 * @param  array $existing_columns
	 * @return array
	 */
	public function product_columns( $existing_columns ) {
		if ( empty( $existing_columns ) && ! is_array( $existing_columns ) ) {
			$existing_columns = array();
		}

		unset( $existing_columns['title'], $existing_columns['comments'], $existing_columns['date'] );

		$columns          = array();
		$columns['cb']    = '<input type="checkbox" />';
		$columns['thumb'] = '<span class="wc-image tips" data-tip="' . esc_attr__( 'Image', 'woocommerce' ) . '">' . __( 'Image', 'woocommerce' ) . '</span>';
		$columns['name']  = __( 'Name', 'woocommerce' );

		if ( wc_product_sku_enabled() ) {
			$columns['sku'] = __( 'SKU', 'woocommerce' );
		}

		if ( 'yes' === get_option( 'woocommerce_manage_stock' ) ) {
			$columns['is_in_stock'] = __( 'Stock', 'woocommerce' );
		}

		$columns['price']        = __( 'Price', 'woocommerce' );
		$columns['product_cat']  = __( 'Categories', 'woocommerce' );
		$columns['product_tag']  = __( 'Tags', 'woocommerce' );
		$columns['featured']     = '<span class="wc-featured parent-tips" data-tip="' . esc_attr__( 'Featured', 'woocommerce' ) . '">' . __( 'Featured', 'woocommerce' ) . '</span>';
		$columns['product_type'] = '<span class="wc-type parent-tips" data-tip="' . esc_attr__( 'Type', 'woocommerce' ) . '">' . __( 'Type', 'woocommerce' ) . '</span>';
		$columns['date']         = __( 'Date', 'woocommerce' );

		return array_merge( $columns, $existing_columns );

	}

	/**
	 * Define custom columns for coupons.
	 * @param  array $existing_columns
	 * @return array
	 */
	public function shop_coupon_columns( $existing_columns ) {
		$columns                = array();
		$columns['cb']          = $existing_columns['cb'];
		$columns['coupon_code'] = __( 'Code', 'woocommerce' );
		$columns['type']        = __( 'Coupon type', 'woocommerce' );
		$columns['amount']      = __( 'Coupon amount', 'woocommerce' );
		$columns['description'] = __( 'Description', 'woocommerce' );
		$columns['products']    = __( 'Product IDs', 'woocommerce' );
		$columns['usage']       = __( 'Usage / Limit', 'woocommerce' );
		$columns['expiry_date'] = __( 'Expiry date', 'woocommerce' );

		return $columns;
	}

	/**
	 * Define custom columns for orders.
	 * @param  array $existing_columns
	 * @return array
	 */
	public function shop_order_columns( $existing_columns ) {
		$columns                     = array();
		$columns['cb']               = $existing_columns['cb'];
		$columns['order_status']     = '<span class="status_head tips" data-tip="' . esc_attr__( 'Status', 'woocommerce' ) . '">' . esc_attr__( 'Status', 'woocommerce' ) . '</span>';
		$columns['order_title']      = __( 'Order', 'woocommerce' );
		$columns['order_items']      = __( 'Purchased', 'woocommerce' );
		$columns['billing_address']  = __( 'Billing', 'woocommerce' );
		$columns['shipping_address'] = __( 'Ship to', 'woocommerce' );
		$columns['customer_message'] = '<span class="notes_head tips" data-tip="' . esc_attr__( 'Customer Message', 'woocommerce' ) . '">' . esc_attr__( 'Customer Message', 'woocommerce' ) . '</span>';
		$columns['order_notes']      = '<span class="order-notes_head tips" data-tip="' . esc_attr__( 'Order Notes', 'woocommerce' ) . '">' . esc_attr__( 'Order Notes', 'woocommerce' ) . '</span>';
		$columns['order_date']       = __( 'Date', 'woocommerce' );
		$columns['order_total']      = __( 'Total', 'woocommerce' );
		$columns['order_actions']    = __( 'Actions', 'woocommerce' );

		return $columns;
	}

	/**
	 * Ouput custom columns for products.
	 *
	 * @param string $column
	 */
	public function render_product_columns( $column ) {
		global $post, $the_product;

		if ( empty( $the_product ) || $the_product->id != $post->ID ) {
			$the_product = wc_get_product( $post );
		}

		switch ( $column ) {
			case 'thumb' :
				echo '<a href="' . get_edit_post_link( $post->ID ) . '">' . $the_product->get_image( 'thumbnail' ) . '</a>';
				break;
			case 'name' :
				$edit_link = get_edit_post_link( $post->ID );
				$title     = _draft_or_post_title();

				echo '<strong><a class="row-title" href="' . esc_url( $edit_link ) . '">' . esc_html( $title ) . '</a>';

				_post_states( $post );

				echo '</strong>';

				if ( $post->post_parent > 0 ) {
					echo '&nbsp;&nbsp;&larr; <a href="'. get_edit_post_link( $post->post_parent ) .'">'. get_the_title( $post->post_parent ) .'</a>';
				}

				// Excerpt view
				if ( isset( $_GET['mode'] ) && 'excerpt' == $_GET['mode'] ) {
					echo apply_filters( 'the_excerpt', $post->post_excerpt );
				}

				$this->_render_product_row_actions( $post, $title );

				get_inline_data( $post );

				/* Custom inline data for woocommerce. */
				echo '
					<div class="hidden" id="woocommerce_inline_' . $post->ID . '">
						<div class="menu_order">' . $post->menu_order . '</div>
						<div class="sku">' . $the_product->sku . '</div>
						<div class="regular_price">' . $the_product->regular_price . '</div>
						<div class="sale_price">' . $the_product->sale_price . '</div>
						<div class="weight">' . $the_product->weight . '</div>
						<div class="length">' . $the_product->length . '</div>
						<div class="width">' . $the_product->width . '</div>
						<div class="height">' . $the_product->height . '</div>
						<div class="shipping_class">' . $the_product->get_shipping_class() . '</div>
						<div class="visibility">' . $the_product->visibility . '</div>
						<div class="stock_status">' . $the_product->stock_status . '</div>
						<div class="stock">' . $the_product->stock . '</div>
						<div class="manage_stock">' . $the_product->manage_stock . '</div>
						<div class="featured">' . $the_product->featured . '</div>
						<div class="product_type">' . $the_product->product_type . '</div>
						<div class="product_is_virtual">' . $the_product->virtual . '</div>
						<div class="tax_status">' . $the_product->tax_status . '</div>
						<div class="tax_class">' . $the_product->tax_class . '</div>
						<div class="backorders">' . $the_product->backorders . '</div>
					</div>
				';

			break;
			case 'sku' :
				echo $the_product->get_sku() ? $the_product->get_sku() : '<span class="na">&ndash;</span>';
				break;
			case 'product_type' :
				if ( 'grouped' == $the_product->product_type ) {
					echo '<span class="product-type tips grouped" data-tip="' . esc_attr__( 'Grouped', 'woocommerce' ) . '"></span>';
				} elseif ( 'external' == $the_product->product_type ) {
					echo '<span class="product-type tips external" data-tip="' . esc_attr__( 'External/Affiliate', 'woocommerce' ) . '"></span>';
				} elseif ( 'simple' == $the_product->product_type ) {

					if ( $the_product->is_virtual() ) {
						echo '<span class="product-type tips virtual" data-tip="' . esc_attr__( 'Virtual', 'woocommerce' ) . '"></span>';
					} elseif ( $the_product->is_downloadable() ) {
						echo '<span class="product-type tips downloadable" data-tip="' . esc_attr__( 'Downloadable', 'woocommerce' ) . '"></span>';
					} else {
						echo '<span class="product-type tips simple" data-tip="' . esc_attr__( 'Simple', 'woocommerce' ) . '"></span>';
					}

				} elseif ( 'variable' == $the_product->product_type ) {
					echo '<span class="product-type tips variable" data-tip="' . esc_attr__( 'Variable', 'woocommerce' ) . '"></span>';
				} else {
					// Assuming that we have other types in future
					echo '<span class="product-type tips ' . $the_product->product_type . '" data-tip="' . ucfirst( $the_product->product_type ) . '"></span>';
				}
				break;
			case 'price' :
				echo $the_product->get_price_html() ? $the_product->get_price_html() : '<span class="na">&ndash;</span>';
				break;
			case 'product_cat' :
			case 'product_tag' :
				if ( ! $terms = get_the_terms( $post->ID, $column ) ) {
					echo '<span class="na">&ndash;</span>';
				} else {
					$termlist = array();
					foreach ( $terms as $term ) {
						$termlist[] = '<a href="' . admin_url( 'edit.php?' . $column . '=' . $term->slug . '&post_type=product' ) . ' ">' . $term->name . '</a>';
					}

					echo implode( ', ', $termlist );
				}
				break;
			case 'featured' :
				$url = wp_nonce_url( admin_url( 'admin-ajax.php?action=woocommerce_feature_product&product_id=' . $post->ID ), 'woocommerce-feature-product' );
				echo '<a href="' . esc_url( $url ) . '" title="'. __( 'Toggle featured', 'woocommerce' ) . '">';
				if ( $the_product->is_featured() ) {
					echo '<span class="wc-featured tips" data-tip="' . esc_attr__( 'Yes', 'woocommerce' ) . '">' . __( 'Yes', 'woocommerce' ) . '</span>';
				} else {
					echo '<span class="wc-featured not-featured tips" data-tip="' . esc_attr__( 'No', 'woocommerce' ) . '">' . __( 'No', 'woocommerce' ) . '</span>';
				}
				echo '</a>';
				break;
			case 'is_in_stock' :

				if ( $the_product->is_in_stock() ) {
					$stock_html = '<mark class="instock">' . __( 'In stock', 'woocommerce' ) . '</mark>';
				} else {
					$stock_html = '<mark class="outofstock">' . __( 'Out of stock', 'woocommerce' ) . '</mark>';
				}

				// If the product has children, a single stock level would be misleading as some could be -ve and some +ve, some managed/some unmanaged etc so hide stock level in this case.
				if ( $the_product->managing_stock() && ! sizeof( $the_product->get_children() ) ) {
					$stock_html .= ' (' . $the_product->get_total_stock() . ')';
				}

				echo apply_filters( 'woocommerce_admin_stock_html', $stock_html, $the_product );

				break;
			default :
				break;
		}
	}

	/**
	 * Render product row actions for old version of WordPress.
	 * Since WordPress 4.3 we don't have to build the row actions.
	 *
	 * @param WP_Post $post
	 * @param string  $title
	 */
	private function _render_product_row_actions( $post, $title ) {
		global $wp_version;

		if ( version_compare( $wp_version, '4.3-beta', '>=' ) ) {
			return;
		}

		$post_type_object = get_post_type_object( $post->post_type );
		$can_edit_post    = current_user_can( $post_type_object->cap->edit_post, $post->ID );

		// Get actions
		$actions = array();

		$actions['id'] = 'ID: ' . $post->ID;

		if ( $can_edit_post && 'trash' != $post->post_status ) {
			$actions['edit'] = '<a href="' . get_edit_post_link( $post->ID, true ) . '" title="' . esc_attr( __( 'Edit this item', 'woocommerce' ) ) . '">' . __( 'Edit', 'woocommerce' ) . '</a>';
			$actions['inline hide-if-no-js'] = '<a href="#" class="editinline" title="' . esc_attr( __( 'Edit this item inline', 'woocommerce' ) ) . '">' . __( 'Quick&nbsp;Edit', 'woocommerce' ) . '</a>';
		}
		if ( current_user_can( $post_type_object->cap->delete_post, $post->ID ) ) {
			if ( 'trash' == $post->post_status ) {
				$actions['untrash'] = '<a title="' . esc_attr( __( 'Restore this item from the Trash', 'woocommerce' ) ) . '" href="' . wp_nonce_url( admin_url( sprintf( $post_type_object->_edit_link . '&amp;action=untrash', $post->ID ) ), 'untrash-post_' . $post->ID ) . '">' . __( 'Restore', 'woocommerce' ) . '</a>';
			} elseif ( EMPTY_TRASH_DAYS ) {
				$actions['trash'] = '<a class="submitdelete" title="' . esc_attr( __( 'Move this item to the Trash', 'woocommerce' ) ) . '" href="' . get_delete_post_link( $post->ID ) . '">' . __( 'Trash', 'woocommerce' ) . '</a>';
			}

			if ( 'trash' == $post->post_status || ! EMPTY_TRASH_DAYS ) {
				$actions['delete'] = '<a class="submitdelete" title="' . esc_attr( __( 'Delete this item permanently', 'woocommerce' ) ) . '" href="' . get_delete_post_link( $post->ID, '', true ) . '">' . __( 'Delete Permanently', 'woocommerce' ) . '</a>';
			}
		}
		if ( $post_type_object->public ) {
			if ( in_array( $post->post_status, array( 'pending', 'draft', 'future' ) ) ) {
				if ( $can_edit_post )
					$actions['view'] = '<a href="' . esc_url( add_query_arg( 'preview', 'true', get_permalink( $post->ID ) ) ) . '" title="' . esc_attr( sprintf( __( 'Preview &#8220;%s&#8221;', 'woocommerce' ), $title ) ) . '" rel="permalink">' . __( 'Preview', 'woocommerce' ) . '</a>';
			} elseif ( 'trash' != $post->post_status ) {
				$actions['view'] = '<a href="' . get_permalink( $post->ID ) . '" title="' . esc_attr( sprintf( __( 'View &#8220;%s&#8221;', 'woocommerce' ), $title ) ) . '" rel="permalink">' . __( 'View', 'woocommerce' ) . '</a>';
			}
		}

		$actions = apply_filters( 'post_row_actions', $actions, $post );

		echo '<div class="row-actions">';

		$i = 0;
		$action_count = sizeof( $actions );

		foreach ( $actions as $action => $link ) {
			++$i;
			( $i == $action_count ) ? $sep = '' : $sep = ' | ';
			echo '<span class="' . $action . '">' . $link . $sep . '</span>';
		}
		echo '</div>';
	}

	/**
	 * Output custom columns for coupons.
	 *
	 * @param string $column
	 */
	public function render_shop_coupon_columns( $column ) {
		global $post, $woocommerce;

		switch ( $column ) {
			case 'coupon_code' :
				$edit_link = get_edit_post_link( $post->ID );
				$title     = _draft_or_post_title();

				echo '<strong><a class="row-title" href="' . esc_url( $edit_link ) . '">' . esc_html( $title ) . '</a>';

				_post_states( $post );

				echo '</strong>';

				$this->_render_shop_coupon_row_actions( $post, $title );
			break;
			case 'type' :
				echo esc_html( wc_get_coupon_type( get_post_meta( $post->ID, 'discount_type', true ) ) );
			break;
			case 'amount' :
				echo esc_html( get_post_meta( $post->ID, 'coupon_amount', true ) );
			break;
			case 'products' :
				$product_ids = get_post_meta( $post->ID, 'product_ids', true );
				$product_ids = $product_ids ? array_map( 'absint', explode( ',', $product_ids ) ) : array();

				if ( sizeof( $product_ids ) > 0 ) {
					echo esc_html( implode( ', ', $product_ids ) );
				} else {
					echo '&ndash;';
				}
			break;
			case 'usage_limit' :
				$usage_limit = get_post_meta( $post->ID, 'usage_limit', true );

				if ( $usage_limit ) {
					echo esc_html( $usage_limit );
				} else {
					echo '&ndash;';
				}
			break;
			case 'usage' :
				$usage_count = absint( get_post_meta( $post->ID, 'usage_count', true ) );
				$usage_limit = esc_html( get_post_meta( $post->ID, 'usage_limit', true ) );
				$usage_url   = sprintf( '<a href="%s">%s</a>', admin_url( sprintf( 'edit.php?s=%s&post_status=all&post_type=shop_order', esc_html( $post->post_title ) ) ), $usage_count );

				printf( _x( '%1$s / %2$s', 'Count / Limit', 'woocommerce' ), $usage_url, $usage_limit ? $usage_limit : '&infin;' );
			break;
			case 'expiry_date' :
				$expiry_date = get_post_meta( $post->ID, 'expiry_date', true );

				if ( $expiry_date ) {
					echo esc_html( date_i18n( 'F j, Y', strtotime( $expiry_date ) ) );
				} else {
					echo '&ndash;';
				}
			break;
			case 'description' :
				echo wp_kses_post( $post->post_excerpt );
			break;
		}
	}

	/**
	 * Render shop_coupon row actions for old version of WordPress.
	 * Since WordPress 4.3 we don't have to build the row actions.
	 *
	 * @param WP_Post $post
	 * @param string  $title
	 */
	private function _render_shop_coupon_row_actions( $post, $title ) {
		global $wp_version;

		if ( version_compare( $wp_version, '4.3-beta', '>=' ) ) {
			return;
		}

		$post_type_object = get_post_type_object( $post->post_type );

		// Get actions
		$actions = array();

		if ( current_user_can( $post_type_object->cap->edit_post, $post->ID ) ) {
			$actions['edit'] = '<a href="' . admin_url( sprintf( $post_type_object->_edit_link . '&amp;action=edit', $post->ID ) ) . '">' . __( 'Edit', 'woocommerce' ) . '</a>';
		}

		if ( current_user_can( $post_type_object->cap->delete_post, $post->ID ) ) {

			if ( 'trash' == $post->post_status ) {
				$actions['untrash'] = "<a title='" . esc_attr( __( 'Restore this item from the Trash', 'woocommerce' ) ) . "' href='" . wp_nonce_url( admin_url( sprintf( $post_type_object->_edit_link . '&amp;action=untrash', $post->ID ) ), 'untrash-post_' . $post->ID ) . "'>" . __( 'Restore', 'woocommerce' ) . "</a>";
			} elseif ( EMPTY_TRASH_DAYS ) {
				$actions['trash'] = "<a class='submitdelete' title='" . esc_attr( __( 'Move this item to the Trash', 'woocommerce' ) ) . "' href='" . get_delete_post_link( $post->ID ) . "'>" . __( 'Trash', 'woocommerce' ) . "</a>";
			}

			if ( 'trash' == $post->post_status || ! EMPTY_TRASH_DAYS ) {
				$actions['delete'] = "<a class='submitdelete' title='" . esc_attr( __( 'Delete this item permanently', 'woocommerce' ) ) . "' href='" . get_delete_post_link( $post->ID, '', true ) . "'>" . __( 'Delete Permanently', 'woocommerce' ) . "</a>";
			}
		}

		$actions = apply_filters( 'post_row_actions', $actions, $post );

		echo '<div class="row-actions">';

		$i = 0;
		$action_count = sizeof( $actions );

		foreach ( $actions as $action => $link ) {
			++$i;
			( $i == $action_count ) ? $sep = '' : $sep = ' | ';
			echo "<span class='$action'>$link$sep</span>";
		}
		echo '</div>';
	}

	/**
	 * Output custom columns for coupons.
	 * @param string $column
	 */
	public function render_shop_order_columns( $column ) {
		global $post, $woocommerce, $the_order;

		if ( empty( $the_order ) || $the_order->id != $post->ID ) {
			$the_order = wc_get_order( $post->ID );
		}

		switch ( $column ) {
			case 'order_status' :

				printf( '<mark class="%s tips" data-tip="%s">%s</mark>', sanitize_title( $the_order->get_status() ), wc_get_order_status_name( $the_order->get_status() ), wc_get_order_status_name( $the_order->get_status() ) );

			break;
			case 'order_date' :

				if ( '0000-00-00 00:00:00' == $post->post_date ) {
					$t_time = $h_time = __( 'Unpublished', 'woocommerce' );
				} else {
					$t_time = get_the_time( __( 'Y/m/d g:i:s A', 'woocommerce' ), $post );
					$h_time = get_the_time( __( 'Y/m/d', 'woocommerce' ), $post );
				}

				echo '<abbr title="' . esc_attr( $t_time ) . '">' . esc_html( apply_filters( 'post_date_column_time', $h_time, $post ) ) . '</abbr>';

			break;
			case 'customer_message' :
				if ( $the_order->customer_message ) {
					echo '<span class="note-on tips" data-tip="' . wc_sanitize_tooltip( $the_order->customer_message ) . '">' . __( 'Yes', 'woocommerce' ) . '</span>';
				} else {
					echo '<span class="na">&ndash;</span>';
				}

			break;
			case 'order_items' :

				echo '<a href="#" class="show_order_items">' . apply_filters( 'woocommerce_admin_order_item_count', sprintf( _n( '%d item', '%d items', $the_order->get_item_count(), 'woocommerce' ), $the_order->get_item_count() ), $the_order ) . '</a>';

				if ( sizeof( $the_order->get_items() ) > 0 ) {

					echo '<table class="order_items" cellspacing="0">';

					foreach ( $the_order->get_items() as $item ) {
						$product        = apply_filters( 'woocommerce_order_item_product', $the_order->get_product_from_item( $item ), $item );
						$item_meta      = new WC_Order_Item_Meta( $item, $product );
						$item_meta_html = $item_meta->display( true, true );
						?>
						<tr class="<?php echo apply_filters( 'woocommerce_admin_order_item_class', '', $item, $the_order ); ?>">
							<td class="qty"><?php echo absint( $item['qty'] ); ?></td>
							<td class="name">
								<?php  if ( $product ) : ?>
									<?php echo ( wc_product_sku_enabled() && $product->get_sku() ) ? $product->get_sku() . ' - ' : ''; ?><a href="<?php echo get_edit_post_link( $product->id ); ?>" title="<?php echo apply_filters( 'woocommerce_order_item_name', $item['name'], $item, false ); ?>"><?php echo apply_filters( 'woocommerce_order_item_name', $item['name'], $item, false ); ?></a>
								<?php else : ?>
									<?php echo apply_filters( 'woocommerce_order_item_name', $item['name'], $item, false ); ?>
								<?php endif; ?>
								<?php if ( ! empty( $item_meta_html ) ) : ?>
									<?php echo wc_help_tip( $item_meta_html ); ?>
								<?php endif; ?>
							</td>
						</tr>
						<?php
					}

					echo '</table>';

				} else echo '&ndash;';
			break;
			case 'billing_address' :

				if ( $address = $the_order->get_formatted_billing_address() ) {
					echo esc_html( preg_replace( '#<br\s*/?>#i', ', ', $address ) );
				} else {
					echo '&ndash;';
				}

				if ( $the_order->billing_phone ) {
					echo '<small class="meta">' . __( 'Tel:', 'woocommerce' ) . ' ' . esc_html( $the_order->billing_phone ) . '</small>';
				}

			break;
			case 'shipping_address' :

				if ( $address = $the_order->get_formatted_shipping_address() ) {
					echo '<a target="_blank" href="' . esc_url( $the_order->get_shipping_address_map_url() ) . '">'. esc_html( preg_replace( '#<br\s*/?>#i', ', ', $address ) ) .'</a>';
				} else {
					echo '&ndash;';
				}

				if ( $the_order->get_shipping_method() ) {
					echo '<small class="meta">' . __( 'Via', 'woocommerce' ) . ' ' . esc_html( $the_order->get_shipping_method() ) . '</small>';
				}

			break;
			case 'order_notes' :
				if ( $post->comment_count ) {

					 //check the status of the post
					$status = ( 'trash' !== $post->post_status ) ? '' : 'post-trashed';

					$latest_notes = get_comments( array(
						'post_id'   => $post->ID,
						'number'    => 1,
						'status'    => $status
					) );

					$latest_note = current( $latest_notes );

					if ( isset( $latest_note->comment_content ) && $post->comment_count == 1 ) {
						echo '<span class="note-on tips" data-tip="' . wc_sanitize_tooltip( $latest_note->comment_content ) . '">' . __( 'Yes', 'woocommerce' ) . '</span>';
					} elseif ( isset( $latest_note->comment_content ) ) {
						echo '<span class="note-on tips" data-tip="' . wc_sanitize_tooltip( $latest_note->comment_content . '<br/><small style="display:block">' . sprintf( _n( 'plus %d other note', 'plus %d other notes', ( $post->comment_count - 1 ), 'woocommerce' ), $post->comment_count - 1 ) . '</small>' ) . '">' . __( 'Yes', 'woocommerce' ) . '</span>';
					} else {
						echo '<span class="note-on tips" data-tip="' . wc_sanitize_tooltip( sprintf( _n( '%d note', '%d notes', $post->comment_count, 'woocommerce' ), $post->comment_count ) ) . '">' . __( 'Yes', 'woocommerce' ) . '</span>';
					}

				} else {
					echo '<span class="na">&ndash;</span>';
				}

			break;
			case 'order_total' :
				echo $the_order->get_formatted_order_total();

				if ( $the_order->payment_method_title ) {
					echo '<small class="meta">' . __( 'Via', 'woocommerce' ) . ' ' . esc_html( $the_order->payment_method_title ) . '</small>';
				}
			break;
			case 'order_title' :

				if ( $the_order->user_id ) {
					$user_info = get_userdata( $the_order->user_id );
				}

				$forinspect = $the_order->post;
				$user = new WP_User($forinspect->post_author);
				//var_dump($user->user_login);

				if ( ! empty( $user_info ) ) {

					//$username = '<a href="user-edit.php?user_id=' . absint( $user_info->ID ) . '">';

					//if ( $user_info->first_name || $user_info->last_name ) {
						//$username .= esc_html( sprintf( _x( '%1$s %2$s', 'full name', 'woocommerce' ), ucfirst( $user_info->first_name ), ucfirst( $user_info->last_name ) ) );
					//} else {
						$username .= esc_html( ucfirst( $user->user_login ) );
					//}

					//$username .= '</a>';

				} else {
					if ( $the_order->billing_first_name || $the_order->billing_last_name ) {
						$username = trim( sprintf( _x( '%1$s %2$s', 'full name', 'woocommerce' ), $the_order->billing_first_name, $the_order->billing_last_name ) );
					} else if ( $the_order->billing_company ) {
						$username = trim( $the_order->billing_company );
					} else {
						$username = __( 'Guest', 'woocommerce' );
					}
				}
				//worrawat
				printf( _x( '%s สร้างโดย<br />  %s', 'Order number by X', 'woocommerce' ), '<a href="' . admin_url( 'post.php?post=' . absint( $post->ID ) . '&action=edit' ) . '" class="row-title"><strong>#' . esc_attr( $the_order->get_order_number() ) . '</strong></a>', $username );

				//if ( $the_order->billing_email ) {
				//	echo '<small class="meta email"><a href="' . esc_url( 'mailto:' . $the_order->billing_email ) . '">' . esc_html( $the_order->billing_email ) . '</a></small>';
				//}

				echo '<button type="button" class="toggle-row"><span class="screen-reader-text">' . __( 'Show more details', 'woocommerce' ) . '</span></button>';

			break;
			case 'order_actions' :

				?><p>
					<?php
						do_action( 'woocommerce_admin_order_actions_start', $the_order );

						$actions = array();

						if ( $the_order->has_status( array(  'on-hold', 'paymentcomplete' ) ) ) {
							$actions['processing'] = array(
								'url'       => wp_nonce_url( admin_url( 'admin-ajax.php?action=woocommerce_mark_order_status&status=processing&order_id=' . $post->ID ), 'woocommerce-mark-order-status' ),
								'name'      => __( 'Processing', 'woocommerce' ),
								'tips'      => __( 'Processing', 'woocommerce' ),
								'action'    => "processing"
							);
						}

						if ( $the_order->has_status( array(  'invoicecreated' ) ) ) {
							$actions['paymentcomplete'] = array(
								'url'       => wp_nonce_url( admin_url( 'admin-ajax.php?action=woocommerce_mark_order_status&status=paymentcomplete&order_id=' . $post->ID ), 'woocommerce-mark-order-status' ),
								'name'      => 'C',
								'tips'      => 'Payment Complete',
								'action'    => "paymentcomplete"
							);
						}

						if ( $the_order->has_status( array(  'processing','on-hold' ) ) ) {
							$actions['readypickup'] = array(
								'url'       => wp_nonce_url( admin_url( 'admin-ajax.php?action=woocommerce_mark_order_status&status=readypickup&order_id=' . $post->ID ), 'woocommerce-mark-order-status' ),
								'name'      => 'R',
								'tips'      => 'Ready for Pickup',
								'action'    => "readypickup"
							);
						}

						if ( $the_order->has_status( array( 'pending', 'on-hold', 'processing','readypickup' ) ) ) {
							$actions['complete'] = array(
								'url'       => wp_nonce_url( admin_url( 'admin-ajax.php?action=woocommerce_mark_order_status&status=completed&order_id=' . $post->ID ), 'woocommerce-mark-order-status' ),
								'name'      => __( 'Complete', 'woocommerce' ),
								'tips'      => __( 'Complete', 'woocommerce' ),
								'action'    => "complete"
							);
						}

						//$actions['view'] = array(
						//	'url'       => admin_url( 'post.php?post=' . $post->ID . '&action=edit' ),
						//	'name'      => __( 'View', 'woocommerce' ),
						//	'action'    => "view"
						//);

						$actions = apply_filters( 'woocommerce_admin_order_actions', $actions, $the_order );

						foreach ( $actions as $action ) {
							//var_dump($action['name']);
							printf( '<a class="button tips %s" href="%s" data-tip="%s">%s</a>', esc_attr( $action['action'] ), esc_url( $action['url'] ), esc_attr( $action['tips'] ), esc_attr( $action['name'] ) );
						}

						do_action( 'woocommerce_admin_order_actions_end', $the_order );
					?>
				</p><?php

			break;
		}
	}

	/**
	 * Make columns sortable - https://gist.github.com/906872.
	 *
	 * @param  array $columns
	 * @return array
	 */
	public function product_sortable_columns( $columns ) {
		$custom = array(
			'price'    => 'price',
			'featured' => array( 'featured', 1 ),
			'sku'      => 'sku',
			'name'     => 'title'
		);
		return wp_parse_args( $custom, $columns );
	}

	/**
	 * Make columns sortable - https://gist.github.com/906872.
	 *
	 * @param  array $columns
	 * @return array
	 */
	public function shop_coupon_sortable_columns( $columns ) {
		return $columns;
	}

	/**
	 * Make columns sortable - https://gist.github.com/906872.
	 *
	 * @param  array $columns
	 * @return array
	 */
	public function shop_order_sortable_columns( $columns ) {
		$custom = array(
			'order_title' => 'ID',
			'order_total' => 'order_total',
			'order_date'  => 'date'
		);
		unset( $columns['comments'] );

		return wp_parse_args( $custom, $columns );
	}

	/**
	 * Remove edit from the bulk actions.
	 *
	 * @param array $actions
	 * @return array
	 */
	public function shop_order_bulk_actions( $actions ) {

		if ( isset( $actions['edit'] ) ) {
			unset( $actions['edit'] );
		}

		return $actions;
	}

	/**
	 * Set list table primary column for products and orders.
	 * Support for WordPress 4.3.
	 *
	 * @param  string $default
	 * @param  string $screen_id
	 *
	 * @return string
	 */
	public function list_table_primary_column( $default, $screen_id ) {

		if ( 'edit-product' === $screen_id ) {
			return 'name';
		}

		if ( 'edit-shop_order' === $screen_id ) {
			return 'order_title';
		}

		if ( 'edit-shop_coupon' === $screen_id ) {
			return 'coupon_code';
		}

		return $default;
	}

	/**
	 * Set row actions for products and orders.
	 *
	 * @param  array $actions
	 * @param  WP_Post $post
	 *
	 * @return array
	 */
	public function row_actions( $actions, $post ) {
		if ( 'product' === $post->post_type ) {
			return array_merge( array( 'id' => 'ID: ' . $post->ID ), $actions );
		}

		if ( in_array( $post->post_type, array( 'shop_order', 'shop_coupon' ) ) ) {
			if ( isset( $actions['inline hide-if-no-js'] ) ) {
				unset( $actions['inline hide-if-no-js'] );
			}
		}

		return $actions;
	}

	/**
	 * Product sorting link.
	 *
	 * Based on Simple Page Ordering by 10up (https://wordpress.org/extend/plugins/simple-page-ordering/).
	 *
	 * @param  array $views
	 * @return array
	 */
	public function product_sorting_link( $views ) {
		global $post_type, $wp_query;

		if ( ! current_user_can( 'edit_others_pages' ) ) {
			return $views;
		}

		$class            = ( isset( $wp_query->query['orderby'] ) && $wp_query->query['orderby'] == 'menu_order title' ) ? 'current' : '';
		$query_string     = remove_query_arg(array( 'orderby', 'order' ));
		$query_string     = add_query_arg( 'orderby', urlencode('menu_order title'), $query_string );
		$query_string     = add_query_arg( 'order', urlencode('ASC'), $query_string );
		$views['byorder'] = '<a href="' . esc_url( $query_string ) . '" class="' . esc_attr( $class ) . '">' . __( 'Sort Products', 'woocommerce' ) . '</a>';

		return $views;
	}

	/**
	 * Custom bulk edit - form.
	 *
	 * @param mixed $column_name
	 * @param mixed $post_type
	 */
	public function bulk_edit( $column_name, $post_type ) {

		if ( 'price' != $column_name || 'product' != $post_type ) {
			return;
		}

		$shipping_class = get_terms( 'product_shipping_class', array(
			'hide_empty' => false,
		) );

		include( WC()->plugin_path() . '/includes/admin/views/html-bulk-edit-product.php' );
	}

	/**
	 * Custom quick edit - form.
	 *
	 * @param mixed $column_name
	 * @param mixed $post_type
	 */
	public function quick_edit( $column_name, $post_type ) {

		if ( 'price' != $column_name || 'product' != $post_type ) {
			return;
		}

		$shipping_class = get_terms( 'product_shipping_class', array(
			'hide_empty' => false,
		) );

		include( WC()->plugin_path() . '/includes/admin/views/html-quick-edit-product.php' );
	}

	/**
	 * Quick and bulk edit saving.
	 *
	 * @param int $post_id
	 * @param WP_Post $post
	 * @return int
	 */
	public function bulk_and_quick_edit_save_post( $post_id, $post ) {

		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		// Don't save revisions and autosaves
		if ( wp_is_post_revision( $post_id ) || wp_is_post_autosave( $post_id ) ) {
			return $post_id;
		}

		// Check post type is product
		if ( 'product' != $post->post_type ) {
			return $post_id;
		}

		// Check user permission
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}

		// Check nonces
		if ( ! isset( $_REQUEST['woocommerce_quick_edit_nonce'] ) && ! isset( $_REQUEST['woocommerce_bulk_edit_nonce'] ) ) {
			return $post_id;
		}
		if ( isset( $_REQUEST['woocommerce_quick_edit_nonce'] ) && ! wp_verify_nonce( $_REQUEST['woocommerce_quick_edit_nonce'], 'woocommerce_quick_edit_nonce' ) ) {
			return $post_id;
		}
		if ( isset( $_REQUEST['woocommerce_bulk_edit_nonce'] ) && ! wp_verify_nonce( $_REQUEST['woocommerce_bulk_edit_nonce'], 'woocommerce_bulk_edit_nonce' ) ) {
			return $post_id;
		}

		// Get the product and save
		$product = wc_get_product( $post );

		if ( ! empty( $_REQUEST['woocommerce_quick_edit'] ) ) {
			$this->quick_edit_save( $post_id, $product );
		} else {
			$this->bulk_edit_save( $post_id, $product );
		}

		// Clear transient
		wc_delete_product_transients( $post_id );

		return $post_id;
	}

	/**
	 * Quick edit.
	 *
	 * @param integer $post_id
	 * @param WC_Product $product
	 */
	private function quick_edit_save( $post_id, $product ) {
		global $wpdb;

		$old_regular_price = $product->regular_price;
		$old_sale_price    = $product->sale_price;

		// Save fields
		if ( isset( $_REQUEST['_sku'] ) ) {
			$sku     = get_post_meta( $post_id, '_sku', true );
			$new_sku = (string) wc_clean( $_REQUEST['_sku'] );

			if ( $new_sku !== $sku ) {
				if ( ! empty( $new_sku ) ) {
					$unique_sku = wc_product_has_unique_sku( $post_id, $new_sku );
					if ( $unique_sku ) {
						update_post_meta( $post_id, '_sku', $new_sku );
					}
				} else {
					update_post_meta( $post_id, '_sku', '' );
				}
			}
		}

		if ( isset( $_REQUEST['_weight'] ) ) {
			update_post_meta( $post_id, '_weight', wc_clean( $_REQUEST['_weight'] ) );
		}

		if ( isset( $_REQUEST['_length'] ) ) {
			update_post_meta( $post_id, '_length', wc_clean( $_REQUEST['_length'] ) );
		}

		if ( isset( $_REQUEST['_width'] ) ) {
			update_post_meta( $post_id, '_width', wc_clean( $_REQUEST['_width'] ) );
		}

		if ( isset( $_REQUEST['_height'] ) ) {
			update_post_meta( $post_id, '_height', wc_clean( $_REQUEST['_height'] ) );
		}

		if ( ! empty( $_REQUEST['_shipping_class'] ) ) {
			$shipping_class = '_no_shipping_class' == $_REQUEST['_shipping_class'] ? '' : wc_clean( $_REQUEST['_shipping_class'] );

			wp_set_object_terms( $post_id, $shipping_class, 'product_shipping_class' );
		}

		if ( isset( $_REQUEST['_visibility'] ) ) {
			if ( update_post_meta( $post_id, '_visibility', wc_clean( $_REQUEST['_visibility'] ) ) ) {
				do_action( 'woocommerce_product_set_visibility', $post_id, wc_clean( $_REQUEST['_visibility'] ) );
			}
		}

		if ( isset( $_REQUEST['_featured'] ) ) {
			if ( update_post_meta( $post_id, '_featured', 'yes' ) ) {
				delete_transient( 'wc_featured_products' );
			}
		} else {
			if ( update_post_meta( $post_id, '_featured', 'no' ) ) {
				delete_transient( 'wc_featured_products' );
			}
		}

		if ( isset( $_REQUEST['_tax_status'] ) ) {
			update_post_meta( $post_id, '_tax_status', wc_clean( $_REQUEST['_tax_status'] ) );
		}

		if ( isset( $_REQUEST['_tax_class'] ) ) {
			update_post_meta( $post_id, '_tax_class', wc_clean( $_REQUEST['_tax_class'] ) );
		}

		if ( $product->is_type('simple') || $product->is_type('external') ) {

			if ( isset( $_REQUEST['_regular_price'] ) ) {
				$new_regular_price = $_REQUEST['_regular_price'] === '' ? '' : wc_format_decimal( $_REQUEST['_regular_price'] );
				update_post_meta( $post_id, '_regular_price', $new_regular_price );
			} else {
				$new_regular_price = null;
			}
			if ( isset( $_REQUEST['_sale_price'] ) ) {
				$new_sale_price = $_REQUEST['_sale_price'] === '' ? '' : wc_format_decimal( $_REQUEST['_sale_price'] );
				update_post_meta( $post_id, '_sale_price', $new_sale_price );
			} else {
				$new_sale_price = null;
			}

			// Handle price - remove dates and set to lowest
			$price_changed = false;

			if ( ! is_null( $new_regular_price ) && $new_regular_price != $old_regular_price ) {
				$price_changed = true;
			} elseif ( ! is_null( $new_sale_price ) && $new_sale_price != $old_sale_price ) {
				$price_changed = true;
			}

			if ( $price_changed ) {
				update_post_meta( $post_id, '_sale_price_dates_from', '' );
				update_post_meta( $post_id, '_sale_price_dates_to', '' );

				if ( ! is_null( $new_sale_price ) && $new_sale_price !== '' ) {
					update_post_meta( $post_id, '_price', $new_sale_price );
				} else {
					update_post_meta( $post_id, '_price', $new_regular_price );
				}
			}
		}

		// Handle stock status
		if ( isset( $_REQUEST['_stock_status'] ) ) {
			$stock_status = wc_clean( $_REQUEST['_stock_status'] );

			if ( $product->is_type( 'variable' ) ) {
				foreach ( $product->get_children() as $child_id ) {
					if ( 'yes' !== get_post_meta( $child_id, '_manage_stock', true ) ) {
						wc_update_product_stock_status( $child_id, $stock_status );
					}
				}

				WC_Product_Variable::sync_stock_status( $post_id );
			} else {
				wc_update_product_stock_status( $post_id, $stock_status );
			}
		}

		// Handle stock
		if ( ! $product->is_type('grouped') ) {
			if ( isset( $_REQUEST['_manage_stock'] ) ) {
				update_post_meta( $post_id, '_manage_stock', 'yes' );
				wc_update_product_stock( $post_id, wc_stock_amount( $_REQUEST['_stock'] ) );
			} else {
				update_post_meta( $post_id, '_manage_stock', 'no' );
				wc_update_product_stock( $post_id, 0 );
			}

			if ( ! empty( $_REQUEST['_backorders'] ) ) {
				update_post_meta( $post_id, '_backorders', wc_clean( $_REQUEST['_backorders'] ) );
			}
		}

		do_action( 'woocommerce_product_quick_edit_save', $product );
	}

	/**
	 * Bulk edit.
	 * @param integer $post_id
	 * @param WC_Product $product
	 */
	public function bulk_edit_save( $post_id, $product ) {

		$old_regular_price = $product->regular_price;
		$old_sale_price    = $product->sale_price;

		// Save fields
		if ( ! empty( $_REQUEST['change_weight'] ) && isset( $_REQUEST['_weight'] ) ) {
			update_post_meta( $post_id, '_weight', wc_clean( stripslashes( $_REQUEST['_weight'] ) ) );
		}

		if ( ! empty( $_REQUEST['change_dimensions'] ) ) {
			if ( isset( $_REQUEST['_length'] ) ) {
				update_post_meta( $post_id, '_length', wc_clean( stripslashes( $_REQUEST['_length'] ) ) );
			}
			if ( isset( $_REQUEST['_width'] ) ) {
				update_post_meta( $post_id, '_width', wc_clean( stripslashes( $_REQUEST['_width'] ) ) );
			}
			if ( isset( $_REQUEST['_height'] ) ) {
				update_post_meta( $post_id, '_height', wc_clean( stripslashes( $_REQUEST['_height'] ) ) );
			}
		}

		if ( ! empty( $_REQUEST['_tax_status'] ) ) {
			update_post_meta( $post_id, '_tax_status', wc_clean( $_REQUEST['_tax_status'] ) );
		}

		if ( ! empty( $_REQUEST['_tax_class'] ) ) {
			$tax_class = wc_clean( $_REQUEST['_tax_class'] );
			if ( 'standard' == $tax_class ) {
				$tax_class = '';
			}
			update_post_meta( $post_id, '_tax_class', $tax_class );
		}

		if ( ! empty( $_REQUEST['_stock_status'] ) ) {
			$stock_status = wc_clean( $_REQUEST['_stock_status'] );

			if ( $product->is_type( 'variable' ) ) {
				foreach ( $product->get_children() as $child_id ) {
					if ( 'yes' !== get_post_meta( $child_id, '_manage_stock', true ) ) {
						wc_update_product_stock_status( $child_id, $stock_status );
					}
				}

				WC_Product_Variable::sync_stock_status( $post_id );
			} else {
				wc_update_product_stock_status( $post_id, $stock_status );
			}
		}

		if ( ! empty( $_REQUEST['_shipping_class'] ) ) {
			$shipping_class = '_no_shipping_class' == $_REQUEST['_shipping_class'] ? '' : wc_clean( $_REQUEST['_shipping_class'] );

			wp_set_object_terms( $post_id, $shipping_class, 'product_shipping_class' );
		}

		if ( ! empty( $_REQUEST['_visibility'] ) ) {
			if ( update_post_meta( $post_id, '_visibility', wc_clean( $_REQUEST['_visibility'] ) ) ) {
				do_action( 'woocommerce_product_set_visibility', $post_id, wc_clean( $_REQUEST['_visibility'] ) );
			}
		}

		if ( ! empty( $_REQUEST['_featured'] ) ) {
			if ( update_post_meta( $post_id, '_featured', stripslashes( $_REQUEST['_featured'] ) ) ) {
				delete_transient( 'wc_featured_products' );
			}
		}

		// Sold Individually
		if ( ! empty( $_REQUEST['_sold_individually'] ) ) {
			if ( $_REQUEST['_sold_individually'] == 'yes' ) {
				update_post_meta( $post_id, '_sold_individually', 'yes' );
			}
			else {
				update_post_meta( $post_id, '_sold_individually', '' );
			}
		}

		// Handle price - remove dates and set to lowest
		$change_price_product_types = apply_filters( 'woocommerce_bulk_edit_save_price_product_types', array( 'simple', 'external' ) );
		$can_product_type_change_price = false;
		foreach ( $change_price_product_types as $product_type ) {
			if ( $product->is_type( $product_type ) ) {
				$can_product_type_change_price = true;
				break;
			}
		}

		if ( $can_product_type_change_price ) {

			$price_changed = false;

			if ( ! empty( $_REQUEST['change_regular_price'] ) ) {

				$change_regular_price = absint( $_REQUEST['change_regular_price'] );
				$regular_price = esc_attr( stripslashes( $_REQUEST['_regular_price'] ) );

				switch ( $change_regular_price ) {
					case 1 :
						$new_price = $regular_price;
						break;
					case 2 :
						if ( strstr( $regular_price, '%' ) ) {
							$percent = str_replace( '%', '', $regular_price ) / 100;
							$new_price = $old_regular_price + ( round( $old_regular_price * $percent, wc_get_price_decimals() ) );
						} else {
							$new_price = $old_regular_price + $regular_price;
						}
						break;
					case 3 :
						if ( strstr( $regular_price, '%' ) ) {
							$percent = str_replace( '%', '', $regular_price ) / 100;
							$new_price = max( 0, $old_regular_price - ( round ( $old_regular_price * $percent, wc_get_price_decimals() ) ) );
						} else {
							$new_price = max( 0, $old_regular_price - $regular_price );
						}
						break;

					default :
						break;
				}

				if ( isset( $new_price ) && $new_price != $old_regular_price ) {
					$price_changed = true;
					$new_price = round( $new_price, wc_get_price_decimals() );
					update_post_meta( $post_id, '_regular_price', $new_price );
					$product->regular_price = $new_price;
				}
			}

			if ( ! empty( $_REQUEST['change_sale_price'] ) ) {

				$change_sale_price = absint( $_REQUEST['change_sale_price'] );
				$sale_price        = esc_attr( stripslashes( $_REQUEST['_sale_price'] ) );

				switch ( $change_sale_price ) {
					case 1 :
						$new_price = $sale_price;
						break;
					case 2 :
						if ( strstr( $sale_price, '%' ) ) {
							$percent = str_replace( '%', '', $sale_price ) / 100;
							$new_price = $old_sale_price + ( $old_sale_price * $percent );
						} else {
							$new_price = $old_sale_price + $sale_price;
						}
						break;
					case 3 :
						if ( strstr( $sale_price, '%' ) ) {
							$percent = str_replace( '%', '', $sale_price ) / 100;
							$new_price = max( 0, $old_sale_price - ( $old_sale_price * $percent ) );
						} else {
							$new_price = max( 0, $old_sale_price - $sale_price );
						}
						break;
					case 4 :
						if ( strstr( $sale_price, '%' ) ) {
							$percent = str_replace( '%', '', $sale_price ) / 100;
							$new_price = max( 0, $product->regular_price - ( $product->regular_price * $percent ) );
						} else {
							$new_price = max( 0, $product->regular_price - $sale_price );
						}
						break;

					default :
						break;
				}

				if ( isset( $new_price ) && $new_price != $old_sale_price ) {
					$price_changed = true;
					$new_price = ! empty( $new_price ) || '0' === $new_price ? round( $new_price, wc_get_price_decimals() ) : '';
					update_post_meta( $post_id, '_sale_price', $new_price );
					$product->sale_price = $new_price;
				}
			}

			if ( $price_changed ) {
				update_post_meta( $post_id, '_sale_price_dates_from', '' );
				update_post_meta( $post_id, '_sale_price_dates_to', '' );

				if ( $product->regular_price < $product->sale_price ) {
					$product->sale_price = '';
					update_post_meta( $post_id, '_sale_price', '' );
				}

				if ( $product->sale_price ) {
					update_post_meta( $post_id, '_price', $product->sale_price );
				} else {
					update_post_meta( $post_id, '_price', $product->regular_price );
				}
			}
		}

		// Handle stock
		if ( ! $product->is_type( 'grouped' ) ) {

			if ( ! empty( $_REQUEST['change_stock'] ) ) {
				update_post_meta( $post_id, '_manage_stock', 'yes' );
				wc_update_product_stock( $post_id, wc_stock_amount( $_REQUEST['_stock'] ) );
			}

			if ( ! empty( $_REQUEST['_manage_stock'] ) ) {

				if ( $_REQUEST['_manage_stock'] == 'yes' ) {
					update_post_meta( $post_id, '_manage_stock', 'yes' );
				} else {
					update_post_meta( $post_id, '_manage_stock', 'no' );
					wc_update_product_stock( $post_id, 0 );
				}
			}

			if ( ! empty( $_REQUEST['_backorders'] ) ) {
				update_post_meta( $post_id, '_backorders', wc_clean( $_REQUEST['_backorders'] ) );
			}

		}

		do_action( 'woocommerce_product_bulk_edit_save', $product );
	}

	/**
	 * Add extra bulk action options to mark orders as complete or processing.
	 *
	 * Using Javascript until WordPress core fixes: https://core.trac.wordpress.org/ticket/16031.
	 */
	public function bulk_admin_footer() {
		global $post_type;

		if ( 'shop_order' == $post_type ) {
			?>
			<script type="text/javascript">
			jQuery(function() {
				jQuery('<option>').val('mark_processing').text('<?php _e( 'Mark processing', 'woocommerce' )?>').appendTo('select[name="action"]');
				jQuery('<option>').val('mark_processing').text('<?php _e( 'Mark processing', 'woocommerce' )?>').appendTo('select[name="action2"]');

				jQuery('<option>').val('mark_on-hold').text('<?php _e( 'Mark on-hold', 'woocommerce' )?>').appendTo('select[name="action"]');
				jQuery('<option>').val('mark_on-hold').text('<?php _e( 'Mark on-hold', 'woocommerce' )?>').appendTo('select[name="action2"]');

				jQuery('<option>').val('mark_completed').text('<?php _e( 'Mark complete', 'woocommerce' )?>').appendTo('select[name="action"]');
				jQuery('<option>').val('mark_completed').text('<?php _e( 'Mark complete', 'woocommerce' )?>').appendTo('select[name="action2"]');
			});
			</script>
			<?php
		}
	}

	/**
	 * Process the new bulk actions for changing order status.
	 */
	public function bulk_action() {
		$wp_list_table = _get_list_table( 'WP_Posts_List_Table' );
		$action        = $wp_list_table->current_action();

		// Bail out if this is not a status-changing action
		if ( strpos( $action, 'mark_' ) === false ) {
			return;
		}

		$order_statuses = wc_get_order_statuses();

		$new_status    = substr( $action, 5 ); // get the status name from action
		$report_action = 'marked_' . $new_status;

		// Sanity check: bail out if this is actually not a status, or is
		// not a registered status
		if ( ! isset( $order_statuses[ 'wc-' . $new_status ] ) ) {
			return;
		}

		$changed = 0;

		$post_ids = array_map( 'absint', (array) $_REQUEST['post'] );

		foreach ( $post_ids as $post_id ) {
			$order = wc_get_order( $post_id );
			$order->update_status( $new_status, __( 'Order status changed by bulk edit:', 'woocommerce' ), true );
			do_action( 'woocommerce_order_edit_status', $post_id, $new_status );
			$changed++;
		}

		$sendback = add_query_arg( array( 'post_type' => 'shop_order', $report_action => true, 'changed' => $changed, 'ids' => join( ',', $post_ids ) ), '' );

		if ( isset( $_GET['post_status'] ) ) {
			$sendback = add_query_arg( 'post_status', sanitize_text_field( $_GET['post_status'] ), $sendback );
		}

		wp_redirect( esc_url_raw( $sendback ) );
		exit();
	}

	/**
	 * Show confirmation message that order status changed for number of orders.
	 */
	public function bulk_admin_notices() {
		global $post_type, $pagenow;

		// Bail out if not on shop order list page
		if ( 'edit.php' !== $pagenow || 'shop_order' !== $post_type ) {
			return;
		}

		$order_statuses = wc_get_order_statuses();

		// Check if any status changes happened
		foreach ( $order_statuses as $slug => $name ) {

			if ( isset( $_REQUEST[ 'marked_' . str_replace( 'wc-', '', $slug ) ] ) ) {

				$number = isset( $_REQUEST['changed'] ) ? absint( $_REQUEST['changed'] ) : 0;
				$message = sprintf( _n( 'Order status changed.', '%s order statuses changed.', $number, 'woocommerce' ), number_format_i18n( $number ) );
				echo '<div class="updated"><p>' . $message . '</p></div>';

				break;
			}
		}
	}

	/**
	 * Search custom fields as well as content.
	 * @param WP_Query $wp
	 */
	public function shop_order_search_custom_fields( $wp ) {
		global $pagenow;

		if ( 'edit.php' != $pagenow || empty( $wp->query_vars['s'] ) || $wp->query_vars['post_type'] != 'shop_order' ) {
			return;
		}

		$post_ids = wc_order_search( $_GET['s'] );

		if ( ! empty( $post_ids ) ) {
			// Remove "s" - we don't want to search order name.
			unset( $wp->query_vars['s'] );

			// so we know we're doing this.
			$wp->query_vars['shop_order_search'] = true;

			// Search by found posts.
			$wp->query_vars['post__in'] = array_merge( $post_ids, array( 0 ) );
		}
	}

	/**
	 * Change the label when searching orders.
	 *
	 * @param mixed $query
	 * @return string
	 */
	public function shop_order_search_label( $query ) {
		global $pagenow, $typenow;

		if ( 'edit.php' != $pagenow ) {
			return $query;
		}

		if ( $typenow != 'shop_order' ) {
			return $query;
		}

		if ( ! get_query_var( 'shop_order_search' ) ) {
			return $query;
		}

		return wp_unslash( $_GET['s'] );
	}

	/**
	 * Query vars for custom searches.
	 *
	 * @param mixed $public_query_vars
	 * @return array
	 */
	public function add_custom_query_var( $public_query_vars ) {
		$public_query_vars[] = 'sku';
		$public_query_vars[] = 'shop_order_search';

		return $public_query_vars;
	}

	/**
	 * Filters for post types.
	 */
	public function restrict_manage_posts() {
		global $typenow;

		if ( in_array( $typenow, wc_get_order_types( 'order-meta-boxes' ) ) ) {
			$this->shop_order_filters();
		} elseif ( 'product' == $typenow ) {
			$this->product_filters();
		} elseif( 'shop_coupon' == $typenow ) {
			$this->shop_coupon_filters();
		}
	}

	/**
	 * Show a category filter box.
	 */
	public function product_filters() {
		global $wp_query;

		// Category Filtering
		wc_product_dropdown_categories();

		// Type filtering
		$terms   = get_terms( 'product_type' );
		$output  = '<select name="product_type" id="dropdown_product_type">';
		$output .= '<option value="">' . __( 'Show all product types', 'woocommerce' ) . '</option>';

		foreach ( $terms as $term ) {
			$output .= '<option value="' . sanitize_title( $term->name ) . '" ';

			if ( isset( $wp_query->query['product_type'] ) ) {
				$output .= selected( $term->slug, $wp_query->query['product_type'], false );
			}

			$output .= '>';

			switch ( $term->name ) {
				case 'grouped' :
					$output .= __( 'Grouped product', 'woocommerce' );
					break;
				case 'external' :
					$output .= __( 'External/Affiliate product', 'woocommerce' );
					break;
				case 'variable' :
					$output .= __( 'Variable product', 'woocommerce' );
					break;
				case 'simple' :
					$output .= __( 'Simple product', 'woocommerce' );
					break;
				default :
					// Assuming that we have other types in future
					$output .= ucfirst( $term->name );
					break;
			}

			$output .= '</option>';

			if ( 'simple' == $term->name ) {

				$output .= '<option value="downloadable" ';

				if ( isset( $wp_query->query['product_type'] ) ) {
					$output .= selected( 'downloadable', $wp_query->query['product_type'], false );
				}

				$output .= '> &rarr; ' . __( 'Downloadable', 'woocommerce' ) . '</option>';

				$output .= '<option value="virtual" ';

				if ( isset( $wp_query->query['product_type'] ) ) {
					$output .= selected( 'virtual', $wp_query->query['product_type'], false );
				}

				$output .= '> &rarr;  ' . __( 'Virtual', 'woocommerce' ) . '</option>';
			}
		}

		$output .= '</select>';

		echo apply_filters( 'woocommerce_product_filters', $output );
	}

	/**
	 * Show custom filters to filter coupons by type.
	 */
	public function shop_coupon_filters() {
		?>
		<select name="coupon_type" id="dropdown_shop_coupon_type">
			<option value=""><?php _e( 'Show all types', 'woocommerce' ); ?></option>
			<?php
				$types = wc_get_coupon_types();

				foreach ( $types as $name => $type ) {
					echo '<option value="' . esc_attr( $name ) . '"';

					if ( isset( $_GET['coupon_type'] ) )
						selected( $name, $_GET['coupon_type'] );

					echo '>' . esc_html__( $type, 'woocommerce' ) . '</option>';
				}
			?>
		</select>
		<?php
	}

	/**
	 * Show custom filters to filter orders by status/customer.
	 */
	public function shop_order_filters() {
		$user_string = '';
		$user_id     = '';
		if ( ! empty( $_GET['_customer_user'] ) ) {
			$user_id     = absint( $_GET['_customer_user'] );
			$user        = get_user_by( 'id', $user_id );
			$user_string = esc_html( $user->display_name ) . ' (#' . absint( $user->ID ) . ' &ndash; ' . esc_html( $user->user_email ) . ')';
		}
		?>
		<input type="hidden" class="wc-customer-search" name="_customer_user" data-placeholder="<?php esc_attr_e( 'Search for a customer&hellip;', 'woocommerce' ); ?>" data-selected="<?php echo htmlspecialchars( $user_string ); ?>" value="<?php echo $user_id; ?>" data-allow_clear="true" />
		<?php
	}

	/**
	 * Filters and sorting handler.
	 *
	 * @param  array $vars
	 * @return array
	 */
	public function request_query( $vars ) {
		global $typenow, $wp_query, $wp_post_statuses;

		if ( 'product' === $typenow ) {
			// Sorting
			if ( isset( $vars['orderby'] ) ) {
				if ( 'price' == $vars['orderby'] ) {
					$vars = array_merge( $vars, array(
						'meta_key'  => '_price',
						'orderby'   => 'meta_value_num'
					) );
				}
				if ( 'featured' == $vars['orderby'] ) {
					$vars = array_merge( $vars, array(
						'meta_key'  => '_featured',
						'orderby'   => 'meta_value'
					) );
				}
				if ( 'sku' == $vars['orderby'] ) {
					$vars = array_merge( $vars, array(
						'meta_key'  => '_sku',
						'orderby'   => 'meta_value'
					) );
				}
			}

		} elseif ( 'shop_coupon' === $typenow ) {

			if ( ! empty( $_GET['coupon_type'] ) ) {
				$vars['meta_key']   = 'discount_type';
				$vars['meta_value'] = wc_clean( $_GET['coupon_type'] );
			}

		} elseif ( in_array( $typenow, wc_get_order_types( 'order-meta-boxes' ) ) ) {

			// Filter the orders by the posted customer.
			if ( isset( $_GET['_customer_user'] ) && $_GET['_customer_user'] > 0 ) {
				$vars['meta_query'] = array(
					array(
						'key'   => '_customer_user',
						'value' => (int) $_GET['_customer_user'],
						'compare' => '='
					)
				);
			}

			// Sorting
			if ( isset( $vars['orderby'] ) ) {
				if ( 'order_total' == $vars['orderby'] ) {
					$vars = array_merge( $vars, array(
						'meta_key'  => '_order_total',
						'orderby'   => 'meta_value_num'
					) );
				}
			}

			// Status
			if ( ! isset( $vars['post_status'] ) ) {
				$post_statuses = wc_get_order_statuses();

				foreach ( $post_statuses as $status => $value ) {
					if ( isset( $wp_post_statuses[ $status ] ) && false === $wp_post_statuses[ $status ]->show_in_admin_all_list ) {
						unset( $post_statuses[ $status ] );
					}
				}

				$vars['post_status'] = array_keys( $post_statuses );
			}
		}

		return $vars;
	}

	/**
	 * Filter the products in admin based on options.
	 *
	 * @param mixed $query
	 */
	public function product_filters_query( $query ) {
		global $typenow, $wp_query;

		if ( 'product' == $typenow ) {

			if ( isset( $query->query_vars['product_type'] ) ) {
				// Subtypes
				if ( 'downloadable' == $query->query_vars['product_type'] ) {
					$query->query_vars['product_type']  = '';
					$query->is_tax = false;
					$query->query_vars['meta_value']    = 'yes';
					$query->query_vars['meta_key']      = '_downloadable';
				} elseif ( 'virtual' == $query->query_vars['product_type'] ) {
					$query->query_vars['product_type']  = '';
					$query->is_tax = false;
					$query->query_vars['meta_value']    = 'yes';
					$query->query_vars['meta_key']      = '_virtual';
				}
			}

			// Categories
			if ( isset( $_GET['product_cat'] ) && '0' === $_GET['product_cat'] ) {
				$query->query_vars['tax_query'][] = array(
					'taxonomy' => 'product_cat',
					'field'    => 'id',
					'terms'    => get_terms( 'product_cat', array( 'fields' => 'ids' ) ),
					'operator' => 'NOT IN'
				);
			}

			// Shipping classes
			if ( isset( $_GET['product_shipping_class'] ) && '0' === $_GET['product_shipping_class'] ) {
				$query->query_vars['tax_query'][] = array(
					'taxonomy' => 'product_shipping_class',
					'field'    => 'id',
					'terms'    => get_terms( 'product_shipping_class', array( 'fields' => 'ids' ) ),
					'operator' => 'NOT IN'
				);
			}
		}
	}

	/**
	 * Search by SKU or ID for products.
	 *
	 * @param string $where
	 * @return string
	 */
	public function product_search( $where ) {
		global $pagenow, $wpdb, $wp;

		if ( 'edit.php' != $pagenow || ! is_search() || ! isset( $wp->query_vars['s'] ) || 'product' != $wp->query_vars['post_type'] ) {
			return $where;
		}

		$search_ids = array();
		$terms      = explode( ',', $wp->query_vars['s'] );

		foreach ( $terms as $term ) {
			if ( is_numeric( $term ) ) {
				$search_ids[] = $term;
			}

			// Attempt to get a SKU
			$sku_to_id = $wpdb->get_results( $wpdb->prepare( "SELECT ID, post_parent FROM {$wpdb->posts} LEFT JOIN {$wpdb->postmeta} ON {$wpdb->posts}.ID = {$wpdb->postmeta}.post_id WHERE meta_key='_sku' AND meta_value LIKE %s;", '%' . $wpdb->esc_like( wc_clean( $term ) ) . '%' ) );
			$sku_to_id = array_merge( wp_list_pluck( $sku_to_id, 'ID' ), wp_list_pluck( $sku_to_id, 'post_parent' ) );

			if ( sizeof( $sku_to_id ) > 0 ) {
				$search_ids = array_merge( $search_ids, $sku_to_id );
			}
		}

		$search_ids = array_filter( array_unique( array_map( 'absint', $search_ids ) ) );

		if ( sizeof( $search_ids ) > 0 ) {
			$where = str_replace( 'AND (((', "AND ( ({$wpdb->posts}.ID IN (" . implode( ',', $search_ids ) . ")) OR ((", $where );
		}

		return $where;
	}

	/**
	 * Disable the auto-save functionality for Orders.
	 */
	public function disable_autosave() {
		global $post;

		if ( $post && in_array( get_post_type( $post->ID ), wc_get_order_types( 'order-meta-boxes' ) ) ) {
			wp_dequeue_script( 'autosave' );
		}
	}

	/**
	 * Removes variations etc belonging to a deleted post, and clears transients.
	 *
	 * @param mixed $id ID of post being deleted
	 */
	public function delete_post( $id ) {
		global $woocommerce, $wpdb;

		if ( ! current_user_can( 'delete_posts' ) ) {
			return;
		}

		if ( $id > 0 ) {

			$post_type = get_post_type( $id );

			switch ( $post_type ) {
				case 'product' :

					$child_product_variations = get_children( 'post_parent=' . $id . '&post_type=product_variation' );

					if ( ! empty( $child_product_variations ) ) {
						foreach ( $child_product_variations as $child ) {
							wp_delete_post( $child->ID, true );
						}
					}

					$child_products = get_children( 'post_parent=' . $id . '&post_type=product' );

					if ( ! empty( $child_products ) ) {
						foreach ( $child_products as $child ) {
							$child_post                = array();
							$child_post['ID']          = $child->ID;
							$child_post['post_parent'] = 0;
							wp_update_post( $child_post );
						}
					}

					if ( $parent_id = wp_get_post_parent_id( $id ) ) {
						wc_delete_product_transients( $parent_id );
					}

				break;
				case 'product_variation' :
					wc_delete_product_transients( wp_get_post_parent_id( $id ) );
				break;
				case 'shop_order' :
					$refunds = $wpdb->get_results( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_type = 'shop_order_refund' AND post_parent = %d", $id ) );

					if ( ! is_null( $refunds ) ) {
						foreach ( $refunds as $refund ) {
							wp_delete_post( $refund->ID, true );
						}
					}
				break;
			}
		}
	}

	/**
	 * woocommerce_trash_post function.
	 *
	 * @param mixed $id
	 */
	public function trash_post( $id ) {
		global $wpdb;

		if ( $id > 0 ) {

			$post_type = get_post_type( $id );

			if ( in_array( $post_type, wc_get_order_types( 'order-count' ) ) ) {

				// Delete count - meta doesn't work on trashed posts
				$user_id = get_post_meta( $id, '_customer_user', true );

				if ( $user_id > 0 ) {
					delete_user_meta( $user_id, '_money_spent' );
					delete_user_meta( $user_id, '_order_count' );
				}

				$refunds = $wpdb->get_results( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_type = 'shop_order_refund' AND post_parent = %d", $id ) );

				foreach ( $refunds as $refund ) {
					$wpdb->update( $wpdb->posts, array( 'post_status' => 'trash' ), array( 'ID' => $refund->ID ) );
				}

				delete_transient( 'woocommerce_processing_order_count' );
				wc_delete_shop_order_transients( $id );
			}

		}
	}

	/**
	 * woocommerce_untrash_post function.
	 *
	 * @param mixed $id
	 */
	public function untrash_post( $id ) {
		global $wpdb;

		if ( $id > 0 ) {

			$post_type = get_post_type( $id );

			if ( in_array( $post_type, wc_get_order_types( 'order-count' ) ) ) {

				// Delete count - meta doesn't work on trashed posts
				$user_id = get_post_meta( $id, '_customer_user', true );

				if ( $user_id > 0 ) {
					delete_user_meta( $user_id, '_money_spent' );
					delete_user_meta( $user_id, '_order_count' );
				}

				$refunds = $wpdb->get_results( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_type = 'shop_order_refund' AND post_parent = %d", $id ) );

				foreach ( $refunds as $refund ) {
					$wpdb->update( $wpdb->posts, array( 'post_status' => 'wc-completed' ), array( 'ID' => $refund->ID ) );
				}

				delete_transient( 'woocommerce_processing_order_count' );
				wc_delete_shop_order_transients( $id );
			} else if ( 'product' === $post_type ) {
				// Check if SKU is valid before untrash the product.
				$sku = get_post_meta( $id, '_sku', true );

				if ( ! empty( $sku ) ) {
					if ( ! wc_product_has_unique_sku( $id, $sku ) ) {
						update_post_meta( $id, '_sku', '' );
					}
				}
			}
		}
	}

	/**
	 * Remove item meta on permanent deletion.
	 */
	public function delete_order_items( $postid ) {
		global $wpdb;

		if ( in_array( get_post_type( $postid ), wc_get_order_types() ) ) {
			do_action( 'woocommerce_delete_order_items', $postid );

			$wpdb->query( "
				DELETE {$wpdb->prefix}woocommerce_order_items, {$wpdb->prefix}woocommerce_order_itemmeta
				FROM {$wpdb->prefix}woocommerce_order_items
				JOIN {$wpdb->prefix}woocommerce_order_itemmeta ON {$wpdb->prefix}woocommerce_order_items.order_item_id = {$wpdb->prefix}woocommerce_order_itemmeta.order_item_id
				WHERE {$wpdb->prefix}woocommerce_order_items.order_id = '{$postid}';
				" );

			do_action( 'woocommerce_deleted_order_items', $postid );
		}
	}

	/**
	 * Remove downloadable permissions on permanent order deletion.
	 */
	public function delete_order_downloadable_permissions( $postid ) {
		global $wpdb;

		if ( in_array( get_post_type( $postid ), wc_get_order_types() ) ) {
			do_action( 'woocommerce_delete_order_downloadable_permissions', $postid );

			$wpdb->query( $wpdb->prepare( "
				DELETE FROM {$wpdb->prefix}woocommerce_downloadable_product_permissions
				WHERE order_id = %d
			", $postid ) );

			do_action( 'woocommerce_deleted_order_downloadable_permissions', $postid );
		}
	}

	/**
	 * Change title boxes in admin.
	 * @param  string $text
	 * @param  object $post
	 * @return string
	 */
	public function enter_title_here( $text, $post ) {
		switch ( $post->post_type ) {
			case 'product' :
				$text = __( 'Product name', 'woocommerce' );
			break;
			case 'shop_coupon' :
				$text = __( 'Coupon code', 'woocommerce' );
			break;
		}

		return $text;
	}

	/**
	 * Print coupon description textarea field.
	 * @param WP_Post $post
	 */
	public function edit_form_after_title( $post ) {
		if ( 'shop_coupon' === $post->post_type ) {
			?>
			<textarea id="woocommerce-coupon-description" name="excerpt" cols="5" rows="2" placeholder="<?php esc_attr_e( 'Description (optional)', 'woocommerce' ); ?>"><?php echo $post->post_excerpt; // This is already escaped in core ?></textarea>
			<?php
		}
	}

	/**
	 * Hidden default Meta-Boxes.
	 * @param  array  $hidden
	 * @param  object $screen
	 * @return array
	 */
	public function hidden_meta_boxes( $hidden, $screen ) {
		if ( 'product' === $screen->post_type && 'post' === $screen->base ) {
			$hidden = array_merge( $hidden, array( 'postcustom' ) );
		}

		return $hidden;
	}

	/**
	 * Output product visibility options.
	 */
	public function product_data_visibility() {
		global $post;

		if ( 'product' != $post->post_type ) {
			return;
		}

		$current_visibility = ( $current_visibility = get_post_meta( $post->ID, '_visibility', true ) ) ? $current_visibility : apply_filters( 'woocommerce_product_visibility_default' , 'visible' );
		$current_featured   = ( $current_featured = get_post_meta( $post->ID, '_featured', true ) ) ? $current_featured : 'no';

		$visibility_options = apply_filters( 'woocommerce_product_visibility_options', array(
			'visible' => __( 'Catalog/search', 'woocommerce' ),
			'catalog' => __( 'Catalog', 'woocommerce' ),
			'search'  => __( 'Search', 'woocommerce' ),
			'hidden'  => __( 'Hidden', 'woocommerce' )
		) );
		?>
		<div class="misc-pub-section" id="catalog-visibility">
			<?php _e( 'Catalog visibility:', 'woocommerce' ); ?> <strong id="catalog-visibility-display"><?php
				echo isset( $visibility_options[ $current_visibility ]  ) ? esc_html( $visibility_options[ $current_visibility ] ) : esc_html( $current_visibility );

				if ( 'yes' == $current_featured ) {
					echo ', ' . __( 'Featured', 'woocommerce' );
				}
			?></strong>

			<a href="#catalog-visibility" class="edit-catalog-visibility hide-if-no-js"><?php _e( 'Edit', 'woocommerce' ); ?></a>

			<div id="catalog-visibility-select" class="hide-if-js">

				<input type="hidden" name="current_visibility" id="current_visibility" value="<?php echo esc_attr( $current_visibility ); ?>" />
				<input type="hidden" name="current_featured" id="current_featured" value="<?php echo esc_attr( $current_featured ); ?>" />

				<?php
					echo '<p>' . __( 'Choose where this product should be displayed in your catalog. The product will always be accessible directly.', 'woocommerce' ) . '</p>';

					foreach ( $visibility_options as $name => $label ) {
						echo '<input type="radio" name="_visibility" id="_visibility_' . esc_attr( $name ) . '" value="' . esc_attr( $name ) . '" ' . checked( $current_visibility, $name, false ) . ' data-label="' . esc_attr( $label ) . '" /> <label for="_visibility_' . esc_attr( $name ) . '" class="selectit">' . esc_html( $label ) . '</label><br />';
					}

					echo '<p>' . __( 'Enable this option to feature this product.', 'woocommerce' ) . '</p>';

					echo '<input type="checkbox" name="_featured" id="_featured" ' . checked( $current_featured, 'yes', false ) . ' /> <label for="_featured">' . __( 'Featured Product', 'woocommerce' ) . '</label><br />';
				?>
				<p>
					<a href="#catalog-visibility" class="save-post-visibility hide-if-no-js button"><?php _e( 'OK', 'woocommerce' ); ?></a>
					<a href="#catalog-visibility" class="cancel-post-visibility hide-if-no-js"><?php _e( 'Cancel', 'woocommerce' ); ?></a>
				</p>
			</div>
		</div>
		<?php
	}

	/**
	 * Filter the directory for uploads.
	 *
	 * @param array $pathdata
	 * @return array
	 */
	public function upload_dir( $pathdata ) {

		// Change upload dir for downloadable files
		if ( isset( $_POST['type'] ) && 'downloadable_product' == $_POST['type'] ) {

			if ( empty( $pathdata['subdir'] ) ) {
				$pathdata['path']   = $pathdata['path'] . '/woocommerce_uploads';
				$pathdata['url']    = $pathdata['url']. '/woocommerce_uploads';
				$pathdata['subdir'] = '/woocommerce_uploads';
			} else {
				$new_subdir = '/woocommerce_uploads' . $pathdata['subdir'];

				$pathdata['path']   = str_replace( $pathdata['subdir'], $new_subdir, $pathdata['path'] );
				$pathdata['url']    = str_replace( $pathdata['subdir'], $new_subdir, $pathdata['url'] );
				$pathdata['subdir'] = str_replace( $pathdata['subdir'], $new_subdir, $pathdata['subdir'] );
			}
		}

		return $pathdata;
	}

	/**
	 * Run a filter when uploading a downloadable product.
	 */
	public function woocommerce_media_upload_downloadable_product() {
		do_action( 'media_upload_file' );
	}

	/**
	 * Grant downloadable file access to any newly added files on any existing.
	 * orders for this product that have previously been granted downloadable file access.
	 *
	 * @param int $product_id product identifier
	 * @param int $variation_id optional product variation identifier
	 * @param array $downloadable_files newly set files
	 */
	public function process_product_file_download_paths( $product_id, $variation_id, $downloadable_files ) {
		global $wpdb;

		if ( $variation_id ) {
			$product_id = $variation_id;
		}

		$product               = wc_get_product( $product_id );
		$existing_download_ids = array_keys( (array) $product->get_files() );
		$updated_download_ids  = array_keys( (array) $downloadable_files );

		$new_download_ids      = array_filter( array_diff( $updated_download_ids, $existing_download_ids ) );
		$removed_download_ids  = array_filter( array_diff( $existing_download_ids, $updated_download_ids ) );

		if ( ! empty( $new_download_ids ) || ! empty( $removed_download_ids ) ) {
			// determine whether downloadable file access has been granted via the typical order completion, or via the admin ajax method
			$existing_permissions = $wpdb->get_results( $wpdb->prepare( "SELECT * from {$wpdb->prefix}woocommerce_downloadable_product_permissions WHERE product_id = %d GROUP BY order_id", $product_id ) );

			foreach ( $existing_permissions as $existing_permission ) {
				$order = wc_get_order( $existing_permission->order_id );

				if ( ! empty( $order->id ) ) {
					// Remove permissions
					if ( ! empty( $removed_download_ids ) ) {
						foreach ( $removed_download_ids as $download_id ) {
							if ( apply_filters( 'woocommerce_process_product_file_download_paths_remove_access_to_old_file', true, $download_id, $product_id, $order ) ) {
								$wpdb->query( $wpdb->prepare( "DELETE FROM {$wpdb->prefix}woocommerce_downloadable_product_permissions WHERE order_id = %d AND product_id = %d AND download_id = %s", $order->id, $product_id, $download_id ) );
							}
						}
					}
					// Add permissions
					if ( ! empty( $new_download_ids ) ) {

						foreach ( $new_download_ids as $download_id ) {

							if ( apply_filters( 'woocommerce_process_product_file_download_paths_grant_access_to_new_file', true, $download_id, $product_id, $order ) ) {
								// grant permission if it doesn't already exist
								if ( ! $wpdb->get_var( $wpdb->prepare( "SELECT 1=1 FROM {$wpdb->prefix}woocommerce_downloadable_product_permissions WHERE order_id = %d AND product_id = %d AND download_id = %s", $order->id, $product_id, $download_id ) ) ) {
									wc_downloadable_file_permission( $download_id, $product_id, $order );
								}
							}
						}
					}
				}
			}
		}
	}

	/**
	 * Disable DFW feature pointer.
	 */
	public function disable_dfw_feature_pointer() {
		$screen = get_current_screen();

		if ( $screen && 'product' === $screen->id && 'post' === $screen->base ) {
			remove_action( 'admin_print_footer_scripts', array( 'WP_Internal_Pointers', 'pointer_wp410_dfw' ) );
		}
	}

	/**
	 * Removes products, orders, and coupons from the list of post types that support "View Mode" switching.
	 * View mode is seen on posts where you can switch between list or excerpt. Our post types don't support
	 * it, so we want to hide the useless UI from the screen options tab.
	 *
	 * @since 2.6
	 * @param  array $post_types Array of post types supporting view mode
	 * @return array             Array of post types supporting view mode, without products, orders, and coupons
	 */
	public function disable_view_mode_options( $post_types ) {
		unset( $post_types['product'], $post_types['shop_order'], $post_types['shop_coupon'] );
		return $post_types;
	}

	public function maybe_render_blank_state( $which ) {
		global $post_type;

		if ( in_array( $post_type, array( 'shop_order', 'product', 'shop_coupon' ) ) && 'bottom' === $which ) {
			$counts = (array) wp_count_posts( $post_type );
			unset( $counts['auto-draft'] );
			$count  = array_sum( $counts );

			if ( 0 < $count ) {
				return;
			}

			echo '<div class="woocommerce-BlankState">';

			switch ( $post_type ) {
				case 'shop_order' :
					?>
					<h2 class="woocommerce-BlankState-message"><?php _e( 'When you receive a new order, it will appear here.', 'woocommerce' ); ?></h2>
					<a class="woocommerce-BlankState-cta button-primary button" target="_blank" href="https://docs.woocommerce.com/document/managing-orders/?utm_source=blankslate&utm_medium=product&utm_content=ordersdoc&utm_campaign=woocommerceplugin"><?php _e( 'Learn more about orders', 'woocommerce' ); ?></a>
					<?php
				break;
				case 'shop_coupon' :
					?>
					<h2 class="woocommerce-BlankState-message"><?php _e( 'Coupons are a great way to offer discounts and rewards to your customers. They will appear here once created.', 'woocommerce' ); ?></h2>
					<a class="woocommerce-BlankState-cta button-primary button" target="_blank" href="https://docs.woocommerce.com/document/coupon-management/?utm_source=blankslate&utm_medium=product&utm_content=couponsdoc&utm_campaign=woocommerceplugin"><?php _e( 'Learn more about coupons', 'woocommerce' ); ?></a>
					<?php
				break;
				case 'product' :
					?>
					<h2 class="woocommerce-BlankState-message"><?php _e( 'Ready to start selling something awesome?', 'woocommerce' ); ?></h2>
					<a class="woocommerce-BlankState-cta button-primary button" href="<?php echo esc_url( admin_url( 'post-new.php?post_type=product&tutorial=true' ) ); ?>"><?php _e( 'Create your first product!', 'woocommerce' ); ?></a>
					<?php
				break;
			}

			echo '<style type="text/css">#posts-filter .wp-list-table, #posts-filter .tablenav.top, .wrap .subsubsub  { display: none; } </style></div>';
		}
	}
}

endif;

new WC_Admin_Post_Types();
