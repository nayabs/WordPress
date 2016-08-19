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
// this code below will allow for the enqueue of a stylesheet for the plugin. 
function plugin_enqueue_scripts (){
		wp_enqueue_style ('postplugin', plugins_url ('plugin/css/pluginstyle.css')); 
	} 
add_action( 'wp_enqueue_scripts','plugin_enqueue_scripts' );
/*
* This following code below will register the post type for the lable goals. 
*/
function custom_post_type () { 
	// These labels below will create the necessary variables and items required for the goals post type. 
	$labels = array (
		'name' => 'goals',
		'singular_name' => 'goals',
		'add_new' => 'Weekly goals',
		'all_items' => 'All Items',
		'edit_item' => 'Edit Item',
		'new_item' => 'New Item',
		'search_iterm' => 'Search goals',
		'not_found' => 'No Item Found',
		'not_found_in_trash' => 'No Item Found in Trash',
		'parent_item_colon' => 'Parent Item'
	);
	/*this following array will allow the plugin post type to display on wordpress, along with added a custom menu icon to the goals menu option, as seen on the wordpress backend. 'menu_icon' => 'dashicons-thumbs-up' is the line of code responsible for the changing of icons, using dash icons.   */
	$args = array( 
		'labels' => $labels, 
		'public' => true,
		'has_archive' => true,
		'menu_icon' => 'dashicons-thumbs-up',
		'publicly_queryable' => true,
		'query_var' => true, 
		'rewrite' => true, 
		'capability_type' => 'post', 
		'hierarchical' => true, 
		/*the supports function below will allow for there to be an array of a title,editor and feature a thumbnail for the posts created in the goals section of wordpress.*/
		'supports' => array( 'title', 'editor', 'thumbnail'
			),
		/*Taxonomies have been created below to allow for categories to be displayed in the */
		'taxonomies' => array ('category', 'post_tag'),
		'exclude_from_search' => false, 
		);
	register_post_type('goals', $args);
}
add_action('init','custom_post_type');
/* the code below will construct the widget to be used on wordpress.*/
class rama_my_plugin extends WP_Widget {
	//constructor
	public function __construct() {
		$widget_ops = array(
			'classname' => 'rama_my_plugin', 
			'description' => __( 'Posts will be added in descending order.'
				)
			);
		// A description on the Widget page to describe what the widget does.
		parent::__construct('rama_widget', __('Post type Widget', 'rama'), $widget_ops);
	}
	/* With this function, it will allow for the user end of the widget to be created. */
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
		$events->query('post_type=Rama&showposts=5&order=desc' . $rama);
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
	/* the below function will allow for a form to be created on the WordPress backend for the */
	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 
			'title' => ''
			)
		);
		$title = strip_tags($instance['title']);
	?>
		<!-- Creates a 'Title' label and an input for the user to enter a custom widget title. -->
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>
	<?php }
	/* This will save new instances created by the users and updated the title sections*/
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$new_instance = wp_parse_args( (array) $new_instance, array(
			'title' => ''			)
		);
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}
}
/*The widget will now be called to finish the registration process to wordpress*/
add_action('widgets_init', create_function('', 'return register_widget("rama_my_plugin");'));
/* Below is the simple shortcake for the plugin. by adding [rama-shortecode] to the text editor of a wordpress page or post, it will allow for the goals posts to show up wherever the short code is inserted*/
add_shortcode('rama-shortcode', 'custom_post_type_shortcode');
function custom_post_type_shortcode() {
	$args = array(
		'post_type' => 'goals',
		'showposts' => '1',
		'order' => desc
		);
/* one post will be shown at a time in descending order using this shortcode as show by the 'order' => desc in the arguments array */
/* below is a query that says what would happen if a thumbnail is present and not present. The post will try to pull the thumbnail, but if there is an error, a missing thumbnail class is present. */
	$string = '';
	$query = new WP_Query($args);
	if($query->have_posts()) {
		$string .= '<ul class="rama_shortcode">';
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
