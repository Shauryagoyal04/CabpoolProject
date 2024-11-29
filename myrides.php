<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Rides</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Add some basic styles for the cards */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .rides-page {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .ride-card {
            margin: 15px 0;
            padding: 15px;
            background: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .ride-info span {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }
        .ride-status {
            font-weight: bold;
            margin-top: 10px;
        }
        .ride-status.upcoming {
            color: green;
        }
        .ride-status.completed {
            color: red;
        }
    </style>
</head>
<body>
    <div class="rides-page">
        <h1>My Rides</h1>
        <div id="rides-container">
            <!-- Ride cards will be dynamically injected here -->
        </div>
    </div>
    
    <script src="javascript/myrides.js"></script>
</body>
</html>
