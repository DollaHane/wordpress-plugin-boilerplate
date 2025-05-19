<?php

function boilerplate_render_sub_page()
{
    global $wpdb;
    $table = $wpdb->prefix . 'experiment_data';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $fieldThree = sanitize_text_field($_POST['fieldThree']);
        $fieldFour = sanitize_text_field($_POST['fieldFour']);

        $wpdb->insert($table, [
            'field_three' => $fieldThree,
            'field_four' => $fieldFour,
            'created_at' => current_time('mysql')
        ]);

        echo '<div class="notice notice-success"><p>Data saved successfully!</p></div>';
    }

    $results = $wpdb->get_results("SELECT * FROM $table ORDER BY created_at ASC");

?>
    <div class="wrap">
        <h1>Boilerplate WordPress Database Form</h1>
        <form method="POST">
            <label for="field_three">Field Three:</label><br />
            <input type="text" id="field_three" name="fieldThree" /><br /><br />

            <label for="field_four">Field Four:</label><br />
            <input type="text" id="field_four" name="fieldFour" /><br /><br />

            <button type="submit">Save</button>
        </form>

        <?php if (!empty($results)) : ?>
            <?php foreach ($results as $row) : ?>
                <div><?php echo esc_html($row->field_three); ?></div>
                <div><?php echo esc_html($row->field_four); ?></div>
            <?php endforeach; ?>
        <?php else : ?>
            <p>No Data found</p>
        <?php endif; ?>
    </div>
<?php
}
