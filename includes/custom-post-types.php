<?php
// Register custom post types saved in options
function post_type_creator_register_custom_post_types() {
    $custom_post_types = get_option('post_type_creator_custom_post_types', []);
    foreach ($custom_post_types as $post_type) {
        register_post_type($post_type['machine_name'], [
            'label' => $post_type['display_name'],
            'public' => true,
            'supports' => ['title', 'editor', 'thumbnail'],
            'labels' => [
                'name' => $post_type['display_name'],
                'singular_name' => $post_type['display_name'],
                'add_new_item' => 'Add New ' . $post_type['display_name'],
                'edit_item' => 'Edit ' . $post_type['display_name'],
                'view_item' => 'View ' . $post_type['display_name'],
            ],
        ]);
    }
}

// Hook to register post type dynamically
add_action('init', 'post_type_creator_register_custom_post_types');

function post_type_creator_register_custom_taxonomies() {
    $custom_taxonomies = get_option('post_type_creator_custom_taxonomies', []);

    foreach ($custom_taxonomies as $taxonomy => $post_types) {
        register_taxonomy($taxonomy, $post_types, [
            'label' => ucfirst($taxonomy),
            'public' => true,
            'hierarchical' => true, // Set to false for non-hierarchical taxonomies (like tags)
            'show_ui' => true,
            'show_in_menu' => true,
            'show_in_rest' => true,
            'labels' => [
                'name' => ucfirst($taxonomy),
                'singular_name' => ucfirst($taxonomy),
                'add_new_item' => 'Add New ' . ucfirst($taxonomy),
                'edit_item' => 'Edit ' . ucfirst($taxonomy),
                'view_item' => 'View ' . ucfirst($taxonomy),
            ],
        ]);
    }
}
add_action('init', 'post_type_creator_register_custom_taxonomies');