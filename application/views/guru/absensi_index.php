<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h2><i class="fas fa-calendar-check me-2"></i>Absensi</h2>
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
                                        <option value="<?= $k->jadwal_id ?>" <?= (isset($selected_jadwal) && $selected_jadwal == $k->jadwal_id) ? 'selected' : '' ?>>
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
                        <h5><i class="fas fa-users me-2"></i>Input Absensi</h5>
                        <div class="btn-group">
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#inputAbsensiModal">
                                <i class="fas fa-plus me-1"></i>Input Absensi Hari Ini
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

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Tanggal:</strong> <?= date('d F Y') ?><br>
                            <strong>Pertemuan ke:</strong> <?= isset($next_pertemuan) ? $next_pertemuan : 1 ?><br>
                            <small><em>Nomor pertemuan ditentukan otomatis oleh sistem</em></small>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIS</th>
                                        <th>Nama Siswa</th>
                                        <th>Status Kehadiran Hari Ini</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; foreach($siswa as $s): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $s->nis ?></td>
                                            <td><?= $s->nama ?></td>
                                            <td>
                                                <span class="badge bg-secondary">Belum Absen</span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Riwayat Absensi -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h5><i class="fas fa-history me-2"></i>Riwayat Absensi</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Pertemuan</th>
                                        <th>Hadir</th>
                                        <th>Sakit</th>
                                        <th>Izin</th>
                                        <th>Alfa</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">
                                            Belum ada riwayat absensi
                                        </td>
                                    </tr>
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
                        <p class="text-muted">Silakan pilih kelas terlebih dahulu untuk input absensi.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Modal Input Absensi -->
<div class="modal fade" id="inputAbsensiModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Input Absensi - <?= date('d F Y') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= site_url('guru/simpan_absensi') ?>" method="post">
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Pertemuan ke-<?= isset($next_pertemuan) ? $next_pertemuan : 1 ?></strong> - <?= date('d F Y') ?>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NIS</th>
                                    <th>Nama Siswa</th>
                                    <th>Kehadiran</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(isset($siswa)): ?>
                                    <?php $no = 1; foreach($siswa as $s): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $s->nis ?></td>
                                            <td><?= $s->nama ?></td>
                                            <td>
                                                <input type="hidden" name="siswa_id[]" value="<?= $s->id ?>">
                                                <div class="btn-group" role="group">
                                                    <input type="radio" class="btn-check" name="keterangan[<?= $s->id ?>]" value="hadir" id="hadir_<?= $s->id ?>" checked>
                                                    <label class="btn btn-outline-success btn-sm" for="hadir_<?= $s->id ?>">Hadir</label>

                                                    <input type="radio" class="btn-check" name="keterangan[<?= $s->id ?>]" value="sakit" id="sakit_<?= $s->id ?>">
                                                    <label class="btn btn-outline-warning btn-sm" for="sakit_<?= $s->id ?>">Sakit</label>

                                                    <input type="radio" class="btn-check" name="keterangan[<?= $s->id ?>]" value="izin" id="izin_<?= $s->id ?>">
                                                    <label class="btn btn-outline-info btn-sm" for="izin_<?= $s->id ?>">Izin</label>

                                                    <input type="radio" class="btn-check" name="keterangan[<?= $s->id ?>]" value="alfa" id="alfa_<?= $s->id ?>">
                                                    <label class="btn btn-outline-danger btn-sm" for="alfa_<?= $s->id ?>">Alfa</label>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <input type="hidden" name="kelas_id" value="<?= isset($selected_kelas) ? $selected_kelas : '' ?>">
                    <input type="hidden" name="jadwal_id" value="<?= isset($selected_jadwal) ? $selected_jadwal : '' ?>">
                    <input type="hidden" name="tanggal" value="<?= date('Y-m-d') ?>">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Absensi</button>
                </div>
            </form>
        </div>
    </div>
</div>
