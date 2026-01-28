<!DOCTYPE html>
<html>
<head>
    <title>Edit Item</title>
</head>
<body>
    <h1>Edit Item</h1>
    <form method="post" action="<?= base_url('items/update/' . $item['id']) ?>">
        <label>Name:</label>
        <input type="text" name="name" value="<?= $item['name'] ?>" required>
        <br>
        <label>Description:</label>
        <textarea name="description" required><?= $item['description'] ?></textarea>
        <br>
        <button type="submit">Update</button>
    </form>
</body>
</html>