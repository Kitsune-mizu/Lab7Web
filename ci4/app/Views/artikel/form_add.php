<?= $this->include('template/admin_header'); ?>

<h2><?= $title; ?></h2>

<form action="" method="post" enctype="multipart/form-data">
    <p>
        <input type="text" name="judul" placeholder="Masukkan judul artikel" required>
    </p>

    <p>
        <select name="id_kategori" required>
            <option value="" disabled selected>-- Pilih Kategori --</option>
            <?php foreach($kategori as $k): ?>
                <option value="<?= $k['id_kategori']; ?>"><?= $k['nama_kategori']; ?></option>
            <?php endforeach; ?>
        </select>
    </p>

    <p>
        <textarea name="isi" cols="50" rows="10" placeholder="Masukkan isi artikel" required></textarea>
    </p>

    <p>
        <label for="gambar">Upload Gambar:</label><br>
        <input type="file" name="gambar" id="gambar" accept="image/*">
    </p>

    <p>
        <input type="submit" value="Kirim" class="btn btn-large">
    </p>
</form>

<?= $this->include('template/admin_footer'); ?>