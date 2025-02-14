<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Details</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { width: 80%; margin: auto; padding: 20px; }
        h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Book Details</h2>
        <table>
            <tr>
                <th>Title</th>
                <td>{{ $book->title }}</td>
            </tr>
            <tr>
                <th>Author</th>
                <td>{{ $book->author }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>{{ $book->status ? 'Available' : 'Not Available' }}</td>
            </tr>
        </table>
    </div>
</body>
</html>
