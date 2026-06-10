<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="entry">
    <h2><?= $title; ?></h2>
    <hr>
    <p><?= $content; ?></p>
</div>

<div class="entry">
    <h2>Artikel Terbaru</h2>
    <hr>
    <?php
        $model   = new App\Models\ArtikelModel();
        $artikel = $model->orderBy('created_at', 'DESC')->limit(5)->findAll();
    ?>
    <?php if ($artikel) : ?>
        <?php foreach ($artikel as $row) : ?>
            <article class="entry">
                <h3>
                    <a href="<?= base_url('/artikel/' . $row['slug']) ?>">
                        <?= $row['judul'] ?>
                    </a>
                </h3>
                <p><?= substr($row['isi'], 0, 150); ?>...</p>
                <hr class="divider">
            </article>
        <?php endforeach; ?>
    <?php else : ?>
        <p>Belum ada artikel.</p>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
