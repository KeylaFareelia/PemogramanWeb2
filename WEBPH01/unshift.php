<?php
$makanan = ["Susu", "Coklat", "Madu", "Vanila"];

array_unshift($makanan, "Susu", "Coklat");

echo "Hasil";
foreach ($makanan as $p) {
    echo "<br> .$p";
}
?>
