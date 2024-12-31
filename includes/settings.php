<?php
// Form Submission
function post_type_creator_handle_form_submission() {
    if (isset($_POST['post_type_creator_nonce']) && wp_verify_nonce($_POST['post_type_creator_nonce'], 'post_type_creator_nonce_action')) {
        $display_name = sanitize_text_field($_POST['post_type_name']);
        $machine_name = strtolower(str_replace(' ', '_', $display_name)); // Convert spaces to underscores.

        // Validate post type name
        if (!preg_match('/^[a-zA-Z0-9_]+$/', $machine_name)) {
            add_action('admin_notices', function () {
                echo '<div class="notice notice-error"><p>Invalid post type name. Use only letters, numbers, and underscores.</p></div>';
            });
            return;
        }

        // Save post type name to options
        $custom_post_types = get_option('post_type_creator_custom_post_types', []);
        $custom_post_types[] = [
            'machine_name' => $machine_name,
            'display_name' => $display_name,
        ];
        update_option('post_type_creator_custom_post_types', $custom_post_types);

        add_action('admin_notices', function () use ($display_name) {
            echo '<div class="notice notice-success"><p>Post type "' . esc_html($display_name) . '" created successfully.</p></div>';
        });

    }
}

// Handle form submission
if (is_admin() && isset($_POST['post_type_name'])) {
    add_action('admin_init', 'post_type_creator_handle_form_submission');
}

// Handle post type deletion
function post_type_creator_handle_deletion() {
    if (isset($_GET['delete_post_type']) && isset($_GET['_wpnonce']) && wp_verify_nonce($_GET['_wpnonce'], 'delete_post_type')) {
        $post_type = sanitize_text_field($_GET['delete_post_type']);
        $custom_post_types = get_option('post_type_creator_custom_post_types', []);

        // Remove posts of the post type
        $query = new WP_Query(['post_type' => $post_type, 'posts_per_page' => -1]);
        while ($query->have_posts()) {
            $query->the_post();
            wp_delete_post(get_the_ID(), true);
        }
        wp_reset_postdata();

        // Remove post type from options
        $custom_post_types = array_filter($custom_post_types, function ($type) use ($post_type) {
            return $type['machine_name'] !== $post_type;
        });

        update_option('post_type_creator_custom_post_types', $custom_post_types);

        // Redirect to avoid repeated deletions on refresh
        wp_redirect(admin_url('admin.php?page=post-type-creator'));
        exit;
    }
}

add_action('admin_init', 'post_type_creator_handle_deletion');