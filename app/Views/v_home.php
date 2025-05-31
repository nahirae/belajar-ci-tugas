<!-- ini halaman home<br>
<a href="/produk">ke halaman produk</a><br>
<a href="/keranjang">ke halaman keranjang</a> -->

<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<?php
if (session()->getFlashData('success')) {
?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashData('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php
}
?>

<!-- Table with stripped rows -->
<div class="row">
    <?php foreach ($product as $key => $item) : ?>
        <div class="col-lg-6">
            <?= form_open('keranjang') ?>
            <?php
            echo form_hidden('id', $item['id']);
            echo form_hidden('nama', $item['nama']);
            echo form_hidden('harga', $item['harga']);
            echo form_hidden('foto', $item['foto']);
            ?>
            <div class="card">
                <div class="card-body">
                    <img src="<?php echo base_url() . "img/" . $item['foto'] ?>" alt="..." width="300px">
                    <h5 class="card-title"><?php echo $item['nama'] ?><br><?php echo number_to_currency($item['harga'], 'IDR') ?></h5>
                    <button type="submit" class="btn btn-info rounded-pill">Beli</button>
                </div>
            </div>
            <?= form_close() ?>
        </div>
    <?php endforeach ?>
</div>
<!-- <table class="table datatable">
    <thead>
        <tr>
        <th scope="col">#</th>
        <th scope="col">Name</th>
        <th scope="col">Position</th>
        <th scope="col">Age</th>
        <th scope="col">Start Date</th>
        </tr>
    </thead>
    <tbody>
        <tr>
        <th scope="row">1</th>
        <td>Brandon Jacob</td>
        <td>Designer</td>
        <td>28</td>
        <td>2016-05-25</td>
        </tr>
        <tr>
        <th scope="row">2</th>
        <td>Bridie Kessler</td>
        <td>Developer</td>
        <td>35</td>
        <td>2014-12-05</td>
        </tr>
        <tr>
        <th scope="row">3</th>
        <td>Ashleigh Langosh</td>
        <td>Finance</td>
        <td>45</td>
        <td>2011-08-12</td>
        </tr>
        <tr>
        <th scope="row">4</th>
        <td>Angus Grady</td>
        <td>HR</td>
        <td>34</td>
        <td>2012-06-11</td>
        </tr>
        <tr>
        <th scope="row">5</th>
        <td>Raheem Lehner</td>
        <td>Dynamic Division Officer</td>
        <td>47</td>
        <td>2011-04-19</td>
        </tr>
    </tbody>
</table> -->
<!-- End Table with stripped rows -->
<?= $this->endSection() ?>
