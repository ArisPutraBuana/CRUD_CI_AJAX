<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="<?= base_url(); ?>assets/js/jquery.min.js"></script>
</head>

<body>

    <div class="container">
        <h2 class="my-3">Data Barang</h2>

        <a href="#form" data-toggle="modal" class="btn btn-primary mb-3" onclick="submit('tambah')">Tambah Data</a>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">NO</th>
                    <th scope="col">KODE BARANG</th>
                    <th scope="col">NAMA BARANG</th>
                    <th scope="col">HARGA</th>
                    <th scope="col">STOK</th>
                    <th colspan="2" class="">AKSI</th>
                </tr>
            </thead>
            <tbody id="target">


                <!-- Data akan tampil menggunakan AJAX -->


            </tbody>
        </table>

        <!-- Form untuk menambahkan Data -->
        <div class="modal fade" id="form" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Data Barang</h5>
                    </div>
                    <!-- Menampilkan pesan -->
                    <p id="pesan" class="my-3 mx-auto alert-danger"></p>

                    <div class="modal-body">
                        <div class="form-group">
                            <label>KODE BARANG</label>
                            <!-- ID yg di hidden -->
                            <input type="hidden" name="id" value="">
                            <input type="text" name="kode_barang" class="form-control" placeholder="Input Kode Barang">
                        </div>
                        <div class="form-group">
                            <label>NAMA BARANG</label>
                            <input type="text" name="nama_barang" class="form-control" placeholder="Input Nama Barang">
                        </div>
                        <div class="form-group">
                            <label>HARGA</label>
                            <input type="text" name="harga" class="form-control" placeholder="Input Harga Barang">
                        </div>
                        <div class="form-group">
                            <label>STOK</label>
                            <input type="text" name="stok" class="form-control" placeholder="Input Stok Barang">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                        <button type="button" id="btn-tambah" onclick="tambahData()" class="btn btn-primary">Tambah</button>
                        <button type="button" id="btn-ubah" onclick="ubahData()" class="btn btn-primary">Ubah</button>
                    </div>
                </div>
            </div>
        </div>

    </div>



    <script type="text/javascript">
        // Menampilkan Data menggunakan Ajax
        ambilData();

        function ambilData() {
            $.ajax({
                type: 'post',
                url: '<?= base_url() . "index.php/page/ambilData" ?>',
                dataType: 'json',
                success: function(data) {
                    var baris = '';
                    for (var i = 0; i < data.length; i++) {
                        baris += '<tr>' +
                            '<td>' + (i + 1) + '</td>' +
                            '<td>' + data[i].kode_barang + '</td>' +
                            '<td>' + data[i].nama_barang + '</td>' +
                            '<td>' + data[i].harga + '</td>' +
                            '<td>' + data[i].stok + '</td>' +
                            '<td><a href="#form" data-toggle="modal" class="btn btn-info" onclick="submit(' + data[i].id + ')">Ubah</td>' +
                            '<td><a class="btn btn-danger" onclick="hapusData(' + data[i].id + ')">Hapus</td>' +
                            '</tr>';
                    }
                    $('#target').html(baris);
                }
            });
        }

        // Tambah Data menggunakan Ajax
        function tambahData() {
            var kode_barang = $("[name='kode_barang']").val();
            var nama_barang = $("[name='nama_barang']").val();
            var harga = $("[name='harga']").val();
            var stok = $("[name='stok']").val();

            $.ajax({
                type: 'post',
                data: 'kode_barang=' + kode_barang + '&nama_barang=' + nama_barang +
                    '&harga=' + harga + '&stok' + stok,
                url: '<?= base_url() . 'index.php/page/tambahData' ?>',
                dataType: 'json',
                success: function(hasil) {
                    console.log(hasil);
                    die();
                    $("#pesan").html(hasil.pesan);

                    if (hasil.pesan == '') {
                        // Menghilangkan Modal setelah melakukan Tambah Data
                        $("#form").modal('hide');
                        // Me-Represt ke halaman home.php
                        ambilData();

                        // Ketika melakukan Tambah Data lagi (Di input data kosong)
                        $("[name='kode_barang']").val('');
                        $("[name='nama_barang']").val('');
                        $("[name='harga']").val('');
                        $("[name='stok']").val('');
                    }
                }
            });
        }

        // Meng Edit data
        // Fungsi submit (Tambah atau Ubah yg akan dijalankan)
        function submit(x) {
            if (x == 'tambah') {
                $("#btn-tambah").show();
                $("#btn-ubah").hide();
            } else {
                $("#btn-tambah").hide();
                $("#btn-ubah").show();

                // Ambil ID untuk meng-edit data
                $.ajax({
                    type: 'post',
                    data: 'id=' + x,
                    url: '<?= base_url() . "index.php/page/ambilId" ?>',
                    dataType: 'json',
                    success: function(hasil) {
                        $("[name='id']").val(hasil[0].id);
                        $("[name='kode_barang']").val(hasil[0].kode_barang);
                        $("[name='nama_barang']").val(hasil[0].nama_barang);
                        $("[name='harga']").val(hasil[0].harga);
                        $("[name='stok']").val(hasil[0].stok);
                    }

                });
            }
        }

        // Mengubah Data
        function ubahData() {
            var id = $("[name='id']").val();
            var kode_barang = $("[name='kode_barang']").val();
            var nama_barang = $("[name='nama_barang']").val();
            var harga = $("[name='harga']").val();
            var stok = $("[name='stok']").val();

            $.ajax({
                type: 'post',
                data: 'id=' + id + '&kode_barang=' + kode_barang + '&nama_barang=' + nama_barang +
                    '&harga=' + harga + '&stok' + stok,
                url: '<?= base_url() . "index.php/page/ubahData" ?>',
                dataType: 'json',
                success: function(hasil) {
                    $("#pesan").html(hasil.pesan);

                    if (hasil.pesan == '') {
                        // Menghilangkan Modal setelah melakukan Ubah Data
                        $("#form").modal('hide');
                        // Me-Represt ke halaman home.php
                        ambilData();
                    }
                }

            });
        }

        // Meng-Hapus Data
        function hapusData(id) {
            var hapus = confirm('Apakah Anda Yakin ingin Hapus Data');

            if (hapus) {
                $.ajax({
                    type: 'post',
                    data: 'id=' + id,
                    url: '<?= base_url() . "index.php/page/hapusData" ?>',
                    success: function() {
                        // Tampilkan Data terbaru dari database (yg sudah terupdate)
                        ambilData();
                    }
                });
            }
        }
    </script>
    <!-- <script src="<?= base_url(); ?>assets/js/bootstrap.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>