<?php
/*
* Plugin Name: BreezeTact
* Description: Conversions tool - Helps to engage users with quick call-to-actions on mobile at the click of a button such as phone, email, map
* Version: 2.0.1
* Author: BreezeMaxWeb
*/

add_action('wp_footer','bt_conv_conversion_icons');
add_action('wp_enqueue_scripts', 'bt_conv_add_frontend_resources');
add_action('admin_enqueue_scripts', 'bt_conv_add_backend_resources');

add_filter('admin_footer_text', 'bt_conv_remove_footer_admin');

function bt_conv_add_frontend_resources(){

$optionsEWM = get_option('bt_conv_ewm'); 

$tp = "0";
$extSp = "79px";

if($optionsEWM!=""){
$tp = "54px";
$extSp = "133px";
}

$customCSS = '.bt-pl-outer-container {
bottom: '.$tp.';
}

@media(max-width: 550px){

.bt-ext-space-cb-cv {
    height: '.$extSp.';
}

}
';

// get background
$options_r = get_option('bt_conv_background');
$background = esc_html($options_r['bt_conv_field_background']);

if($background==""){
$background = "1e97ff";
}

// get color
$options_r = get_option('bt_conv_clr');
$color = esc_html($options_r['bt_conv_field_clr']);

if($color==""){
$color = "FFF4AD";
}

$customCSS .= '
.bt-conv-front {
border-top: 1px solid #'.$color.' !important;
background: #'.$background.' !important;
color: #'.$color.' !important;
}
.bt-icons-txt-cb, .bt-pl-outer-container a {
color: #'.$color.' !important;
}
.bt-pl-outer-container {
background: #'.$background.' !important;
}
.bt-pl-inner-container {
border-right: 1px solid #'.$color.' !important;
}
';

wp_register_style('icons-stylesheet', '//maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css');
wp_register_style('icons-style', plugins_url('source/front/style.css', __FILE__ ),'','','screen');

wp_enqueue_style('icons-stylesheet');
wp_enqueue_style('icons-style');

wp_add_inline_style('icons-style', $customCSS);

}

function bt_conv_add_backend_resources(){

wp_register_script('jss-color', plugins_url('source/admin/jss-color.js', __FILE__ ),'','',true);
wp_enqueue_script('jss-color');

}

function bt_conv_conversion_icons(){

if(!is_admin()){

// get background
$options_r = get_option('bt_conv_background');
$background = esc_html($options_r['bt_conv_field_background']);

if($background==""){
$background = "1e97ff";
}

// get color
$options_r = get_option('bt_conv_clr');
$color = esc_html($options_r['bt_conv_field_clr']);

if($color==""){
$color = "FFF4AD";
}

// get phone
$options_r = get_option('bt_conv_phone');
// output the title
$phone = esc_html($options_r['bt_conv_field_phone']);

if($phone==""){
$phone = "9999999999";
}

// get email
$options_r = get_option('bt_conv_email');
// output the title
$email = esc_html($options_r['bt_conv_field_email']);

if($email==""){
$email = "your@email.com";
}

// get map
$options_r = get_option('bt_conv_map');
// output the title
$map = esc_html($options_r['bt_conv_field_map']);

if($map==""){
$map = "##";
}

?>

<div class="bt-pl-outer-container">
<a href="tel:<?php echo $phone; ?>"><div class="bt-pl-inner-container bt-pl-inner-container-left">
<p class="bt-icons-txt-cb"><i class="fa fa-phone fa-2x"></i><br> CALL</p>
</div></a>
<a href="mailto:<?php echo $email; ?>"><div class="bt-pl-inner-container bt-pl-inner-container-center">
<p class="bt-icons-txt-cb"><i class="fa fa-envelope fa-2x"></i><br> EMAIL</p>
</div></a>
<a href="<?php echo $map; ?>"><div class="bt-pl-inner-container bt-pl-inner-container-right">
<p class="bt-icons-txt-cb"><i class="fa fa-map-marker fa-2x"></i><br> MAP</p>
</div></a>
</div>
<div class="bt-ext-space-cb-cv"></div>

<?php

// If watermark is enabled
$optionsEWM = get_option('bt_conv_ewm');

if($optionsEWM!=""){
?>
<div class="bt-conv-front bt-wm-bottom"><p>Conversion Optimized By&nbsp;&nbsp;</p><img src="<?php echo plugins_url('images/BreezeTact-Logo-Watermark.png', __FILE__ )  ?>" width="70" /></div>
<?php
}

}

}

function bt_conv_remove_footer_admin(){
    echo '';
}
 
/**
 * @internal never define functions inside callbacks.
 * these functions could be run multiple times; this would result in a fatal error.
 */
 
/**
 * custom option and settings
 */
