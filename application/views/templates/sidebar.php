<div class="sidebar bg-dark text-white p-3 col-md-3 col-lg-2">
    <a href="#" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
        <span class="fs-4">SIA</span>
    </a>
    <hr>
    <p>Selamat datang,<br><strong><?= $this->session->userdata('nama_lengkap'); ?></strong></p>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <?php $role = $this->session->userdata('role'); ?>

        <?php if ($role == 'admin'): ?>
            <li class="nav-item">
                <a href="<?= site_url('admin/dashboard') ?>" class="nav-link <?= ($this->uri->segment(2) == 'dashboard') ? 'active' : 'text-white' ?>">
                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= site_url('admin/data_guru') ?>" class="nav-link <?= ($this->uri->segment(2) == 'data_guru') ? 'active' : 'text-white' ?>">
                    <i class="fas fa-chalkboard-teacher me-2"></i>Data Guru
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= site_url('admin/data_siswa') ?>" class="nav-link <?= ($this->uri->segment(2) == 'data_siswa') ? 'active' : 'text-white' ?>">
                    <i class="fas fa-users me-2"></i>Data Siswa
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= site_url('admin/data_kelas') ?>" class="nav-link <?= ($this->uri->segment(2) == 'data_kelas') ? 'active' : 'text-white' ?>">
                    <i class="fas fa-school me-2"></i>Data Kelas
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= site_url('admin/mata_pelajaran') ?>" class="nav-link <?= ($this->uri->segment(2) == 'mata_pelajaran') ? 'active' : 'text-white' ?>">
                    <i class="fas fa-book me-2"></i>Mata Pelajaran
                </a>
            </li>

        <?php elseif ($role == 'guru'): ?>
            <li class="nav-item">
                <a href="<?= site_url('guru/dashboard') ?>" class="nav-link <?= ($this->uri->segment(2) == 'dashboard') ? 'active' : 'text-white' ?>">
                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= site_url('guru/kelas_saya') ?>" class="nav-link <?= ($this->uri->segment(2) == 'kelas_saya') ? 'active' : 'text-white' ?>">
                    <i class="fas fa-chalkboard me-2"></i>Kelas Saya
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= site_url('guru/nilai') ?>" class="nav-link <?= ($this->uri->segment(2) == 'nilai') ? 'active' : 'text-white' ?>">
                    <i class="fas fa-clipboard-list me-2"></i>Input Nilai
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= site_url('guru/absensi') ?>" class="nav-link <?= ($this->uri->segment(2) == 'absensi') ? 'active' : 'text-white' ?>">
                    <i class="fas fa-calendar-check me-2"></i>Absensi
                </a>
            </li>

        <?php elseif ($role == 'siswa'): ?>
            <li class="nav-item">
                <a href="<?= site_url('siswa/dashboard') ?>" class="nav-link <?= ($this->uri->segment(2) == 'dashboard') ? 'active' : 'text-white' ?>">
                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= site_url('siswa/jadwal') ?>" class="nav-link <?= ($this->uri->segment(2) == 'jadwal') ? 'active' : 'text-white' ?>">
                    <i class="fas fa-calendar me-2"></i>Jadwal Pelajaran
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= site_url('siswa/nilai') ?>" class="nav-link <?= ($this->uri->segment(2) == 'nilai') ? 'active' : 'text-white' ?>">
                    <i class="fas fa-chart-line me-2"></i>Lihat Nilai
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= site_url('siswa/absensi') ?>" class="nav-link <?= ($this->uri->segment(2) == 'absensi') ? 'active' : 'text-white' ?>">
                    <i class="fas fa-calendar-check me-2"></i>Absensi Saya
                </a>
            </li>

        <?php endif; ?>
    </ul>
    <hr>
    <div class="dropdown">
        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-user-circle me-2"></i>
            <strong><?= $this->session->userdata('username'); ?></strong>
        </a>
        <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
            <li><a class="dropdown-item" href="<?= site_url($role.'/profile') ?>"><i class="fas fa-user me-2"></i>Profile</a></li>
            <li><a class="dropdown-item" href="<?= site_url($role.'/settings') ?>"><i class="fas fa-cog me-2"></i>Settings</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="<?= site_url('auth/logout') ?>"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
        </ul>
    </div>
</div>

<div class="content p-4 col-md-9 col-lg-10">