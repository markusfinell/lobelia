<?php

add_action('init', 'lobelia_register_blocks');

add_action('rest_api_init', 'lobelia_register_rest_routes');

add_filter('allowed_block_types_all', 'lobelia_allow_block_types', 10);

add_filter('block_categories_all', 'lobelia_add_block_categories');

add_action('wp_enqueue_scripts', 'lobelia_enqueue_scripts');
