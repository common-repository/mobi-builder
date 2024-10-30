<?php
/**
* Plugin Name: Mobi Builder
* Plugin URI: https://mobibuilder.tech/documentation/public-projects/
* Description: Embed a Mobi Builder project into your website.
* Version: 1.0
* Author: Mobi Builder
* Author URI: https://mobibuilder.tech/
**/

function mobibuilder_shortcode_function( $atts ){
	$a = shortcode_atts( array(
		'user' => 'NONE',
		'project' => 'NONE',
	), $atts );
	
	$url = "https://mobibuilder.tech/builder/v1/?admin={$a['user']}&project={$a['project']}&shareMode=true";
	$openInNewWindowOption = get_option('mobibuilderopeninnewtab');
	$showBorder = get_option('mobibuildershowborder');
	
	if($a['user'] == "NONE" || $a['project'] == "NONE") {
		$url = "data:text/html;charset=utf-8;base64,PGRpdiBzdHlsZT0iYm9yZGVyOiAycHggc29saWQgcmVkOyBwYWRkaW5nOiAxNXB4OyI+DQo8aDM+IEVycm9yIGZvciBzaXRlIG93bmVyLiA8L2gzPg0KPHA+IFRoZSB1c2VyIGFuZCBwcm9qZWN0IHBhcmFtZXRlciBhcmUgYm90aCByZXF1aXJlZC4gPC9wPg0KPHA+IEV4YW1wbGU6IFttb2JpYnVpbGRlciB1c2VyPSJVU0VSLUlEIiBwcm9qZWN0PSJQUk9KRUNULU5BTUUiXSA8L3A+DQo8cD4gVG8gZmluZCB5b3VyIHVzZXIgaWQgYW5kIHRoZSBwcm9qZWN0IG5hbWUsIGdvIHRvIDxhIGhyZWY9Imh0dHBzOi8vbW9iaS1idWlsZGVyLndlYi5hcHAvcHJvamVjdHMvIiB0YXJnZXQ9Il9ibGFuayI+aHR0cHM6Ly9tb2JpLWJ1aWxkZXIud2ViLmFwcC9wcm9qZWN0cy88L2E+IGFuZCBmaW5kIGFuZCBvcGVuIHlvdXIgcHJvamVjdC4gQ2xpY2sgJ3NoYXJlJyBhbmQgdGhlbiBjaG9vc2UgdG8gc2hhcmUgeW91ciBwcm9qZWN0IHVzaW5nIHRoZSBNb2JpIEJ1aWxkZXIgd29yZHByZXNzIHBsdWdpbi4gWW91IHdpbGwgYmUgZ2l2ZW4gYSBjb21wbGV0ZWQgc2hvcnRjb2RlIHdoaWNoIHlvdSBjYW4gdXNlIHRvIGxvYWQgdGhpcyBwcm9qZWN0LjwvcD4NCjxicj4NCjxwPiBOb3RlOiBUaGUgcHJvamVjdCB3aGljaCB5b3Ugd2lzaCB0byBlbWJlZCBtdXN0IG5vdCBiZSBwcml2YXRlLiA8L3A+DQo8L2Rpdj4=";
		$openInNewWindowOption = false;
	}
	
	$border = "none";
	
	if($showBorder == "1") {
		$borderColor = get_option('mobibuilderbordercolor');
		$borderThickness = get_option('mobibuilderborderthickness');
		$border = "$borderThickness solid $borderColor";
	}

	$iframe = "<iframe src='$url' style='width=100vw height: 500px; border: $border; margin-left: 10px; margin-right: 10px;'> Your browser does not support this content. </iframe>";
	
	if($openInNewWindowOption == "1") {
		return "<center> $iframe <br> <button onclick=\"javascript: window.open('$url')\"> Open this project in a new window </button> </center>";
	}
	else {
		return "<center> $iframe </center>";
	}
}

function mobibuilder_initialize_plugin(){
	add_options_page('Mobi Builder', 'Mobi Builder', 'manage_options', 'mobi-builder', 'mobibuilder_options_page');
	
	add_option( 'mobibuilderopeninnewtab', '1');
    register_setting( 'mobibuilderplugin', 'mobibuilderopeninnewtab', 'mobibuilder_plugin_callback' );
	
	add_option( 'mobibuildershowborder', '0');
    register_setting( 'mobibuilderplugin', 'mobibuildershowborder', 'mobibuilder_plugin_callback' );
	
	add_option( 'mobibuilderbordercolor', 'black');
    register_setting( 'mobibuilderplugin', 'mobibuilderbordercolor', 'mobibuilder_plugin_callback' );
	
    add_option( 'mobibuilderborderthickness', '3px');
    register_setting( 'mobibuilderplugin', 'mobibuilderborderthickness', 'mobibuilder_plugin_callback' );
}

