<?php

/**
 * 'title' => 'bail|required|string|min:5|max:255',
 * 'description' => 'required|string|min:5|max:255',
 * 'rental_cost' => 'required|numeric|min:5',
 */

/**
 * Render the main form page and handle AJAX submissions
 */
function boilerplate_render_main_page()
{
    // Handle AJAX submission
    if (isset($_POST['action']) && $_POST['action'] === 'boilerplate_submit_form' && wp_verify_nonce($_POST['nonce'], 'boilerplate_form_nonce')) {

        $user_api_key = get_option('my_boilerplate_api_key');
        $user_email_key = get_option('my_boilerplate_user_email');

        // Sanitize and validate form data
        $title = isset($_POST['title']) ? sanitize_text_field($_POST['title']) : '';
        $description = isset($_POST['description']) ? sanitize_text_field($_POST['description']) : '';
        $rental_cost = isset($_POST['rental_cost']) ? floatval($_POST['rental_cost']) : 0;

        if (strlen($title) < 5 || strlen($title) > 255) {
            wp_send_json_error('Title must be between 5 and 255 characters');
        } elseif (strlen($description) < 5 || strlen($description) > 255) {
            wp_send_json_error('Description must be between 5 and 255 characters');
        } elseif ($rental_cost < 5) {
            wp_send_json_error('Rental cost must be at least 5');
        }

        // Send request to external server
        $response = wp_remote_post('http://localhost:8000/adverts/wp', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'api-key' => $user_api_key,
                'user-email' => $user_email_key,
            ],
            'body' => json_encode([
                'title' => $title,
                'description' => $description,
                'rental_cost' => $rental_cost,
            ]),
            'timeout' => 15,
        ]);

        // Check if the request was successful
        if (is_wp_error($response)) {
            // Handle error
            error_log('Request failed: ' . $response->get_error_message());
            return;
        }

        // Get the response body and status code
        $response_body = wp_remote_retrieve_body($response);
        $response_code = wp_remote_retrieve_response_code($response);
        $response_headers = wp_remote_retrieve_headers($response);

        // Log or debug the response
        error_log('Response Code: ' . $response_code);
        error_log('Response Body: ' . print_r($response_body, true));
        error_log('Response Headers: ' . print_r($response_headers, true));

        // Decode JSON response (since Laravel returns JSON)
        $response_data = json_decode($response_body, true);

        // Check the response data
        if (isset($response_data['message'])) {
            wp_send_json_success($response_data['message']);
        } else {
            wp_send_json_error('Unexpected response');
        }
    }

    $nonce = wp_create_nonce('boilerplate_form_nonce');
?>
    <div class="wrap">
        <h1>Boilerplate External Database Form</h1>
        <form id="custom-form-one" method="POST">
            <label for="title">Title:</label><br />
            <input type="text" id="title" name="title" /><br /><br />

            <label for="description">Description:</label><br />
            <input type="text" id="description" name="description" /><br /><br />

            <label for="rental_cost">Rental Rate:</label><br />
            <input type="number" id="rental_cost" name="rental_cost" /><br /><br />

            <input type="hidden" name="nonce" value="<?php echo esc_attr($nonce); ?>">
            <input type="hidden" name="action" value="boilerplate_submit_form">
            <button type="submit">Save</button>
        </form>

        <div id="response-one"></div>

        <script>
            document.getElementById('custom-form-one').addEventListener('submit', async function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                try {
                    const res = await fetch('<?php echo esc_url(admin_url('admin-ajax.php')); ?>', {
                        method: 'POST',
                        body: formData,
                    });
                    const result = await res.json();

                    if (result.success) {
                        document.getElementById('custom-form-one').reset();
                        document.getElementById('response-one').innerText = `Response: ${result.data}`;
                    }

                    if (result.error) {
                        document.getElementById('response-one').innerText = `Response: ${result.error}`;
                    }
                } catch (error) {
                    document.getElementById('response-one').innerText = `Failed to submit form - Error: ${error}`;
                }
            });
        </script>
    </div>
<?php
}
