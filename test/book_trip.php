<?php
    // Only process POST reqeusts.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the form fields and remove whitespace.
    $name = strip_tags(trim($_POST["name"]));
    $name = str_replace(array("\r","\n"),array(" "," "),$name);
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $phone = trim($_POST["phone"]);
    $from_date = trim($_POST["from_date"]);
    $to_date = trim($_POST["to_date"]);
    $number_person = trim($_POST["number_person"]);
    $trip = trim($_POST["trip"]);
    $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        // Check that data was sent to the mailer.
    if ( empty($name) OR empty($phone)  OR empty($from_date)  OR empty($to_date)  OR empty($number_person) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Set a 400 (bad request) response code and exit.
        http_response_code(400);
        echo "Oops! There was a problem with your submission. Please complete the form and try again.";
        exit;
    }

    // Set the recipient email address.
    $recipient = "info@moldthemes.com";

    // Set the email subject.
    $subject = "New contact from $name";

    // Build the email content.
    $email_content = "Name: $name\n";
    $email_content .= "Email: $email\n";
    $email_content .= "Phone: $phone\n";
    $email_content .= "From Date: $from_date\n";
    $email_content .= "To Date: $to_date\n";
    $email_content .= "Number of person: $number_person\n";
    $email_content .= "Trip : $trip\n";
    $email_content .= "Booking for : $actual_link\n";

    // Build the email headers.
    $email_headers = "From: $name <$email>";

        // Send the email.
    if (mail($recipient, $subject, $email_content, $email_headers)) {
            // Set a 200 (okay) response code.
        http_response_code(200);
        echo "Thank You! Your message has been sent.";
    } else {
            // Set a 500 (internal server error) response code.
        http_response_code(500);
        echo "Oops! Something went wrong and we couldn't send your message.";
    }

} else {
        // Not a POST request, set a 403 (forbidden) response code.
    http_response_code(403);
    echo "There was a problem with your submission, please try again.";
}

?>