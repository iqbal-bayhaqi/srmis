<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Untitled Document</title>
<style type=�text/css�>
@media print {
input.noPrint { display: none; }
}
</style>
</head>
<?php
	include "./../include/fungsi_rp.php";
	include "./../include/koneksi.php";
?>

<body>
<table border="0" cellpadding="2" cellspacing="2" width="800px" align="center">
	<tr>
		<td align="center" colspan="4"><font color="#000000" size="+1"><strong>LAPORAN PENJUALAN BARANG PER BULAN<br></strong></font></td>
	</tr>
	<tr>
		<td width="240">Bulan : <?=$_POST['month']. "-" .$_POST['year'] ?></td>
		<td colspan="3" align="right"><input class="noPrint" type="button" value="Print" onclick="window.print()"> </td>
		<td></td>
	</tr>
	<tr>
		<td colspan="4" align="center">
			<?php
			$query = mysql_query("SELECT * FROM obat,penjualan,pasien WHERE obat.kode_obat = penjualan.kode_obat AND pasien.no_rm = penjualan.no_rm AND 
			month = '".$_POST['month']."' AND year = '".$_POST['year']."'");
			echo '<table border=1 cellpadding=2 cellspacing=2 width=100% bordercolor=#FF9933>
					<tr bgcolor=#FEFAFA align=center>
						<td><font color=#000000 width=10px>Audit</font></td>
						<td><font color=#000000 width=10px>Tanggal</font></td>
						<td><font color=#000000 width=10px>Transaksi</font></td>
						<td><font color=#000000 width=10px>No RM</font></td>
						<td><font color=#000000 width=10px>Kode Obat</font></td>
						<td><font color=#000000 width=250px>Nama Obat</font></td>
						<td><font color=#000000 width=50px>Jumlah</font></td>
						<td><font color=#000000>Jumlah Harga</font></td>
					</tr>';
			$no = 1;
			while ($result = mysql_fetch_array($query))
			{
				$q = mysql_query ("SELECT * FROM admin WHERE id = '$result[id_audit]'");
				$r = mysql_fetch_array ($q);
				echo "<tr>
				<td>$r[username]</td>
				<td align=center>$result[date]</td>
				<td align=center>$result[transaksi]</td>
				<td align=center>$result[no_rm]</td>
				<td>$result[kode_obat]</td>
				<td>$result[nama_obat]</td>
				<td align=right>$result[jumlah]</td>
				<td align=right>";
					rupiah($result[jumlah_harga]);
				echo "</td>
				</tr>";
				$no++;
			}
			$q3=mysql_query("SELECT SUM(jumlah_harga) FROM penjualan WHERE month = '".$_POST['month']."' 
			AND year = '".$_POST['year']."'");
			$r3=mysql_fetch_array($q3);
			echo "<tr>
			<td colspan=7 align=right>
			Total :</td><td align=right>";
			rupiah($r3['SUM(jumlah_harga)']);
			echo "</td>
			</tr>";
			echo '</table></td></tr>';
			
			?>
	<tr>
		<td colspan="2">&nbsp;</td>
		<td colspan="2" align="right"></td>
	</tr>
</table>
</body>
</html>
