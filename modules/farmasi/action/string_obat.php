<?php
include "../include/koneksi.php";

$qa = mysql_query("SELECT * FROM barang_unit,ms_barang WHERE barang_unit.barang_id=ms_barang.id AND barang_unit.unit_id='2' AND ms_barang.status = 'Aktif' AND ms_barang.nama LIKE '$mysearchString%' LIMIT 10"); // limits our results list to 10.
while ($ra = mysql_fetch_array($qa)) 
{
	echo '<li onClick="fill(\''.$ra["nama"].'\');">'.$ra["kd_barang"]. " | " .$ra["nama"].'</li>';
}
?>
