<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-book me-2"></i>Detail Mata Pelajaran</h2>
        <a href="<?= base_url('admin/mata_pelajaran') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Informasi Mata Pelajaran</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong>ID:</strong>
                        </div>
                        <div class="col-sm-9">
                            <?= $mapel->id ?>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong>Nama Mata Pelajaran:</strong>
                        </div>
                        <div class="col-sm-9">
                            <span class="badge bg-primary fs-6"><?= $mapel->nama_mapel ?></span>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-warning" onclick="editMapel(<?= $mapel->id ?>)">
                        <i class="fas fa-edit me-2"></i>Edit Data
                    </button>
                    <button type="button" class="btn btn-danger" onclick="hapusMapel(<?= $mapel->id ?>, '<?= $mapel->nama_mapel ?>')">
                        <i class="fas fa-trash me-2"></i>Hapus Data
                    </button>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Informasi Tambahan</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">
                        <i class="fas fa-info-circle me-2"></i>
                        Mata pelajaran ini dapat digunakan dalam pembuatan jadwal mengajar dan input nilai siswa.
                    </p>
                    <p class="text-muted">
                        <i class="fas fa-chalkboard-teacher me-2"></i>
                        Guru dapat mengajar mata pelajaran ini sesuai dengan jadwal yang telah ditentukan.
                    </p>
                    <p class="text-muted">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Mata pelajaran yang masih digunakan dalam jadwal tidak dapat dihapus dari sistem.
                    </p>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="mb-0">Aksi Cepat</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="<?= base_url('admin/data_kelas') ?>" class="btn btn-outline-primary">
                            <i class="fas fa-school me-2"></i>Lihat Data Kelas
                        </a>
                        <a href="<?= base_url('admin/data_guru') ?>" class="btn btn-outline-success">
                            <i class="fas fa-chalkboard-teacher me-2"></i>Lihat Data Guru
                        </a>
                        <button class="btn btn-outline-info" disabled>
                            <i class="fas fa-calendar-alt me-2"></i>Jadwal Mengajar
                            <small class="d-block text-muted">Coming Soon</small>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function editMapel(id) {
    // Redirect ke halaman mata pelajaran untuk edit
    window.location.href = '<?= base_url('admin/mata_pelajaran') ?>';
}

function hapusMapel(id, nama) {
    if (confirm('Apakah Anda yakin ingin menghapus mata pelajaran "' + nama + '"?\n\nPerhatian: Mata pelajaran yang masih digunakan dalam jadwal tidak dapat dihapus.')) {
        window.location.href = '<?= base_url('admin/hapus_mapel/') ?>' + id;
    }
}
</script>
