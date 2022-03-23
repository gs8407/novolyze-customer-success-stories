<?php

/**
 * package Novolyze Customer Success Stories
 */

/*
    Plugin Name: Novolyze Customer Success Stories
    Description: Adds the Customer Success Stories
    Version: 1.0.0
    Author: Mediavista
    Licence: GPLv2 or later
    Text Domain: novolyze-customer-success-stories
 */

if (!function_exists('add_action')) {
  die;
}

define('MY_PLUGIN_PATH', plugin_dir_url(__FILE__));

class SuccessStories
{

  function __construct()
  {
    add_action('init', array($this, 'novolyze_customer_success_stories_register'));
  }

  function register()
  {
    add_action('wp_enqueue_scripts', array($this, 'enqueue'));
  }

  function activate()
  {
    $this->novolyze_customer_success_stories_register();
    flush_rewrite_rules();
  }


  function deactivate()
  {
    flush_rewrite_rules();
  }

  // Register Custom Post Type
  function novolyze_customer_success_stories_register()
  {

    $labels = array(
      'name'                  => _x('Success Stories', 'Post Type General Name', 'novolyze-customer-success-stories'),
      'singular_name'         => _x('Success Story', 'Post Type Singular Name', 'novolyze-customer-success-stories'),
      'menu_name'             => __('Success Stories', 'novolyze-customer-success-stories'),
      'name_admin_bar'        => __('Success Stories', 'novolyze-customer-success-stories'),
      'archives'              => __('Success Stories', 'novolyze-customer-success-stories'),
      'attributes'            => __('Success Stories Attributes', 'novolyze-customer-success-stories'),
      'parent_item_colon'     => __('Parent Item:', 'novolyze-customer-success-stories'),
      'all_items'             => __('All Items', 'novolyze-customer-success-stories'),
      'add_new_item'          => __('Add New Item', 'novolyze-customer-success-stories'),
      'add_new'               => __('Add New', 'novolyze-customer-success-stories'),
      'new_item'              => __('New Item', 'novolyze-customer-success-stories'),
      'edit_item'             => __('Edit Item', 'novolyze-customer-success-stories'),
      'update_item'           => __('Update Item', 'novolyze-customer-success-stories'),
      'view_item'             => __('View Item', 'novolyze-customer-success-stories'),
      'view_items'            => __('View Items', 'novolyze-customer-success-stories'),
      'search_items'          => __('Search Item', 'novolyze-customer-success-stories'),
      'not_found'             => __('Not found', 'novolyze-customer-success-stories'),
      'not_found_in_trash'    => __('Not found in Trash', 'novolyze-customer-success-stories'),
      'featured_image'        => __('Featured Image', 'novolyze-customer-success-stories'),
      'set_featured_image'    => __('Set featured image', 'novolyze-customer-success-stories'),
      'remove_featured_image' => __('Remove featured image', 'novolyze-customer-success-stories'),
      'use_featured_image'    => __('Use as featured image', 'novolyze-customer-success-stories'),
      'insert_into_item'      => __('Insert into item', 'novolyze-customer-success-stories'),
      'uploaded_to_this_item' => __('Uploaded to this item', 'novolyze-customer-success-stories'),
      'items_list'            => __('Items list', 'novolyze-customer-success-stories'),
      'items_list_navigation' => __('Items list navigation', 'novolyze-customer-success-stories'),
      'filter_items_list'     => __('Filter items list', 'novolyze-customer-success-stories'),
    );
    $args = array(
      'label'                 => __('Success Story', 'novolyze-customer-success-stories'),
      'labels'                => $labels,
      'supports'              => array('title', 'editor', 'revisions', 'thumbnail'),
      // 'taxonomies'            => array('post_tag'),
      'hierarchical'          => false,
      'public'                => true,
      'show_ui'               => true,
      'show_in_menu'          => true,
      'menu_position'         => 5,
      'menu_icon'             => 'dashicons-media-spreadsheet',
      'show_in_admin_bar'     => true,
      'show_in_nav_menus'     => true,
      'can_export'            => true,
      'has_archive'           => 'success-stories',
      'exclude_from_search'   => false,
      'publicly_queryable'    => true,
      'capability_type'       => 'page',
    );
    register_post_type('success-stories', $args);
  }

  // Add CSS and JS
  function enqueue()
  {
    wp_enqueue_style('customer-success-stories-styles', plugins_url('/assets/customer-success-stories-main.css', __FILE__));
    wp_enqueue_script('customer-success-stories-scripts', plugins_url('/assets/novolyze-customer-success-stories.js', __FILE__));
    wp_add_inline_script('search', 'ajax_url', admin_url('admin-ajax.php'));
  }