function mobibuilder_options_page()
{
?>
  <div>
  <?php screen_icon(); ?>
  <h2>Mobi Builder</h2>
  <p><b>How to use this plugin</b></p>
  <p>The Mobi Builder plugin allows you to embed a Mobi Builder project onto your website. This allows other people to view, but not edit, your project. The project which you wish to display must be public. You don't have to be the owner of the project to embed it. To use this plugin, you can use the following shortcode. It requires two parameters, user and project. If you want the shortcode filled in for you, go to the <a href="https://mobibuilder.tech/projects/" target="_blank">Mobi Builder shared projects collection</a> and find your project. Click on your project to open it, then click 'share'. Choose to share your project with the Mobi Builder wordpress plugin and you will be given a shortocde which you can copy and paste. If you have not used shortcodes before in WordPress, you can learn more about them <a href="https://wordpress.com/support/shortcodes/" target="_blank">at the WordPress documentation.</a></p>
   <p>[mobibuilder user="USER-ID" project="PROJECT-NAME"]</p>
	
   <br>
	  
	  <p><a href="https://mobibuilder.tech/documentation/public-projects" target="_blank">Read the documentation on how to use this plugin.</a></p>
	  
	<br>
	  
   <p><b>Settings</b></p>
	  
  <form method="post" action="options.php">
  <?php settings_fields( 'mobibuilderplugin' ); ?>
  <table>
  <tr valign="top">
  <th scope="row"><label for="mobibuilderopeninnewtab">Display the 'Open this project in a new window' option</label></th>
	  
  <td>
	<select id="mobibuilderopeninnewtab" name="mobibuilderopeninnewtab">
  		<option value="1">Yes</option>
  		<option value="0">No</option>
	</select> 
  </td>
  </tr>
	  
  <tr valign="top">
  <th scope="row"><label for="mobibuildershowborder">Show border around embedded project</label></th>
	  
  <td>
	<select id="mobibuildershowborder" name="mobibuildershowborder">
  		<option value="1">Yes</option>
  		<option value="0">No</option>
	</select> 
  </td>
  </tr>
	  
  <tr valign="top">
  <th scope="row"><label for="mobibuilderbordercolor">Border color</label></th>
	  
  <td>
	<select id="mobibuilderbordercolor" name="mobibuilderbordercolor">
  		<option value="black">Black</option>
		<option value="white">White</option>
  		<option value="red">Red</option>
		<option value="green">Green</option>
		<option value="blue">Blue</option>
		<option value="yellow">Yellow</option>
	</select> 
  </td>
  </tr>
  
  <tr valign="top">
  <th scope="row"><label for="mobibuilderborderthicknes">Border thickness</label></th>
	  
  <td>
	<select id="mobibuilderborderthickness" name="mobibuilderborderthickness">
  		<option value="1px">1px</option>
		<option value="2px">2px</option>
  		<option value="3px">3px</option>
		<option value="4px">4px</option>
		<option value="5px">5px</option>
		<option value="6px">6px</option>
		<option value="7px">7px</option>
		<option value="8px">8px</option>
	</select> 
  </td>
  </tr>
	  
	<script>
		document.getElementById("mobibuilderopeninnewtab").value = <?php echo get_option('mobibuilderopeninnewtab'); ?>;
	    document.getElementById("mobibuildershowborder").value = <?php echo get_option('mobibuildershowborder'); ?>;
		document.getElementById("mobibuilderbordercolor").value = "<?php echo get_option('mobibuilderbordercolor'); ?>";
		document.getElementById("mobibuilderborderthickness").value = "<?php echo get_option('mobibuilderborderthickness'); ?>";
	</script>
	  
	  
  </table>
  <?php  submit_button(); ?>
  </form>
  </div>
<?php
}

add_action('admin_menu', 'mobibuilder_initialize_plugin');

add_shortcode( 'mobibuilder', 'mobibuilder_shortcode_function' );



function mobibuilder_settings_link($links) { 
  $settings_link = '<a href="options-general.php?page=mobi-builder">Settings</a>'; 
  array_unshift($links, $settings_link); 

  $settings_link = '<a href="https://mobibuilder.tech/documentation/public-projects" target="_blank">Help</a>'; 
  array_unshift($links, $settings_link); 
	
  return $links; 
}
$plugin = plugin_basename(__FILE__); 
add_filter("plugin_action_links_$plugin", 'mobibuilder_settings_link' );