<div class="page-header mb-4">
    <h2><i class="bi bi-clock-history me-2"></i>Riwayat Peminjaman</h2>
    <p class="text-muted mb-0">Daftar buku yang pernah dipinjam</p>
</div>

<div class="card">
    <div class="card-body">
        <?php if (empty($riwayat)): ?>
            <div class="text-center py-5">
                <i class="bi bi-inbox" style="font-size: 48px; color: #ccc;"></i>
                <p class="text-muted mt-3">Belum ada riwayat peminjaman</p>
                <a href="<?= base_url('peminjaman') ?>" class="btn btn-primary">Pinjam Buku Sekarang</a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Buku</th>
                            <th>Tgl Pinjam</th>
                            <th>Batas Kembali</th>
                            <th>Status</th>
                            <th>Denda</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($riwayat as $r): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <strong><?= htmlspecialchars($r['judul']) ?></strong><br>
                                <small class="text-muted"><?= htmlspecialchars($r['kode_buku']) ?> - <?= htmlspecialchars($r['pengarang']) ?></small>
                            </td>
                            <td><?= date('d/m/Y', strtotime($r['tanggal_pinjam'])) ?></td>
                            <td><?= date('d/m/Y', strtotime($r['tanggal_kembali'])) ?></td>
                            <td>
                                <?php if ($r['status'] == 'dipinjam'): ?>
                                    <?php if (strtotime($r['tanggal_kembali']) < strtotime(date('Y-m-d'))): ?>
                                        <span class="badge bg-danger">Terlambat</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning">Dipinjam</span>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span class="badge bg-success">Dikembalikan</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($r['denda'] > 0): ?>
                                    <span class="text-danger">Rp <?= number_format($r['denda'], 0, ',', '.') ?></span>
                                <?php else: ?>
                                    -
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