  function portfolios_shortcode()
  {

    $args = array(
      'post_type' => 'success-stories'
    );

    $the_query = new WP_Query($args);
?>
    <div class="portfolio-wrapper">
      <?php if ($the_query->have_posts()) :
        while ($the_query->have_posts()) : $the_query->the_post(); ?>
          <div class="<?php if ($the_query->current_post === 0 || $the_query->current_post % 6 === 0) echo "big";  ?>" style="background-image: url(<?php echo get_the_post_thumbnail_url(get_the_ID(), 'large'); ?>);">
            <a href="<?php echo get_the_permalink(); ?>"><?php the_title(); ?></a>
          </div>
      <?php endwhile;
      endif;
      wp_reset_postdata(); ?>
    </div>

<?php
  }
}

if (class_exists('SuccessStories')) {
  $SuccessStories = new SuccessStories();
  $SuccessStories->register();
}

// Set archive template
function archive_custom_template($template)
{
  global $post;
  $plugin_root_dir = WP_PLUGIN_DIR . '/novolyze-customer-success-stories/';
  if (is_archive() && get_post_type($post) == 'success-stories') {
    $template = $plugin_root_dir . '/inc/templates/archive-success-stories.php';
  }

  return $template;
}
add_filter('archive_template', 'archive_custom_template');

// Set single template
function single_custom_template($template)
{
  $plugin_root_dir = WP_PLUGIN_DIR . '/novolyze-customer-success-stories/';
  if (is_singular('success-stories')) {
    $template = $plugin_root_dir . '/inc/templates/single-success-stories.php';
  }

  return $template;
}
add_filter('single_template', 'single_custom_template', 50, 1);

// Add Solutions category
function solutions_taxonomy()
{
  register_taxonomy(
    'solutions_categories',  // The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces).
    'success-stories',             // post type name
    array(
      'hierarchical' => true,
      'label' => 'Solutions Categories', // display name
      'query_var' => true,
      'rewrite' => array(
        'slug' => 'solutions-taxonomy',    // This controls the base slug that will display before each term
        'with_front' => false  // Don't display the category base before
      )
    )
  );
}
add_action('init', 'solutions_taxonomy');

// Add Industry category
function industry_taxonomy()
{
  register_taxonomy(
    'industry_categories',  // The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces).
    'success-stories',             // post type name
    array(
      'hierarchical' => true,
      'label' => 'Industry Categories', // display name
      'query_var' => true,
      'rewrite' => array(
        'slug' => 'industry-taxonomy',    // This controls the base slug that will display before each term
        'with_front' => false  // Don't display the category base before
      )
    )
  );
}
add_action('init', 'industry_taxonomy');

// Activation
register_activation_hook(__FILE__, array($SuccessStories, 'activate'));

// Deactivation
register_activation_hook(__FILE__, array($SuccessStories, 'deactivate'));



/**
 * Filter
 */

add_action('wp_ajax_filter', 'filter_callback');
add_action('wp_ajax_nopriv_filter', 'filter_callback');

function filter_callback()
{

  header("Content-Type: application/json");

  $result = array();

  if (!empty($_GET['search'])) {
    $search = sanitize_text_field($_GET['search']);
  }

  $paged = 1;
  $paged = sanitize_text_field($_GET['paginate']);

  if (!empty($_GET['solution'])) {
    $solution_operator = "IN";
  } else {
    $solution_operator = "NOT IN";
  }

  if (!empty($_GET['industry'])) {
    $industry_operator = "IN";
  } else {
    $industry_operator = "NOT IN";
  }

  $args = array(
    'post_type' => 'success-stories',
    'post_status' => 'publish',
    's' => $search,
    'posts_per_page' => 20,
    'paged' => $paged,
    'tax_query' => array(
      'relation' => 'OR',
      array(
        'taxonomy' => 'solutions_categories',
        'field' => 'slug',
        'terms' => $_GET['solution'],
        'operator' => $solution_operator
      ),
      array(
        'taxonomy' => 'industry_categories',
        'field' => 'slug',
        'terms' => $_GET['industry'],
        'operator' => $industry_operator
      ),
    )
  );


  // if (!empty($_GET['industry'])) {
  //   $industry = sanitize_text_field($_GET['industry']);
  //   $args['tax_query'][] = array(
  //     'taxonomy' => 'industry_categories',   // taxonomy name
  //     'field' => 'slug',           // term_id, slug or name
  //     'terms' => $industry,
  //   );
  // }

  // if (!empty($_GET['solution'])) {
  //   $solution = sanitize_text_field($_GET['solution']);
  //   $args['tax_query'][] = array(
  //     'taxonomy' => 'solutions_categories',   // taxonomy name
  //     'field' => 'slug',           // term_id, slug or name
  //     'terms' => $solution,
  //   );
  // }

  $filter_query = new WP_Query($args);

  while ($filter_query->have_posts()) {
    $filter_query->the_post();
    $result[] = array(
      'title' => get_the_title(),
      'image' => get_field('image')['url'],
      'permalink' => get_permalink(),
      'current_page' => $paged,
      'max' => $filter_query->max_num_pages,
    );
  }

  echo json_encode($result);

  wp_die();
};
