<?php
// Change these to match your MySQL user
$db_host = '127.0.0.1';
$db_name = 'appdb';
$db_user = 'appuser';
$db_pass = 'apppass';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
$conn->set_charset('utf8mb4');

function h($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $conn->prepare('DELETE FROM clients WHERE id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $note = trim($_POST['note'] ?? '');
    if ($name !== '') {
        $stmt = $conn->prepare('INSERT INTO clients (name, phone, note) VALUES (?, ?, ?)');
        $stmt->bind_param('sss', $name, $phone, $note);
        $stmt->execute();
    }
    header('Location: index.php');
    exit;
}

$rows = $conn->query('SELECT * FROM clients ORDER BY id DESC');
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Clients</title>
<style>
body{font-family:Arial,sans-serif;max-width:720px;margin:30px auto;padding:0 16px;color:#222}
h1{font-size:22px}
form,table{width:100%}
input,button{padding:8px;margin:4px 4px 12px 0}
table{border-collapse:collapse}
td,th{border-bottom:1px solid #ddd;padding:8px;text-align:left}
a{color:#a33}
</style>
</head>
<body>
<h1>Clients</h1>

<form method="post">
  <input name="name" placeholder="Name" required>
  <input name="phone" placeholder="Phone">
  <input name="note" placeholder="Note">
  <button type="submit">Add</button>
</form>

<table>
<tr><th>Name</th><th>Phone</th><th>Note</th><th></th></tr>
<?php while ($r = $rows->fetch_assoc()): ?>
<tr>
  <td><?= h($r['name']) ?></td>
  <td><?= h($r['phone']) ?></td>
  <td><?= h($r['note']) ?></td>
  <td><a href="?delete=<?= (int)$r['id'] ?>" onclick="return confirm('Delete?')">delete</a></td>
</tr>
<?php endwhile; ?>
</table>
</body>
</html>