function bt_conv_settings_init() {

 // register a new setting for "conv" page
 register_setting('conv', 'bt_conv_options');

// Background
 register_setting('conv', 'bt_conv_background');
// Background

// Color
 register_setting('conv', 'bt_conv_clr');
// Color

// Phone
 register_setting('conv', 'bt_conv_phone');
// Phone

// Email
 register_setting('conv', 'bt_conv_email');
// Email
 
// Map
 register_setting('conv', 'bt_conv_map');
// Map
 
// Watermark Status
 register_setting('conv', 'bt_conv_ewm');
// Watermark Status

 // register a new section in the "conv" page
 add_settings_section(
 'bt_conv_section_settings',
 __( 'Conversion Settings:', 'conv' ),
 'bt_conv_section_settings_cb',
 'conv'
 );
 
//New
 // register background
 add_settings_field(
 'bt_conv_field_background',
 __( 'Icons Background (Hex code)', 'conv' ),
 'bt_conv_field_background_cb',
 'conv',
 'bt_conv_section_settings',
 [
 'label_for' => 'bt_conv_field_background',
 'class' => 'bt_conv_row',
 'bt_conv_custom_data' => 'custom',
 ]
 );
 //New

//New
 // register color
 add_settings_field(
 'bt_conv_field_clr',
 __( 'Icons Color (Hex code)', 'conv' ),
 'bt_conv_field_clr_cb',
 'conv',
 'bt_conv_section_settings',
 [
 'label_for' => 'bt_conv_field_clr',
 'class' => 'bt_conv_row',
 'bt_conv_custom_data' => 'custom',
 ]
 );
 //New

//New
 // register phone
 add_settings_field(
 'bt_conv_field_phone',
 __( 'Phone', 'conv' ),
 'bt_conv_field_phone_cb',
 'conv',
 'bt_conv_section_settings',
 [
 'label_for' => 'bt_conv_field_phone',
 'class' => 'bt_conv_row',
 'bt_conv_custom_data' => 'custom',
 ]
 );
 //New

//New
 // register email
 add_settings_field(
 'bt_conv_field_email',
 __( 'Email', 'conv' ),
 'bt_conv_field_email_cb',
 'conv',
 'bt_conv_section_settings',
 [
 'label_for' => 'bt_conv_field_email',
 'class' => 'bt_conv_row',
 'bt_conv_custom_data' => 'custom',
 ]
 );
 //New


//New
 // register map
 add_settings_field(
 'bt_conv_field_map',
 __( 'Map', 'conv' ),
 'bt_conv_field_map_cb',
 'conv',
 'bt_conv_section_settings',
 [
 'label_for' => 'bt_conv_field_map',
 'class' => 'bt_conv_row',
 'bt_conv_custom_data' => 'custom',
 ]
 );
 //New

//New
 // register ewm
 add_settings_field(
 'bt_conv_field_ewm',
 __( 'Enable Watermark', 'conv' ),
 'bt_conv_field_ewm_cb',
 'conv',
 'bt_conv_section_settings',
 [
 'label_for' => 'bt_conv_field_ewm',
 'class' => 'bt_conv_row',
 'bt_conv_custom_data' => 'custom',
 ]
 );
 //New

}
 
/**
 * register our bt_conv_settings_init to the admin_init action hook
 */
add_action( 'admin_init', 'bt_conv_settings_init' );
 
/**
 * custom option and settings:
 * callback functions
 */
 
// conversion section cb
 
// section callbacks can accept an $args parameter, which is an array.
// $args have the following keys defined: title, id, callback.
// the values are defined at the add_settings_section() function.
function bt_conv_section_settings_cb( $args ) {
 ?>
 <p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'Set Fields:', 'conv' ); ?></p>
 <?php
}
 
// conversion field cb

//New
function bt_conv_field_background_cb( $args ) {
$options = get_option('background_options');
?>

 <input id="<?php echo esc_attr( $args['label_for'] ); ?>"
 data-custom="<?php echo esc_attr( $args['bt_conv_custom_data'] ); ?>"
 name="bt_conv_background[<?php echo esc_attr( $args['label_for'] ); ?>]" value="<?php $options_r = get_option('bt_conv_background'); $background = esc_html($options_r['bt_conv_field_background']); if($background==""){ $background = "#1e97ff"; } echo $background; ?>" class="jscolor {width:243, height:150, position:'right',
    borderColor:'#FFF', insetColor:'#FFF', backgroundColor:'#666'}" />

<?php
}
//New

