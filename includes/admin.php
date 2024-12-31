<?php
// Function to add menu
function post_type_creator_add_admin_menu() {
  add_menu_page(
      'Post Type Creator',                     // Page title
      'Post Type Creator',                    // Menu title
      'manage_options',                      // Capability
      'post-type-creator',                  // Menu slug
      'post_type_creator_settings_page',   // Callback function
      'dashicons-admin-tools',            // Icon (optional)
    //   20                              // Position (optional)
  );
}

// Callback function for admin page which contains the template for the settings page of the plugin
function post_type_creator_settings_page() {
    echo '<h1>Welcome to the '. esc_html(get_admin_page_title()) . '</h1>';
    ?>
    <div class="wrap">
        <form method="post" action="">
            <?php wp_nonce_field('post_type_creator_nonce_action', 'post_type_creator_nonce'); ?>
            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label for="post_type_name">Post Type Name</label>
                    </th>
                    <td>
                        <input name="post_type_name" id="post_type_name" type="text" class="regular-text" required>
                    </td>
                </tr>
            </table>
            <?php submit_button('Create Post Type'); ?>
        </form>
    </div>
    <?php
}

// Hook to add menu to the admin area
add_action('admin_menu', 'post_type_creator_add_admin_menu');