<?php
// get value of id that sent from address bar 
$id=$_GET['id'];
$pasien_id=$_GET['pasien_id'];
$diberi = $_GET['diberi'];
$no_resep=$_GET['no_resep'];
$param_no=$_GET['param_no'];

// Delete data in mysql from row that has this id 

$qu=mysql_query("SELECT * FROM ms_barang WHERE kd_barang='".$_GET['kd_barang']."'");
$ru=mysql_fetch_array($qu);
$q22=mysql_query("select * from barang_unit where barang_id='$ru[id]' AND unit_id='4'");
$r22=mysql_fetch_array($q22);
$jml=$qty + $r22['stok'];
$qq=mysql_query("UPDATE barang_unit SET stok='$jml' WHERE barang_id='$r22[barang_id]' and unit_id='4'");

$sql="DELETE FROM resep WHERE id='$id'";
$result=mysql_query($sql);

//$q=mysql_query("SELECT pasien_id FROM resep WHERE pasien_id='$pasien_id'");
//$r=mysql_fetch_array($q);

// if successfully deleted
if($result){
print "<script>alert('Data Berhasil di Hapus.');location.href='home.php?hal=content/resep_reg_rawat_jalan&pasien_id=$pasien_id&pasien_id=$pasien_id&id=$pasien_id&no_resep=$no_resep&param_no=$param_no'</script>";
}

else {
echo "ERROR";
}


?>