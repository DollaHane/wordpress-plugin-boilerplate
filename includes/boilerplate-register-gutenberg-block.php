<?php

function boilerplate_register_gutenberg_block()
{
    wp_register_script(
        'boilerplate-block-script',
        plugins_url('../build/index.js', __FILE__),
        ['wp-blocks', 'wp-element', 'wp-editor'],
        filemtime(plugin_dir_path(__FILE__) . '../build/index.js')
    );

    register_block_type('boilerplate/experiment-data', [
        'editor_script' => 'boilerplate-block-script',
        'render_callback' => 'boilerplate_render_block'
    ]);
}

function boilerplate_render_block()
{
    global $wpdb;
    $table = $wpdb->prefix . 'experiment_data';

    if ($wpdb->get_var("SHOW TABLES LIKE '$table'") !== $table) {
        return '<p><em>No data found.</em></p>';
    }

    $results = $wpdb->get_results("SELECT * FROM $table ORDER BY created_at ASC");

    if (empty($results)) {
        return '<p><em>No data found.</em></p>';
    }

    ob_start();
    ?>
    <div class="boilerplate-data-block">
        <h2>Boilerplate Gutenberg Block</h2>
        <?php foreach ($results as $row): ?>
            <div>
                <p><?php echo esc_html($row->field_three); ?></p>
                <p><?php echo esc_html($row->field_four); ?></p>
            </div>
        <?php endforeach; ?>
    </div>
    <?php
    return ob_get_clean();
}
