<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h2><i class="fas fa-chart-line me-2"></i>Laporan Nilai</h2>
            <hr>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-clipboard-list me-2"></i>Nilai Per Mata Pelajaran</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($laporan_nilai)): ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>Mata Pelajaran</th>
                                        <th>UTS<br><small>(25%)</small></th>
                                        <th>UAS<br><small>(25%)</small></th>
                                        <th>Tugas<br><small>(25%)</small></th>
                                        <th>Sikap<br><small>(10%)</small></th>
                                        <th>Presensi<br><small>(15%)</small></th>
                                        <th>Nilai Akhir</th>
                                        <th>Grade</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; $total_nilai = 0; $jumlah_mapel = 0; ?>
                                    <?php foreach ($laporan_nilai as $laporan): ?>
                                        <?php
                                        $nilai_akhir = floatval($laporan['detail_nilai']['nilai_akhir']);
                                        $total_nilai += $nilai_akhir;
                                        $jumlah_mapel++;

                                        // Tentukan grade
                                        if ($nilai_akhir >= 90) $grade = 'A';
                                        elseif ($nilai_akhir >= 80) $grade = 'B';
                                        elseif ($nilai_akhir >= 70) $grade = 'C';
                                        elseif ($nilai_akhir >= 60) $grade = 'D';
                                        else $grade = 'E';

                                        // Warna grade
                                        $grade_color = [
                                            'A' => 'success',
                                            'B' => 'primary',
                                            'C' => 'warning',
                                            'D' => 'danger',
                                            'E' => 'dark'
                                        ];
                                        ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><strong><?= $laporan['nama_mapel'] ?></strong></td>
                                            <td>
                                                <span class="badge bg-<?= $laporan['detail_nilai']['uts'] > 0 ? 'success' : 'secondary' ?>">
                                                    <?= $laporan['detail_nilai']['uts'] > 0 ? $laporan['detail_nilai']['uts'] : '-' ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-<?= $laporan['detail_nilai']['uas'] > 0 ? 'success' : 'secondary' ?>">
                                                    <?= $laporan['detail_nilai']['uas'] > 0 ? $laporan['detail_nilai']['uas'] : '-' ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-<?= $laporan['detail_nilai']['tugas'] > 0 ? 'success' : 'secondary' ?>">
                                                    <?= $laporan['detail_nilai']['tugas'] > 0 ? $laporan['detail_nilai']['tugas'] : '-' ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-<?= $laporan['detail_nilai']['sikap'] > 0 ? 'success' : 'secondary' ?>">
                                                    <?= $laporan['detail_nilai']['sikap'] > 0 ? $laporan['detail_nilai']['sikap'] : '-' ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">
                                                    <?= $laporan['detail_nilai']['presensi'] ?>%
                                                </span>
                                                <br><small>(<?= $laporan['detail_nilai']['total_hadir'] ?>/<?= $laporan['detail_nilai']['total_pertemuan'] ?>)</small>
                                            </td>
                                            <td>
                                                <strong class="text-primary fs-5"><?= $laporan['detail_nilai']['nilai_akhir'] ?></strong>
                                            </td>
                                            <td>
                                                <span class="badge bg-<?= $grade_color[$grade] ?> fs-6"><?= $grade ?></span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot class="table-secondary">
                                    <tr>
                                        <td colspan="7" class="text-end"><strong>Rata-rata Keseluruhan:</strong></td>
                                        <td>
                                            <strong class="text-success fs-5">
                                                <?= $jumlah_mapel > 0 ? number_format($total_nilai / $jumlah_mapel, 2) : '0.00' ?>
                                            </strong>
                                        </td>
                                        <td>
                                            <?php
                                            $rata_rata = $jumlah_mapel > 0 ? $total_nilai / $jumlah_mapel : 0;
                                            if ($rata_rata >= 90) $grade_rata = 'A';
                                            elseif ($rata_rata >= 80) $grade_rata = 'B';
                                            elseif ($rata_rata >= 70) $grade_rata = 'C';
                                            elseif ($rata_rata >= 60) $grade_rata = 'D';
                                            else $grade_rata = 'E';
                                            ?>
                                            <span class="badge bg-<?= $grade_color[$grade_rata] ?> fs-6"><?= $grade_rata ?></span>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info text-center">
                            <i class="fas fa-info-circle me-2"></i>
                            Belum ada nilai yang tersedia.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Keterangan Penilaian -->
    <?php if (!empty($laporan_nilai)): ?>
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-info-circle me-2"></i>Keterangan Penilaian</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <h6>Komponen Nilai:</h6>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-circle text-primary me-2"></i>UTS: 25%</li>
                                <li><i class="fas fa-circle text-success me-2"></i>UAS: 25%</li>
                                <li><i class="fas fa-circle text-warning me-2"></i>Tugas: 25%</li>
                                <li><i class="fas fa-circle text-info me-2"></i>Presensi: 15%</li>
                                <li><i class="fas fa-circle text-secondary me-2"></i>Sikap: 10%</li>
                            </ul>
                        </div>
                        <div class="col-6">
                            <h6>Grade:</h6>
                            <ul class="list-unstyled">
                                <li><span class="badge bg-success me-2">A</span>90 - 100</li>
                                <li><span class="badge bg-primary me-2">B</span>80 - 89</li>
                                <li><span class="badge bg-warning me-2">C</span>70 - 79</li>
                                <li><span class="badge bg-danger me-2">D</span>60 - 69</li>
                                <li><span class="badge bg-dark me-2">E</span>< 60</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-chart-pie me-2"></i>Ringkasan Prestasi</h5>
                </div>
                <div class="card-body">
                    <?php
                    $rata_rata_final = $jumlah_mapel > 0 ? $total_nilai / $jumlah_mapel : 0;
                    ?>
                    <div class="text-center">
                        <h3 class="text-primary"><?= number_format($rata_rata_final, 2) ?></h3>
                        <p class="text-muted">Rata-rata Nilai Keseluruhan</p>

                        <?php if ($rata_rata_final >= 85): ?>
                            <div class="alert alert-success">
                                <i class="fas fa-trophy me-2"></i>
                                <strong>Prestasi Sangat Baik!</strong><br>
                                Pertahankan prestasi yang luar biasa ini.
                            </div>
                        <?php elseif ($rata_rata_final >= 75): ?>
                            <div class="alert alert-primary">
                                <i class="fas fa-thumbs-up me-2"></i>
                                <strong>Prestasi Baik!</strong><br>
                                Terus tingkatkan untuk hasil yang lebih baik.
                            </div>
                        <?php elseif ($rata_rata_final >= 65): ?>
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Perlu Peningkatan</strong><br>
                                Fokus pada mata pelajaran yang masih kurang.
                            </div>
                        <?php else: ?>
                            <div class="alert alert-danger">
                                <i class="fas fa-times-circle me-2"></i>
                                <strong>Perlu Bimbingan Khusus</strong><br>
                                Konsultasi dengan guru untuk strategi belajar.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>