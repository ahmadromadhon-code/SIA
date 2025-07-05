<div class="container-fluid">
    <!-- Flash Messages -->
    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Data Guru</span>
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambahGuruModal">
                <i class="fas fa-plus me-2"></i>Tambah Guru
            </button>
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIP</th>
                        <th>Nama Lengkap</th>
                        <th>No. HP</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($guru)): ?>
                        <?php foreach($guru as $key => $g): ?>
                        <tr>
                            <td><?= $key + 1 ?></td>
                            <td><?= $g->nip ?></td>
                            <td><?= $g->nama ?></td>
                            <td><?= $g->no_hp ?></td>
                            <td>
                                <a href="<?= base_url('admin/detail_guru/'.$g->id) ?>" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye me-1"></i>Detail
                                </a>
                                <button type="button" class="btn btn-warning btn-sm" onclick="editGuru(<?= $g->id ?>)">
                                    <i class="fas fa-edit me-1"></i>Edit
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" onclick="hapusGuru(<?= $g->id ?>, '<?= $g->nama ?>')">
                                    <i class="fas fa-trash me-1"></i>Hapus
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">Belum ada data guru.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Guru -->
<div class="modal fade" id="tambahGuruModal" tabindex="-1" aria-labelledby="tambahGuruModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahGuruModalLabel">
                    <i class="fas fa-user-plus me-2"></i>Tambah Data Guru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('admin/simpan_guru') ?>" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nip" class="form-label">NIP <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nip" name="nip" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nama" name="nama" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="password" name="password" required>
                                <small class="form-text text-muted">Minimal 6 karakter</small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="no_hp" class="form-label">No. HP <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="no_hp" name="no_hp" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
                            </div>
                        </div>
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

<!-- Modal Edit Guru -->
<div class="modal fade" id="editGuruModal" tabindex="-1" aria-labelledby="editGuruModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editGuruModalLabel">
                    <i class="fas fa-user-edit me-2"></i>Edit Data Guru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editGuruForm" action="<?= base_url('admin/update_guru') ?>" method="post">
                <input type="hidden" id="edit_id" name="id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_nip" class="form-label">NIP <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_nip" name="nip" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_nama" name="nama" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_username" class="form-label">Username <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_username" name="username" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="edit_password" name="password">
                                <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah password</small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_no_hp" class="form-label">No. HP <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_no_hp" name="no_hp" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_alamat" class="form-label">Alamat <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="edit_alamat" name="alamat" rows="3" required></textarea>
                            </div>
                        </div>
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
function editGuru(id) {
    // Fetch data guru via AJAX
    fetch('<?= base_url('admin/get_guru/') ?>' + id)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('edit_id').value = data.guru.id;
                document.getElementById('edit_nip').value = data.guru.nip;
                document.getElementById('edit_nama').value = data.guru.nama;
                document.getElementById('edit_username').value = data.guru.username;
                document.getElementById('edit_no_hp').value = data.guru.no_hp;
                document.getElementById('edit_alamat').value = data.guru.alamat;

                const modal = new bootstrap.Modal(document.getElementById('editGuruModal'));
                modal.show();
            } else {
                alert('Gagal mengambil data guru!');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan!');
        });
}

function hapusGuru(id, nama) {
    if (confirm('Apakah Anda yakin ingin menghapus guru "' + nama + '"?')) {
        window.location.href = '<?= base_url('admin/hapus_guru/') ?>' + id;
    }
}
</script>