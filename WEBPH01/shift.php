<?php
$makanan = ["Susu", "Coklat", "Madu", "Vanila"];

$awal = array_shift($makanan);

echo "Makanan yang dihapus : $awal <br>";
echo "Array setelah shift <br>";
foreach ($makanan as $r) {
    echo "$r <br>";
}
?>
