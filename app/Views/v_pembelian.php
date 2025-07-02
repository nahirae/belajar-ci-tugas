<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="pagetitle">
    <h1>Pembelian</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active">Pembelian</li>
        </ol>
    </nav>
</div><section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body pt-4">

                    <?php if (session()->getFlashdata('success')) : ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= session()->getFlashdata('success') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>ID Pembelian</th>
                                    <th>Username</th>
                                    <th>Waktu Pembelian</th>
                                    <th>Total Bayar</th>
                                    <th>Alamat</th> <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pembelian as $index => $item) : ?>
                                    <tr>
                                        <td class="text-center"><?= $index + 1 ?></td>
                                        <td>#<?= $item['id'] ?></td>
                                        <td><?= esc($item['username']) ?></td>
                                        <td><?= esc($item['created_at']) ?></td>
                                        <td><?= 'IDR ' . number_format($item['total_harga'], 0, ',', '.') ?></td>
                                        <td><?= esc($item['alamat']) ?></td> <td>
                                            <?php if ($item['status'] == 1) : ?>
                                                <span class="badge bg-success">Sudah Selesai</span>
                                            <?php else : ?>
                                                <span class="badge bg-danger">Belum Selesai</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="<?= base_url('pembelian/ubah_status/' . $item['id']) ?>" class="btn btn-warning btn-sm">
                                                Ubah Status
                                            </a>
                                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#detailModal-<?= $item['id'] ?>">
                                                Detail
                                            </button>
                                        </td>
                                    </tr>

                                    <div class="modal fade" id="detailModal-<?= $item['id'] ?>" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Detail Data</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <?php if (isset($detail[$item['id']])) : ?>
                                                        <?php foreach ($detail[$item['id']] as $idx => $d) : ?>
                                                            <div class="d-flex align-items-start mb-3">
                                                                <div class="me-2"><?= $idx + 1 ?>)</div>
                                                                <div class="me-3" style="width: 100px; flex-shrink: 0;">
                                                                    <img src="<?= base_url('img/' . $d['foto']) ?>" class="img-fluid rounded">
                                                                </div>
                                                                <div class="flex-grow-1">
                                                                    <strong><?= esc($d['nama']) ?></strong>
                                                                    <?php
                                                                        $harga_asli = $d['harga_asli'] ?? ($d['subtotal_harga'] / $d['jumlah']) + $d['diskon'];
                                                                    ?>
                                                                    <span class="badge bg-primary rounded-pill ms-2"><?= number_to_currency($harga_asli, 'IDR') ?></span>
                                                                    <br>
                                                                    <span>(<?= $d['jumlah'] ?> pcs)</span>
                                                                    <br>
                                                                    <span class="badge bg-primary rounded-pill"><?= number_to_currency($d['subtotal_harga'], 'IDR') ?></span>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                    <strong>Ongkir:</strong> <?= number_to_currency($item['ongkir'], 'IDR') ?>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>