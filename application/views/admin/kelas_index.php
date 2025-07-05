<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-school me-2"></i>Data Kelas</h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahKelasModal">
            <i class="fas fa-plus me-2"></i>Tambah Kelas
        </button>
    </div>

    <?php if($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Kelas</th>
                            <th>Wali Kelas</th>
                            <th>Jumlah Siswa</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($kelas) && !empty($kelas)): ?>
                            <?php $no = 1; foreach($kelas as $k): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $k->nama_kelas ?></td>
                                    <td><?= isset($k->nama_wali) ? $k->nama_wali : '-' ?></td>
                                    <td><?= isset($k->jumlah_siswa) ? $k->jumlah_siswa : '0' ?></td>
                                    <td>
                                        <a href="<?= base_url('admin/detail_kelas/'.$k->id) ?>" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye me-1"></i>Detail
                                        </a>
                                        <button class="btn btn-sm btn-warning" onclick="editKelas(<?= $k->id ?>)">
                                            <i class="fas fa-edit me-1"></i>Edit
                                        </button>
                                        <button class="btn btn-sm btn-danger" onclick="hapusKelas(<?= $k->id ?>, '<?= $k->nama_kelas ?>')">
                                            <i class="fas fa-trash me-1"></i>Hapus
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">Belum ada data kelas</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Kelas -->
<div class="modal fade" id="tambahKelasModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Kelas Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('admin/simpan_kelas') ?>" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Kelas <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nama_kelas" placeholder="Contoh: X IPA 1" required>
                        <small class="form-text text-muted">Format: [Tingkat] [Jurusan] [Nomor], contoh: X IPA 1</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Wali Kelas <span class="text-danger">*</span></label>
                        <select class="form-select" name="wali_kelas_id" required>
                            <option value="">Pilih Wali Kelas</option>
                            <?php if(isset($guru)): ?>
                                <?php foreach($guru as $g): ?>
                                    <option value="<?= $g->id ?>"><?= $g->nama ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Kelas -->
<div class="modal fade" id="editKelasModal" tabindex="-1" aria-labelledby="editKelasModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editKelasModalLabel">
                    <i class="fas fa-edit me-2"></i>Edit Data Kelas
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editKelasForm" action="<?= base_url('admin/update_kelas') ?>" method="post">
                <input type="hidden" id="edit_kelas_id" name="id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_nama_kelas" class="form-label">Nama Kelas <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_nama_kelas" name="nama_kelas" required>
                        <small class="form-text text-muted">Format: [Tingkat] [Jurusan] [Nomor], contoh: X IPA 1</small>
                    </div>
                    <div class="mb-3">
                        <label for="edit_wali_kelas_id" class="form-label">Wali Kelas <span class="text-danger">*</span></label>
                        <select class="form-select" id="edit_wali_kelas_id" name="wali_kelas_id" required>
                            <option value="">Pilih Wali Kelas</option>
                            <?php if(isset($guru)): ?>
                                <?php foreach($guru as $g): ?>
                                    <option value="<?= $g->id ?>"><?= $g->nama ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function editKelas(id) {
    // Fetch data kelas via AJAX
    fetch('<?= base_url('admin/get_kelas/') ?>' + id)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('edit_kelas_id').value = data.kelas.id;
                document.getElementById('edit_nama_kelas').value = data.kelas.nama_kelas;
                document.getElementById('edit_wali_kelas_id').value = data.kelas.wali_kelas_id;

                const modal = new bootstrap.Modal(document.getElementById('editKelasModal'));
                modal.show();
            } else {
                alert('Gagal mengambil data kelas!');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan!');
        });
}

function hapusKelas(id, nama) {
    if (confirm('Apakah Anda yakin ingin menghapus kelas "' + nama + '"?\n\nPerhatian: Kelas yang masih memiliki siswa tidak dapat dihapus.')) {
        window.location.href = '<?= base_url('admin/hapus_kelas/') ?>' + id;
    }
}
</script>
