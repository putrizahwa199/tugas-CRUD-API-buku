<?php
$host       = "localhost";
$user       = "root";
$pass       = "";
$db         = "kuliahweb";

$connection    = mysqli_connect($host, $user, $pass, $db);
if (!$connection) { //cek koneksi
    die("Tidak bisa terkoneksi ke database");
}

$isbn           = "";
$judul          = "";
$pengarang      = "";
$jumlah         = "";
$tanggal        = "";
$abstrak        = "";
$sukses         = "";
$error          = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}
if($op == 'delete'){
    $isbn         = $_GET['isbn'];
    $sql1       = "delete from daftarbuku where isbn = '$isbn'";
    $q1         = mysqli_query($connection,$sql1);
    if($q1){
        $sukses = "Berhasil menghapus data";
    }else{
        $error  = "Gagal menghapus data";
    }
}
if ($op == 'edit') {
    $isbn               = $_GET['isbn'];
    $sql1             = "select * from daftarbuku where isbn = '$isbn'";
    $q1               = mysqli_query($connection, $sql1);
    $r1               = mysqli_fetch_array($q1);
    $judul            = $r1['judul'];
    $pengarang        = $r1['pengarang'];
    $jumlah           = $r1['jumlah'];
    $tanggal          = $r1['tanggal'];
    $abstrak          = $r1['abstrak'];


    if ($isbn == '') {
        $error = "Data tidak ditemukan";
    }
}

if(isset($POST['simpan'])) { //untuk create
    $isbn           = $_POST['isbn'];
    $judul          = $_POST['judul'];
    $pengarang      = $_POST['pengarang'];
    $jumlah = $_POST['jumlah'];
    $tanggal        = $_POST['tanggal'];
    $abstrak        = $_POST['abstrak'];

    if($isbn && $judul && $pengarang && $jumlah && $tanggal && $abstrak){
        if ($op == 'edit') { //untuk update
            $sql1       = "update daftarbuku set isbn = '$isbn',judul='$judul',pengarang = '$pengarang',jumlah='$jumlah',tanggal='$tanggal',abstrak='$abstrak' where isbn = '$isbn'";
            $q1         = mysqli_query($connection, $sql1);
            if ($q1) {
                $sukses = "Data berhasil diupdate";
            } else {
                $error  = "Data gagal diupdate";
            }
        } else { //untuk insert
            $sql1 ="insert into daftarbuku(isbn,judul,pengarang,jumlah,tanggal,abstrak) values ('$isbn','$judul','$pengarang','$jumlah','$tanggal','$abstrak')";
            $q1 = mysqli_query($connection,$sql1);
            if ($q1) {
                $sukses     = "Berhasil memasukkan data baru";
            } else {
                $error      = "Gagal memasukkan data";
            }
        }
    } else {
        $error = "Silakan masukkan semua data";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
    .mx-auto {
        width: 800px
    }

    .card {
        margin-top: 10px
    }
    </style>
</head>

<body>
    <div class="mx-auto">
        <!--untuk memasukkan data-->
        <div class="card">
            <div class="card-header">
                Create / Edit Data
            </div>
            <div class="card-body">
            <?php
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                    header("refresh:5;url=index.php");//5 : detik
                }
                ?>
                <?php
                if ($sukses) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                <?php
                    header("refresh:5;url=index.php");
                }
                ?>
                <form action="" method="POST">
                    <div class="mb-3 row">
                        <label for="judul" class="col-sm-2 col-form-label">Judul</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="judul" name="judul"
                                value="<?php echo $judul ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="pengarang" class="col-sm-2 col-form-label">Pengarang</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="pengarang" name="pengarang"
                                value="<?php echo $pengarang ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="jumlah" class="col-sm-2 col-form-label">Jumlah Halaman</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="jumlah" name="jumlah"
                                value="<?php echo $jumlah ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="tanggal" class="col-sm-2 col-form-label">Tanggal</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="tanggal" name="tanggal"
                                value="<?php echo $tanggal ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="abstrak" class="col-sm-2 col-form-label">Abstrak</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="abstrak" name="abstrak"
                                value="<?php echo $abstrak ?>">
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" />
                    </div>
                </form>
            </div>
        </div>

        <!--untuk mengeluarkan data-->
        <div class="card">
            <div class="card-header text-white bg-secondary">
                Daftar Buku
            </div>
            <div class="card-body">
            <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">isbn</th>
                            <th scope="col">judul</th>
                            <th scope="col">pengarang</th>
                            <th scope="col">jumlah halaman</th>
                            <th scope="col">tanggal</th>
                            <th scope="col">abstrak</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $sql2   = "select * from daftarbuku order by isbn desc";
                        $q2     = mysqli_query($connection, $sql2);
                        $urut   = 1;
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $isbn            = $r2['isbn'];
                            $judul           = $r2['judul'];
                            $pengarang       = $r2['pengarang'];
                            $jumlah  = $r2['jumlah'];
                            $tanggal         = $r2['tanggal'];
                            $abstrak         = $r2['abstrak'];
                        ?>
                        <tr>
                                <th scope="row"><?php echo $urut++ ?></th>
                                <td scope="row"><?php echo $isbn ?></td>
                                <td scope="row"><?php echo $judul ?></td>
                                <td scope="row"><?php echo $pengarang ?></td>
                                <td scope="row"><?php echo $jumlah ?></td>
                                <td scope="row"><?php echo $tanggal ?></td>
                                <td scope="row"><?php echo $abstrak ?></td>
                                <td scope="row">
                                    <a href="index.php?op=edit&id=<?php echo $isbn ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                    <a href="index.php?op=delete&id=<?php echo $isbn?>" onclick="return confirm('Yakin mau menghapus data?')"><button type="button" class="btn btn-danger">Delete</button></a>            
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                    
                </table>
            </div>
        </div>
    </div>
</body>

</html>