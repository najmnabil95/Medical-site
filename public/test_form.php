<!DOCTYPE html>
<html>
<head><title>Delete Test</title></head>
<body>
<h1>Delete Test</h1>
<?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
  <p style="color:green; font-weight: bold;">POST received!</p>
  <p>_method: <?= $_POST['_method'] ?? 'NOT SET' ?></p>
  <p>_token: <?= isset($_POST['_token']) ? 'SET' : 'NOT SET' ?></p>
<?php endif; ?>

<form action="/test_form.php" method="POST" onsubmit="return confirm('Delete?');">
  <input type="hidden" name="_method" value="DELETE">
  <input type="hidden" name="_token" value="test123">
  <button type="submit" style="background: red; color: white; padding: 10px 20px; cursor: pointer;">Delete Test</button>
</form>
</body>
</html>
