<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-user me-2"></i>Detail Siswa</h2>
        <a href="<?= base_url('admin/data_siswa') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Informasi Siswa</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong>NIS:</strong>
                        </div>
                        <div class="col-sm-9">
                            <?= $siswa->nis ?>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong>Nama Lengkap:</strong>
                        </div>
                        <div class="col-sm-9">
                            <?= $siswa->nama ?>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong>Username:</strong>
                        </div>
                        <div class="col-sm-9">
                            <?= $siswa->username ?>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong>Kelas:</strong>
                        </div>
                        <div class="col-sm-9">
                            <?= isset($siswa->nama_kelas) ? $siswa->nama_kelas : '-' ?>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong>Jenis Kelamin:</strong>
                        </div>
                        <div class="col-sm-9">
                            <?= $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' ?>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong>Tanggal Lahir:</strong>
                        </div>
                        <div class="col-sm-9">
                            <?= date('d F Y', strtotime($siswa->tanggal_lahir)) ?>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong>Alamat:</strong>
                        </div>
                        <div class="col-sm-9">
                            <?= $siswa->alamat ?>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-warning" onclick="editSiswa(<?= $siswa->id ?>)">
                        <i class="fas fa-edit me-2"></i>Edit Data
                    </button>
                    <button type="button" class="btn btn-danger" onclick="hapusSiswa(<?= $siswa->id ?>, '<?= $siswa->nama ?>')">
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
                        Data siswa ini dapat digunakan untuk login ke sistem dengan username dan password yang telah ditentukan.
                    </p>
                    <p class="text-muted">
                        <i class="fas fa-graduation-cap me-2"></i>
                        Siswa dapat mengakses fitur melihat nilai, jadwal pelajaran, dan informasi akademik lainnya.
                    </p>
                    <p class="text-muted">
                        <i class="fas fa-calendar-check me-2"></i>
                        Presensi siswa akan dicatat otomatis oleh guru pada setiap pertemuan.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function editSiswa(id) {
    // Redirect ke halaman edit atau buka modal edit
    window.location.href = '<?= base_url('admin/data_siswa') ?>';
}

function hapusSiswa(id, nama) {
    if (confirm('Apakah Anda yakin ingin menghapus siswa "' + nama + '"?')) {
        window.location.href = '<?= base_url('admin/hapus_siswa/') ?>' + id;
    }
}
</script>
