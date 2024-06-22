<?php

require 'config.php';

$dsn = "mysql:host=$host;dbname=$db;charset=UTF8";
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

try {
    $pdo = new PDO($dsn, $user, $password, $options);

    if ($pdo) {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $query = "SELECT * FROM `users` WHERE username = :username";
            $statement = $pdo->prepare($query);
            $statement->execute([':username' => $username]);

            $user = $statement->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                if ('secret123' === $password) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];

                    header("Location: posts.php");
                    exit;
                } else {
                    echo "Invalid password!";
                }
            } else {
                echo "User not found!";
            }
        }
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Open+Sans:wght@500&display=swap');

        body {
            background: #ee99bf;
            font-family: 'Montserrat';
        }

        :root {
            --myClematis: #f7ccdf; 
            --lavenderPetal: #e666a0; 
            --wisteriaBlossom: #c095d5; 
            --lilacBloom: #ee99bf; 
            --iRis: #f9eeff; 
        }

        .login-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            border: 3px solid #d50060;
            border-radius: 5px;
            background: #f7ccdf;
            color: #d50060;
        }

        h2 {
            text-align: center;
        }

        input[type="text"],
        input[type="password"],
        button {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
        }

        .rLogin-Container {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .inputContainer {
            width: 350px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(to bottom, #e666a0, #ee99bf);
            border-radius: 30px;
            overflow: hidden;
            cursor: pointer;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.075);
            margin: 1em;
        }

        .buttonDiv {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #submit {
            font-family: 'Montserrat';
            width: 200px;
            height: 30px;
            margin-top: 20px;
            background-color: #d50060;
            border-radius: 12px;
        }

    </style>
</head>

<body>
    <div class="login-container">
        <h2>Login Form</h2>
        <div class="rLogin-Container">
        <form id="loginForm" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <div class="inputContainer">
            <input type="text" id="username" placeholder="Enter username" name="username" required>
            </div>
            <div class="inputContainer">
            <input type="password" id="password" placeholder="Enter password" name="password" required>
            </div>
        </div>
        <div class="buttonDiv">
        <button id="submit" style="color: white;">Login</button>
        </div>
    </div>
</body>

</html>