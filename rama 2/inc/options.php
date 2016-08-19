<?php


//This function adds the options page on the sub-menu item to the existing menu
function rc_add_submenu() {
		add_submenu_page( 'themes.php', 'RC Options', 'Theme Options', 'manage_options', 'theme_options', 'my_theme_options_page');
	}
add_action( 'admin_menu', 'rc_add_submenu' );
	
//this registers the settings for the options page
function rc_settings_init() { 
	register_setting( 'theme_options', 'rc_options_settings' );
//this function will add setting field 
	add_settings_section(
		'rc_options_page_section', 
		'Description', 
		'rc_options_page_section_callback', 
		'theme_options'
	);
//this function provides the section detail and description
	function rc_options_page_section_callback() { 
		echo 'About Me.';
	}
//this function adds a textbox to the setting field
	add_settings_field( 
		'rc_text_field', 
		'Work Experience', 
		'rc_text_field_render', 
		'theme_options', 
		'rc_options_page_section' 
	);
function rc_text_field_render() { 
		$options = get_option( 'rc_options_settings' );
		?>
		<input type="text" name="rc_options_settings[rc_text_field]" value="<?php if (isset($options['rc_text_field'])) echo $options['rc_text_field']; ?>" />
		<?php
	}


//this function will add a checkbox 
	add_settings_field( 
		'rc_checkbox_field', 
		'Check your preference', 
		'rc_checkbox_field_render', 
		'theme_options', 
		'rc_options_page_section'  
	);
	
function rc_checkbox_field_render() { 
		$options = get_option( 'rc_options_settings' );
	?>
		<input type="checkbox" name="rc_options_settings[rc_checkbox_field]" <?php if (isset($options['rc_checkbox_field'])) checked( 'on', ($options['rc_checkbox_field']) ) ; ?> value="on" />
		<label>Turn it On</label> 
		<?php	
	}	
//this function will add a radio button 
	add_settings_field( 
		'rc_radio_field', 
		'Qualifications', 
		'rc_radio_field_render', 
		'theme_options', 
		'rc_options_page_section'  
	);
	
	function rc_radio_field_render() { 
		$options = get_option( 'rc_options_settings' );
		?>
		<input type="radio" name="rc_options_settings[rc_radio_field]" <?php if (isset($options['rc_radio_field'])) checked( $options['rc_radio_field'], 1 ); ?> value="1" /> <label>Bachelors</label><br />
		<input type="radio" name="rc_options_settings[rc_radio_field]" <?php if (isset($options['rc_radio_field'])) checked( $options['rc_radio_field'], 2 ); ?> value="2" /> <label>Masters</label><br />
		<input type="radio" name="rc_options_settings[rc_radio_field]" <?php if (isset($options['rc_radio_field'])) checked( $options['rc_radio_field'], 3 ); ?> value="3" /> <label>PH.D</label>
		<?php
	}
	

	//this will create the options page under Appearance on the Dashboard o
	function my_theme_options_page(){ 
		?>
		<form action="options.php" method="post">
			<h2>RC Theme Options</h2>
			<?php
			settings_fields( 'theme_options' );
			do_settings_sections( 'theme_options' );
			submit_button();
			?>
		</form>
		<?php
	}

}
//this will activate the plugin
add_action( 'admin_init', 'rc_settings_init' );
