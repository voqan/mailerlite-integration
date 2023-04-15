<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MailerLite API Key</title>
</head>
<body>
    <h1>Enter your MailerLite API Key</h1>
    <form action="/api-keys" method="post">
        @csrf
        <label for="api_key">API Key:</label>
        <input type="text" name="api_key" id="api_key" value="{{ $api_key }}" required>
        <button type="submit">Submit</button>
    </form>
</body>
</html>

