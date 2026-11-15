
<?php
$title = "Student Registration and Data Validation System";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?></title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 40px 20px;
            font-family: Arial, sans-serif;
            background: #f1f5fb;
            color: #263248;
        }

        .container {
            max-width: 850px;
            margin: 35px auto;
            padding: 45px 30px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 5px 24px #243b5315;
            text-align: center;
        }

        .tag {
            display: inline-block;
            padding: 8px 14px;
            border-radius: 20px;
            background: #e9f1ff;
            color: #234e9b;
            font-size: 13px;
            font-weight: bold;
        }

        h1 {
            margin: 22px 0 15px;
            color: #234e9b;
            font-size: 34px;
            line-height: 1.3;
        }

        .description {
            max-width: 620px;
            margin: 0 auto 30px;
            color: #68758a;
            font-size: 17px;
            line-height: 1.7;
        }

        .features {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin: 30px 0;
            text-align: left;
        }

        .feature {
            padding: 20px 16px;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            background: #fbfdff;
        }

        .feature h3 {
            margin: 0 0 10px;
            color: #234e9b;
            font-size: 16px;
        }

        .feature p {
            margin: 0;
            color: #68758a;
            font-size: 14px;
            line-height: 1.6;
        }

        .buttons {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 30px;
        }

        .button {
            display: inline-block;
            padding: 14px 22px;
            border: 2px solid #234e9b;
            border-radius: 8px;
            background: #234e9b;
            color: white;
            font-weight: bold;
            text-decoration: none;
            transition: 0.2s;
        }

        .button:hover {
            background: #183b79;
            border-color: #183b79;
        }

        .button.secondary {
            background: white;
            color: #234e9b;
        }

        .button.secondary:hover {
            background: #e9f1ff;
        }

        footer {
            margin-top: 35px;
            color: #8792a4;
            font-size: 13px;
        }

        @media (max-width: 650px) {
            .container {
                margin: 10px auto;
                padding: 30px 20px;
            }

            h1 {
                font-size: 27px;
            }

            .features {
                grid-template-columns: 1fr;
            }

            .buttons {
                flex-direction: column;
            }

            .button {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <main class="container">

        <span class="tag">PHP &amp; MySQL Project</span>

        <h1>Student Registration and Data Validation System</h1>

        <p class="description">
            A web-based application that validates student information
            and securely stores registration records using PHP and MySQL.
        </p>

        <section class="features">
            <div class="feature">
                <h3>Student Registration</h3>
                <p>Register students by entering their personal and course details.</p>
            </div>

            <div class="feature">
                <h3>Data Validation</h3>
                <p>Check names, email addresses, mobile numbers and passwords.</p>
            </div>

            <div class="feature">
                <h3>Database Storage</h3>
                <p>Save student records and view them from the database.</p>
            </div>
        </section>

        <div class="buttons">
            <a class="button" href="register.php">Register a Student</a>
            <a class="button secondary" href="view_students.php">View Registered Students</a>
        </div>

        <footer>
            Student Registration and Data Validation System
            <br>
            Developed using PHP, MySQL, HTML and CSS
        </footer>

    </main>
</body>
</html>
```