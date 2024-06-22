<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts Page</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Open+Sans:wght@500&display=swap');

        body {
            background: radial-gradient(#e666a0 1.3px, #ee99bf 1.3px);
            font-family: 'Montserrat';
        }

        .posts-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            border: 3px solid #d50060;
            border-radius: 5px;
            background: #f7ccdf;
            color: #d50060;
        }

        h1 {
            text-align: center;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
        font-family: 'Montserrat';
        font-size: 1.2em;
        color: #d50060;
        text-align: center;
        margin: 1em;
        padding: 1em;
        border-radius: 5px;
        cursor: pointer;
        list-style-type: none;
        border: 3px solid #d50060;
        border-radius: 3em;

        display: flex;
        justify-content: center;
        align-items: center;

        text-decoration: none;
    }

    li:hover {
        background-color: #ee99bf;
        transform: scale(1.1);
        transition: all 0.4s ease-in-out;
    }

    li a {
        text-decoration: none;
        color: #d50060;
    }

    </style>
</head>

<body>
    <div class="posts-container">
        <h1>Posts Page</h1>
        <hr style="height:2px;border-width:0;color:#d50060;background-color:#d50060">
        <ul id="postLists" style = "text-decoration: none">
            <?php

            require 'config.php';

            if (!isset($_SESSION['user_id'])) {
                header("Location: index.php");
                exit;
            }

            $dsn = "mysql:host=$host;dbname=$db;charset=UTF8";
            $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

            try {
                $pdo = new PDO($dsn, $user, $password, $options);

                if ($pdo) {
                    $user_id = $_SESSION['user_id'];

                    $query = "SELECT * FROM `posts` WHERE userId = :id";
                    $statement = $pdo->prepare($query);
                    $statement->execute([':id' => $user_id]);

                    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($rows as $row) {
                        echo '<li><a href="post.php?id=' . $row['id'] . '">' . $row['title'] . '</li>';
                    }

                }
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
            ?>
        </ul>
    </div>
</body>

</html>