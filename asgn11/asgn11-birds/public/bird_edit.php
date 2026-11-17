<?php
require_once __DIR__ . '/../private/initialize.php';

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = filter_input(
    INPUT_POST,
    'id',
    FILTER_VALIDATE_INT,
    ['options' => ['min_range' => 1]]
  );
} else {
  $id = filter_input(
    INPUT_GET,
    'id',
    FILTER_VALIDATE_INT,
    ['options' => ['min_range' => 1]]
  );
}

if ($id === false || $id === null) {
  http_response_code(400);
  $bird = null;
  $error_message = 'A valid bird ID is required.';
} else {
  $bird = Bird::find_by_id($id);
  if ($bird === null) {
    http_response_code(404);
    $error_message = 'bird not found.';
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $bird !== null) {
  $bird->common_name = trim($_POST['common_name'] ?? '');
  $bird->scientific_name = trim($_POST['scientific_name'] ?? '');
  $bird->family_name = trim($_POST['family_name'] ?? '');
  $bird->primary_habitat = trim($_POST['primary_habitat'] ?? '');
  $bird->seasonal_status = trim($_POST['seasonal_status'] ?? '');
  $bird->description = trim($_POST['description'] ?? '');

  if ($bird->common_name === '' || $bird->scientific_name === '') {
    $error_message = 'Common name and scientific name are required.';
  } elseif ($bird->update()) {
    header('Location: bird.php?id=' . $bird->id);
    exit;
  } else {
    $error_message = 'The bird could not be updated.';
  }
}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Update Salamander</title>
</head>

<body>
  <h1>Update bird</h1>

  <?php if ($error_message !== ''): ?>
    <p><?= h($error_message) ?></p>
  <?php endif; ?>

  <?php if ($bird !== null): ?>
    <p>Editing ID: <?= (int) $bird->id ?></p>

    <form action="bird_edit.php" method="post">
      <input type="hidden" name="id" value="<?= (int) $bird->id ?>">

      <p>
        <label for="common_name">Common Name</label><br>
        <input type="text" id="common_name" name="common_name" value="<?= h($bird->common_name) ?>" required>
      </p>
      <p>
        <label for="scientific_name">Scientific Name</label><br>
        <input type="text" id="scientific_name" name="scientific_name" value="<?= h($bird->scientific_name) ?>" required>
      </p>
      <p>
        <label for="family_name">Family</label><br>
        <input type="text" id="family_name" name="family_name" value="<?= h($bird->family_name) ?>">
      </p>
      <p>
        <label for="primary_habitat">Primary Habitat</label><br>
        <input type="text" id="primary_habitat" name="primary_habitat" value="<?= h($bird->primary_habitat) ?>">
      </p>
      <p>
        <label for="seasonal_status">seasonal status</label><br>
        <textarea id="seasonal_status" name="seasonal_status" rows="5" cols="60"><?= h($bird->seasonal_status) ?></textarea>
      </p>
      <p>
        <label for="description">description</label><br>
        <textarea id="description" name="description" rows="5" cols="60"><?= h($bird->description) ?></textarea>
      </p>
      <button type="submit">Update bird</button>
    </form>
  <?php endif; ?>

  <p><a href="birds.php">Cancel</a></p>
</body>

</html>
