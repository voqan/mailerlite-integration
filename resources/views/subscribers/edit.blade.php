<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Subscriber</title>
</head>
<body>
    <h1>Edit Subscriber</h1>
    <form action="/subscribers/{{ $subscriber->id }}" method="post">
        @csrf
        @method('PUT')
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="{{ $subscriber->email }}" readonly>
        <br>
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" value="{{ $subscriber->name }}" required>
        <br>
        <label for="country">Country:</label>
        <input type="text" name="country" id="country" value="{{ $subscriber->country }}" required>
        <br>
        <button type="submit">Save</button>
    </form>
</body>
</html>

