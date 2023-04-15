<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Subscriber</title>
</head>
<body>
    <h1>Add Subscriber</h1>
    <form action="/subscribers" method="post">
        @csrf
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
        <br>
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required>
        <br>
        <label for="country">Country:</label>
        <input type="text" name="country" id="country" required>
        <br>
        <button type="submit">Submit</button>
    </form>
</body>
</html>