//New
function bt_conv_field_clr_cb( $args ) {
$options = get_option('clr_options');
?>

 <input id="<?php echo esc_attr( $args['label_for'] ); ?>"
 data-custom="<?php echo esc_attr( $args['bt_conv_custom_data'] ); ?>"
 name="bt_conv_clr[<?php echo esc_attr( $args['label_for'] ); ?>]" value="<?php $options_r = get_option('bt_conv_clr'); $color = esc_html($options_r['bt_conv_field_clr']); if($color==""){ $color = "#FFF"; } echo $color; ?>" class="jscolor {width:243, height:150, position:'right',
    borderColor:'#FFF', insetColor:'#FFF', backgroundColor:'#666'}" />

<?php
}
//New

//New
function bt_conv_field_phone_cb( $args ) {
$options = get_option('phone_options');
?>

 <input id="<?php echo esc_attr( $args['label_for'] ); ?>"
 data-custom="<?php echo esc_attr( $args['bt_conv_custom_data'] ); ?>"
 name="bt_conv_phone[<?php echo esc_attr( $args['label_for'] ); ?>]" value="<?php $options_r = get_option('bt_conv_phone'); $phone = esc_html($options_r['bt_conv_field_phone']); if($phone==""){ $phone = "9999999999"; } echo $phone; ?>" />

<?php
}
//New


//New
function bt_conv_field_email_cb( $args ) {
$options = get_option('email_options');
?>

 <input id="<?php echo esc_attr( $args['label_for'] ); ?>"
 data-custom="<?php echo esc_attr( $args['bt_conv_custom_data'] ); ?>"
 name="bt_conv_email[<?php echo esc_attr( $args['label_for'] ); ?>]" value="<?php $options_r = get_option('bt_conv_email'); $email = esc_html($options_r['bt_conv_field_email']); if($email==""){ $email = "your@email.com"; } echo $email; ?>" />

<?php
}
//New

//New
function bt_conv_field_map_cb( $args ) {
$options = get_option('map_options');
?>

 <textarea id="<?php echo esc_attr( $args['label_for'] ); ?>"
 data-custom="<?php echo esc_attr( $args['bt_conv_custom_data'] ); ?>"
 name="bt_conv_map[<?php echo esc_attr( $args['label_for'] ); ?>]" style="width: 163px; height: 100px;"><?php $options_r = get_option('bt_conv_map'); $map = esc_html($options_r['bt_conv_field_map']); if($map==""){ $map = "##"; } echo $map; ?></textarea>

<?php
}
//New

//New
function bt_conv_field_ewm_cb( $args ) {
$options = get_option('ewm_options');
?>

 <input id="<?php echo esc_attr( $args['label_for'] ); ?>"
 data-custom="<?php echo esc_attr( $args['bt_conv_custom_data'] ); ?>"
 name="bt_conv_ewm[<?php echo esc_attr( $args['label_for'] ); ?>]" type="checkbox" value="EWM" <?php $optionsEWM = get_option('bt_conv_ewm'); if($optionsEWM!=""){ echo "checked"; } ?> />

<?php
}
//New

/**
 * top level menu
 */
function bt_conv_options_page() {
 // add top level menu page
 add_menu_page(
 'BreezeTact Interface',
 'BreezeTact Interface',
 'manage_options',
 'conv',
 'bt_conv_options_page_html'
 );
}
 
/**
 * register our bt_conv_options_page to the admin_menu action hook
 */
add_action( 'admin_menu', 'bt_conv_options_page' );
 
/**
 * top level menu:
 * callback functions
 */
function bt_conv_options_page_html() {
 // check user capabilities
 if ( ! current_user_can( 'manage_options' ) ) {
 return;
 }
 
 // add error/update messages
 
 // check if the user have submitted the settings
 // wordpress will add the "settings-updated" $_GET parameter to the url
 if ( isset( $_GET['settings-updated'] ) ) {
 // add settings saved message with the class of "updated"
 add_settings_error( 'bt_conv_messages', 'bt_conv_message', __( 'Settings Saved', 'conv' ), 'updated' );
 }
 
 // show error/update messages
 settings_errors( 'bt_conv_messages' );
 ?>
 <div class="wrap">
 <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
 <form action="options.php" method="post">
 <?php
 // output security fields for the registered setting "conv"
 settings_fields( 'conv' );
 // output setting sections and their fields
 // (sections are registered for "conv", each field is registered to a specific section)
 do_settings_sections( 'conv' );
 // output save settings button
 submit_button( 'Save Settings' );
 ?>
 </form>

<?php

$optionsEWM = get_option('bt_conv_ewm');

if($optionsEWM!=""){
?>
<div class="bt-conv-admin bt-wm-bottom"><p>Conversion Optimized By </p><img src="<?php echo plugins_url('images/BreezeTact-Logo-Watermark.png', __FILE__ );  ?>" width="170" /></div>
<?php
}
?>
 </div>

<?php
}
?>