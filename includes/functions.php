<?php

function printr()
{
    array_map(
        function ($arg) {
            printf('<pre style="margin-block="1rem;font-family:monospace;">%s</pre>', print_r($arg, 1));
        },
        func_get_args()
    );
}

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
    $template_dir = get_template_directory();
    $blocks_dir = $template_dir . '/build/blocks';
    $src_dir = $template_dir . '/src/blocks';

    $blocks = lobelia_get_blocks();

    array_map(
        function ($dir) use ($blocks_dir, $src_dir) {
            register_block_type($blocks_dir . '/' . $dir);
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

function lobelia_add_block_categories($categories)
{
    // Adding a new category.
    $categories[] = [
        'slug'  => 'lobelia',
        'title' => 'Lobelia'
    ];

    return $categories;
}

function lobelia_enqueue_scripts()
{
    wp_enqueue_style('lobelia-style', get_template_directory_uri() . '/build/style.css', [], '0.1.0', 'all');
}

function lobelia_block_editor_assets()
{
    wp_enqueue_style('lobelia-editor-style', get_template_directory_uri() . '/build/editor.css', [], '0.1.0', 'all');
}

function lobelia_unregister_patterns()
{
    remove_theme_support('core-block-patterns');
}

function lobelia_add_editor_style()
{
    add_editor_style(get_template_directory_uri() . '/build/style.css');
}

function lobelia_register_block_styles()
{
    register_block_style(
        'core/image',
        [
            'name' => 'blob',
            'label' => 'Blob'
        ]
    );
}

function lobelia_remove_core_block_styles()
{
    wp_dequeue_style('wp-block-gallery');
    wp_dequeue_style('wp-block-gallery');
}
