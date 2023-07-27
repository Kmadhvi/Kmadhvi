<?php
/* This file contains admin modifications */

function wp_auth_manage_meta_boxes() {
    add_meta_box('contributors-meta-box', __('Contributors '), 'wp_auth_manage_meta_boxes_contributor_meta_box_callback', array('post'), 'advanced', 'low');
}
add_action('add_meta_boxes', 'wp_auth_manage_meta_boxes', 10, 2);

// Callback function of contributors metbox
function wp_auth_manage_meta_boxes_contributor_meta_box_callback($post) {
    wp_nonce_field(basename(__FILE__), 'auth_nonce');
    $contributors_name = maybe_unserialize(get_post_meta($post->ID, 'author', true));
    ?>

    <table class="form-table">
        <tbody>
            <tr>
                <th scope="row">
                    <label for="contributors">Select Contributors</label>
                </th>
                <td>
                    <?php
                    $blog_authors = get_users(array('role__in' => array('author')));
                    // Array of WP_User objects.

                    foreach ($blog_authors as $blog_author) {
                        if (is_array($contributors_name) && in_array($blog_author->ID, $contributors_name)) {
                            $checked = 'checked="checked"';
                        } else {
                            $checked = null;
                        }
                    ?>
                        <p>
                            <input type="checkbox" name="author[]" value="<?php echo $blog_author->ID; ?>" <?php echo esc_attr($checked); ?> />
                            <?php echo $blog_author->display_name; ?>
                        </p>
                    <?php } ?>
                </td>
            </tr>
        </tbody>
    </table>
    <?php
}

// Callback function save meta box of contributors
add_action('save_post', 'wp_auth_manage_contributors_save_meta_data');
function wp_auth_manage_contributors_save_meta_data($post_id) {

    $is_autosave = wp_is_post_autosave($post_id);
    $is_revision = wp_is_post_revision($post_id);
    $is_valid_nonce = (isset($_POST['auth_nonce']) && wp_verify_nonce($_POST['auth_nonce'], basename(__FILE__))) ? 'true' : 'false';

    if ($is_autosave || $is_revision || !$is_valid_nonce) {
        return;
    }

    // If the checkbox was not empty, save it as an array in post meta
    if (!empty($_POST['author'])) {
        update_post_meta($post_id, 'author', $_POST['author']);
    } else {
        // Otherwise, just delete it if its blank value.
        delete_post_meta($post_id, 'author');
    }
}
?>
