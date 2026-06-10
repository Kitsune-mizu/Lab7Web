<?= $this->include('template/admin_header'); ?>

<h2><?= $title; ?></h2>

<form action="" method="post" enctype="multipart/form-data">
    <p>
        <input type="text" name="judul" value="<?= $data['judul']; ?>" required>
    </p>

    <p>
        <select name="id_kategori" required>
            <option value="" disabled>-- Pilih Kategori --</option>
            <?php foreach($kategori as $k): ?>
                <option value="<?= $k['id_kategori']; ?>" <?= ($data['id_kategori'] == $k['id_kategori']) ? 'selected' : ''; ?>>
                    <?= $k['nama_kategori']; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </p>

    <p>
        <textarea name="isi" cols="50" rows="10" required><?= $data['isi']; ?></textarea>
    </p>

    <p>
        <label for="gambar">Upload Gambar Baru (Biarkan kosong jika tidak ingin mengubah):</label><br>
        
        <?php if (!empty($data['gambar'])): ?>
            <img src="<?= base_url('gambar/' . $data['gambar']); ?>" alt="Preview Gambar" width="150" style="margin-bottom: 10px; display: block;">
        <?php endif; ?>
        
        <input type="file" name="gambar" id="gambar" accept="image/*">
    </p>

    <p>
        <input type="submit" value="Kirim" class="btn btn-large">
    </p>
</form>

<?= $this->include('template/admin_footer'); ?>