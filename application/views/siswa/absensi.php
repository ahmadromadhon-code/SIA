<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h2><i class="fas fa-calendar-check me-2"></i>Riwayat Absensi</h2>
            <hr>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-list me-2"></i>Riwayat Kehadiran</h5>
                </div>
                <div class="card-body">
                    <?php if(isset($absensi) && !empty($absensi)): ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Hari</th>
                                        <th>Mata Pelajaran</th>
                                        <th>Guru</th>
                                        <th>Jam</th>
                                        <th>Pertemuan</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; foreach($absensi as $a): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= date('d/m/Y', strtotime($a->tanggal)) ?></td>
                                            <td><?= $a->hari ?></td>
                                            <td><?= $a->nama_mapel ?></td>
                                            <td><?= $a->nama_guru ?></td>
                                            <td><?= date('H:i', strtotime($a->jam_mulai)) ?> - <?= date('H:i', strtotime($a->jam_selesai)) ?></td>
                                            <td>
                                                <span class="badge bg-secondary"><?= $a->pertemuan ?></span>
                                            </td>
                                            <td>
                                                <?php
                                                $status_color = [
                                                    'hadir' => 'success',
                                                    'sakit' => 'warning',
                                                    'izin' => 'info',
                                                    'alfa' => 'danger'
                                                ];
                                                $status_icon = [
                                                    'hadir' => 'check-circle',
                                                    'sakit' => 'thermometer-half',
                                                    'izin' => 'info-circle',
                                                    'alfa' => 'times-circle'
                                                ];
                                                ?>
                                                <span class="badge bg-<?= $status_color[$a->keterangan] ?>">
                                                    <i class="fas fa-<?= $status_icon[$a->keterangan] ?> me-1"></i>
                                                    <?= ucfirst($a->keterangan) ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info text-center">
                            <i class="fas fa-info-circle me-2"></i>
                            Belum ada riwayat absensi.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Kehadiran -->
    <?php if(isset($absensi) && !empty($absensi)): ?>
    <div class="row mt-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-chart-pie me-2"></i>Statistik Kehadiran</h5>
                </div>
                <div class="card-body">
                    <?php
                    $total_pertemuan = count($absensi);
                    $hadir = 0;
                    $sakit = 0;
                    $izin = 0;
                    $alfa = 0;
                    
                    foreach($absensi as $a) {
                        switch($a->keterangan) {
                            case 'hadir': $hadir++; break;
                            case 'sakit': $sakit++; break;
                            case 'izin': $izin++; break;
                            case 'alfa': $alfa++; break;
                        }
                    }
                    
                    $persentase_hadir = $total_pertemuan > 0 ? ($hadir / $total_pertemuan) * 100 : 0;
                    ?>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-6">
                                    <div class="card bg-success text-white">
                                        <div class="card-body text-center">
                                            <h4><?= $hadir ?></h4>
                                            <small>Hadir</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="card bg-warning text-white">
                                        <div class="card-body text-center">
                                            <h4><?= $sakit ?></h4>
                                            <small>Sakit</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-6">
                                    <div class="card bg-info text-white">
                                        <div class="card-body text-center">
                                            <h4><?= $izin ?></h4>
                                            <small>Izin</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="card bg-danger text-white">
                                        <div class="card-body text-center">
                                            <h4><?= $alfa ?></h4>
                                            <small>Alfa</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="text-center">
                                <h3 class="text-primary"><?= number_format($persentase_hadir, 1) ?>%</h3>
                                <p class="text-muted">Persentase Kehadiran</p>
                                
                                <div class="progress mb-3" style="height: 20px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: <?= $persentase_hadir ?>%">
                                        <?= number_format($persentase_hadir, 1) ?>%
                                    </div>
                                </div>
                                
                                <?php if ($persentase_hadir >= 90): ?>
                                    <div class="alert alert-success">
                                        <i class="fas fa-trophy me-2"></i>
                                        <strong>Kehadiran Sangat Baik!</strong>
                                    </div>
                                <?php elseif ($persentase_hadir >= 80): ?>
                                    <div class="alert alert-primary">
                                        <i class="fas fa-thumbs-up me-2"></i>
                                        <strong>Kehadiran Baik</strong>
                                    </div>
                                <?php elseif ($persentase_hadir >= 70): ?>
                                    <div class="alert alert-warning">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        <strong>Perlu Ditingkatkan</strong>
                                    </div>
                                <?php else: ?>
                                    <div class="alert alert-danger">
                                        <i class="fas fa-times-circle me-2"></i>
                                        <strong>Kehadiran Kurang</strong>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-info-circle me-2"></i>Informasi</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fas fa-calendar me-2 text-primary"></i>
                            <strong>Total Pertemuan:</strong> <?= $total_pertemuan ?>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check-circle me-2 text-success"></i>
                            <strong>Hadir:</strong> <?= $hadir ?> kali
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-thermometer-half me-2 text-warning"></i>
                            <strong>Sakit:</strong> <?= $sakit ?> kali
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-info-circle me-2 text-info"></i>
                            <strong>Izin:</strong> <?= $izin ?> kali
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-times-circle me-2 text-danger"></i>
                            <strong>Alfa:</strong> <?= $alfa ?> kali
                        </li>
                    </ul>
                    
                    <hr>
                    
                    <div class="alert alert-info">
                        <small>
                            <strong>Catatan:</strong><br>
                            Kehadiran minimal 75% untuk dapat mengikuti ujian akhir semester.
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
