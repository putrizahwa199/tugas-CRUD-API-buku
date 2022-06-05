<?php
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
    $id         = $_GET['id'];
    $sql1       = "delete from daftarbuku where id = '$id'";
    $q1         = mysqli_query($connection,$sql1);
    if($q1){
        $sukses = "Berhasil hapus data";
    }else{
        $error  = "Gagal melakukan delete data";
    }
}
if ($op == 'edit') {
    $id         = $_GET['id'];
    $sql1       = "select * from daftarbuku where id = '$id'";
    $q1         = mysqli_query($connection, $sql1);
    $r1         = mysqli_fetch_array($q1);
    $isbn       = $r1['isbn'];
    $judul      = $r1['judul'];
    $pengarang  = $r1['pengarang'];
    $jumlah     = $r1['jumlah'];
    $tanggal    = $r1['tanggal'];
    $abstrak    = $r1['abstrak'];

    if ($isbn == '') {
        $error = "Data tidak ditemukan";
    }
}
if (isset($_POST['simpan'])) { //untuk create
    $isbn        = $_POST['isbn'];
    $judul       = $_POST['judul'];
    $pengarang   = $_POST['pengarang'];
    $jumlah      = $_POST['jumlah'];
    $tanggal     = $_POST['tanggal'];
    $abstrak     = $_POST['abstrak'];

    if ($isbn && $judul && $pengarang && $jumlah && $tanggal && $abstrak) {
        if ($op == 'edit') { //untuk update
            $sql1       = "update daftarbuku set isbn = '$isbn',judul='$judul',pengarang = '$pengarang',jumlah='$jumlah',tanggal='$tanggal',abstrak='$abstrak' where id = '$id'";
            $q1         = mysqli_query($connection, $sql1);
            if ($q1) {
                $sukses = "Data berhasil diupdate";
            } else {
                $error  = "Data gagal diupdate";
            }
        } else { //untuk insert
            $sql1   = "insert into daftarbuku(isbn,judul,pengarang,jumlah,tanggal,abstrak) values ('$isbn','$judul','$pengarang','$jumlah','$tanggal','$abstrak')";
            $q1     = mysqli_query($connection, $sql1);
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
    <title>Daftar buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <style>
        .mx-auto {
            width: 1200px
        }

        .card {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="mx-auto">
        <!-- untuk memasukkan data -->
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
                        <label for="isbn" class="col-sm-2 col-form-label">ISBN</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="isbn" name="isbn" value="<?php echo $isbn ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="judul" class="col-sm-2 col-form-label">JUDUL</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="judul" name="judul" value="<?php echo $judul ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="alamat" class="col-sm-2 col-form-label">PENGARANG</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="pengarang" name="pengarang" value="<?php echo $pengarang ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="jumlah" class="col-sm-2 col-form-label">JUMLAH HALAMAN</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="jumlah" name="jumlah" value="<?php echo $jumlah ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="tanggal" class="col-sm-2 col-form-label">TANGGAL</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="tanggal" name="tanggal" value="<?php echo $tanggal ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="abstrak" class="col-sm-2 col-form-label">ABSTRAK</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="abstrak" name="abstrak" value="<?php echo $abstrak ?>">
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" />
                    </div>
                </form>
            </div>
        </div>

        <!-- untuk mengeluarkan data -->
        <div class="card">
            <div class="card-header text-white bg-secondary">
                Daftar Buku
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">ISBN</th>
                            <th scope="col">JUDUL</th>
                            <th scope="col">PENGARANG</th>
                            <th scope="col">JUMLAH HALAMAN</th>
                            <th scope="col">TANGGAL</th>
                            <th scope="col">ABSTRAK</th>
                            <th scope="col">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql2   = "select * from daftarbuku order by id desc";
                        $q2     = mysqli_query($connection, $sql2);
                        $urut   = 1;
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $id         = $r2['id'];
                            $isbn       = $r2['isbn'];
                            $judul      = $r2['judul'];
                            $pengarang  = $r2['pengarang'];
                            $jumlah     = $r2['jumlah'];
                            $tanggal    = $r2['tanggal'];
                            $abstrak    = $r2['abstrak'];

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
                                    <a href="index.php?op=edit&id=<?php echo $id ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                    <a href="index.php?op=delete&id=<?php echo $id?>" onclick="return confirm('Anda yakin ingin menghapus data ini?')"><button type="button" class="btn btn-danger">Delete</button></a>            
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