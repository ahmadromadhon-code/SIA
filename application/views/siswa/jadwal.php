<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h2><i class="fas fa-calendar me-2"></i>Jadwal Pelajaran</h2>
            <hr>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-clock me-2"></i>Jadwal Pelajaran Kelas</h5>
                </div>
                <div class="card-body">
                    <?php if(isset($jadwal) && !empty($jadwal)): ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Hari</th>
                                        <th>Jam</th>
                                        <th>Mata Pelajaran</th>
                                        <th>Guru</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $hari_urutan = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                                    $jadwal_grouped = [];
                                    foreach($jadwal as $j) {
                                        $jadwal_grouped[$j->hari][] = $j;
                                    }
                                    ?>
                                    
                                    <?php foreach($hari_urutan as $hari): ?>
                                        <?php if(isset($jadwal_grouped[$hari])): ?>
                                            <?php foreach($jadwal_grouped[$hari] as $index => $j): ?>
                                                <tr>
                                                    <?php if($index == 0): ?>
                                                        <td rowspan="<?= count($jadwal_grouped[$hari]) ?>" class="align-middle">
                                                            <strong><?= $hari ?></strong>
                                                        </td>
                                                    <?php endif; ?>
                                                    <td><?= date('H:i', strtotime($j->jam_mulai)) ?> - <?= date('H:i', strtotime($j->jam_selesai)) ?></td>
                                                    <td>
                                                        <span class="badge bg-primary"><?= $j->nama_mapel ?></span>
                                                    </td>
                                                    <td><?= $j->nama_guru ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info text-center">
                            <i class="fas fa-info-circle me-2"></i>
                            Belum ada jadwal pelajaran yang tersedia.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Jadwal Hari Ini -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5><i class="fas fa-calendar-day me-2"></i>Jadwal Hari Ini - <?= date('l, d F Y') ?></h5>
                </div>
                <div class="card-body">
                    <?php 
                    $hari_ini = date('l');
                    $hari_indonesia = [
                        'Monday' => 'Senin',
                        'Tuesday' => 'Selasa', 
                        'Wednesday' => 'Rabu',
                        'Thursday' => 'Kamis',
                        'Friday' => 'Jumat',
                        'Saturday' => 'Sabtu',
                        'Sunday' => 'Minggu'
                    ];
                    $hari_sekarang = $hari_indonesia[$hari_ini];
                    
                    $jadwal_hari_ini = [];
                    if(isset($jadwal)) {
                        foreach($jadwal as $j) {
                            if($j->hari == $hari_sekarang) {
                                $jadwal_hari_ini[] = $j;
                            }
                        }
                    }
                    ?>
                    
                    <?php if(!empty($jadwal_hari_ini)): ?>
                        <div class="row">
                            <?php foreach($jadwal_hari_ini as $j): ?>
                                <div class="col-md-6 col-lg-4 mb-3">
                                    <div class="card border-success">
                                        <div class="card-body">
                                            <h6 class="card-title text-success"><?= $j->nama_mapel ?></h6>
                                            <p class="card-text">
                                                <i class="fas fa-clock me-1"></i><?= date('H:i', strtotime($j->jam_mulai)) ?> - <?= date('H:i', strtotime($j->jam_selesai)) ?><br>
                                                <i class="fas fa-user me-1"></i><?= $j->nama_guru ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-success text-center">
                            <i class="fas fa-smile me-2"></i>
                            Tidak ada jadwal pelajaran hari ini. Selamat beristirahat!
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
