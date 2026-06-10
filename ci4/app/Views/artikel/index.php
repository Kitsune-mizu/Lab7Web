<?= $this->include('template/header'); ?>

<h2 style="color: #1f5faa; margin-bottom: 20px;"><?= $title ?? 'Daftar Artikel'; ?></h2>

<?php if ($artikel): ?>
    <?php foreach ($artikel as $row): ?>
        <article class="entry">
            <h2>
                <a href="<?= base_url('/artikel/view/' . $row['slug']); ?>" style="text-decoration:none; color:#333;">
                    <?= $row['judul']; ?>
                </a>
            </h2>

            <p style="font-size: 13px; font-weight:bold; color:#1f5faa; margin-top:-10px; margin-bottom:15px;">
                Kategori: <?= $row['nama_kategori'] ?? 'Uncategorized'; ?>
            </p>

            <img 
                src="<?= base_url('/gambar/' . $row['gambar']); ?>" 
                alt="<?= $row['judul']; ?>"
            >

            <p>
                <?= substr($row['isi'], 0, 200); ?>...
            </p>
        </article>

        <hr class="divider" />
    <?php endforeach; ?>
<?php else: ?>
    <article class="entry">
        <h2>Belum ada data artikel di kategori ini.</h2>
    </article>
<?php endif; ?>

<?= $this->include('template/footer'); ?>