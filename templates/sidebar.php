<?php if(get_field('schedule_an_appointment_phone', 'options')): ?>
    <section class="widget widget-appointment">
        <h3><?php the_field('schedule_an_appointment_label', 'options'); ?></h3>
        <p><?php the_field('schedule_an_appointment_phone', 'options'); ?></p>
    </section>
<?php endif; ?>

<?php if (has_nav_menu('secondary_navigation')) : ?>
    <section class="widget widget-practice-area">
        <h3>Practice Areas</h3>
        <?php wp_nav_menu(array('theme_location' => 'secondary_navigation', 'menu_class' => 'sidebar-nav', 'walker' => new Walker_Nav_Menu())); ?>
    </section>
<?php endif; ?>

<?php dynamic_sidebar('sidebar-primary'); ?>