<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-users me-2"></i>Data Siswa</h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahSiswaModal">
            <i class="fas fa-plus me-2"></i>Tambah Siswa
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
                            <th>NIS</th>
                            <th>Nama Lengkap</th>
                            <th>Kelas</th>
                            <th>Jenis Kelamin</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($siswa) && !empty($siswa)): ?>
                            <?php $no = 1; foreach($siswa as $s): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $s->nis ?></td>
                                    <td><?= $s->nama ?></td>
                                    <td><?= isset($s->nama_kelas) ? $s->nama_kelas : '-' ?></td>
                                    <td><?= $s->jenis_kelamin ?></td>
                                    <td><?= $s->alamat ?></td>
                                    <td>
                                        <a href="<?= base_url('admin/detail_siswa/'.$s->id) ?>" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye me-1"></i>Detail
                                        </a>
                                        <button class="btn btn-sm btn-warning" onclick="editSiswa(<?= $s->id ?>)">
                                            <i class="fas fa-edit me-1"></i>Edit
                                        </button>
                                        <button class="btn btn-sm btn-danger" onclick="hapusSiswa(<?= $s->id ?>, '<?= $s->nama ?>')">
                                            <i class="fas fa-trash me-1"></i>Hapus
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center">Belum ada data siswa</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Siswa -->
<div class="modal fade" id="tambahSiswaModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Siswa Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('admin/simpan_siswa') ?>" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">NIS <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nis" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nama" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Username <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="username" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" name="password" required>
                                <small class="form-text text-muted">Minimal 6 karakter</small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Kelas <span class="text-danger">*</span></label>
                                <select class="form-select" name="kelas_id" required>
                                    <option value="">Pilih Kelas</option>
                                    <?php if(isset($kelas)): ?>
                                        <?php foreach($kelas as $k): ?>
                                            <option value="<?= $k->id ?>"><?= $k->nama_kelas ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                <select class="form-select" name="jenis_kelamin" required>
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="tanggal_lahir" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Alamat <span class="text-danger">*</span></label>
                                <textarea class="form-control" name="alamat" rows="3" required></textarea>
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

<!-- Modal Edit Siswa -->
<div class="modal fade" id="editSiswaModal" tabindex="-1" aria-labelledby="editSiswaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSiswaModalLabel">
                    <i class="fas fa-user-edit me-2"></i>Edit Data Siswa
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editSiswaForm" action="<?= base_url('admin/update_siswa') ?>" method="post">
                <input type="hidden" id="edit_siswa_id" name="id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_nis" class="form-label">NIS <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_nis" name="nis" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_nama_siswa" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_nama_siswa" name="nama" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_username_siswa" class="form-label">Username <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_username_siswa" name="username" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_password_siswa" class="form-label">Password</label>
                                <input type="password" class="form-control" id="edit_password_siswa" name="password">
                                <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah password</small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_kelas_id" class="form-label">Kelas <span class="text-danger">*</span></label>
                                <select class="form-select" id="edit_kelas_id" name="kelas_id" required>
                                    <option value="">Pilih Kelas</option>
                                    <?php if(isset($kelas)): ?>
                                        <?php foreach($kelas as $k): ?>
                                            <option value="<?= $k->id ?>"><?= $k->nama_kelas ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_jenis_kelamin" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                <select class="form-select" id="edit_jenis_kelamin" name="jenis_kelamin" required>
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_tanggal_lahir" class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="edit_tanggal_lahir" name="tanggal_lahir" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_alamat_siswa" class="form-label">Alamat <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="edit_alamat_siswa" name="alamat" rows="3" required></textarea>
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
function editSiswa(id) {
    // Fetch data siswa via AJAX
    fetch('<?= base_url('admin/get_siswa/') ?>' + id)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('edit_siswa_id').value = data.siswa.id;
                document.getElementById('edit_nis').value = data.siswa.nis;
                document.getElementById('edit_nama_siswa').value = data.siswa.nama;
                document.getElementById('edit_username_siswa').value = data.siswa.username;
                document.getElementById('edit_kelas_id').value = data.siswa.kelas_id;
                document.getElementById('edit_jenis_kelamin').value = data.siswa.jenis_kelamin;
                document.getElementById('edit_tanggal_lahir').value = data.siswa.tanggal_lahir;
                document.getElementById('edit_alamat_siswa').value = data.siswa.alamat;

                const modal = new bootstrap.Modal(document.getElementById('editSiswaModal'));
                modal.show();
            } else {
                alert('Gagal mengambil data siswa!');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan!');
        });
}

function hapusSiswa(id, nama) {
    if (confirm('Apakah Anda yakin ingin menghapus siswa "' + nama + '"?')) {
        window.location.href = '<?= base_url('admin/hapus_siswa/') ?>' + id;
    }
}
</script>
