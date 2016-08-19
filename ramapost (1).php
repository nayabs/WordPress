<?php
	
/*
* Plugin Name: Post asssignment 
* Description: Displays posts.
* Plugin URI: http://phoenix.sheridanc.on.ca/~ccit3669
* Author: Rama Chaudhry
* Author URI: http://phoenix.sheridanc.on.ca/~ccit3669
* 
*/

/*
As stated in the wordpress codex, the following code ; the first register post type function will display labels, which are written below.
Next, the second part of the argument will ensure that it shows on the front part of the website for the user

*/


function plugin_enqueue_scripts (){
		wp_enqueue_style ('new-plugin', plugins_url ('new-plugin/css/new-style.css')); 
	} 
add_action( 'wp_enqueue_scripts','plugin_enqueue_scripts' );

/*
* this function registers the custom 'goals' post type
*/

function custom_post_type () { 
	// these are arrays of labels for the custom 'Porfolio' post type.
	$labels = array (
		'name' => 'goals',
		'singular_name' => 'goals',
		'add_new' => 'Todays goals',
		'all_items' => 'All Items',
		'edit_item' => 'Edit Item',
		'new_item' => 'New Item',
		'search_iterm' => 'Search goals',
		'not_found' => 'No Item Found',
		'not_found_in_trash' => 'No Item Found in Trash',
		'parent_item_colon' => 'Parent Item'
	);

	// An array of arguments for custom 'goals' post types.
	$args = array( 
		'labels' => $labels, 
		'public' => true,
		'has_archive' => true,
		'publicly_queryable' => true,
		'query_var' => true, 
		'rewrite' => true, 
		'capability_type' => 'post', 
		'hierarchical' => true, 
		'supports' => array( 
			'title',
			'editor',
			'excerpt',
			'thumbnail',
			'revisions',
			),
		'taxonomies' => array ('category', 'post_tag'),
		'exclude_from_search' => false, 
		);

	register_post_type('goals', $args);
}
add_action('init','custom_post_type');

/*
*
* this function will create the widget 
*
*/

class rama_my_plugin extends WP_Widget {
	//constructor
	public function __construct() {
		$widget_ops = array(
			'classname' => 'rama_my_plugin', 
			'description' => __( 'Adds 3 posts from the special post type in a descending order.'
				)
			);
		// A description on the Widget page to describe what the widget does.
		parent::__construct('rama_widget', __('Special Widget', 'rama'), $widget_ops);
	}

	/*
	*
	* Set up the user side of the widget. Display the widget title and 'goals' posts.
	*
	*/
	public function widget( $args, $instance ) {
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);
		$rama = $instance['rama'];
		echo $before_widget;
		if($title) {
			echo $before_title . $title . $after_title;
		}
		$this->get_my_events($rama);
		echo $after_widget;
	}

	/*
	*
	* A custom query that returns the post's title and Learn More text as links to the rest of the content. 
	* The query also returns a thumbnail and the excerpt. There will be only 3 posts returned, they 
	* will be from the custom 'Portfolio' post type and they will appear in descending order.
	*
	*/
	function get_my_events($rama) {
		global $post;
		$events = new WP_Query();
		$events->query('post_type=Rama&showposts=3&order=desc' . $rama);
		if($events->found_posts>0) {
			echo '<ul class="rama_widget">';
				while($events->have_posts()) {
					$events->the_post();
					$image = (has_post_thumbnail($post->ID)) ? get_the_post_thumbnail($post->ID) : '<div class="missingthumbnail"></div>';
					$eventItem = '<li>' . $image;
					$eventItem .= '<a href="' . get_permalink() . '">';
					$eventItem .= get_the_title() . '</a>';
					$eventItem .= '<span>' . get_the_excerpt() . '';
					$eventItem .= '<a class="widgetmore" href="' . get_permalink() . '">';
					$eventItem .= '<p>Read More... </p>' . '</a></span></li>';
					echo $eventItem;
				}
			echo '</ul>';
			wp_reset_postdata();
		}
	}

	/* this function will create the widget in the WordPress administration dashboard menu. */
	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 
			'title' => ''
			)
		);
		$title = strip_tags($instance['title']);
	?>

		/* here the user can create a title label to enter in the custom widget title */
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>

	<?php }

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$new_instance = wp_parse_args( (array) $new_instance, array(
			'title' => ''			)
		);
		$instance['title'] = strip_tags($new_instance['title']);

		return $instance;
	}
}

/* this code is Registering the widget */
add_action('widgets_init', create_function('', 'return register_widget("rama_my_plugin");'));


// this function is adding the shortcode
add_shortcode('rama-shortcode', 'custom_post_type_shortcode');

function custom_post_type_shortcode() {
	$args = array(
		'post_type' => 'goals',
		'showposts' => '1',
		'order' => desc
		);
	$string = '';
	$query = new WP_Query($args);
	if($query->have_posts()) {
		$string .= '<ul class="hc_shortcode">';
		while($query->have_posts()) {
			$query->the_post();
			$image = (has_post_thumbnail($post->ID)) ? get_the_post_thumbnail($post->ID) : '<div class="missingthumbnail"></div>';
			$string = '<li>' . $image;
			$string .= '<a href="' . get_permalink() . '">';
			$string .= get_the_title() . '</a>';
			$string .= '<span>' . get_the_excerpt() . '';
			$string .= '<a class="ramashortcode" href="' . get_permalink() . '">';
			$string .= '<p>Read More... </p>' . '</a></span></li>';
		}
		$string .= '</ul>';
	}
	wp_reset_postdata();
	return $string;
}
