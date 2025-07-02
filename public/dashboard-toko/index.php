<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - Toko</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
    <?php 
    function curl(){ 
        $curl = curl_init(); 
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://localhost:8080/api", // Pastikan URL API Anda benar
            CURLOPT_RETURNTRANSFER => true, 
            CURLOPT_CUSTOMREQUEST => "GET", 
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
                "key: random123678abcghi", // Pastikan Key Anda benar
            ),
        ));
            
        $output = curl_exec($curl);
        if(curl_errno($curl)){
            // Jika ada error cURL, tampilkan pesan
            echo 'Curl error: ' . curl_error($curl);
            return null;
        }
        curl_close($curl);      
        
        $data = json_decode($output);   
        
        return $data;
    } 
    ?>
    <div class="p-3 pb-md-4 mx-auto text-center">
        <h1 class="display-4 fw-normal text-body-emphasis">Dashboard - TOKO</h1>
        <p class="fs-5 text-body-secondary"><?= date("l, d-m-Y") ?> <span id="jam"></span>:<span id="menit"></span>:<span id="detik"></span></p>
    </div> 
    <hr>
    
    <div class="table-responsive card m-5 p-5">
        <h3 class="text-center mb-4">Transaksi Pembelian</h3>
        <table class="table text-center">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 10%;">Username</th>
                    <th style="width: 30%;">Alamat</th>
                    <th style="width: 15%;">Total Harga</th>
                    <th style="width: 10%;">Ongkir</th>
                    <th style="width: 10%;">Status</th>
                    <th style="width: 20%;">Tanggal Transaksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $send1 = curl();
                    if(!empty($send1) && isset($send1->results)){
                        $hasil1 = $send1->results;
                        $i = 1; 

                        if(!empty($hasil1)){
                            foreach($hasil1 as $item1){ 
                                ?>
                                <tr>
                                    <td scope="row" class="text-start"><?= $i++ ?></td>
                                    <td><?= $item1->username; ?></td>
                                    <td><?= $item1->alamat; ?></td>
                                    <td>
                                        <?= "Rp " . number_format($item1->total_harga, 0, ',', '.'); ?>
                                        <br>
                                        <small class="text-muted">(<?= $item1->jumlah_item; ?> Item)</small>
                                    </td>
                                    <td><?= "Rp " . number_format($item1->ongkir, 0, ',', '.'); ?></td>
                                    <td>
                                        <?php if ($item1->status == 1) : ?>
                                            <span class="badge bg-success">Sudah Selesai</span>
                                        <?php else : ?>
                                            <span class="badge bg-warning text-dark">Belum Selesai</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $item1->created_at; ?></td>
                                </tr> 
                                <?php
                            } 
                        }
                    } else {
                        echo '<tr><td colspan="7">Tidak dapat mengambil data atau data kosong.</td></tr>';
                    }
                    ?> 
            </tbody>
        </table>
    </div> 

    <script>
        window.setTimeout("waktu()", 1000);

        function waktu() {
            var waktu = new Date();
            setTimeout("waktu()", 1000);
            document.getElementById("jam").innerHTML = String(waktu.getHours()).padStart(2, '0');
            document.getElementById("menit").innerHTML = String(waktu.getMinutes()).padStart(2, '0');
            document.getElementById("detik").innerHTML = String(waktu.getSeconds()).padStart(2, '0');
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>