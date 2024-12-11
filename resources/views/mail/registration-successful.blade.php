<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Confirmation</title>
    <style>
        /* General Styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f8fb;
            margin: 0;
            padding: 0;
        }

        /* Container */
        .container {
            max-width: 600px;
            margin: 2rem auto;
            background-color: #ffffff;
            border-radius: 8px;
            padding: 2rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        /* Title */
        .title {
            font-size: 1.8rem;
            font-weight: bold;
            color: #2563eb;
            text-align: center;
        }

        /* Greeting and Message Text */
        .greeting,
        .message {
            color: #374151;
            font-size: 1rem;
            margin: 1.5rem 0;
            line-height: 1.6;
        }

        /* Button */
        .button {
            display: inline-block;
            text-align: center;
            background-color: #2563eb;
            color: #ffffff !important;
            font-weight: bold;
            padding: 0.75rem 1.5rem;
            border-radius: 5px;
            text-decoration: none;
            margin: 1.5rem auto;
            display: block;
            width: fit-content;
        }

        .button:hover {
            background-color: #1d4ed8;
        }

        /* Footer */
        .footer {
            text-align: center;
            color: #6b7280;
            font-size: 0.875rem;
            margin-top: 2rem;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="title">Welcome to JourX!</h1>

        <p class="greeting">Hello, {{ $username }}</p>

        <p class="message">Thank you for joining <strong>JourX</strong>, your personal space to share your thoughts,
            reflect on your day, and receive meaningful insights. We’re excited to have you as part of our community
            where mental well-being and self-expression matter most.</p>

        <p class="message">Your account has been successfully created, and you are now ready to use JourX. Whether it’s
            pouring your heart out in a journal entry or seeking AI-generated advice, we’re here to support your mental
            health journey.</p>

        <p class="message">Click the button below to return to the app and start your first journal entry:</p>

        <a href="https://jourxredirect.dickyyyy.site/success?username={{ $username }}" class="button">Back to
            JourX</a>

        <p class="message">If you have any questions or need assistance, feel free to contact our support team.
            Together, we’ll make every moment count.</p>

        <div class="footer">
            <p>&copy; 2024 JourX. Your stories, your voice, your peace.</p>
        </div>
    </div>
</body>

</html>
