<?php
  $logo = '<a href="'. get_bloginfo('url') .'"><img src="'. get_template_directory_uri() .'/assets/img/bg/logo.png" alt="'. get_bloginfo('name') .'"></a>';
?>

<header class="navbar navbar-default navbar-static-top" role="banner">

  <div class="container">

    <?php if(is_home()): ?>
      <h1 class="logo"><?php echo $logo; ?></h1>
    <?php else: ?>
      <strong class="logo"><?php echo $logo; ?></strong>
    <?php endif; ?>

    <p class="tagline"><?php echo get_bloginfo('description'); ?></p>

    <?php get_search_form(); ?>

    <div class="navbar-header">

      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>

      <a href="<?php echo get_bloginfo('url'); ?>" class="navbar-brand"><?php echo get_bloginfo('name'); ?></a>

    </div>

    <nav class="collapse navbar-collapse" role="navigation">
      <?php
        if (has_nav_menu('primary_navigation')) :
          wp_nav_menu(array('theme_location' => 'primary_navigation', 'menu_class' => 'nav navbar-nav'));
        endif;
      ?>
    </nav>

  </div>

</header>