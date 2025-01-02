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
    <div class="wrap" style = "width: 80%; display: flex; justify-content: space-between;">
        <div>
        <h2>Create Post Types</h2>
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
            <h2>Existing Post Types</h2>
            <ul>
                <?php
                    $custom_post_types = get_option('post_type_creator_custom_post_types', []);
                ?>
                <?php if ($custom_post_types) { ?>
                    <?php foreach ($custom_post_types as $post_type): ?>
                        <li>
                            <?php echo esc_html($post_type['display_name']); ?>
                            <a href="<?php echo wp_nonce_url(admin_url('admin.php?page=post-type-creator&delete_post_type=' . $post_type['machine_name']), 'delete_post_type'); ?>" style="color: red; text-decoration: none;">
                                [Delete]
                            </a>
                        </li>
                    <?php endforeach; ?>
                <?php } else {
                    echo 'No Post Types Found!';
                }
                ?>
            </ul>
        </div>
        
        <div>
            <h2>Create Taxonomy</h2>
            <form method="post" action="">
                <?php wp_nonce_field('post_type_creator_taxonomy_action', 'post_type_creator_taxonomy_nonce'); ?>
                <table class="form-table">
                    <tr>
                        <th scope="row"><label for="taxonomy_name">Taxonomy Name</label></th>
                        <td>
                            <input name="taxonomy_name" id="taxonomy_name" type="text" class="regular-text" required>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="post_types">Assign to Post Types</label></th>
                        <td>
                            <?php
                            if (!empty($custom_post_types)) {
                                foreach ($custom_post_types as $post_type) {
                                    echo '<label><input type="checkbox" name="post_types[]" value="' . esc_attr($post_type['machine_name']) . '"> ' . esc_html($post_type['display_name']) . '</label><br>';
                                }
                            } else {
                                echo '<p>No custom post types available. Create some first!</p>';
                            }
                            ?>
                        </td>
                    </tr>
                </table>
                <?php submit_button('Create Taxonomy'); ?>
            </form>

            <!-- List of Present taxonomies -->
            <h2>Present Taxonomies</h2>
            <ul>
                <?php
                $custom_taxonomies = get_option('post_type_creator_custom_taxonomies', []);
                if ($custom_taxonomies) {
                    foreach ($custom_taxonomies as $taxonomy => $post_types) {
                        ?>
                        <li>
                            <?php echo esc_html($taxonomy); ?> (Assigned to: <?php echo implode(', ', $post_types); ?>)
                            <a href="<?php echo wp_nonce_url(admin_url('admin.php?page=post-type-creator&delete_taxonomy=' . $taxonomy), 'delete_taxonomy'); ?>" style="color: red; text-decoration: none;">
                                [Delete Completely]
                            </a>
                        </li>
                        <?php
                    }
                } else {
                    echo 'No Taxonomies found!';
                }
                ?>
            </ul>
        </div>
    </div>
    <?php
}

// Hook to add menu to the admin area
add_action('admin_menu', 'post_type_creator_add_admin_menu');