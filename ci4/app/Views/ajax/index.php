<?= $this->include('template/header'); ?>

<!-- Modal Tambah / Ubah Artikel -->
<div id="modalOverlay" style="display:none;">
    <div id="modalBox">
        <h2 id="modalTitle">Tambah Artikel</h2>
        <input type="hidden" id="editId" value="">

        <label for="inputJudul">Judul</label>
        <input type="text" id="inputJudul" placeholder="Masukkan judul artikel">

        <label for="inputIsi">Isi</label>
        <textarea id="inputIsi" placeholder="Masukkan isi artikel" rows="4"></textarea>

        <div class="modal-buttons">
            <button id="btnSimpan">Simpan</button>
            <button id="btnBatal">Batal</button>
        </div>
    </div>
</div>

<div class="page-wrapper">
    <div class="page-header">
        <h1>Data Artikel</h1>
        <button id="btnTambah" class="btn btn-success">+ Tambah Artikel</button>
    </div>

    <table class="table-data" id="artikelTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Judul</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<style>
    /* ===== OVERLAY & MODAL ===== */
    #modalOverlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.55);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
    }

    #modalBox {
        background: #fff;
        border-radius: 10px;
        padding: 30px;
        width: 460px;
        max-width: 95%;
        box-shadow: 0 8px 32px rgba(0,0,0,0.18);
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    #modalBox h2 {
        margin: 0 0 6px;
        font-size: 1.3rem;
        color: #1a1a2e;
    }

    #modalBox label {
        font-size: 0.85rem;
        font-weight: 600;
        color: #444;
        margin-bottom: -6px;
    }

    #modalBox input[type="text"],
    #modalBox textarea {
        width: 100%;
        padding: 9px 12px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 0.95rem;
        box-sizing: border-box;
        resize: vertical;
    }

    #modalBox input[type="text"]:focus,
    #modalBox textarea:focus {
        outline: none;
        border-color: #4f8ef7;
        box-shadow: 0 0 0 3px rgba(79,142,247,0.15);
    }

    .modal-buttons {
        display: flex;
        gap: 10px;
        margin-top: 6px;
    }

    .modal-buttons button {
        flex: 1;
        padding: 10px;
        border: none;
        border-radius: 6px;
        font-size: 0.95rem;
        cursor: pointer;
        font-weight: 600;
        transition: opacity 0.2s;
    }

    #btnSimpan  { background: #2ecc71; color: #fff; }
    #btnBatal   { background: #e0e0e0; color: #333; }

    .modal-buttons button:hover { opacity: 0.85; }

    /* ===== HALAMAN ===== */
    .page-wrapper {
        padding: 24px;
    }

    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 18px;
    }

    .page-header h1 {
        font-size: 1.5rem;
        margin: 0;
    }

    /* ===== TABEL ===== */
    .table-data {
        width: 100%;
        border-collapse: collapse;
        background: #fff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(0,0,0,0.07);
    }

    .table-data th {
        background: #1a1a2e;
        color: #fff;
        padding: 12px 14px;
        text-align: left;
        font-size: 0.88rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .table-data td {
        padding: 11px 14px;
        border-bottom: 1px solid #f0f0f0;
        font-size: 0.92rem;
        color: #333;
        vertical-align: middle;
    }

    .table-data tr:last-child td { border-bottom: none; }
    .table-data tr:hover td     { background: #f7f9ff; }

    /* ===== TOMBOL ===== */
    .btn {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 5px;
        font-size: 0.82rem;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        border: none;
        transition: opacity 0.2s;
    }

    .btn:hover        { opacity: 0.82; }
    .btn-primary      { background: #4f8ef7; color: #fff; }
    .btn-danger       { background: #e74c3c; color: #fff; }
    .btn-success      { background: #2ecc71; color: #fff; }
    .btn-warning      { background: #f39c12; color: #fff; }
</style>

<script src="<?= base_url('assets/js/jquery-3.6.0.min.js') ?>"></script>
<script>
$(document).ready(function () {

    /* ─────────────────────────────────────────
       HELPER: Tampilkan pesan loading
    ───────────────────────────────────────── */
    function showLoadingMessage() {
        $('#artikelTable tbody').html(
            '<tr><td colspan="4" style="text-align:center;color:#888;">Loading data...</td></tr>'
        );
    }

    /* ─────────────────────────────────────────
       LOAD DATA (Read / GET)
    ───────────────────────────────────────── */
    function loadData() {
        showLoadingMessage();

        $.ajax({
            url: "<?= base_url('ajax/getData') ?>",
            method: "GET",
            dataType: "json",
            success: function (data) {
                var tableBody = "";

                if (data.length === 0) {
                    tableBody = '<tr><td colspan="4" style="text-align:center;">Belum ada data.</td></tr>';
                } else {
                    for (var i = 0; i < data.length; i++) {
                        var row = data[i];
                        tableBody += '<tr>';
                        tableBody += '<td>' + row.id    + '</td>';
                        tableBody += '<td>' + row.judul + '</td>';
                        tableBody += '<td><span class="status">—</span></td>';
                        tableBody += '<td>';
                        tableBody += '<button class="btn btn-warning btn-ubah" data-id="' + row.id + '">Edit</button> ';
                        tableBody += '<button class="btn btn-danger  btn-delete" data-id="' + row.id + '">Hapus</button>';
                        tableBody += '</td>';
                        tableBody += '</tr>';
                    }
                }

                $('#artikelTable tbody').html(tableBody);
            },
            error: function () {
                $('#artikelTable tbody').html(
                    '<tr><td colspan="4" style="color:red;text-align:center;">Gagal memuat data.</td></tr>'
                );
            }
        });
    }

    loadData();

    /* ─────────────────────────────────────────
       MODAL HELPER
    ───────────────────────────────────────── */
    function bukaModal(judul, id, isiJudul, isiKonten) {
        $('#modalTitle').text(judul);
        $('#editId').val(id);
        $('#inputJudul').val(isiJudul   || '');
        $('#inputIsi').val(isiKonten    || '');
        $('#modalOverlay').fadeIn(200);
    }

    function tutupModal() {
        $('#modalOverlay').fadeOut(180);
        $('#editId').val('');
        $('#inputJudul').val('');
        $('#inputIsi').val('');
    }

    /* ─────────────────────────────────────────
       TAMBAH ARTIKEL (Insert / POST)
    ───────────────────────────────────────── */
    $('#btnTambah').on('click', function () {
        bukaModal('Tambah Artikel', '', '', '');
    });

    /* ─────────────────────────────────────────
       UBAH ARTIKEL (Update – buka modal isi data)
    ───────────────────────────────────────── */
    $(document).on('click', '.btn-ubah', function () {
        var id = $(this).data('id');

        $.ajax({
            url: "<?= base_url('ajax/getById/') ?>" + id,
            method: "GET",
            dataType: "json",
            success: function (row) {
                bukaModal('Ubah Artikel', row.id, row.judul, row.isi);
            },
            error: function () {
                alert('Gagal mengambil data artikel.');
            }
        });
    });

    /* ─────────────────────────────────────────
       SIMPAN (Tambah ATAU Ubah)
    ───────────────────────────────────────── */
    $('#btnSimpan').on('click', function () {
        var id    = $('#editId').val();
        var judul = $('#inputJudul').val().trim();
        var isi   = $('#inputIsi').val().trim();

        if (judul === '') {
            alert('Judul tidak boleh kosong!');
            return;
        }

        var url    = id ? "<?= base_url('ajax/update/') ?>" + id
                       : "<?= base_url('ajax/save') ?>";
        var method = id ? "POST" : "POST"; // CodeIgniter 4 pakai POST + _method override jika perlu

        $.ajax({
            url: url,
            method: method,
            data: { judul: judul, isi: isi },
            dataType: "json",
            success: function (res) {
                if (res.status === 'OK') {
                    tutupModal();
                    loadData();
                }
            },
            error: function () {
                alert('Gagal menyimpan data.');
            }
        });
    });

    /* ─────────────────────────────────────────
       BATAL
    ───────────────────────────────────────── */
    $('#btnBatal').on('click', function () {
        tutupModal();
    });

    /* ─────────────────────────────────────────
       HAPUS ARTIKEL (Delete)
    ───────────────────────────────────────── */
    $(document).on('click', '.btn-delete', function (e) {
        e.preventDefault();
        var id = $(this).data('id');

        if (confirm('Apakah Anda yakin ingin menghapus artikel ini?')) {
            $.ajax({
                url: "<?= base_url('ajax/delete/') ?>" + id,
                method: "DELETE",
                dataType: "json",
                success: function (data) {
                    loadData();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Error menghapus artikel: ' + textStatus + ' ' + errorThrown);
                }
            });
        }
    });

});
</script>

<?= $this->include('template/footer'); ?>