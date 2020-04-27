<?php 
class Atgl_Post_Formats
{

    public function __construct($formats, $screens){
      $this->screens = $screens;
  
      add_theme_support('post-formats', $formats);
  
      foreach($formats as $format){
        if(method_exists($this, 'register_' . $format)){
          add_action('add_meta_boxes', array($this, 'register_' . $format));
          add_action('save_post', array($this, $format . '_meta_box_save'));
        }
      }
  
      add_action('init', array($this, 'init'), 11);
  
      add_action('admin_enqueue_scripts', array($this, 'enqueue'));
    }
  
    public function init(){
      foreach($this->screens as $screen){
        add_post_type_support($screen, 'post-formats');
        register_taxonomy_for_object_type('post_format', $screen);
      }
    }
  
    public function get_base_path(){
      $base = get_template_directory_uri();
  
      $parts = explode(get_template(), dirname(__FILE__));
  
      $url = str_replace('\\', '/', $base . array_pop($parts) );
  
      return $url;
    }
  
    public function enqueue(){
      global $typenow;
      if(in_array($typenow, $this->screens)){
        wp_enqueue_style('post_formats_css', 
                        $this->get_base_path() . 'css/agtl-style.css');
        wp_enqueue_script('post_formats_js', 
                        $this->get_base_path() . 'js/atgl-posts.js', 
                        array('jquery'));
      }
    }
  
    public function register_image(){
      foreach($this->screens as $screen){
        add_meta_box(
          'post_formats_image',
          __('Image', 'post-formats'),
          array($this, 'image_meta_box'),
          $screen,
          'normal',
          'default'
        );
      }
    }
  
    public function register_aside(){
      foreach($this->screens as $screen){
        add_meta_box(
          'post_formats_aside',
          __('Aside', 'post-formats'),
          array($this, 'aside_meta_box'),
          $screen,
          'normal',
          'default'
        );
      }
    }

    public function image_meta_box($post){
      wp_nonce_field('post_format_image_nonce', 'post_format_image_nonce');
      $image = get_post_meta($post->ID, '_post_format_image', true);
      ?>
        <p style="text-align:center;">
          <img src="<?php echo(wp_get_attachment_image_src($image, 'thumbnail')[0]); ?>" id="post_format_image_thumb" />
        </p>
        <input type="hidden" id="post_format_image" name="post_format_image" value="<?php echo($image); ?>" />
        <input type="button" id="post_format_image_select" value="<?php _e('Select Image', 'post-formats'); ?>" />
      <?php
    }
  
    public function image_meta_box_save($post_id){
      $is_autosave = wp_is_post_autosave($post_id);
      $is_revision = wp_is_post_revision($post_id);
      $is_valid_nonce = (isset($_POST[ 'post_format_image_nonce' ]) && wp_verify_nonce($_POST['post_format_image_nonce'], 'post_format_image_nonce')) ? 'true' : 'false';
  
      if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
      }
  
      if(isset($_POST['post_format_image'])){
        update_post_meta($post_id, '_post_format_image', $_POST['post_format_image']);
      }
    }

    public function aside_meta_box($post){
      wp_nonce_field('post_format_aside_nonce', 'post_format_aside_nonce');
      $aside = get_post_meta($post->ID, '_post_format_aside', true);
      ?>
        <p style="text-align:center;">
          <img src="<?php echo(wp_get_attachment_url($aside)); ?>" id="post_formats_aside_preview" height="150" />
        </p>
        <input type="hidden" id="post_format_aside" name="post_format_aside" value="<?php echo($aside); ?>" />
        <input type="button" id="post_format_aside_select" value="<?php _e('Select Aside', 'post_formats'); ?>" />
      <?php
    }
  
    public function aside_meta_box_save($post_id){
      $is_autosave = wp_is_post_autosave($post_id);
      $is_revision = wp_is_post_revision($post_id);
      $is_valid_nonce = (isset($_POST[ 'post_format_aside_nonce' ]) 
        && wp_verify_nonce($_POST['post_format_aside_nonce'], 
        'post_format_aside_nonce') ) ? 'true' : 'false';
  
      if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
      }
  
      if( isset( $_POST['post_format_aside'] ) ) {
        update_post_meta( $post_id, '_post_format_aside', $_POST['post_format_aside'] );
      }
    }
}