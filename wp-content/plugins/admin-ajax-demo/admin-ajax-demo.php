<?php
/*
* Plugin Name:Ajax in the wordpress Admin demo
* Plugin URI:http://wordpress.
* Description: Ajax in the wordpress Admin demo
* Version: 1.0
* Author :kush juthani
* Author URI: http://wordpress.
*/

function add_admin_page(){
    global $aad_settings;
    $aad_settings=add_options_page(__('Admin Ajax Demo','aad'),__('Admin Ajax','aad'),'manage_options','admin-ajax-demo','aad_render_admin');
}
add_action('admin_menu','add_admin_page');

function aad_render_admin(){
    ?>
    <div class="wrap">
        <h2><?php _e('Admin Ajax Demo','aad'); ?></h2>
        <form id="aad-form" action="" method="POST">
            <div>
                <input type="submit" id="aad_submit" class="button-primary" value="<?php _e('Get Results','aad');?>" name="add-submit" />
                <img src="<?php echo admin_url('/images/wpspin_light.gif');?>" class="waiting" style="display:none;" id="aad_loading" />
            </div>
        </form>
        <div id="aad_results"></div>
    </div>
    <?php
}
function aad_load_scripts($hook){
    global $aad_settings;
    if($hook != $aad_settings)
        return;

    wp_enqueue_script('aad-ajax',plugin_dir_url(__FILE__). 'js/aad-ajax.js',array('jquery'));
    wp_localize_script('aad-ajax','aad_vars',array(
        'aad_nonce'=>wp_create_nonce('aad-nonce')
    ));
}
add_action('admin_enqueue_scripts','aad_load_scripts');

function aad_process_ajax(){

    if(!isset($_POST['aad_nonce']) || !wp_verify_nonce($_POST['aad_nonce'],'aad-nonce'))
        die('Permission denied');

    $downloads=get_posts(array('post_type'=>'post','posts_per_page'=>5));
    if($downloads):
        echo '<ul>';
            foreach($downloads as $download){
                echo '<li>'.get_the_title($download->ID).'   :  <a href="'.get_permalink($download->ID).'">'.__('View Posts','aad').'</li>';
            }
        echo'<ul>';
    else: 
        echo '<p>'.__('No results found','aad').'</p>';
    endif;

    die();
}
add_action('wp_ajax_aad_get_results','aad_process_ajax');