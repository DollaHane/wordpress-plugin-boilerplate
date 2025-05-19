<?php

function boilerplate_render_settings_page()
{

  $user_api_key = get_option('my_boilerplate_api_key');

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $apiKeyField = sanitize_text_field($_POST['apiKeyField']);
    update_option('my_boilerplate_api_key', $apiKeyField);
    $user_api_key = $apiKeyField;
    echo '<div class="update"><p>API key saved successfully</p></div>';
  }

?>
  <div class="wrap">
    <h1>Settings</h1>
    <form method="POST">
      <label for="api_key_field">API Key:</label><br />
      <input type="text" id="api_key_field" name="apiKeyField" /><br />
      <button type="submit" class="button button-primary" style="margin-top: 20px;">Save</button>
    </form>
    <div style="margin-top: 20px;">
      <h3>Current API Key:</h3>
      <?php if (!empty($user_api_key)) : ?>
        <p style="height: 20px; background"><?php echo esc_html($user_api_key); ?></p>
      <?php else : ?>
        <p>No API key saved</p>
      <?php endif; ?>
    </div>
  </div>
<?php
}
