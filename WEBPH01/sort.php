<?php
$ar_buah = ["a" => "Apel", "m" => "Mangga", "s" => "Semangka", "n" => "Nanas"];

echo '<ol>';
sort($ar_buah);

foreach ($ar_buah as $value) {
    echo '<li>' . $value . '</li>';
}
echo '</ol>';
