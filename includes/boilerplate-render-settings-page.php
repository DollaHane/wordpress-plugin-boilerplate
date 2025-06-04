<?php

function boilerplate_render_settings_page()
{

  $user_api_key = get_option('my_boilerplate_api_key');
  $user_email_key = get_option('my_boilerplate_user_email');

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $apiKeyField = sanitize_text_field($_POST['apiKeyField']);
    update_option('my_boilerplate_api_key', $apiKeyField);
    $user_api_key = $apiKeyField;

    $userEmailField = sanitize_text_field($_POST['userEmailField']);
    update_option('my_boilerplate_user_email', $userEmailField);
    $user_email_key = $userEmailField;

    echo '<div class="update"><p>User details saved successfully</p></div>';
  }

?>
  <div class="wrap">
    <h1>Settings</h1>

    <form method="POST">
      <label for="api_key_field">API Key:</label><br />
      <input type="text" id="api_key_field" name="apiKeyField" /><br />
      <label for="user_email_field">User Email:</label><br />
      <input type="text" id="user_email_field" name="userEmailField" /><br />
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

    <div style="">
      <h3>Current User Email:</h3>
      <?php if (!empty($user_email_key)) : ?>
        <p style="height: 20px; background"><?php echo esc_html($user_email_key); ?></p>
      <?php else : ?>
        <p>No Email saved</p>
      <?php endif; ?>
    </div>

  </div>
<?php
}
