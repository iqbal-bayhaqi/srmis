<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Untitled Document</title>
</head>
<body>
<?php
$No_BPB = $_GET['No_BPB'];
$No_SPP = $_GET['No_SPP'];
$qar2=mysql_query("SELECT * FROM permintaan_unit WHERE No_BPB = '$No_BPB'");
$rar2=mysql_fetch_array($qar2);

$qar=mysql_query("SELECT * FROM permintaan_unit WHERE No_SPP = '$No_SPP'");
$rar=mysql_fetch_array($qar);
?>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td>
		<table border="0" width="100%" cellpadding="0" cellspacing="0">
			<tr>
				<td width="8px">&nbsp;</td>
				<td width="300px" bgcolor="#9b9999">&nbsp;&nbsp;<b><font color="#fefafa" style="font-size:14px;">Bukti Pengeluaran Barang </font></b></td>
				<td></td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td><img src="images/atas_isi.png"></td>
	</tr>
	<tr>
		<td id="tengah_isi" >
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td width="15px">&nbsp;</td>
					<td valign="top">
					<font style="font-size:12px;">
					<table border="0" cellpadding="2" cellspacing="2" width="100%">
						<tr>
							<td>Tanggal</td>
						  <td><?php
									$date=date("d/m/Y");
								?>
						    :
						    <input type="text" size="12" name="tgl" value="<?= $rar['Tgl_SPP']?>" style="background-color:#CCCFFF; " readonly="true">
                          </td>
							
							<td width="70px" align="right"></td>
							
						</tr>
						<tr>
                          <td align="left" width="100">No BPB </td>
							<td>
							: <input type="text" size="20" name="No_BPB" value="<?= $_GET['No_BPB']?>" style="background-color:#CCCFFF; " readonly="true"></td>
								<!--
								<input type="button" src="javascript:void(0);" onClick="PopupCenter('content/input_daftar_barang.php', 'myPop1',400,400);" value="Tambah Data">
								-->
						  <td width="70px" align="right">						  </td>
					  </tr>
					  <tr>
                          <td align="left" width="100">No SPP </td>
							<td>
							: <input type="text" size="20" name="no_SPP" value="<?= $_GET['No_SPP']?>" style="background-color:#CCCFFF; " readonly="true">
							<input type="hidden" size="20" name="id" value="<?= $id?>">							</td>
								<!--
								<input type="button" src="javascript:void(0);" onClick="PopupCenter('content/input_daftar_barang.php', 'myPop1',400,400);" value="Tambah Data">
								-->
						  <td width="70px" align="right">						  </td>
					  </tr>

					  <tr>
					  	<td>Unit</td>
						<td>: <input type="text" name="unit" value="<?=$_SESSION['U_NMUNIT']?>" readonly="true" style="background-color:#CCCFFF; " size="60"></td>
						<td width="70px" align="right">
						  </td>
					  </tr>
						
					</table>
					<hr>
					
					<form method="post" action="home.php?hal=content/list_spb" enctype="multipart/form-data" id="form1" name="form1">
					<input type="hidden" name="no_SPP" value="<?= $_GET['No_SPP']?>">
							<input type="hidden" name="id" value="<?= $id?>">
							<input type="hidden" name="tgl" value="<?= $rar['Tgl_SPP']?>">
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
						<tr>
							<td>
							<?php
									$pdate = date ("d") + 0;
									$pmonth = date("m") + 1;
									$ppmonth = date ("m") + 0;
									$pyear = date("Y") + 0;
 							$query2  = mysql_query ("SELECT * FROM ms_barang,permintaan_unitdetail WHERE ms_barang.id = permintaan_unitdetail.barang_id
										AND permintaan_unitdetail.No_SPP='".$_GET['No_SPP']."' AND permintaan_unitdetail.flags=1");
																		
							echo "<div style='border:1px  solid  #CCCCCC; width:670px; height:200px; overflow:auto;'>";
								echo '<table cellpadding=2 cellspacing=2 width=1250px>
									<tr bgcolor=#414141 align=center>
										<td><font color=#FFFFFF width=12px>No</font></td>
										<td><font color=#FFFFFF width=100px>Kode</font></td>
										<td><font color=#FFFFFF>Nama</font></td>
										<td><font color=#FFFFFF width=80px>Satuan</font></td>
										<td><font color=#FFFFFF width=25px>Diminta</font></td>
										<td><font color=#FFFFFF width=25px>Diberi</font></td>
										<td><font color=#FFFFFF width=40px>Stok</font></td>
										<td><font color=#FFFFFF width=100px>Pabrik</font></td>
										<td><font color=#FFFFFF width=80px>Expired</font></td>
										<td><font color=#FFFFFF width=80px>Unit</font></td>
										<td><font color=#FFFFFF width=80px>Status</font></td>
										<td><font color=#FFFFFF width=220px>Action</font></td>
									</tr>';
									$no = 1;
									
									while ($result2 = mysql_fetch_array($query2))
									{
										if ($no%2)
										{
												echo "<tr valign=top>";
										}
										else
										{
											echo "<tr bgcolor=#CCCCCC valign=top style=font-color:#FF0000>";
										}
										
										
										$q_p = mysql_query ("SELECT * FROM pabrik WHERE kd_pabrik = '$result2[pabrik_obat]'");
										$r_p = mysql_fetch_array($q_p);
										
										echo "<td width=12px>$no</td>
											<td width=60px>$result2[kd_barang]</td>
											<td width=180px>$result2[nama]</td>
											<td width=80px align=center>$result2[satuan]</td>
											<td width=25px align=right>$result2[Qty]</td>
											<td width=25px align=right>$result2[Qty_diberi]</td>
											<td width=40px align=right>$result2[stok]</td>
											<td width=100px align=right>$r_p[nama]</td>";
											
											//echo "<td></td>";
											if (($pmonth == $result2['ex_month']) AND ($pyear == $result2['ex_year']))
											{ 
												echo "<td width=80px align=center><font color=blue>$result2[expire_date]</font></td>";
											}
											else if (($pmonth > $result2['ex_month']) AND ($pyear > $result2['ex_year']) AND ($pdate > $result2['ex_date'])) 
											{
												$qy = mysql_query("UPDATE ms_barang SET status='Non-Aktif' WHERE kd_barang='$result[kd_barang]'"); 
												echo "<td width=80px align=center><font color=red>$result2[expire_date]</font></td>";
											}
											else if (($ppmonth == $result2['ex_month']) AND ($pyear == $result2['ex_year']))
											{
												echo "<td width=80px align=center><font color=blue>$result2[expire_date]</font></td>";
											}
											else
											{
											 	echo "<td width=80px align=center>$result2[expire_date]</td>";
											}
											
											$qunit = mysql_query("select * from pelayanan where id='".$result2['Unit']."'");
											$runit = mysql_fetch_array($qunit);
											
											echo "<td width=120px align=center>".$runit['nama']."</td>";
											
											$qstatus = mysql_query("select * from status where id='".$result2['status_detail']."'");
											$rstatus = mysql_fetch_array($qstatus);
											
											echo "<td align=center width=100px>".$rstatus['nama']."</td>";
																			            
										    echo "<td align=center width=160px>";
												  if ($result2['status_detail']==2 OR $result2['status_detail']==4 OR $result2['status_detail']==9)
												  {
												  		
												  } 
												  else if ($result2['status_detail']==3)
												  { 
												  /*echo "<a href='home.php?hal=action/app_distribusi_kontrol&id_ms=$result2[0]&kd_barang=$result2[kd_barang]&status=2&No_BPB=$rar[No_BPB]&Tgl_SPP=$rar[Tgl_SPP]&id=$result2[id]&No_SPP=$result2[No_SPP]&diberi=$result2[Qty]'>APPROVE</a> | ";
												  echo "<a href='javascript:void(0);' onClick=\"PopupCenter('content/input_distribusi_kontrol.php?id_ms=$result2[0]&kd_barang=$result2[kd_barang]&status=2&No_BPB=$rar[No_BPB]&Tgl_SPP=$rar[Tgl_SPP]&id=$result2[id]&No_SPP=$result2[No_SPP]', 'myPop1',800,400);\">
												  <font size=-1>EDIT</font></a> | ";
												  echo "<a href=\"home.php?hal=action/update_distribusi_kontrol&status=4&No_BPB=$rar[No_BPB]&Tgl_SPP=$rar[Tgl_SPP]&kd_barang=$result2[kd_barang]&id=$result2[id]&No_SPP=$result2[No_SPP]\" 
												  onClick=\"return confirm('Apakah Anda benar-benar akan membatalkan $result2[nama]?')\">
												  <font size=-1>CANCEL</font></a> ";*/
												  
												  echo "<a href='home.php?hal=action/app_distribusi_kontrol&id_ms=$result2[0]&kd_barang=$result2[kd_barang]&status=2&No_BPB=$rar[No_BPB]&Tgl_SPP=$rar[Tgl_SPP]&id=$result2[id]&No_SPP=$result2[No_SPP]&diberi=$result2[Qty]'>DISETUJUI</a> | ";
												  echo "<a href='javascript:void(0);' onClick=\"PopupCenter('content/input_distribusi_kontrol.php?id_ms=$result2[0]&kd_barang=$result2[kd_barang]&status=2&No_BPB=$rar[No_BPB]&Tgl_SPP=$rar[Tgl_SPP]&id=$result2[id]&No_SPP=$result2[No_SPP]', 'myPop1',800,400);\">
												  <font size=-1>EDIT</font></a> | ";
												  echo "<a href=\"home.php?hal=action/update_distribusi_kontrol&status=4&No_BPB=$rar[No_BPB]&Tgl_SPP=$rar[Tgl_SPP]&kd_barang=$result2[kd_barang]&id=$result2[id]&No_SPP=$result2[No_SPP]\" 
												  onClick=\"return confirm('Apakah Anda benar-benar akan membatalkan $result2[nama]?')\">
												  <font size=-1>CANCEL</font></a> ";
												  
												  }
												  else
												  {
												  /*echo "<a href='home.php?hal=action/app_distribusi_kontrol&id_ms=$result2[0]&kd_barang=$result2[kd_barang]&status=2&No_BPB=$rar[No_BPB]&Tgl_SPP=$rar[Tgl_SPP]&id=$result2[id]&No_SPP=$result2[No_SPP]&diberi=$result2[Qty]'>APPROVE</a> | ";
												  echo "<a href='javascript:void(0);' onClick=\"PopupCenter('content/input_distribusi_kontrol.php?id_ms=$result2[0]&kd_barang=$result2[kd_barang]&status=2&No_BPB=$rar[No_BPB]&Tgl_SPP=$rar[Tgl_SPP]&id=$result2[id]&No_SPP=$result2[No_SPP]', 'myPop1',800,400);\">
												  <font size=-1>EDIT</font></a> | 
												  <a href=\"home.php?hal=action/update_distribusi_kontrol&id_ms=$result2[0]&kd_barang=$result2[kd_barang]&status=3&No_BPB=$rar[No_BPB]&Tgl_SPP=$rar[Tgl_SPP]&id=$result2[id]&No_SPP=$result2[No_SPP]\">
												  <font size=-1>PENDING</font></a> | ";
												  echo "<a href=\"home.php?hal=action/update_distribusi_kontrol&id_ms=$result2[0]&status=4&No_BPB=$rar[No_BPB]&Tgl_SPP=$rar[Tgl_SPP]&kd_barang=$result2[kd_barang]&id=$result2[id]&No_SPP=$result2[No_SPP]\" 
												  onClick=\"return confirm('Apakah Anda benar-benar akan membatalkan $result2[nama]?')\">
												  <font size=-1>CANCEL</font></a> ";*/
												  
												  
												  echo "<a href='home.php?hal=action/app_distribusi_kontrol&id_ms=$result2[0]&kd_barang=$result2[kd_barang]&status=2&No_BPB=$rar[No_BPB]&Tgl_SPP=$rar[Tgl_SPP]&id=$result2[id]&No_SPP=$result2[No_SPP]&diberi=$result2[Qty]'>DISETUJUI</a> | ";
												  echo "<a href='javascript:void(0);' onClick=\"PopupCenter('content/input_distribusi_kontrol.php?id_ms=$result2[0]&kd_barang=$result2[kd_barang]&status=2&No_BPB=$rar[No_BPB]&Tgl_SPP=$rar[Tgl_SPP]&id=$result2[id]&No_SPP=$result2[No_SPP]', 'myPop1',800,400);\">
												  <font size=-1>EDIT</font></a> | ";
												  echo "<a href=\"home.php?hal=action/update_distribusi_kontrol&id_ms=$result2[0]&status=4&No_BPB=$rar[No_BPB]&Tgl_SPP=$rar[Tgl_SPP]&kd_barang=$result2[kd_barang]&id=$result2[id]&No_SPP=$result2[No_SPP]\" 
												  onClick=\"return confirm('Apakah Anda benar-benar akan membatalkan $result2[nama]?')\">
												  <font size=-1>CANCEL</font></a> ";
												  
												  // echo "<a href='javascript:void(0);' onClick=\"PopupCenter('content/input_buat_pendimg.php?UsrRetur=$UsrRetur&No_SPP=$result2[No_SPP]&id=$result2[id]', 'myPop1',800,400);\">BUAT RETUR</a>";
												  }
												  
												  
												  echo "</td>
												  </tr>";
										
										$no++;
									}
									$no_f=$no-1;
									echo "<input type=hidden name=param value='$no_f'>";								
									echo '</table></div>';
									echo '<hr>';
							?>
							</td>
						</tr>
						</form>
						<tr>
							<td>
								<table width="100%">
									<tr>
										<td>
										<table width="100%">
											<tr>
												<td width="100">User Buat</td>
												<td>: <input type="text" size="30" name="" value="<?=$rar['UsrBuat']?>"  readonly="true" style="background-color:#CCCFFF; "></td>
											</tr>
											<tr>
												<td width="100">User Approve </td>
												<td>: <input type="text" size="30" name="" value="<?=$_SESSION['U_USER']?>"  readonly="true" style="background-color:#CCCFFF; "></td>
											</tr>
										</table>
									</td>
									<td align="right" valign="top">
									<table border="0" cellpadding="0" cellspacing="0" width="100%">
										<tr valign="top">
											<td  width="80px" align="right">
												<form method="post" enctype="multipart/form-data" action="home.php?hal=action/approve_distribusi">
													<input type="hidden" name="no_SPP" value="<?= $_GET['No_SPP']?>">
													<input type="hidden" name="id" value="<?= $id?>">
													<input type="hidden" name="no_bpb" value="<?= $rar2['No_BPB']?>">
													<input type="hidden" name="tgl" value="<?= $rar['Tgl_SPP']?>">
													<input type=submit value="Buat BPB">
												</form>
											</td>
										</tr>
									</table>
									</td>
									</tr>
							  </table>	
							</td>
						</tr>
					</table>
					</font>
					</td>
					<td width="15px"><p>&nbsp;</p>
				    <p>&nbsp;</p></td>
				</tr>
			</table>
	</tr>
	<tr>
		<td><img src="images/bawah_isi.png"></td>
	</tr>
</table>
</body>
</html>
