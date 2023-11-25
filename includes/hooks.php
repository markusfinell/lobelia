<?php

add_action('init', 'lobelia_register_blocks');
add_action('init', 'lobelia_unregister_patterns');
add_action('init', 'lobelia_add_editor_style');
add_action('init', 'lobelia_register_block_styles');

add_action('rest_api_init', 'lobelia_register_rest_routes');

add_filter('block_categories_all', 'lobelia_add_block_categories');

add_action('wp_enqueue_scripts', 'lobelia_enqueue_scripts');
add_action('wp_enqueue_scripts', 'lobelia_remove_core_block_styles');

add_action('enqueue_block_editor_assets', 'lobelia_block_editor_assets');
