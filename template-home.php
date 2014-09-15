<?php
/*
Template Name: Homepage
*/
?>

<?php while (have_posts()) : the_post(); ?>
    <div id="columns">
        <?php get_template_part('templates/content', 'page'); ?>
    </div>
<?php endwhile; ?>
