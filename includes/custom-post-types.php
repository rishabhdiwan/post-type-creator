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