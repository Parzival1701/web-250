<?php
require_once(__DIR__ . '/../private/initialize.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  var_dump($_POST);

  $firstName = $_POST['first_name'] ?? '';
  $lastName = $_POST['last_name'] ?? '';
  $email = $_POST['email'] ?? '';
  $username = $_POST['username'] ?? '';
  $password = $_POST['password'] ?? '';
  $confirmPassword = $_POST['confirm_password'] ?? '';

  $errors = [];
  if (
    $firstName === '' ||
    $lastName === '' ||
    $email === '' ||
    $username === '' ||
    $password === '' ||
    $confirmPassword === ''
  ) {
    $errors[] = 'Please complete all fields.';
  }

  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Please enter a valid email address.';
  }

  if (strlen($password) < 8) {
    $errors[] = 'Your password must be at least 8 characters long.';
  }

  if ($password !== $confirmPassword) {
    $errors[] = 'Your passwords do not match.';
  }

  if ($username !== '') {
    $sql = "SELECT COUNT(*) FROM members WHERE username = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':username', $username);
    $stmt->execute();

    if ($stmt->fetchColumn() > 0) {
      $errors[] = 'That username is already taken.';
    }
  }

  if ($email !== '') {
    $sql = "SELECT COUNT(*) FROM members WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':email', $email);
    $stmt->execute();
  }
  if ($stmt->fetchColumn() > 0) {
    $errors[] = 'That email address is already registered.';
  }
  var_dump($errors);
  if (empty($errors)) {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO members (first_name, last_name, email, username, password_hash)
            VALUES (:first_name, :last_name, :email, :username, :password)";

    $stmt = $pdo->prepare($sql);

    $stmt->bindValue(':first_name', $firstName);
    $stmt->bindValue(':last_name', $lastName);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':username', $username);
    $stmt->bindValue(':password', $hashedPassword);

    $stmt->execute();
    $success = "Your account has been created successfully!";
  }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
</head>

<body>

  <h1>Register</h1>

  <form action="register.php" method="post">

    <label for="first_name">First Name:</label>
    <input type="text" id="first_name" name="first_name" required><br>

    <label for="last_name">Last Name:</label>
    <input type="text" id="last_name" name="last_name" required><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required><br>

    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required><br>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br>

    <label for="confirm_password">Confirm Password:</label>
    <input type="password" id="confirm_password" name="confirm_password" required><br>

    <button type="submit">Register</button>

  </form>

</body>

</html>
