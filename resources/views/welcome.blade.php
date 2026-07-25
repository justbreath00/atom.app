<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            /* Added a modern linear gradient background */
            background: linear-gradient(135deg, #d8f0ff 0%, #a0dcb2 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .profile-card {
            background: url("yah.jpg") center center / cover no-repeat;
            background-size: cover;
            padding: 30px;
            border-radius: 12px;
            /* Adjusted box-shadow to blend smoothly with the new background */
            box-shadow: 0 10px 25px rgba(22, 163, 74, 0.08), 0 4px 12px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }
        .profile-info {
            text-align: left;
            margin-bottom: 20px;
        }
        .profile-info p {
            margin: 10px 0;
            color: #333;
            font-size: 16px;
        }
        .label {
            font-weight: bold;
            color: #555;
        }
        .motto-box {
            background-color: #f0fdf4;
            border-left: 4px solid #163ea3;
            padding: 15px;
            border-radius: 4px;
            font-style: italic;
            color: #15803d;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <div class="profile-card">
        <h2>User Profile</h2>
        <hr style="border: 0; border-top: 1px solid #eee; margin-bottom: 20px;">
        
        <div class="profile-info">
            <p><span class="label">Name:</span> Jhon Renier Tambogon</p>
            <p><span class="label">Age:</span> 19</p>
            <p><span class="label">Address:</span> Urdaneta Pangasinan</p>
        </div>

        <div class="motto-box">
            "Never back down, never what?. 
            Never give up!"
        </div>
    </div>

</body>
</html>