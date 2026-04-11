<?php 
// Array Function
$arrBuah = ['Delima', 'Rambutan', 'Naga', 'Mangga', 'Jambu'];

// is_array()
if(is_array($arrBuah)){
    echo "Ini adalah array \n\n";
} else {
    echo "Ini bukan array \n\n";
}

// count()
$jumlahBuah = count($arrBuah);
echo "Jumlah buah: $jumlahBuah \n\n";

// sort()
sort($arrBuah);
echo "Buah setelah diurutkan: \n";
foreach($arrBuah as $buah){
    echo "$buah \n";
}

// shuffle()
shuffle($arrBuah);
echo "Buah setelah diacak: \n";
foreach($arrBuah as $buah){
    echo "$buah \n";
}   

// String
$namaBuah = $arrBuah[0];
$subNamaBuah = substr($namaBuah, 0, 3);
echo "Nama buah: $namaBuah \n"; 
echo "Bagian pertama dari nama buah: $subNamaBuah \n";

?>