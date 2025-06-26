<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Custom Form</h1>
    <?php

    if (isset($_POST['cf-submitted'])) {
        // sanitise and store values
        $name = sanitize_text_field($_POST['cf-name']);
        $email = sanitize_email($_POST['cf-email']);
        $message = esc_textarea($_POST['cf-message']);

        // Email Details
        $to = get_option('admin_email'); //send email to admin
        $subject = "Message from $name";
        $headers = "From: $name <$email>";

        // Send Email
        $sent = wp_mail($to, $subject, $message, $headers);

        if($sent){
            echo '<div class="success"> Thank you! your message has been sent';
        }else{
            echo '<div class="success"> Oops something went wrong!';
        }
    }

    ?>
    <form action="" method="post">
        <p>
            <label for="cf-name">Name</label>
            <input type="text" name="cf-name" required>
        </p>
        <p>
            <label for="cf-email">Email</label>
            <input type="email" name="cf-email" required>
        </p>
        <p>
            <label for="cf-message">Message</label>
            <textarea name="cf-message" rows="5" required></textarea>
        </p>
        <button type="submit" name="cf-submitted">Submit</button>
    </form>
</body>

</html>