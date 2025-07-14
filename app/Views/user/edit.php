<h2>Edit Data Pengguna</h2>

<?php if (session()->get('errors')): ?>
    <div style="color: red; margin-bottom: 10px;">
        <ul>
            <?php foreach (session()->get('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form action="<?= base_url('user/update/' . $user['id']) ?>" method="post">
    <label>Nama:</label><br>
    <input type="text" name="nama" value="<?= old('nama', $user['nama']) ?>"><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" value="<?= old('email', $user['email']) ?>"><br><br>

    <label>Username:</label><br>
    <input type="text" name="username" value="<?= old('username', $user['username']) ?>"><br><br>

    <label>Password (Kosongkan jika tidak ingin diubah):</label><br>
    <input type="password" name="password"><br><br>

    <label>Role:</label><br>
    <select name="role">
        <option value="">-- Pilih Role --</option>
        <option value="admin" <?= old('role', $user['role']) === 'admin' ? 'selected' : '' ?>>Admin</option>
        <option value="staff" <?= old('role', $user['role']) === 'staff' ? 'selected' : '' ?>>Staff</option>
        <option value="viewer" <?= old('role', $user['role']) === 'viewer' ? 'selected' : '' ?>>Viewer</option>
    </select><br><br>

    <button type="submit">Simpan Perubahan</button>
</form>