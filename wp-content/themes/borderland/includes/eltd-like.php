<?php
class ElatedLike {
	
	 function __construct(){	
		add_action('wp_enqueue_scripts', array(&$this, 'enqueue_scripts'));
		add_action('wp_ajax_eltd_like', array(&$this, 'ajax'));
		add_action('wp_ajax_nopriv_eltd_like', array(&$this, 'ajax'));
	}
	
	function enqueue_scripts(){
		
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'eltd-like', get_template_directory_uri() . '/js/eltd-like.js', 'jquery', '1.0', TRUE );
		
		wp_localize_script( 'eltd-like', 'eltdLike', array(
			'ajaxurl' => admin_url('admin-ajax.php')
		));
	}
	
	function ajax($post_id){		
		//update
		if( isset($_POST['likes_id']) ) {
			$post_id = str_replace('eltd-like-', '', $_POST['likes_id']);
			$type    = isset($_POST['type']) ? $_POST['type'] : '';

			echo wp_kses($this->like_post($post_id, 'update', $type), array(
				'span' => array(
					'class' => true,
					'aria-hidden' => true,
					'style' => true,
					'id' => true
				),
				'i' => array(
					'class' => true,
					'style' => true,
					'id' => true
				)
			));
		} 
		
		//get
		else {
			$post_id = str_replace('eltd-like-', '', $_POST['likes_id']);
			echo wp_kses($this->like_post($post_id, 'get'), array(
				'span' => array(
					'class' => true,
					'aria-hidden' => true,
					'style' => true,
					'id' => true
				),
				'i' => array(
					'class' => true,
					'style' => true,
					'id' => true
				)
			));
		}
		exit;
	}
	
	function like_post($post_id, $action = 'get', $type = ''){
		if(!is_numeric($post_id)) return;
	
		switch($action) {
		
			case 'get':
				$like_count = get_post_meta($post_id, '_eltd-like', true);
				if(isset($_COOKIE['eltd-like_'. $post_id])){
					$icon = '<i class="icon_heart" aria-hidden="true"></i>';
				}else{
					$icon = '<i class="icon_heart_alt" aria-hidden="true"></i>';
				}
				if( !$like_count ){
					$like_count = 0;
					add_post_meta($post_id, '_eltd-like', $like_count, true);
					$icon = '<i class="icon_heart_alt" aria-hidden="true"></i>';
				}
				$return_value = $icon . "<span>" . $like_count . "</span>";
				
				return $return_value;
				break;
				
			case 'update':
				$like_count = get_post_meta($post_id, '_eltd-like', true);

				if($type != 'portfolio_list' && isset($_COOKIE['eltd-like_'. $post_id])) {
					return $like_count;
				}
				
				$like_count++;

				update_post_meta($post_id, '_eltd-like', $like_count);
				setcookie('eltd-like_'. $post_id, $post_id, time()*20, '/');

				if($type != 'portfolio_list') {
					$return_value = "<i class='icon_heart' aria-hidden='true'></i><span>" . $like_count . "</span>";

					$return_value .= '</span>';
					return $return_value;
				}

				return '';
				break;
			default:
				return '';
				break;
		}
	}

	function add_eltd_like(){
		global $post;

		$output = $this->like_post($post->ID);
  
  		$class = 'eltd-like';
  		$title = __('Like this', 'eltd');
		if( isset($_COOKIE['eltd-like_'. $post->ID]) ){
			$class = 'eltd-like liked';
			$title = __('You already liked this!', 'eltd');
		}
		
		return '<a href="#" class="'. $class .'" id="eltd-like-'. $post->ID .'" title="'. $title .'">'. $output .'</a>';
	}

	function add_eltd_like_portfolio_list($portfolio_project_id){

  		$class = 'eltd-like';
  		$title = __('Like this', 'eltd');
		if( isset($_COOKIE['eltd-like_'. $portfolio_project_id]) ){
			$class = 'eltd-like liked';
			$title = __('You already like this!', 'eltd');
		}
		
		return '<a class="'. $class .'" data-type="portfolio_list" id="eltd-like-'. $portfolio_project_id .'" title="'. $title .'"></a>';
	}

    function add_eltd_like_blog_list($blog_id){

        $class = 'eltd-like';
        $title = __('Like this', 'eltd');
        if( isset($_COOKIE['eltd-like_'. $blog_id]) ){
            $class = 'eltd-like liked';
            $title = __('You already like this!', 'eltd');
        }

        return '<a class="hover_icon '. $class .'" data-type="portfolio_list" id="eltd-like-'. $blog_id .'" title="'. $title .'"></a>';
    }
}

global $eltd_like;
$eltd_like = new ElatedLike();

function eltd_like() {
	global $eltd_like;
	echo wp_kses($eltd_like->add_eltd_like(), array(
		'span' => array(
			'class' => true,
			'aria-hidden' => true,
			'style' => true,
			'id' => true
		),
		'i' => array(
			'class' => true,
			'style' => true,
			'id' => true
		),
		'a' => array(
			'href' => true,
			'class' => true,
			'id' => true,
			'title' => true,
			'style' => true
		)
	));
}

function eltd_like_latest_posts() {
	global $eltd_like;
	return $eltd_like->add_eltd_like(); 
}

function eltd_like_portfolio_list($portfolio_project_id) {
	global $eltd_like;
	return $eltd_like->add_eltd_like_portfolio_list($portfolio_project_id);
}