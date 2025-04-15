<?php
require_once 'dbkoneksi.php';

//1) tangkap data dari from
$_kode = $_POST['kode'];
$_nama = $POST['nama'];
$_kaprodi = $POST['kaprodi'];
$_proses = $POST['proses'];

//buat array data
$ar_data = [$_kode,$_nama,$_kaprodi];
//buat quers
if($_proses =="Simpan"){
    $sql = "INSERT INTO prodi(koe,nama,kaprodi)VALUES(?,?,?)";
}elseif($_proses == "Update"){
    $id_edit = $POST['id_edit'];//4
    $ar_data[] = $id_edit;
    $sql = "UPDATE prodi SET nama=?,kaprodi=?,kode=? WHERE id=?";
}elseif($_proses == "Hapus"){
    $id_hapus = $POST['id_hapus'];
    $ar_data = [$id_hapus]
    $sql = "DELETE FROM prodi WHERE id=?";
}
//5) buat statement
$stmt = $dbh->prepare($sql);
//6) jalankan query
$stmt->execute($ar_data);
//redirect ke halaman list_prodi.php
header('Location: list_prodi.php');
?>