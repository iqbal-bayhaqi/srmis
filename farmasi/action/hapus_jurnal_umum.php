<?
$id=$_GET['id'];
$q1=mysql_query("delete from jurnal_umum where id='$id'");
if($q1)
{
 echo"<script>alert('Jurnal Berhasil di Hapus');location.href='home.php?hal=content/jurnal_umum'</script>";
}else{
 echo"<script>alert('Jurnal Gagal di Hapus');location.href='home.php?hal=content/jurnal_umum'</script>";
}
?>