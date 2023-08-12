<?php

/**
 * Check if block directory is of an actual block,
 * including a block.json file, and is not template
 *
 * @param string $dir        Directory name
 * @param string $blocks_dir Build directory path
 *
 * @return bool
 */
function lobelia_is_legit_block($dir, $blocks_dir)
{
    if (in_array($dir, ['.', '..'])) {
        return false;
    }
    if (!is_dir($blocks_dir . '/' . $dir)) {
        return false;
    }
    if (!file_exists($blocks_dir . '/' . $dir . '/block.json')) {
        return false;
    }

    return true;
}

function lobelia_get_blocks()
{
    $blocks_dir = get_template_directory() . '/build/blocks';

    $blocks = array_filter(
        scandir($blocks_dir),
        function ($dir) use ($blocks_dir) {
            return lobelia_is_legit_block($dir, $blocks_dir);
        }
    );

    return $blocks;
}

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function lobelia_register_blocks($build = '')
{
    $blocks_dir = __DIR__ . '/build/blocks';
    $src_dir = __DIR__ . '/src/blocks';

    $blocks = lobelia_get_blocks();

    array_map(
        function ($dir) use ($blocks_dir, $src_dir) {
            register_block_type($blocks_dir . '/' . $dir);

            if (file_exists($src_dir . '/' . $dir . '/functions.php')) {
                include_once $src_dir . '/' . $dir . '/functions.php';
            }
        },
        $blocks
    );
}

function lobelia_register_rest_routes()
{
    register_rest_route(
        'lobelia/v1',
        '/data',
        [
            'methods' => 'GET',
            'callback' => 'lobelia_get_data',
            'permission_callback' => '__return_true'
        ]
    );
}

function lobelia_get_data()
{
    return true;
}

function lobelia_allow_block_types($allowed_block_types)
{
    $allowed_block_types = array_values(
        array_map(
            function ($block) {
                return 'ma/' . $block;
            },
            lobelia_get_blocks()
        )
    );

    return $allowed_block_types;
}

function lobelia_add_block_categories($categories)
{
    // Adding a new category.
    $categories[] = [
    'slug'  => 'marsapril',
    'title' => 'MarsApril'
    ];

    return $categories;
}

function lobelia_enqueue_scripts()
{
    wp_enqueue_style('map-style', get_stylesheet_uri(), [], '0.1.0', 'all');
}
