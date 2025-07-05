<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-school me-2"></i>Detail Kelas</h2>
        <a href="<?= base_url('admin/data_kelas') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Informasi Kelas</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong>Nama Kelas:</strong>
                        </div>
                        <div class="col-sm-9">
                            <?= $kelas->nama_kelas ?>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong>Wali Kelas:</strong>
                        </div>
                        <div class="col-sm-9">
                            <?= isset($kelas->nama_wali) ? $kelas->nama_wali : '-' ?>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong>Jumlah Siswa:</strong>
                        </div>
                        <div class="col-sm-9">
                            <span class="badge bg-primary fs-6">
                                <?= isset($kelas->jumlah_siswa) ? $kelas->jumlah_siswa : '0' ?> Siswa
                            </span>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-warning" onclick="editKelas(<?= $kelas->id ?>)">
                        <i class="fas fa-edit me-2"></i>Edit Data
                    </button>
                    <button type="button" class="btn btn-danger" onclick="hapusKelas(<?= $kelas->id ?>, '<?= $kelas->nama_kelas ?>')">
                        <i class="fas fa-trash me-2"></i>Hapus Data
                    </button>
                    <a href="<?= base_url('admin/data_siswa') ?>" class="btn btn-info">
                        <i class="fas fa-users me-2"></i>Lihat Siswa
                    </a>
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
                        Kelas ini dikelola oleh wali kelas yang bertanggung jawab atas administrasi dan pembinaan siswa.
                    </p>
                    <p class="text-muted">
                        <i class="fas fa-chalkboard-teacher me-2"></i>
                        Wali kelas dapat mengakses data lengkap siswa dalam kelasnya dan melakukan input nilai.
                    </p>
                    <p class="text-muted">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Kelas yang masih memiliki siswa tidak dapat dihapus dari sistem.
                    </p>
                </div>
            </div>

            <?php if(isset($kelas->jumlah_siswa) && $kelas->jumlah_siswa > 0): ?>
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="mb-0">Statistik Kelas</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span>Total Siswa:</span>
                        <span class="badge bg-primary"><?= $kelas->jumlah_siswa ?></span>
                    </div>
                    <div class="progress mb-3">
                        <div class="progress-bar" role="progressbar" style="width: <?= min(($kelas->jumlah_siswa / 40) * 100, 100) ?>%" aria-valuenow="<?= $kelas->jumlah_siswa ?>" aria-valuemin="0" aria-valuemax="40">
                            <?= $kelas->jumlah_siswa ?>/40
                        </div>
                    </div>
                    <small class="text-muted">Kapasitas maksimal: 40 siswa per kelas</small>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
function editKelas(id) {
    // Redirect ke halaman data kelas untuk edit
    window.location.href = '<?= base_url('admin/data_kelas') ?>';
}

function hapusKelas(id, nama) {
    if (confirm('Apakah Anda yakin ingin menghapus kelas "' + nama + '"?\n\nPerhatian: Kelas yang masih memiliki siswa tidak dapat dihapus.')) {
        window.location.href = '<?= base_url('admin/hapus_kelas/') ?>' + id;
    }
}
</script>
