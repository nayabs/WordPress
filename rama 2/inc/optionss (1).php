<?php
	
function rc_add_submenu() {
		add_submenu_page( 'themes.php', 'RC Options', 'Theme Options', 'manage_options', 'theme_options', 'my_theme_options_page');
	}
add_action( 'admin_menu', 'rc_add_submenu' );
	

function rc_settings_init() { 
	register_setting( 'theme_options', 'rc_options_settings' );
	
	add_settings_section(
		'rc_options_page_section', 
		'Your section description', 
		'rc_options_page_section_callback', 
		'theme_options'
	);
	
	function rc_options_page_section_callback() { 
		echo 'A description and detail about the section.';
	}

	add_settings_field( 
		'rc_text_field', 
		'Enter your text', 
		'rc_text_field_render', 
		'theme_options', 
		'rc_options_page_section' 
	);

	add_settings_field( 
		'rc_checkbox_field', 
		'Check your preference', 
		'rc_checkbox_field_render', 
		'theme_options', 
		'rc_options_page_section'  
	);

	add_settings_field( 
		'rc_radio_field', 
		'Choose an option', 
		'rc_radio_field_render', 
		'theme_options', 
		'rc_options_page_section'  
	);
	
	add_settings_field( 
		'rc_textarea_field', 
		'Enter content in the textarea', 
		'rc_textarea_field_render', 
		'theme_options', 
		'rc_options_page_section'  
	);
	
	add_settings_field( 
		'rc_select_field', 
		'Choose from the dropdown', 
		'rc_select_field_render', 
		'theme_options', 
		'rc_options_page_section'  
	);

	function rc_text_field_render() { 
		$options = get_option( 'rc_options_settings' );
		?>
		<input type="text" name="rc_options_settings[rc_text_field]" value="<?php if (isset($options['rc_text_field'])) echo $options['rc_text_field']; ?>" />
		<?php
	}
	
	function rc_checkbox_field_render() { 
		$options = get_option( 'rc_options_settings' );
	?>
		<input type="checkbox" name="rc_options_settings[rc_checkbox_field]" <?php if (isset($options['rc_checkbox_field'])) checked( 'on', ($options['rc_checkbox_field']) ) ; ?> value="on" />
		<label>Turn it On</label> 
		<?php	
	}
	
	function rc_radio_field_render() { 
		$options = get_option( 'rc_options_settings' );
		?>
		<input type="radio" name="rc_options_settings[rc_radio_field]" <?php if (isset($options['rc_radio_field'])) checked( $options['rc_radio_field'], 1 ); ?> value="1" /> <label>Option One</label><br />
		<input type="radio" name="rc_options_settings[rc_radio_field]" <?php if (isset($options['rc_radio_field'])) checked( $options['rc_radio_field'], 2 ); ?> value="2" /> <label>Option Two</label><br />
		<input type="radio" name="rc_options_settings[rc_radio_field]" <?php if (isset($options['rc_radio_field'])) checked( $options['rc_radio_field'], 3 ); ?> value="3" /> <label>Option Three</label>
		<?php
	}
	
	function rc_textarea_field_render() { 
		$options = get_option( 'rc_options_settings' );
		?>
		<textarea cols="40" rows="5" name="rc_options_settings[rc_textarea_field]"><?php if (isset($options['rc_textarea_field'])) echo $options['rc_textarea_field']; ?></textarea>
		<?php
	}

	function rc_select_field_render() { 
		$options = get_option( 'rc_options_settings' );
		?>
		<select name="rc_options_settings[rc_select_field]">
			<option value="1" <?php if (isset($options['rc_select_field'])) selected( $options['rc_select_field'], 1 ); ?>>Option 1</option>
			<option value="2" <?php if (isset($options['rc_select_field'])) selected( $options['rc_select_field'], 2 ); ?>>Option 2</option>
		</select>
	<?php
	}
	
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

add_action( 'admin_init', 'rc_settings_init' );
