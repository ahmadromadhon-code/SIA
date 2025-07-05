<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h2><i class="fas fa-clipboard-list me-2"></i>Input Nilai</h2>
            <hr>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-filter me-2"></i>Filter Kelas</h5>
                </div>
                <div class="card-body">
                    <form method="GET">
                        <div class="mb-3">
                            <label class="form-label">Pilih Kelas & Mata Pelajaran</label>
                            <select class="form-select" name="jadwal_id" onchange="this.form.submit()">
                                <option value="">-- Pilih Kelas & Mata Pelajaran --</option>
                                <?php if(isset($kelas)): ?>
                                    <?php foreach($kelas as $k): ?>
                                        <option value="<?= $k->jadwal_id ?>" data-kelas="<?= $k->id ?>" <?= (isset($selected_jadwal) && $selected_jadwal == $k->jadwal_id) ? 'selected' : '' ?>>
                                            <?= $k->nama_kelas ?> - <?= $k->nama_mapel ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <?php if(isset($siswa) && !empty($siswa)): ?>
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5><i class="fas fa-users me-2"></i>Daftar Siswa & Nilai</h5>
                        <div class="btn-group">
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#inputNilaiModal">
                                <i class="fas fa-plus me-1"></i>Input Nilai
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php if($this->session->flashdata('success')): ?>
                            <div class="alert alert-success alert-dismissible fade show">
                                <?= $this->session->flashdata('success') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <?php if($this->session->flashdata('error')): ?>
                            <div class="alert alert-danger alert-dismissible fade show">
                                <?= $this->session->flashdata('error') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <div class="table-responsive">
                            <table class="table table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIS</th>
                                        <th>Nama Siswa</th>
                                        <th>UTS</th>
                                        <th>UAS</th>
                                        <th>Tugas (Rata-rata)</th>
                                        <th>Sikap</th>
                                        <th>Presensi</th>
                                        <th>Nilai Akhir</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; foreach($siswa as $s): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $s->nis ?></td>
                                            <td><?= $s->nama ?></td>
                                            <td>
                                                <span class="badge bg-<?= $s->nilai['uts'] > 0 ? 'success' : 'secondary' ?>">
                                                    <?= $s->nilai['uts'] > 0 ? $s->nilai['uts'] : '-' ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-<?= $s->nilai['uas'] > 0 ? 'success' : 'secondary' ?>">
                                                    <?= $s->nilai['uas'] > 0 ? $s->nilai['uas'] : '-' ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-<?= $s->nilai['tugas'] > 0 ? 'success' : 'secondary' ?>">
                                                    <?= $s->nilai['tugas'] > 0 ? $s->nilai['tugas'] : '-' ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-<?= $s->nilai['sikap'] > 0 ? 'success' : 'secondary' ?>">
                                                    <?= $s->nilai['sikap'] > 0 ? $s->nilai['sikap'] : '-' ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">
                                                    <?= $s->nilai['presensi'] ?>% (<?= $s->nilai['total_hadir'] ?>/<?= $s->nilai['total_pertemuan'] ?>)
                                                </span>
                                            </td>
                                            <td>
                                                <strong class="text-primary"><?= $s->nilai['nilai_akhir'] ?></strong>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary" onclick="inputNilaiSiswa(<?= $s->id ?>, '<?= $s->nama ?>')">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="card">
                    <div class="card-body text-center">
                        <i class="fas fa-arrow-left fa-3x text-muted mb-3"></i>
                        <h5>Pilih Kelas</h5>
                        <p class="text-muted">Silakan pilih kelas terlebih dahulu untuk melihat daftar siswa dan input nilai.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Modal Input Nilai -->
<div class="modal fade" id="inputNilaiModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Input Nilai</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= site_url('guru/simpan_nilai') ?>" method="post" id="formInputNilai">
                <div class="modal-body">
                    <div class="alert alert-info">
                        <small>
                            <strong>Catatan:</strong><br>
                            • UTS, UAS, dan Sikap hanya bisa diinput sekali per siswa<br>
                            • Tugas bisa diinput berkali-kali, sistem akan menghitung rata-rata
                        </small>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Siswa</label>
                                <select class="form-select" name="siswa_id" id="siswa_id" required>
                                    <option value="">Pilih Siswa</option>
                                    <?php if(isset($siswa)): ?>
                                        <?php foreach($siswa as $s): ?>
                                            <option value="<?= $s->id ?>"><?= $s->nama ?> (<?= $s->nis ?>)</option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Jenis Nilai</label>
                                <select class="form-select" name="jenis" id="jenis_nilai" required onchange="checkNilaiExists()">
                                    <option value="">Pilih Jenis</option>
                                    <option value="uts">UTS (25%)</option>
                                    <option value="uas">UAS (25%)</option>
                                    <option value="tugas">Tugas (25%)</option>
                                    <option value="sikap">Sikap (10%)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nilai (0-100)</label>
                        <input type="number" class="form-control" name="nilai" min="0" max="100" step="0.01" required>
                    </div>
                    <div id="warning-exists" class="alert alert-warning d-none">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Nilai ini sudah pernah diinput untuk siswa ini!
                    </div>
                    <input type="hidden" name="kelas_id" value="<?= isset($selected_kelas) ? $selected_kelas : '' ?>">
                    <input type="hidden" name="jadwal_id" value="<?= isset($selected_jadwal) ? $selected_jadwal : '' ?>">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Nilai</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function updateJadwal(kelasId) {
    const select = document.querySelector('select[name="kelas_id"]');
    const selectedOption = select.options[select.selectedIndex];
    const jadwalId = selectedOption.getAttribute('data-jadwal');
    document.getElementById('jadwal_id').value = jadwalId || '';
}

function inputNilaiSiswa(siswaId, namaSiswa) {
    document.getElementById('siswa_id').value = siswaId;
    const modal = new bootstrap.Modal(document.getElementById('inputNilaiModal'));
    modal.show();
}

function checkNilaiExists() {
    const siswaId = document.getElementById('siswa_id').value;
    const jenis = document.getElementById('jenis_nilai').value;
    const warning = document.getElementById('warning-exists');

    // Reset warning
    warning.classList.add('d-none');

    if (siswaId && jenis && ['uts', 'uas', 'sikap'].includes(jenis)) {
        // Cek dari data yang sudah ada di tabel
        const table = document.querySelector('table tbody');
        const rows = table.querySelectorAll('tr');

        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            if (cells.length > 1) {
                // Ambil data siswa dari baris
                const rowSiswaId = row.querySelector('button').getAttribute('onclick').match(/\d+/)[0];
                if (rowSiswaId == siswaId) {
                    let hasValue = false;
                    if (jenis === 'uts' && cells[3].textContent.trim() !== '-') hasValue = true;
                    if (jenis === 'uas' && cells[4].textContent.trim() !== '-') hasValue = true;
                    if (jenis === 'sikap' && cells[6].textContent.trim() !== '-') hasValue = true;

                    if (hasValue) {
                        warning.classList.remove('d-none');
                    }
                }
            }
        });
    }
}

// Event listeners
document.getElementById('siswa_id').addEventListener('change', checkNilaiExists);
document.getElementById('jenis_nilai').addEventListener('change', checkNilaiExists);
</script>
