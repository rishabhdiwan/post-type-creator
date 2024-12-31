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