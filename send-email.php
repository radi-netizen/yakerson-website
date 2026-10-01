<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 1. Honeypot Anti-Spam Check: If a bot fills this hidden field, discard the email instantly
    if (!empty($_POST['honeypot'])) {
        exit("Spam detected."); 
    }

    // 2. Sanitize user inputs to prevent injection attacks
    $name    = strip_tags(trim($_POST["name"]));
    $email   = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $message = htmlspecialchars(trim($_POST["message"]));

    // 3. Set your destination email address (hidden safely on the server)
    $to = "info@yakerson.co.il";
    
    // 4. Construct the email
    $subject = "New Contact Form Submission from " . $name;
    $email_content = "Name: $name\n";
    $email_content .= "Email: $email\n\n";
    $email_content .= "Message:\n$message\n";

    // 5. Secure headers to ensure correct delivery formats
    $headers = "From: webmaster@yakerson.co.il\r\n"; // Must match your domain to prevent spam filters
    $headers .= "Reply-To: $email\r\n";

    // 6. Send the email
    if (mail($to, $subject, $email_content, $headers)) {
        // Redirect to a thank-you confirmation page
        echo "<script>alert('Thank you! Your message has been sent.'); window.location.href='index.html';</script>";
    } else {
        echo "<script>alert('Oops! Something went wrong, please try again.'); window.history.back();</script>";
    }
} else {
    header("Location: index.html");
    exit;
}
?>
