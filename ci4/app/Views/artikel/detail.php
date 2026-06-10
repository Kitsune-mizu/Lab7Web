<?= $this->include('template/header'); ?>

<article class="entry">
    <h2><?= $artikel['judul']; ?></h2>

    <p style="font-weight:600; color:#1f5faa; margin-bottom: 15px; font-size: 14px;">
        Kategori: <?= $artikel['nama_kategori'] ?? 'Tidak ada kategori'; ?>
    </p>

    <img 
        src="<?= base_url('/gambar/' . $artikel['gambar']); ?>" 
        alt="<?= $artikel['judul']; ?>"
        style="max-width: 100%; height: auto; margin-bottom: 15px;"
    >

    <p style="text-align: justify; line-height: 1.8;">
        <?= $artikel['isi']; ?>
    </p>
</article>

<?= $this->include('template/footer'); ?>