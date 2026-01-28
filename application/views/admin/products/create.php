<!DOCTYPE html>
<html>
<head>
    <title>Create Item</title>
</head>
<body>
    <h1>Create Item</h1>
    <form method="post" action="<?= base_url('items/save') ?>">
        <label>Name:</label>
        <input type="text" name="name" required>
        <br>
        <label>Description:</label>
        <textarea name="description" required></textarea>
        <br>
        <button type="submit">Save</button>
    </form>
</body>
</html>