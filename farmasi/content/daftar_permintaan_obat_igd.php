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
			$.post("action/string_daftar_barang.php", {mysearchString: ""+inputString+""}, function(data){
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
				<td width="300px" bgcolor="#9b9999">&nbsp;&nbsp;<font style="font-size:14px; " color="#fefafa"><b>Daftar Obat</b></font></td>
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
							<td align="right">
								<div id="container">
								<form method="post" action="home.php?hal=content/daftar_permintaan_obat_igd" enctype="multipart/form-data">
								Cari Kode Obat : <input type="text" name="cari" value="" id="inputString" onkeyup="lookup(this.value);" onblur="fill();" size="15">
								<?php
									echo "<input type=hidden name=no_SPP value='$no_SPP'>
											<input type=hidden readonly=true value='$tgl' name=tgl>
											<input type=hidden readonly=true value='$id' name=id>";
								?>
								&nbsp;<input type="submit" value="Cari"> &nbsp;
								</form>
								<!-- hide our suggesetion box to begin with-->
    							<div class="suggestionsBox" id="suggestions" style="display: none;" align="left">
        							<img src="upArrow.png" style="position: relative; top: -18px; left: 150px;" alt="upArrow" />
        						<div class="suggestionList" id="autoSuggestionsList"></div>
    							</div>
								</div>
							</td>
						</tr>
					</table>
					<hr>
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
						<tr>
							<td>
								<?php
									if ($_POST['no_SPP'])
									{
									$no_SPP = $_POST['no_SPP'];
									$id = $_POST['id'];
									$tgl = $_POST['tgl'];
									}
									else
									{
									$no_SPP = $_GET['no_SPP'];
									$id = $_GET['id'];
									$tgl = $_GET['tgl'];
									}
									$rowsPerPage = 20;


									$pageNum = 1;

									if(isset($_GET['page']))
									{
    									$pageNum = $_GET['page'];
									}

									$offset = ($pageNum - 1) * $rowsPerPage;
									
									if ($cari)
									{
									$query  = mysql_query ("SELECT * FROM ms_barang WHERE  flags='1' AND 
									kd_barang LIKE '$cari%' ORDER BY ex_year,ex_month,ex_date ASC ");
									}
									else
									{
									$query  = mysql_query ("SELECT * FROM ms_barang WHERE  flags='1'  ORDER BY ex_year,ex_month,ex_date ASC
											   LIMIT $offset, $rowsPerPage");
									}
									
									echo '<table cellpadding=2 cellspacing=2 width=100% style="border:1px  solid  #CCCCCC; ">
											<tr bgcolor=#414141 align=center>
												<td><font color=#FFFFFF width=70px>Kode</font></td>
												<td><font color=#FFFFFF>Nama Obat</font></td>
												<td><font color=#FFFFFF>Harga</font></td>
												<td><font color=#FFFFFF>Stok</font></td>
												<td><font color=#FFFFFF width=60px>Action</font></td>
											</tr>';
											
									$no = 1;
									while ($result = mysql_fetch_array($query))
									{
								/*	$qms=mysql_query("select * from ms_barang where id='$result[barang_id]'");
											$rms=mysql_fetch_array($qms); */
										if ($no%2)
										{
												echo "<tr valign=top>";
										}
										else
										{
											echo "<tr bgcolor=#CCCCCC valign=top style=font-color:#FF0000>";
										}
										
										
										echo "<td width=70px>$result[kd_barang]</td>";
											
											echo "<td>$result[nama]</td>
											<td align=right>";
											rupiah($result[harga_dosp]);
											echo "</td>
											<td align=right>$result[stok]</td>
											<td align=center width=60px>
											<form method=post action='home.php?hal=content/input_permintaan_obat_igd' enctype=multipart/form-data>
											<input type=hidden name=kd_barang value='$result[kd_barang]'>
											<input type=hidden name=no_SPP value='$no_SPP'>
											<input type=hidden readonly=true value='$tgl' name=tgl>
											<input type=hidden readonly=true value='$id' name=id>
											<input type=Submit value=Pilih>
											</form>
											</td>
											</tr>";
										$no++;
									}
									echo '</table><br>';
									

									echo '<div align=center><br>';

									$query   = "SELECT COUNT(kd_barang) AS numrows FROM ms_barang WHERE  flags='1' ORDER BY ex_year,ex_month,ex_date ASC";
									$result  = mysql_query($query) or die('Error, query failed');
									$row     = mysql_fetch_array($result, MYSQL_ASSOC);
									$numrows = $row['numrows'];

									$maxPage = ceil($numrows/$rowsPerPage);

									$self = $_SERVER['PHP_SELF'];

									if ($pageNum > 1)
									{
   										$page = $pageNum - 1;
   								   	 	$prev = " <a href=\"$self?page=$page&hal=content/daftar_permintaan_obat_igd&no_SPP=$no_SPP&tgl=$tgl&id=$id\"><font color='#565957' size=-1>[&laquo;]</font></a> ";

    									$first = " <a href=\"$self?page=1&hal=content/daftar_permintaan_obat_igd&no_SPP=$no_SPP&tgl=$tgl&id=$id\"><font color='#565957' size=-1>[&laquo;&laquo;]</font></a> ";
									}
									else
									{
   			 							$prev  = ' [&laquo;] ';
										$first = ' [&laquo;&laquo;] ';
									}

									if ($pageNum < $maxPage)
									{
    									$page = $pageNum + 1;
    									$next = " <a href=\"$self?page=$page&hal=content/daftar_permintaan_obat_igd&no_SPP=$no_SPP&tgl=$tgl&id=$id\"><font color='#565957' size=-1>[&raquo;]</font></a> ";

    									$last = " <a href=\"$self?page=$maxPage&hal=content/daftar_permintaan_obat_igd&no_SPP=$no_SPP&tgl=$tgl&id=$id\"><font color='#565957' size=-1>[&raquo;&raquo;]</font></a> ";
									}
									else
									{
   										$next = ' [&raquo;] ';
    									$last = ' [&raquo;&raquo;] ';
									}

										echo $first . $prev . "Halaman <strong>$pageNum</strong> dari <strong>$maxPage</strong> " . $next . $last;
									echo '</div>';

								?>
							</td>
						</tr>
					</table>
					
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
