<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $name = htmlspecialchars(trim($_POST["name"]));
    $email = htmlspecialchars(trim($_POST["email"]));
    $message = htmlspecialchars(trim($_POST["message"]));

    // Email configuration
    $to = "julfiker24878@gmail.com";
    $subject = "New Contact Form Submission";
    $headers = "From: $email" . "\r\n" .
               "Reply-To: $email" . "\r\n" .
               "X-Mailer: PHP/" . phpversion();

    $body = "Name: $name\nEmail: $email\n\nMessage:\n$message";

    // Send the email
    if (mail($to, $subject, $body, $headers)) {
        $success = true;
    } else {
        $success = false;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form</title>
    <style>
        /* Basic styling for the form */
        .contact-form {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .contact-form label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .contact-form input, .contact-form textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .contact-form button {
            padding: 10px 15px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .contact-form button:hover {
            background-color: #0056b3;
        }

        .success-popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .success-popup .popup-content {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
        }

        .success-popup .popup-content button {
            margin-top: 10px;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Form validation
            $('.contact-form').on('submit', function(event) {
                var isValid = true;
                $('.error').remove();

                var name = $('#name').val().trim();
                var email = $('#email').val().trim();
                var message = $('#message').val().trim();

                if (name === '') {
                    isValid = false;
                    $('#name').after('<span class="error">This field is required</span>');
                }

                if (email === '') {
                    isValid = false;
                    $('#email').after('<span class="error">This field is required</span>');
                } else if (!validateEmail(email)) {
                    isValid = false;
                    $('#email').after('<span class="error">Enter a valid email</span>');
                }

                if (message === '') {
                    isValid = false;
                    $('#message').after('<span class="error">This field is required</span>');
                }

                if (!isValid) {
                    event.preventDefault();
                }
            });

            function validateEmail(email) {
                var regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return regex.test(email);
            }

            // Show success popup if the form was submitted successfully
            <?php if (isset($success) && $success) : ?>
                $('.success-popup').fadeIn();
            <?php endif; ?>
        });

        function closePopup() {
            $('.success-popup').fadeOut();
        }
    </script>
</head>
<body>
    <div class="contact-form">
        <form method="post" action="">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="5" required></textarea>

            <button type="submit">Submit</button>
        </form>
    </div>

    <div class="success-popup">
        <div class="popup-content">
            <p>Thank you for your message! We will get back to you soon.</p>
            <button onclick="closePopup()">Close</button>
        </div>
    </div>
</body>
</html>
