<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-user me-2"></i>Detail Guru</h2>
        <a href="<?= base_url('admin/data_guru') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Informasi Guru</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong>NIP:</strong>
                        </div>
                        <div class="col-sm-9">
                            <?= $guru->nip ?>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong>Nama Lengkap:</strong>
                        </div>
                        <div class="col-sm-9">
                            <?= $guru->nama ?>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong>Username:</strong>
                        </div>
                        <div class="col-sm-9">
                            <?= $guru->username ?>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong>No. HP:</strong>
                        </div>
                        <div class="col-sm-9">
                            <?= $guru->no_hp ?>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong>Alamat:</strong>
                        </div>
                        <div class="col-sm-9">
                            <?= $guru->alamat ?>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="<?= base_url('admin/edit_guru/'.$guru->id) ?>" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>Edit Data
                    </a>
                    <button type="button" class="btn btn-danger" onclick="hapusGuru(<?= $guru->id ?>, '<?= $guru->nama ?>')">
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
                        Data guru ini dapat digunakan untuk login ke sistem dengan username dan password yang telah ditentukan.
                    </p>
                    <p class="text-muted">
                        <i class="fas fa-chalkboard-teacher me-2"></i>
                        Guru dapat mengakses fitur input nilai, presensi, dan melihat jadwal mengajar.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function hapusGuru(id, nama) {
    if (confirm('Apakah Anda yakin ingin menghapus guru "' + nama + '"?')) {
        window.location.href = '<?= base_url('admin/hapus_guru/') ?>' + id;
    }
}
</script>
