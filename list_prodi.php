<?php
require_once 'proses_prodi.php';

//4)definisikan query
$sql = "SELECT * FROM prodi";
//5) jalan kan query
$rs = $dbh->query($sql);
//6) tampilkan hasil query
?>
<table border="1" width="100%">
    <tr>
        <th>No</th>
        <th>Kode</th>
        <th>Nama Prodi</th>
        <th>Kepala Prodi</th>
        <th>Aksi</th>
    </tr>
    <?php
    $nomor = 1;
    foreach($rs as $row){
    ?>
    <tr>
        <td><?php echo $nomor; ?></td>
        <td><?php echo $row->kode; ?></td>
        <td><?php echo $row->nama; ?></td>
        <td><?php echo $row->kaprodi; ?></td>
        <td>
            <a href="form_prodi.php?id_edit=<?php echo $row->id; ?>">Edit</a>
            <a href="proses_prodi.php?id_hapus=<?php echo $row->id; ?>">Hapus</a>
        </td>
    </tr>
    <?php 
    $nomor++;
    } 
    ?>
</table>
