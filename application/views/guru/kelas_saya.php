<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h2><i class="fas fa-chalkboard me-2"></i>Kelas Saya</h2>
            <hr>
        </div>
    </div>

    <div class="row">
        <?php if(isset($kelas) && !empty($kelas)): ?>
            <?php foreach($kelas as $k): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-school me-2"></i><?= $k->nama_kelas ?>
                            </h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text">
                                <strong>Mata Pelajaran:</strong> <?= $k->nama_mapel ?><br>
                                <strong>Jumlah Siswa:</strong> <?= isset($k->jumlah_siswa) ? $k->jumlah_siswa : '0' ?> siswa
                            </p>
                        </div>
                        <div class="card-footer">
                            <div class="btn-group w-100" role="group">
                                <a href="<?= site_url('guru/absensi_kelas/'.$k->id) ?>" class="btn btn-success btn-sm">
                                    <i class="fas fa-calendar-check me-1"></i>Absensi
                                </a>
                                <a href="<?= site_url('guru/nilai_kelas/'.$k->id) ?>" class="btn btn-warning btn-sm">
                                    <i class="fas fa-clipboard-list me-1"></i>Nilai
                                </a>
                                <a href="<?= site_url('guru/detail_kelas/'.$k->id) ?>" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye me-1"></i>Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle me-2"></i>
                    Belum ada kelas yang diampu.
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
