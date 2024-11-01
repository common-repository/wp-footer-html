<?php
/*
Plugin Name: WP Footer HTML
Plugin URI: http://blog.greg-dev.com/wordpress/wordpress-footer-html/
Description: This plugin allows you to insert HTML in the footer of your blog and you can set it to add the data just to the homepage. <a href="options-general.php?wp-footer-html.php">Configuration Page</a>
Version: 0.2
Author: Greg Molnar
Author URI: http://blog.greg-dev.com
 
License: GPL2
*/

add_action('wp_footer', 'wp_footer_html');
add_action('admin_menu', 'wp_footer_html_create_menu');
add_action('admin_init', 'wp_footer_html_update_settings');

function wp_footer_html_create_menu() {
	add_options_page('WPFooter HTML', 'WPFooter Html Settings', 'administrator', __FILE__, 'wp_footer_html_settings','', __FILE__);
	add_action( 'admin_init', 'register_wp_footer_html_settings' );
}
function wp_footer_html_update_settings(){
	if(!empty($_POST) and isset($_POST['save'])){		
		
		update_option( 'footer_html_content', mysql_real_escape_string(htmlspecialchars_decode($_POST['content'])));
		update_option( 'footer_html_just_home', mysql_real_escape_string($_POST['just_home']));
	}
}
function register_wp_footer_html_settings() {	
	$settings = array(
			  'footer_html_content' =>  '',
			  'footer_html_just_home' => false
			 
			  );
        foreach($settings as $setting => $value){            
	    if(get_option($setting) == ''){        
		update_option( $setting, $value );
	    }
        }     
}

function wp_footer_html()
{
    
    if(get_option('footer_html_just_home')){
	if(is_home() and !is_paged() )echo get_option('footer_html_content');	
    }else echo get_option('footer_html_content');
   
}



function wp_footer_html_settings()
{
    wp_nonce_field('update-options');
    
    
?>
<div class="wrap">
<h2>WP Footer HTML Plugin</h2>
<form method="post" action="">
    <?php /*settings_fields('wp_footer_html-settings-group');*/ ?>

    <h2>Settings</h2>
    <div class="inside">
	<ul>
		<li><label>Content(HTML)</label><br /><textarea name="content" cols="50" rows="8"><?php echo htmlspecialchars(stripslashes(get_option('footer_html_content'))); ?></textarea></li>
		
		<li><label>Appear just on homepage? <input type="checkbox" name="just_home"
		<?php if(get_option('footer_html_just_home'))echo ' checked="checked" ' ?>
		/></label></li>
	</ul>
    </div>
    <p class="submit">
    <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" name="save"/>
    </p>
</form>

</div>
<?php    
  

}

?>