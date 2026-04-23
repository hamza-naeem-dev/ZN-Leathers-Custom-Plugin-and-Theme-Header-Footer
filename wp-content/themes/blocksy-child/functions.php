<?php

add_action("wp_enqueue_scripts", "blocksy_child_enqueue_assets");

function blocksy_child_enqueue_assets()
{
    wp_enqueue_style("blocksy-parent", get_template_directory_uri() . '/style.css');
    wp_enqueue_style("blocksy_child", get_stylesheet_uri());
}

add_theme_support("custom-logo");