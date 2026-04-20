<div class="wrapper">
    <!-- Sidebar -->
    <nav class="sidebar" style="width: 280px; background: linear-gradient(180deg, #1a1a2e 0%, #16213e 100%); min-height: 100vh; position: fixed; left: 0; top: 0; padding: 30px 20px; z-index: 1000;">
        <div class="sidebar-header text-center mb-4">
            <div class="logo mb-3">
                <i class="bi bi-book-half" style="font-size: 48px; color: #00b894;"></i>
            </div>
            <h4 style="color: white; font-weight: 700;">Perpustakaan</h4>
            <p style="color: #6c757d; font-size: 0.85rem;"> Library System</p>
        </div>

        <div class="user-info text-center mb-4 p-3" style="background: rgba(255,255,255,0.05); border-radius: 12px;">
            <div class="avatar mb-2">
                <i class="bi bi-person-circle" style="font-size: 48px; color: #00b894;"></i>
            </div>
            <h6 style="color: white; margin-bottom: 5px;"><?= $this->session->userdata('username') ?></h6>
            <span class="badge bg-success">Siswa</span>
        </div>

        <ul class="nav flex-column">
            <li class="nav-item mb-2">
                <a class="nav-link <?= $this->uri->segment(1) == 'siswa' ? 'active' : '' ?>" href="<?= base_url('siswa') ?>" style="color: #a5b4fc; padding: 12px 15px; border-radius: 10px; display: flex; align-items: center; gap: 12px; transition: all 0.3s;">
                    <i class="bi bi-speedometer2" style="font-size: 18px;"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link <?= $this->uri->segment(1) == 'peminjaman' && $this->uri->segment(2) != 'riwayat' ? 'active' : '' ?>" href="<?= base_url('peminjaman') ?>" style="color: #a5b4fc; padding: 12px 15px; border-radius: 10px; display: flex; align-items: center; gap: 12px; transition: all 0.3s;">
                    <i class="bi bi-book" style="font-size: 18px;"></i>
                    <span>Pinjam Buku</span>
                </a>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link <?= $this->uri->segment(2) == 'riwayat' ? 'active' : '' ?>" href="<?= base_url('peminjaman/riwayat') ?>" style="color: #a5b4fc; padding: 12px 15px; border-radius: 10px; display: flex; align-items: center; gap: 12px; transition: all 0.3s;">
                    <i class="bi bi-clock-history" style="font-size: 18px;"></i>
                    <span>Riwayat Peminjaman</span>
                </a>
            </li>
            <li class="nav-item mt-4">
                <a class="nav-link" href="<?= site_url('auth/logout') ?>" style="color: #e17055; padding: 12px 15px; border-radius: 10px; display: flex; align-items: center; gap: 12px; transition: all 0.3s;">
                    <i class="bi bi-box-arrow-right" style="font-size: 18px;"></i>
                    <span>Logout</span>
                </a>
            </li>
        </ul>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>
                <?= $this->session->flashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle me-2"></i>
                <?= $this->session->flashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

    <style>
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background: rgba(0, 184, 148, 0.2) !important;
            color: white !important;
        }
    </style>
