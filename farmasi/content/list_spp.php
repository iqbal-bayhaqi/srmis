<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Untitled Document</title>
<!-- suggestion -->
<script>
	function lookup(inputString) {
		if(inputString.length == 0) {
			// Hide the suggestion box.
			$('#suggestions').hide();
		} else {
			// post data to our php processing page and if there is a return greater than zero
			// show the suggestions box
			$.post("action/string_spp.php", {mysearchString: ""+inputString+""}, function(data){
				if(data.length >0) {
					$('#suggestions').show();
					$('#autoSuggestionsList').html(data);
				}
			});
		}
	} //end
	
	// if user clicks a suggestion, fill the text box.
	function fill(thisValue) {
		$('#inputString').val(thisValue);
		setTimeout("$('#suggestions').hide();", 200);
	}
</script>

<!-- end suggestion-->

<style>
.suggestionsBox {
	position: absolute;
	width: 320px;
	background-color: #000000;
	border: 2px solid #000;
	color: #fff;
	padding: 5px;
	margin-top: 10px;
	margin-right: 0px;
	margin-bottom: 0px;
	margin-left: 10px;
	-moz-border-radius: 8px;
	-webkit-border-radius: 8px;
}


</style>

</head>
<body>
<?php
	$cari = $_POST['cari'];
?>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td>
		<table border="0" width="100%" cellpadding="0" cellspacing="0">
			<tr>
				<td width="8px">&nbsp;</td>
				<td width="300px" bgcolor="#9b9999">&nbsp;&nbsp;<b><font color="#fefafa">Dokumen Permintaan </font></b></td>
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
							<form method="post" action="home.php?hal=content/list_spp" enctype="multipart/form-data">
							<td align="left">
						  <!--
								<input type="button" src="javascript:void(0);" onClick="PopupCenter('content/input_daftar_barang.php', 'myPop1',400,400);" value="Tambah Data">
								-->
						  <div id="container"> Cari No. SPP:
						    <input type="text" name="cari" value="" id="inputString" onkeyup="lookup(this.value);" onblur="fill();" size="18">
							  &nbsp;
							  <input name="submit" type="submit" value="Cari">
							  <!-- hide our suggesetion box to begin with-->
							  <div class="suggestionsBox" id="suggestions" style="display: none;" align="left"> <img src="upArrow.png" style="position: relative; top: -18px; left: 150px;" alt="upArrow" />
								  <div class="suggestionList" id="autoSuggestionsList"></div>
							  </div>
					      </div></td>
						  </form>
							
							<td align="right" width="70px">
							<?php
									echo '<form method=post action=home.php?hal=action/insert_spp enctype=multipart/form-data>';
									echo "<input type=submit value='Buat Request'>";
									
									echo '</form>';
							?>							</td>
						</tr>
					</table>
					<hr>
					<div style="border:1px  solid; border-color:#CCCCCC; width:670px; height:300px; overflow:auto;">
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
						<tr>
							<td>
							<?php
									$pdate = date ("d") + 0;
									$pmonth = date("m") + 1;
									$ppmonth = date ("m") + 0;
									$pyear = date("Y") + 0;
							if ($cari)
									{
										$query2  = mysql_query ("SELECT * FROM permintaan_unit where No_SPP like '$cari%' AND Unit='".$_SESSION['U_SUBUNIT']."'ORDER BY No_SPP DESC");
									}
									else
									{
										$query2  = mysql_query ("SELECT * FROM permintaan_unit WHERE Unit='".$_SESSION['U_SUBUNIT']."' ORDER BY No_SPP DESC");
									}
							//$query2  = mysql_query ("SELECT * FROM permintaan_unit WHERE Unit='".$_SESSION['U_SUBUNIT']."' ORDER BY No_SPP DESC");
																		
							echo '<table border=0 cellpadding=2 cellspacing=2 width=100%>
									<tr bgcolor=#414141 align=center>
										<td><font color=#FFFFFF>Tanggal SPP</font></td>
										<td ><font color=#FFFFFF>No. SPP</font></td>
										<td ><font color=#FFFFFF>No. BPB</font></td>
										<td><font color=#FFFFFF>Unit</font></td>
										<td><font color=#FFFFFF width=110px>Applyed By</font></td>
										<td><font color=#FFFFFF width=80px>Status</font></td>
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
										
										
										echo "<td align=center width=80px>$result2[Tgl_SPP]</td>
											<td align=center width=110px><a href='javascript:void(0);' onClick=\"PopupCenter('content/daftar_spp.php?No_SPP=$result2[No_SPP]', 'myPop1',800,400);\">".$result2['No_SPP']."</a></td>";
											echo "<td align=center width=110px><a href='javascript:void(0);' onClick=\"PopupCenter('content/daftar_spp.php?No_SPP=$result2[No_SPP]', 'myPop1',800,400);\">".$result2[No_BPB]."</a></td>";
											$qunit = mysql_query("select * from pelayanan where id='".$result2['Unit']."'");
											$runit = mysql_fetch_array($qunit);
											
											echo "<td align=center>".$runit['nama']."</td>";										
											
											$qstatus = mysql_query("select * from status where id='".$result2['status']."'");
											$rstatus = mysql_fetch_array($qstatus);
											
											echo "<td align=center>".$result2['UsrBuat']."</td>";	
											echo "<td align=center>".$rstatus['nama']."</td>";

																
									/*		if ($result2['flags_unit']==1)
											{
												echo "<td align=center><a href='home.php?hal=content/lihat_status_spp&No_SPP=$result2[No_SPP]&UsrBuat=".$_SESSION['U_USER']."' style=visibility:hidden>Terima Barang</a></td>";
											}
											elseif (($result2['status']==2) AND ($result2['Unit'] == $_SESSION['U_SUBUNIT']))
											{
												echo "<td align=center><a href='home.php?hal=content/lihat_status_spp&No_SPP=$result2[No_SPP]&UsrBuat=".$_SESSION['U_USER']."'>Terima Barang</a></td>";
											}
											else
											{
												echo "<td align=center><a href='home.php?hal=content/lihat_status_spp&No_SPP=$result2[No_SPP]&UsrBuat=".$_SESSION['U_USER']."' style=visibility:hidden>Terima Barang</a></td>";
											}*/
											
										echo "</tr>";
										$no++;
									}
									$no_f=$no-1;
									echo'</table>';
							?>
							</td>
						</tr>
					</table>
					</div>
					</font>
					</td>
					<td width="15px">&nbsp;</td>
				</tr>
		</table>
	</tr>
	<tr>
		<td><img src="images/bawah_isi.png"></td>
	</tr>
</table>
</body>

</html>