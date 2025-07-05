<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-book me-2"></i>Data Mata Pelajaran</h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahMapelModal">
            <i class="fas fa-plus me-2"></i>Tambah Mata Pelajaran
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
                            <th>Nama Mata Pelajaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($mapel) && !empty($mapel)): ?>
                            <?php $no = 1; foreach($mapel as $mp): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $mp->nama_mapel ?></td>
                                    <td>
                                        <a href="<?= base_url('admin/detail_mapel/'.$mp->id) ?>" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye me-1"></i>Detail
                                        </a>
                                        <button class="btn btn-sm btn-warning" onclick="editMapel(<?= $mp->id ?>)">
                                            <i class="fas fa-edit me-1"></i>Edit
                                        </button>
                                        <button class="btn btn-sm btn-danger" onclick="hapusMapel(<?= $mp->id ?>, '<?= $mp->nama_mapel ?>')">
                                            <i class="fas fa-trash me-1"></i>Hapus
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="text-center">Belum ada data mata pelajaran</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Mata Pelajaran -->
<div class="modal fade" id="tambahMapelModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Mata Pelajaran Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('admin/simpan_mapel') ?>" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Mata Pelajaran <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nama_mapel" placeholder="Contoh: Matematika" required>
                        <small class="form-text text-muted">Nama mata pelajaran harus unik</small>
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

<!-- Modal Edit Mata Pelajaran -->
<div class="modal fade" id="editMapelModal" tabindex="-1" aria-labelledby="editMapelModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editMapelModalLabel">
                    <i class="fas fa-edit me-2"></i>Edit Mata Pelajaran
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editMapelForm" action="<?= base_url('admin/update_mapel') ?>" method="post">
                <input type="hidden" id="edit_mapel_id" name="id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_nama_mapel" class="form-label">Nama Mata Pelajaran <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_nama_mapel" name="nama_mapel" required>
                        <small class="form-text text-muted">Nama mata pelajaran harus unik</small>
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
function editMapel(id) {
    // Fetch data mapel via AJAX
    fetch('<?= base_url('admin/get_mapel/') ?>' + id)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('edit_mapel_id').value = data.mapel.id;
                document.getElementById('edit_nama_mapel').value = data.mapel.nama_mapel;

                const modal = new bootstrap.Modal(document.getElementById('editMapelModal'));
                modal.show();
            } else {
                alert('Gagal mengambil data mata pelajaran!');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan!');
        });
}

function hapusMapel(id, nama) {
    if (confirm('Apakah Anda yakin ingin menghapus mata pelajaran "' + nama + '"?\n\nPerhatian: Mata pelajaran yang masih digunakan dalam jadwal tidak dapat dihapus.')) {
        window.location.href = '<?= base_url('admin/hapus_mapel/') ?>' + id;
    }
}
</script>
