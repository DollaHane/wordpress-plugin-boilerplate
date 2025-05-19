<?php

function boilerplate_render_main_page()
{
?>
    <div class="wrap">
        <h1>Boilerplate External Database Form</h1>
        <form id="custom-form-one" method="POST">
            <label for="field_one">Field One:</label><br />
            <input type="text" id="field_one" name="fieldOne" /><br /><br />

            <label for="field_two">Field Two:</label><br />
            <input type="text" id="field_two" name="fieldTwo" /><br /><br />

            <button type="submit">Save</button>
        </form>

        <div id="response-one"></div>

        <script>
            document.getElementById('custom-form-one').addEventListener('submit', async function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                const res = await fetch('https://your-external-server.com/receive-data', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'auth-token': 'some-token'
                    }
                });

                const result = await res.text();
                document.getElementById('response-one').innerText = 'Response: ' + result;
            });
        </script>
    </div>
<?php
}
