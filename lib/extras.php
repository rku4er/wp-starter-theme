<?php

/**
 * Clean up the_excerpt()
 */
add_filter('excerpt_more', 'roots_excerpt_more');

function roots_excerpt_more($more) {
  return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', 'roots') . '</a>';
}


/**
 * Manage output of wp_title()
 */
add_filter('wp_title', 'roots_wp_title', 10);

function roots_wp_title($title) {
  if (is_feed()) {
    return $title;
  }

  $title .= get_bloginfo('name');

  return $title;
}


/**
 * Filtering the Wrapper: Custom Post Types
 */
add_filter('roots_wrap_base', 'roots_wrap_base_cpts');

function roots_wrap_base_cpts($templates) {
    $cpt = get_post_type();
    if ($cpt) {
       array_unshift($templates, 'base-' . $cpt . '.php');
    }
    return $templates;
}


/**
 * Search Filter
 */
add_action('pre_get_posts','search_filter');

function search_filter($query) {
  if ( !is_admin() && $query->is_main_query() ) {
    if ($query->is_search) {
      $query->set('post_type', 'post');
    }
  }
}


/**
 * Posts count Filter
 */
add_action( 'pre_get_posts', 'my_post_queries' );

function my_post_queries( $query ) {

  $home_posts = function_exists('get_field') ? get_field('posts_on_blog_page', 'options') : '';
  $category_posts = function_exists('get_field') ? get_field('posts_on_category_page', 'options') : '';

  // do not alter the query on wp-admin pages and only alter it if it's the main query
  if (!is_admin() && $query->is_main_query()){

    // alter the query for the home and category pages
    if(is_home()){
      $query->set('posts_per_page', $home_posts ? $home_posts : 4);
    }

    if(is_category()){
      $query->set('posts_per_page', $category_posts ? $category_posts : 4);
    }

  }
}


/**
 * Copyright shortcode
 */
add_shortcode('copyright', 'copyright_func');

function copyright_func($atts, $content = null) {
    $atts = shortcode_atts(array(), $atts);

    $output = '';

    $copyright = function_exists('get_field') ? get_field('copyright', 'options') : '';

    if($copyright){
      $output .= 'Copyright &copy; ' . date('Y') . ' ' . $copyright;
    }

    return $output;
}


/**
 * Slider shortcode
 */
add_shortcode('slider', 'slider_func');

function slider_func($atts, $content = null) {
  $atts = shortcode_atts(array(
    'timeout' => '0'
  ), $atts);

  $output = '';

  $slider = function_exists('get_field') ? get_field('slider') : '';

  if($slider){

    $output .= '<section id="home-slider" class="carousel slide carousel-fade" data-ride="carousel" data-interval="'. $atts['timeout'] .'">';

    $output .= '<div class="carousel-inner">';

    $i = 0;

    while(have_rows('slider')){

        the_row();
        $i++;
        $active = ($i == 1) ? 'active' : '';
        $img_src = wp_get_attachment_image_src(get_sub_field('image'), 'home-slider', false);
        $target = get_sub_field('new_window') ? 'target="_blank"' : '';
        $image = '<img src="'. $img_src[0] .'" alt="">';
        $url = get_sub_field('url');
        $title = '<h2 class="title">' . get_sub_field('title') . '</h2>';
        $caption = '<p class="caption">'. get_sub_field('caption') .'</p>';

        $output .= '<div class="item '. $active .'">'; // item begin
        $output .= $url ? '<a href="'. $url .'" '. $target .'>' . $image . '</a>' : $image;
        $output .= '<div class="bar">';
        $output .= $title;
        $output .= $caption;
        $output .= '<a href="'. $url .'" '. $target .' class="more"><span class="like-table"><span class="like-table-cell">' . __('Read More', 'roots') . '</span></span></a>';
        $output .= '</div>';
        $output .= '</div>'; // item end
    }

    $output .= '</div>';

    $output .= '</section>';

  }

  return $output;
}


/**
 * About images shortcode
 */
add_shortcode('images', 'row_images_func');

function row_images_func($atts, $content = null) {
  $atts = shortcode_atts(array(
    'items_in_row' => '4'
  ), $atts);

  $num = 12 / $atts['items_in_row'];

  $output = '';

  $row_images = function_exists('get_field') ? get_field('row_images') : '';

  if($row_images){

    $output .= '<section id="row_images" class="demos">';

    $i = 0;

    while(have_rows('row_images')){

        the_row();
        $i++;
        $full_src = wp_get_attachment_image_src(get_sub_field('image'), 'full', false);
        $thumb_src = wp_get_attachment_image_src(get_sub_field('image'), 'demos', false);
        $lightbox = get_sub_field('lightbox') ? 'rel="lightbox[row_images]"' : '';
        $href = $full_src[0];

        if($i == 1 || ($i-1)%$atts['items_in_row'] == 0){
          $output .= '<div class="row">';
        }

        $output .= '<div class="col-sm-'. $num .'">';
        $output .= '<h3 style="background-image: url('. $thumb_src[0] .')"><a href="'. $href .'"'. $lightbox .'><img src="'. $thumb_src[0] .'" alt=""></a></h3>';
        $output .= '</div>';

        if($i == count(get_field('row_images')) || $i%$atts['items_in_row'] == 0){
          $output .= '</div>';
        }
    }

    $output .= '</section>';

  }

  return $output;
}


/**
 * Helpful layout shortcodes
 */
add_shortcode('container_open', 'container_open_func');
function container_open_func($atts, $content = null) {
  return '<div class="container">';
}

add_shortcode('container_close', 'container_close_func');
function container_close_func($atts, $content = null) {
  return '</div>';
}

add_shortcode('row_open', 'row_open_func');
function row_open_func($atts, $content = null) {
  return '<div class="row">';
}

add_shortcode('row_close', 'row_close_func');
function row_close_func($atts, $content = null) {
  return '</div>';
}

add_shortcode('column_open', 'column_open_func');
function column_open_func($atts, $content = null) {
  return '<div class="col-md-6">';
}

add_shortcode('column_close', 'column_close_func');
function column_close_func($atts, $content = null) {
  return '</div>';
}