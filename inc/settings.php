<?php
//Settings Page HTML
function wpac_options_page_html() {
    // check user capabilities
    if (!current_user_can('manage_options')) {
        return;
    }
    ?>
    <div class="wrap">
        <h1><?= esc_html(get_admin_page_title()); ?></h1>
        <form action="options.php" method="post">
            <?php
            // output security fields for the registered setting "wporg_options"
            settings_fields('wpac-settings');
            // output setting sections and their fields
            // (sections are registered for "wporg", each field is registered to a specific section)
            do_settings_sections('wpac-settings');
            // output save settings button
            submit_button('Save Settings');
            ?>
        </form>
    </div>
    <?php

}
//Settings Page & Menus
function wpac_options_page()
{
   add_menu_page(
       'WPAC Like System',
       'WPAC Settings',
       'manage_options',
       'wpac-settings',
       'wpac_options_page_html',
       'dashicons-thumbs-up',
       50
   );
}
add_action('admin_menu', 'wpac_options_page');

//Register Settings & Sections
function wpac_settings_init()
{
    // register a new setting for "reading" page
    register_setting('wpac-settings', 'wpac_like_btn_label');
    register_setting('wpac-settings', 'wpac_dislike_btn_label');
 
    // register a new section in the "reading" page
    add_settings_section(
        'wpac_settings_labels_section',
        'Button Labels',
        'wparc_labels_section_cb',
        'wpac-settings'
    );
 
    // register a new field in the "wporg_settings_section" section, inside the "reading" page
    add_settings_field(
        'wpac_like_btn_label_txt',
        'Like Button Label',
        'wpac_like_label_field_cb',
        'wpac-settings',
        'wpac_settings_labels_section'
    );
    add_settings_field(
        'wpac_dislike_btn_label_txt',
        'Dislike Button Label',
        'wpac_dislike_label_field_cb',
        'wpac-settings',
        'wpac_settings_labels_section'
    );
}
 
/**
 * register wporg_settings_init to the admin_init action hook
 */
add_action('admin_init', 'wpac_settings_init');
 
/**
 * callback functions
 */
 
// section content cb
function wparc_labels_section_cb()
{
    echo '<p>Set Labels for Buttons.</p>';
}
 
// field content cb
function wpac_like_label_field_cb()
{
    // get the value of the setting we've registered with register_setting()
    $setting = get_option('wpac_like_btn_label');
    // output the field
    ?>
    <input type="text" name="wpac_like_btn_label" value="<?php echo isset( $setting ) ? esc_attr( $setting ) : ''; ?>">
    <?php
}
function wpac_dislike_label_field_cb()
{
    // get the value of the setting we've registered with register_setting()
    $setting = get_option('wpac_dislike_btn_label');
    // output the field
    ?>
    <input type="text" name="wpac_dislike_btn_label" value="<?php echo isset( $setting ) ? esc_attr( $setting ) : ''; ?>">
    <?php
}
