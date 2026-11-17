<?php
require_once(__DIR__ . '/../private/initialize.php');

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $username = $_POST['username'] ?? '';
  $password = $_POST['password'] ?? '';

  if ($username === '' || $password === '') {
    $errors[] = 'Please enter your username and password.';
  }

  if (empty($errors)) {
    $sql = "SELECT * FROM members WHERE username = :username";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':username', $username);
    $stmt->execute();

    $member = $stmt->fetch(PDO::FETCH_ASSOC);
    var_dump($member);

    if ($member && password_verify($password, $member['password_hash'])) {

      session_regenerate_id(true);

      $_SESSION['member_id'] = $member['id'];
      $_SESSION['username'] = $member['username'];
      $_SESSION['role'] = $member['role'];

      header('Location: index.php');
      exit;
    } else {
      $errors[] = 'Incorrect username or password.';
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
</head>

<body>

  <h1>Member Login</h1>

  <?php if (!empty($errors)): ?>
    <?php foreach ($errors as $error): ?>
      <p><?php echo htmlspecialchars($error); ?></p>
    <?php endforeach; ?>
  <?php endif; ?>

  <form action="login.php" method="post">

    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>
    <br>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>
    <br>

    <button type="submit">Login</button>

  </form>

  <p>Don't have an account? <a href="register.php">Register here</a>.</p>

</body>

</html>
