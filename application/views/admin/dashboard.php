<?php
// Sample data - ganti dengan data dari database Anda
$total_buku = isset($total_buku) ? $total_buku : 1250;
$total_anggota = isset($total_anggota) ? $total_anggota : 384;
$total_peminjaman = isset($total_peminjaman) ? $total_peminjaman : 47;

$bulan_ini = isset($bulan_ini) ? $bulan_ini : 26;
$pengembalian_bulan_ini = isset($pengembalian_bulan_ini) ? $pengembalian_bulan_ini : 22;
$terlambat_bulan_ini = isset($terlambat_bulan_ini) ? $terlambat_bulan_ini : 4;
$denda_bulan_ini = isset($denda_bulan_ini) ? $denda_bulan_ini : 150000;

// Chart data
$chart_labels = isset($chart_labels) ? $chart_labels : json_encode(['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun']);
$chart_peminjaman = isset($chart_peminjaman) ? $chart_peminjaman : json_encode([12, 18, 15, 22, 20, 26]);
$chart_pengembalian = isset($chart_pengembalian) ? $chart_pengembalian : json_encode([10, 15, 14, 19, 18, 22]);

// Kategori buku data
$kategori_labels = isset($kategori_labels) ? $kategori_labels : json_encode(['Ayah ini arahnya kemana', 'Laskar Pelangi', 'Matematika dasar', 'Pemrograman PHP', 'Sejarah Indonesia']);
$kategori_data = isset($kategori_data) ? $kategori_data : json_encode([3, 5, 7, 10, 3]);

// Aktivitas mingguan
$aktivitas_labels = isset($aktivitas_labels) ? $aktivitas_labels : json_encode(['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min']);
$aktivitas_data = isset($aktivitas_data) ? $aktivitas_data : json_encode([8, 12, 10, 15, 9, 5, 3]);

// Sample peminjaman terbaru
$peminjaman_terbaru = isset($peminjaman_terbaru) ? $peminjaman_terbaru : [
    ['nama' => 'Ahmad Fauzi', 'judul' => 'Laskar Pelangi', 'tanggal_pinjam' => '2024-01-15', 'status' => 'dipinjam'],
    ['nama' => 'Siti Nurhaliza', 'judul' => 'Bumi Manusia', 'tanggal_pinjam' => '2024-01-14', 'status' => 'dikembalikan'],
    ['nama' => 'Budi Santoso', 'judul' => 'Filosofi Teras', 'tanggal_pinjam' => '2024-01-13', 'status' => 'dipinjam'],
    ['nama' => 'Dewi Lestari', 'judul' => 'Supernova', 'tanggal_pinjam' => '2024-01-12', 'status' => 'dikembalikan'],
    ['nama' => 'Rizky Pratama', 'judul' => 'Atomic Habits', 'tanggal_pinjam' => '2024-01-11', 'status' => 'dipinjam'],
];

