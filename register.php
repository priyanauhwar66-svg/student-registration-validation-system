```php
<?php
$errors = [];
$success = "";

$name = "";
$email = "";
$phone = "";
$course = "";
$age = "";

function cleanInput($value) {
    return trim($value);
}

function validateName($name) {
    return preg_match("/^[a-zA-Z ]{2,50}$/", $name);
}

function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function validatePhone($phone) {
    return preg_match("/^[6-9][0-9]{9}$/", $phone);
}

function validatePassword($password) {
    return strlen($password) >= 8;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = cleanInput($_POST["name"] ?? "");
    $email = cleanInput($_POST["email"] ?? "");
    $phone = cleanInput($_POST["phone"] ?? "");
    $course = cleanInput($_POST["course"] ?? "");
    $age = cleanInput($_POST["age"] ?? "");
    $password = $_POST["password"] ?? "";
    $confirmPassword = $_POST["confirm_password"] ?? "";

    if (!validateName($name)) {
        $errors[] = "Name must contain 2-50 letters and spaces only.";
    }

    if (!validateEmail($email)) {
        $errors[] = "Please enter a valid email address.";
    }

    if (!validatePhone($phone)) {
        $errors[] = "Enter a valid 10-digit Indian mobile number.";
    }

    if (!in_array($course, ["BCA", "BBA", "BCom", "MCA"], true)) {
        $errors[] = "Please select a valid course.";
    }

    if (filter_var($age, FILTER_VALIDATE_INT) === false ||
        (int)$age < 16 || (int)$age > 100) {
        $errors[] = "Age must be between 16 and 100.";
    }

    if (!validatePassword($password)) {
        $errors[] = "Password must contain at least 8 characters.";
    }

    if ($confirmPassword === "") {
        $errors[] = "Please confirm your password.";
    } elseif ($password !== $confirmPassword) {
        $errors[] = "Passwords do not match.";
    }

    if (empty($errors)) {
        try {
            $pdo = new PDO(
                "mysql:host=127.0.0.1;port=3307;dbname=student_validation;charset=utf8mb4",
                "root",
                ""
            );

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare(
                "INSERT INTO students
                (full_name, email, phone, age, course, password)
                VALUES (?, ?, ?, ?, ?, ?)"
            );

            $stmt->execute([
                $name,
                $email,
                $phone,
                (int)$age,
                $course,
                $hashedPassword
            ]);

            $success = "Registration successful! Your details have been saved.";
            $name = $email = $phone = $course = $age = "";

        } catch (PDOException $e) {
            if ($e->getCode() === "23000") {
                $errors[] = "This email is already registered. Please use another email.";
            } else {
                error_log($e->getMessage());
                $errors[] = "Unable to save registration. Please check your database settings.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            padding: 30px 15px;
            font-family: Arial, sans-serif;
            background: #f1f5fb;
            color: #263248;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 30px;
            background: white;
            border-radius: 14px;
            box-shadow: 0 5px 24px #243b5315;
        }

        h1 { margin-top: 0; color: #234e9b; text-align: center; }
        .subtitle { text-align: center; color: #68758a; margin-bottom: 25px; }

        label { display: block; margin: 16px 0 7px; font-weight: bold; }

        input, select {
            width: 100%;
            padding: 12px;
            border: 1px solid #cbd5e1;
            border-radius: 7px;
            font-size: 15px;
        }

        input:focus, select:focus {
            outline: 2px solid #9bbcf8;
            border-color: #315fba;
        }

        button {
            width: 100%;
            margin-top: 24px;
            padding: 13px;
            background: #234e9b;
            color: white;
            border: none;
            border-radius: 7px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover { background: #183b79; }

        .errors, .success {
            padding: 14px 18px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .errors { background: #fff0f0; color: #a51d2d; }
        .success { background: #e9f9ef; color: #17683a; }
        .errors li { margin: 7px 0; }

        .back {
            display: block;
            margin-top: 20px;
            text-align: center;
            color: #234e9b;
            text-decoration: none;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Student Registration</h1>
    <p class="subtitle">Enter your details to register.</p>

    <?php if (!empty($errors)): ?>
        <div class="errors">
            <strong>Please correct the following errors:</strong>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if ($success !== ""): ?>
        <div class="success">
            <?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="register.php">
        <label for="name">Full Name</label>
        <input type="text" id="name" name="name"
               value="<?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?>"
               maxlength="50" required>

        <label for="email">Email Address</label>
        <input type="email" id="email" name="email"
               value="<?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?>"
               required>

        <label for="phone">Mobile Number</label>
        <input type="tel" id="phone" name="phone"
               value="<?= htmlspecialchars($phone, ENT_QUOTES, 'UTF-8') ?>"
               maxlength="10" inputmode="numeric" required>

        <label for="age">Age</label>
        <input type="number" id="age" name="age"
               value="<?= htmlspecialchars($age, ENT_QUOTES, 'UTF-8') ?>"
               min="16" max="100" required>

        <label for="course">Select Course</label>
        <select id="course" name="course" required>
            <option value="">-- Choose Course --</option>
            <option value="BCA" <?= $course === "BCA" ? "selected" : "" ?>>BCA</option>
            <option value="BBA" <?= $course === "BBA" ? "selected" : "" ?>>BBA</option>
            <option value="BCom" <?= $course === "BCom" ? "selected" : "" ?>>B.Com</option>
            <option value="MCA" <?= $course === "MCA" ? "selected" : "" ?>>MCA</option>
        </select>

        <label for="password">Password</label>
        <input type="password" id="password" name="password"
               minlength="8" autocomplete="new-password" required>

        <label for="confirm_password">Confirm Password</label>
        <input type="password" id="confirm_password"
               name="confirm_password" autocomplete="new-password" required>

        <button type="submit">Register Student</button>
    </form>

    <a class="back" href="index.php">← Back to Home</a>
</div>
</body>
</html>
```