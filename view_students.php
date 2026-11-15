
<?php
$students = [];
$error = "";

try {
    $pdo = new PDO(
        "mysql:host=127.0.0.1;port=3307;dbname=student_validation;charset=utf8mb4",
        "root",
        ""
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query(
        "SELECT id, full_name, email, phone, age, course, created_at
         FROM students
         ORDER BY id DESC"
    );

    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    error_log($e->getMessage());
    $error = "Unable to load student records. Please check the database connection.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registered Students</title>

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
            max-width: 1100px;
            margin: auto;
            padding: 28px;
            background: white;
            border-radius: 14px;
            box-shadow: 0 5px 24px #243b5315;
        }

        h1 {
            color: #234e9b;
            text-align: center;
            margin-top: 0;
        }

        .subtitle {
            color: #68758a;
            text-align: center;
            margin-bottom: 25px;
        }

        .table-wrap { overflow-x: auto; }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }

        th {
            background: #234e9b;
            color: white;
            white-space: nowrap;
        }

        tr:hover td { background: #f5f8ff; }

        .count {
            padding: 12px;
            background: #e9f1ff;
            border-radius: 7px;
            color: #234e9b;
            font-weight: bold;
        }

        .message {
            padding: 14px;
            border-radius: 7px;
            background: #fff0f0;
            color: #a51d2d;
        }

        .empty {
            padding: 20px;
            text-align: center;
            color: #68758a;
        }

        .button {
            display: inline-block;
            margin-top: 22px;
            padding: 11px 18px;
            background: #234e9b;
            color: white;
            border-radius: 7px;
            text-decoration: none;
        }

        .button:hover { background: #183b79; }
    </style>
</head>

<body>
<div class="container">
    <h1>Registered Students</h1>
    <p class="subtitle">Student Registration and Data Validation System</p>

    <?php if ($error !== ""): ?>
        <p class="message">
            <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
        </p>
    <?php else: ?>

        <p class="count">
            Total Registered Students: <?= count($students) ?>
        </p>

        <?php if (empty($students)): ?>
            <p class="empty">No student records found yet.</p>
        <?php else: ?>
            <div class="table-wrap">
                <table>
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Age</th>
                        <th>Course</th>
                        <th>Registration Date</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php foreach ($students as $student): ?>
                        <tr>
                            <td><?= (int)$student['id'] ?></td>
                            <td><?= htmlspecialchars($student['full_name'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($student['email'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($student['phone'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= (int)$student['age'] ?></td>
                            <td><?= htmlspecialchars($student['course'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($student['created_at'], ENT_QUOTES, 'UTF-8') ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

    <?php endif; ?>

    <a class="button" href="register.php">+ Register New Student</a>
    <a class="button" href="index.php">Back to Home</a>
</div>
</body>
</html>
```