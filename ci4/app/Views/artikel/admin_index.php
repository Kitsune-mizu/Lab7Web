<?= $this->include('template/admin_header'); ?>

<h2><?= $title; ?></h2>

<!-- Form Search & Filter -->
<form id="search-form" class="form-search">
    <div class="search-row">
        <input
            type="text"
            name="q"
            id="search-box"
            value="<?= $q; ?>"
            placeholder="Cari judul artikel..."
        >
        <input type="submit" value="Cari" class="btn btn-primary">
    </div>
    <select name="kategori_id" id="category-filter" class="kategori-filter">
        <option value="">-- Semua Kategori --</option>
        <?php foreach ($kategori as $k): ?>
            <option
                value="<?= $k['id_kategori']; ?>"
                <?= ($kategori_id == $k['id_kategori']) ? 'selected' : ''; ?>
            >
                <?= $k['nama_kategori']; ?>
            </option>
        <?php endforeach; ?>
    </select>
</form>

<!-- Loading Indicator -->
<div id="loading-indicator" style="display:none; padding:16px; color:#5a5a5a;">
    ⏳ Memuat data...
</div>

<!-- Container Tabel -->
<div id="article-container"></div>

<!-- Container Pagination -->
<div id="pagination-container"></div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {

    const articleContainer    = $('#article-container');
    const paginationContainer = $('#pagination-container');
    const loadingIndicator    = $('#loading-indicator');
    const searchForm          = $('#search-form');
    const searchBox           = $('#search-box');
    const categoryFilter      = $('#category-filter');

    const fetchData = (url) => {
        loadingIndicator.show();
        articleContainer.hide();
        paginationContainer.hide();

        $.ajax({
            url      : url,
            type     : 'GET',
            dataType : 'json',
            headers  : { 'X-Requested-With': 'XMLHttpRequest' },
            success  : function (data) {
                renderArticles(data.artikel);
                renderPagination(data.pager);
                loadingIndicator.hide();
                articleContainer.show();
                paginationContainer.show();
            },
            error: function () {
                loadingIndicator.hide();
                articleContainer.html(
                    '<p style="color:red;">Gagal memuat data.</p>'
                ).show();
            }
        });
    };

    const renderArticles = (articles) => {
        let html = `
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
        `;

        if (articles && articles.length > 0) {
            articles.forEach(article => {
                html += `
                    <tr>
                        <td>${article.id}</td>
                        <td>
                            <b>${article.judul}</b>
                            <small>${article.isi.substring(0, 50)}</small>
                        </td>
                        <td>${article.nama_kategori ?? '-'}</td>
                        <td>${article.status}</td>
                        <td>
                            <a class="btn"
                               href="/admin/artikel/edit/${article.id}">Ubah</a>
                            <a class="btn btn-danger"
                               onclick="return confirm('Yakin menghapus data?');"
                               href="/admin/artikel/delete/${article.id}">Hapus</a>
                        </td>
                    </tr>
                `;
            });
        } else {
            html += '<tr><td colspan="5">Belum ada data.</td></tr>';
        }

        html += `
                </tbody>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
            </table>
        `;

        articleContainer.html(html);
    };

    const renderPagination = (pager) => {
        // Tidak ada data pagination sama sekali
        if (!pager || !pager.links) return;

        // Hanya 1 halaman, tidak perlu pagination
        if (pager.totalPages <= 1) {
            paginationContainer.html('');
            return;
        }

        let html = '<ul class="pagination">';

        pager.links.forEach(link => {
            const url         = link.url ? link.url : '#';
            const activeClass = link.active ? 'active' : '';

            html += `
                <li class="${activeClass}">
                    <a class="pagination-link" href="${url}">${link.title}</a>
                </li>
            `;
        });

        html += '</ul>';
        paginationContainer.html(html);
    };

    searchForm.on('submit', function (e) {
        e.preventDefault();
        const q           = searchBox.val();
        const kategori_id = categoryFilter.val();
        fetchData(`/admin/artikel?q=${q}&kategori_id=${kategori_id}`);
    });

    categoryFilter.on('change', function () {
        searchForm.trigger('submit');
    });

    $(document).on('click', '.pagination-link', function (e) {
        e.preventDefault();
        const url = $(this).attr('href');
        if (url && url !== '#') fetchData(url);
    });

    fetchData('/admin/artikel');
});
</script>

<?= $this->include('template/admin_footer'); ?>