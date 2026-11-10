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
    $salamander = null;
    $error_message = 'A valid Salamander ID is required.';
} else {
    $salamander = Salamander::find_by_id($id);
    if ($salamander === null) {
        http_response_code(404);
        $error_message = 'Salamander not found.';
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $salamander !== null) {
    if ($salamander->delete()) {
        header('Location: salamanders.php');
        exit;
    }

    $error_message = 'The Salamander could not be deleted.';
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Delete Salamander</title>
</head>
<body>
    <h1>Delete Salamander</h1>

    <?php if ($error_message !== ''): ?>
        <p><?= h($error_message) ?></p>
    <?php endif; ?>

    <?php if ($salamander !== null): ?>
        <p><strong>ID:</strong> <?= (int) $salamander->id ?></p>
        <p><strong>Name:</strong> <?= h($salamander->common_name) ?></p>
        <p>Are you sure you want to delete this Salamander?</p>

        <form action="salamander_delete.php" method="post">
            <input type="hidden" name="id" value="<?= (int) $salamander->id ?>">
            <button type="submit">Delete Salamander</button>
        </form>
    <?php endif; ?>

    <p><a href="salamanders.php">Cancel</a></p>
</body>
</html>
