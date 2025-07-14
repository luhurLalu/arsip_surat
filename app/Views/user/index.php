<h2>Daftar Pengguna</h2>

<?php if (session()->getFlashdata('error')): ?>
    <div style="color: red; margin-bottom: 10px;">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('success')): ?>
    <div style="color: green; margin-bottom: 10px;">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>Username</th>
            <th>Role</th>
            <?php if (session()->get('role') === 'admin'): ?>
                <th>Aksi</th>
            <?php endif; ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= esc($user['nama']) ?></td>
                <td><?= esc($user['email']) ?></td>
                <td><?= esc($user['username']) ?></td>
                <td><?= esc($user['role']) ?></td>
                <?php if (session()->get('role') === 'admin'): ?>
                    <td>
                        <a href="<?= base_url('user/edit/' . $user['id']) ?>">Edit</a> |
                        <a href="<?= base_url('user/delete/' . $user['id']) ?>" onclick="return confirm('Yakin ingin menghapus pengguna ini?')">Hapus</a>
                    </td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<br>

<?php if (session()->get('role') === 'admin'): ?>
    <a href="<?= base_url('user/create') ?>">➕ Tambah Pengguna</a>
<?php endif; ?>