// Base URL function jika belum ada
if (!function_exists('base_url')) {
    function base_url($path = '') {
        return '/' . ltrim($path, '/');
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Perpustakaan</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- ApexCharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.45.1/dist/apexcharts.min.js"></script>
    
    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --secondary: #8b5cf6;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #06b6d4;
            --dark: #1e293b;
            --gray: #64748b;
            --light-gray: #f1f5f9;
            --white: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
            color: var(--dark);
        }

        .dashboard-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 24px;
        }

        /* Header */
        .dashboard-header {
            background: var(--white);
            padding: 28px 32px;
            border-radius: 20px;
            margin-bottom: 28px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
        }

        .dashboard-header h1 {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--dark);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .dashboard-header h1 i {
            color: var(--primary);
        }

        .dashboard-header p {
            color: var(--gray);
            margin-top: 4px;
            font-size: 0.95rem;
        }

        .date-badge {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: var(--white);
            padding: 14px 24px;
            border-radius: 14px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.95rem;
            box-shadow: 0 4px 16px rgba(99, 102, 241, 0.3);
        }

        /* Stat Cards */
        .stat-card {
            background: var(--white);
            border-radius: 20px;
            padding: 28px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            height: 100%;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            border-radius: 20px 20px 0 0;
        }

        .stat-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 16px 48px rgba(0, 0, 0, 0.12);
        }

        .stat-card .icon-wrapper {
            width: 64px;
            height: 64px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            color: var(--white);
            flex-shrink: 0;
        }

        .stat-card .value {
            font-size: 2.25rem;
            font-weight: 800;
            color: var(--dark);
            line-height: 1.1;
        }

        .stat-card .label {
            color: var(--gray);
            font-size: 0.9rem;
            font-weight: 500;
            margin-top: 6px;
        }

        .stat-card .trend {
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-top: 8px;
        }

        .stat-card .trend.up {
            color: var(--success);
        }

        .stat-card .trend.down {
            color: var(--danger);
        }

        /* Chart Cards */
        .chart-card {
            background: var(--white);
            border-radius: 20px;
            padding: 28px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
            height: 100%;
        }

        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
        }

        .chart-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--dark);
        }

        .chart-subtitle {
            color: var(--gray);
            font-size: 0.85rem;
            margin-top: 2px;
        }

        .chart-badge {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: var(--white);
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        /* Mini Stat Cards */
        .mini-stat {
            background: var(--white);
            border-radius: 16px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
            height: 100%;
        }

        .mini-stat:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.1);
        }

        .mini-stat .mini-value {
            font-size: 2rem;
            font-weight: 800;
            line-height: 1.1;
        }

        .mini-stat .mini-label {
            color: var(--gray);
            font-size: 0.85rem;
            font-weight: 500;
            margin-top: 8px;
        }

        .mini-stat .mini-sublabel {
            color: #cbd5e1;
            font-size: 0.75rem;
            margin-top: 4px;
        }

        /* Quick Actions */
        .quick-actions {
            background: var(--white);
            border-radius: 20px;
            padding: 28px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
            margin-bottom: 28px;
        }

        .section-title {
            display: flex;
            align-items: center;
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 20px;
            gap: 10px;
        }

        .section-title i {
            color: var(--primary);
        }

        .action-btn {
            background: var(--white);
            border: 2px solid var(--light-gray);
            border-radius: 16px;
            padding: 20px;
            text-align: center;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: inherit;
            height: 100%;
        }

        .action-btn:hover {
            border-color: transparent;
            transform: translateY(-4px);
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.12);
        }

        .action-btn.primary:hover {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
        }

        .action-btn.success:hover {
            background: linear-gradient(135deg, var(--success), #059669);
        }

        .action-btn.warning:hover {
            background: linear-gradient(135deg, var(--warning), #d97706);
        }

        .action-btn.info:hover {
            background: linear-gradient(135deg, var(--info), #0891b2);
        }

        .action-btn:hover i,
        .action-btn:hover span {
            color: var(--white) !important;
        }

        .action-btn i {
            font-size: 28px;
            transition: color 0.3s ease;
        }

        .action-btn span {
            font-weight: 600;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }

        /* Recent Transactions */
        .transactions-card {
            background: var(--white);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
        }

        .transactions-header {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: var(--white);
            padding: 24px 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .transactions-header h3 {
            margin: 0;
            font-size: 1.1rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .view-all-btn {
            background: rgba(255, 255, 255, 0.2);
            color: var(--white);
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .view-all-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            color: var(--white);
            transform: translateY(-2px);
        }

        .transaction-table {
            margin: 0;
        }

        .transaction-table thead tr {
            background: var(--light-gray);
        }

        .transaction-table thead th {
            color: var(--dark);
            font-weight: 600;
            padding: 16px 24px;
            border: none;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .transaction-table tbody td {
            padding: 18px 24px;
            border-color: var(--light-gray);
            vertical-align: middle;
            color: var(--gray);
        }

        .transaction-table tbody tr {
            transition: all 0.3s ease;
        }

        .transaction-table tbody tr:hover {
            background: rgba(99, 102, 241, 0.04);
        }

        .member-name {
            font-weight: 600;
            color: var(--dark);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .book-title {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .status-badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.8rem;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .status-badge.dipinjam {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.15), rgba(239, 68, 68, 0.15));
            color: var(--warning);
        }

        .status-badge.dikembalikan {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.15), rgba(6, 182, 212, 0.15));
            color: var(--success);
        }

        .empty-state {
            text-align: center;
            padding: 60px 30px;
        }

        .empty-state i {
            font-size: 56px;
            color: #e2e8f0;
            margin-bottom: 20px;
        }

        .empty-state p {
            color: var(--gray);
            font-size: 1rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .dashboard-container {
                padding: 16px;
            }

            .dashboard-header {
                padding: 20px;
            }

            .dashboard-header h1 {
                font-size: 1.4rem;
            }

            .stat-card {
                padding: 20px;
            }

            .stat-card .value {
                font-size: 1.75rem;
            }

            .chart-card {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Dashboard Header -->
        <div class="dashboard-header">
            <div>
                <h1><i class="bi bi-speedometer2"></i>Dashboard Admin</h1>
                <p>Selamat datang di panel administrasi perpustakaan</p>
            </div>
            <div class="date-badge">
                <i class="bi bi-calendar3"></i>
                <?= date('d F Y') ?>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row g-4 mb-4">
            <div class="col-lg-4 col-md-6">
                <div class="stat-card">
                    <div class="d-flex align-items-center gap-4">
                        <div class="icon-wrapper" style="background: linear-gradient(135deg, #3b82f6, #06b6d4);">
                            <i class="bi bi-book-fill"></i>
                        </div>
                        <div>
                            <div class="value"><?= number_format($total_buku) ?></div>
                            <div class="label">Total Buku</div>
                            <div class="trend up">
                                <i class="bi bi-arrow-up"></i> +12% dari bulan lalu
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="stat-card">
                    <div class="d-flex align-items-center gap-4">
                        <div class="icon-wrapper" style="background: linear-gradient(135deg, #8b5cf6, #ec4899);">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <div>
                            <div class="value"><?= number_format($total_anggota) ?></div>
                            <div class="label">Total Anggota</div>
                            <div class="trend up">
                                <i class="bi bi-arrow-up"></i> +8% dari bulan lalu
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="stat-card">
                    <div class="d-flex align-items-center gap-4">
                        <div class="icon-wrapper" style="background: linear-gradient(135deg, #f59e0b, #ef4444);">
                            <i class="bi bi-arrow-left-right"></i>
                        </div>
                        <div>
                            <div class="value"><?= number_format($total_peminjaman) ?></div>
                            <div class="label">Peminjaman Aktif</div>
                            <div class="trend down">
                                <i class="bi bi-arrow-down"></i> -3% dari bulan lalu
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="row g-4 mb-4">
            <!-- Area Chart - Tren Peminjaman -->
            <div class="col-lg-8">
                <div class="chart-card">
                    <div class="chart-header">
                        <div>
                            <div class="chart-title">Tren Peminjaman & Pengembalian</div>
                            <div class="chart-subtitle">Data 6 bulan terakhir</div>
                        </div>
                        <span class="chart-badge">
                            <i class="bi bi-lightning-fill me-1"></i> Live
                        </span>
                    </div>
                    <div id="areaChart" style="min-height: 300px;"></div>
                </div>
            </div>

            <!-- Mini Stats -->
            <div class="col-lg-4">
                <div class="row g-3">
                    <div class="col-6">
                        <div class="mini-stat">
                            <div class="mini-value" style="color: var(--primary);"><?= $bulan_ini ?></div>
                            <div class="mini-label">Peminjaman</div>
                            <div class="mini-sublabel">Bulan Ini</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mini-stat">
                            <div class="mini-value" style="color: var(--success);"><?= $pengembalian_bulan_ini ?></div>
                            <div class="mini-label">Pengembalian</div>
                            <div class="mini-sublabel">Bulan Ini</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mini-stat">
                            <div class="mini-value" style="color: var(--danger);"><?= $terlambat_bulan_ini ?></div>
                            <div class="mini-label">Terlambat</div>
                            <div class="mini-sublabel">Status</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mini-stat">
                            <div class="mini-value" style="color: var(--warning); font-size: 1.5rem;">Rp <?= number_format($denda_bulan_ini / 1000, 0) ?>k</div>
                            <div class="mini-label">Total Denda</div>
                            <div class="mini-sublabel">Bulan Ini</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- More Charts -->
        <div class="row g-4 mb-4">
            <!-- Bar Chart - Aktivitas Mingguan -->
            <div class="col-lg-6">
                <div class="chart-card">
                    <div class="chart-header">
                        <div>
                            <div class="chart-title">Aktivitas Mingguan</div>
                            <div class="chart-subtitle">Jumlah transaksi per hari</div>
                        </div>
                    </div>
                    <div id="barChart" style="min-height: 280px;"></div>
                </div>
            </div>

            <!-- Donut Chart - Kategori Buku -->
            <div class="col-lg-6">
                <div class="chart-card">
                    <div class="chart-header">
                        <div>
                            <div class="chart-title">Distribusi Kategori Buku</div>
                            <div class="chart-subtitle">Berdasarkan koleksi perpustakaan</div>
                        </div>
                    </div>
                    <div id="donutChart" style="min-height: 280px;"></div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions">
            <div class="section-title">
                <i class="bi bi-lightning-fill"></i>
                Aksi Cepat
            </div>
            <div class="row g-3">
                <div class="col-lg-3 col-md-6">
                    <a href="<?= base_url('buku/tambah') ?>" class="action-btn primary">
                        <i class="bi bi-plus-circle" style="color: var(--primary);"></i>
                        <span style="color: var(--dark);">Tambah Buku</span>
                    </a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <a href="<?= base_url('anggota/tambah') ?>" class="action-btn success">
                        <i class="bi bi-person-plus" style="color: var(--success);"></i>
                        <span style="color: var(--dark);">Tambah Anggota</span>
                    </a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <a href="<?= base_url('transaksi/tambah') ?>" class="action-btn warning">
                        <i class="bi bi-arrow-left-right" style="color: var(--warning);"></i>
                        <span style="color: var(--dark);">Transaksi Baru</span>
                    </a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <a href="<?= base_url('transaksi') ?>" class="action-btn info">
                        <i class="bi bi-list-check" style="color: var(--info);"></i>
                        <span style="color: var(--dark);">Lihat Transaksi</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Recent Transactions -->
        <div class="transactions-card">
            <div class="transactions-header">
                <h3>
                    <i class="bi bi-clock-history"></i>
                    Transaksi Terbaru
                </h3>
                <a href="<?= base_url('transaksi') ?>" class="view-all-btn">
                    Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
            <?php if (empty($peminjaman_terbaru)): ?>
                <div class="empty-state">
                    <i class="bi bi-inbox"></i>
                    <p>Belum ada transaksi terbaru. Mulai dengan membuat transaksi baru!</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table transaction-table mb-0">
                        <thead>
                            <tr>
                                <th><i class="bi bi-person me-2"></i>Anggota</th>
                                <th><i class="bi bi-book me-2"></i>Buku</th>
                                <th><i class="bi bi-calendar me-2"></i>Tanggal Pinjam</th>
                                <th class="text-center"><i class="bi bi-tag me-2"></i>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($peminjaman_terbaru as $p): ?>
                            <tr>
                                <td>
                                    <div class="member-name">
                                        <i class="bi bi-person-circle" style="color: var(--primary);"></i>
                                        <?= htmlspecialchars($p['nama']) ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="book-title">
                                        <i class="bi bi-book" style="color: var(--secondary);"></i>
                                        <?= htmlspecialchars($p['judul']) ?>
                                    </div>
                                </td>
                                <td>
                                    <i class="bi bi-calendar-event me-2" style="color: var(--warning);"></i>
                                    <?= date('d/m/Y', strtotime($p['tanggal_pinjam'])) ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($p['status'] == 'dipinjam'): ?>
                                        <span class="status-badge dipinjam">
                                            <i class="bi bi-hourglass-split"></i>Dipinjam
                                        </span>
                                    <?php else: ?>
                                        <span class="status-badge dikembalikan">
                                            <i class="bi bi-check-circle"></i>Dikembalikan
                                        </span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- ApexCharts Initialization -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Area Chart - Tren Peminjaman
            const areaOptions = {
                series: [{
                    name: 'Peminjaman',
                    data: <?= $chart_peminjaman ?>
                }, {
                    name: 'Pengembalian',
                    data: <?= $chart_pengembalian ?>
                }],
                chart: {
                    type: 'area',
                    height: 300,
                    fontFamily: 'Inter, sans-serif',
                    toolbar: { show: false },
                    animations: {
                        enabled: true,
                        easing: 'easeinout',
                        speed: 800
                    }
                },
                colors: ['#6366f1', '#10b981'],
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.5,
                        opacityTo: 0.1,
                        stops: [0, 90, 100]
                    }
                },
                dataLabels: { enabled: false },
                stroke: {
                    curve: 'smooth',
                    width: 3
                },
                grid: {
                    borderColor: '#f1f5f9',
                    strokeDashArray: 4
                },
                xaxis: {
                    categories: <?= $chart_labels ?>,
                    labels: {
                        style: {
                            colors: '#64748b',
                            fontWeight: 500
                        }
                    },
                    axisBorder: { show: false },
                    axisTicks: { show: false }
                },
                yaxis: {
                    labels: {
                        style: {
                            colors: '#64748b',
                            fontWeight: 500
                        }
                    }
                },
                legend: {
                    position: 'top',
                    horizontalAlign: 'right',
                    fontWeight: 600,
                    markers: { radius: 12 }
                },
                tooltip: {
                    theme: 'light',
                    y: { formatter: val => val + ' transaksi' }
                }
            };
            new ApexCharts(document.querySelector("#areaChart"), areaOptions).render();

            // Bar Chart - Aktivitas Mingguan
            const barOptions = {
                series: [{
                    name: 'Transaksi',
                    data: <?= $aktivitas_data ?>
                }],
                chart: {
                    type: 'bar',
                    height: 280,
                    fontFamily: 'Inter, sans-serif',
                    toolbar: { show: false }
                },
                colors: ['#6366f1'],
                plotOptions: {
                    bar: {
                        borderRadius: 8,
                        columnWidth: '50%',
                        distributed: true
                    }
                },
                dataLabels: { enabled: false },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shade: 'light',
                        type: 'vertical',
                        shadeIntensity: 0.3,
                        gradientToColors: ['#8b5cf6'],
                        opacityFrom: 1,
                        opacityTo: 0.8,
                        stops: [0, 100]
                    }
                },
                grid: {
                    borderColor: '#f1f5f9',
                    strokeDashArray: 4
                },
                xaxis: {
                    categories: <?= $aktivitas_labels ?>,
                    labels: {
                        style: {
                            colors: '#64748b',
                            fontWeight: 500
                        }
                    },
                    axisBorder: { show: false },
                    axisTicks: { show: false }
                },
                yaxis: {
                    labels: {
                        style: {
                            colors: '#64748b',
                            fontWeight: 500
                        }
                    }
                },
                legend: { show: false },
                tooltip: {
                    theme: 'light',
                    y: { formatter: val => val + ' transaksi' }
                }
            };
            new ApexCharts(document.querySelector("#barChart"), barOptions).render();

            // Donut Chart - Kategori Buku
            const donutOptions = {
                series: <?= $kategori_data ?>,
                chart: {
                    type: 'donut',
                    height: 280,
                    fontFamily: 'Inter, sans-serif'
                },
                colors: ['#6366f1', '#8b5cf6', '#06b6d4', '#10b981', '#f59e0b'],
                labels: <?= $kategori_labels ?>,
                plotOptions: {
                    pie: {
                        donut: {
                            size: '70%',
                            labels: {
                                show: true,
                                total: {
                                    show: true,
                                    label: 'Total Buku',
                                    fontSize: '14px',
                                    fontWeight: 600,
                                    color: '#64748b',
                                    formatter: function(w) {
                                        return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                    }
                                }
                            }
                        }
                    }
                },
                dataLabels: { enabled: false },
                stroke: {
                    width: 0
                },
                legend: {
                    position: 'bottom',
                    fontWeight: 500,
                    markers: { radius: 12 }
                },
                tooltip: {
                    theme: 'light',
                    y: { formatter: val => val + ' buku' }
                }
            };
            new ApexCharts(document.querySelector("#donutChart"), donutOptions).render();
        });
    </script>
</body>
</html>