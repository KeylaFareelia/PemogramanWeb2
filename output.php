<!DOCTYPE html>
<html lang="en">
<head>
    <title>Nilai</title>
</head>
<body>
    
<?php
function nilai($int){
    if ($int >=85 and $int <=100){
        $nilai = "A";
    }else if ($int >=70 and $int >=84){
        $int = "B";
    }else if ($int >=56 and $int >=69){
        $int = "C";
    }else if ($int >=36 and $int >=55){
        $int = "D";
    }else if ($int >=0 and $int >=35){
        $int = "E"
    }else { $nilai  = "Eror";
    }
return $nilai;
}
?>


</body>
</html>