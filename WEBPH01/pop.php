<?php
$siswa = ["Keyla", "Farrelia",
            "Farrel","Lia"];

echo "Array awal :\n";
print_r($siswa);

$orang_terakhir = array_pop($siswa);

echo "Elemen yang akan di hapus" .$orang_terakhir. "\n";

echo "Array setelah penghapusan";
print_r($siswa);

?>
