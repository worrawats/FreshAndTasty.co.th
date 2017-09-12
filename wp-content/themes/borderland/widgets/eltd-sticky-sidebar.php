<?php
class Elated_Sticky_Sidebar extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'eltd-sticky-sidebar', // Base ID
			'Elated Sticky Sidebar', // Name
			array( 'description' => __( 'Use this widget to make the sidebar sticky. Drag it into the sidebar above the widget which you want to be the first element in the sticky sidebar.', 'eltd' ), ) // Args
		);
	}

	public function widget( $args, $instance ) {
		echo '<div class="widget widget_sticky-sidebar"></div>';
	}


	public function update( $new_instance, $old_instance ) {
		$instance = array();
		return $instance;
	}

}
add_action( 'widgets_init', create_function( '', 'register_widget( "Elated_Sticky_Sidebar" );' ) );
