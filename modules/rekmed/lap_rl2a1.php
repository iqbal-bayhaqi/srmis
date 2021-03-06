<?
$_TITLE = "Laporan RL2a1 (Data Keadaan Morbiditas Rawat Inap Surveilans)";

Class Laporan_RL2a1 {

	function get_lap_rl2a1($val) {
		$objResponse = new xajaxResponse;
		$dtd = array('292.0','292.2','292.4','292.6','292.8');
		$dtd_kecuali = implode("','", $dtd);
		$kon = new Konek;
		$sql = "
			SELECT
				i.no_dtd as no_dtd,
				i.kode_icd as kode_icd,
				i.gol_sebab_sakit as gol_sebab_sakit,
				p.tgl_lahir as tgl_lahir,
				kk.tgl_keluar as tgl_keluar,
				p.sex as sex,
				k.keadaan_keluar as keadaan_keluar
			FROM
				kunjungan_kamar kk
				JOIN kunjungan k ON (k.id = kk.kunjungan_id)
				JOIN pasien p ON (p.id = k.pasien_id)
				JOIN kamar kmr ON (kmr.id = kk.kamar_id)
				JOIN pelayanan pel ON (pel.id = kmr.pelayanan_id)
				JOIN icd i ON (i.id = kk.diagnosa_utama_id)
			WHERE
				kk.tgl_keluar IS NOT NULL
				AND pel.jenis = 'RAWAT INAP'
				AND kk.kelanjutan IN ('DIRUJUK', 'PULANG')
				AND i.no_dtd NOT IN ('" . $dtd_kecuali . "')
				AND EXTRACT(YEAR_MONTH FROM kk.tgl_keluar) = EXTRACT(YEAR_MONTH FROM '".$val[tahun]."-".$val[bulan]."-01')
			ORDER BY i.no_dtd
		";
		//$objResponse->addAssign("debug", "innerHTML", $sql);
		$kon->sql = $sql;
		$kon->execute();
		$data = $kon->getAll();
		$baru = array();
		$s = 0;
		for($i=0;$i<sizeof($data);$i++) {
			$umur = hitungUmur($data[$i][tgl_lahir], $data[$i][tgl_keluar]);
			$umur_tahun = $umur[tahun];
			$umur_hari = $umur[hari];
			if($data[$i][no_dtd] == $data[$i-1][no_dtd]) {
				//bikin anak
				//nggabungin kode icd
				if($baru[$s][kode_icd] != $data[$i][kode_icd]) $baru[$s][kode_icd] = $baru[$s][kode_icd] . ", " . $data[$i][kode_icd];

				if($umur[tahun] > 64) {
					$baru[$s]['nam_lima'] += 1;
					$total['nam_lima'] += 1;
				} elseif ($umur[tahun] > 44) {
					$baru[$s]['pat_lima'] += 1;
					$total['pat_lima'] += 1;
				} elseif ($umur[tahun] > 24) {
					$baru[$s]['dua_lima'] += 1;
					$total['dua_lima'] += 1;
				} elseif ($umur[tahun] > 14) {
					$baru[$s]['lima_belas'] += 1;
					$total['lima_belas'] += 1;
				} elseif ($umur[tahun] > 4) {
					$baru[$s]['lima'] += 1;
					$total['lima'] += 1;
				} elseif ($umur[tahun] >=1) {
					$baru[$s]['satu'] += 1;
					$total['satu'] += 1;
				} elseif ($umur[hari] > 27) {
					$baru[$s]['dua_lapan'] += 1;
					$total['dua_lapan'] += 1;
				} else {
					$baru[$s]['nol'] += 1;
					$total['nol'] += 1;
				}
				//sex
				if($data[$i][sex] == "LAKI-LAKI") {
					$baru[$s][sex_laki] += 1;
					$total['sex_laki'] += 1;
					$total['total'] += 1;
				} else {
					$baru[$s][sex_prp] += 1;
					$total['sex_prp'] += 1;
					$total['total'] += 1;
				}
				if($data[$i][keadaan_keluar] == "MATI < 48 JAM" || $data[$i][keadaan_keluar] == "MATI >= 48 JAM") {
					$baru[$s][mati] += 1;
					$total['mati'] += 1;
				}
				$baru[$s][total] = $baru[$s][sex_prp] + $baru[$s][sex_laki];
			} else {
				//bikin embok
				if($i!=0) {
					$s++;
				}
				$baru[$s][no_dtd] = $data[$i][no_dtd];
				$baru[$s][kode_icd] = $data[$i][kode_icd];
				$baru[$s][gol_sebab_sakit] = $data[$i][gol_sebab_sakit];
				$baru[$s][tgl_lahir] = $data[$i][tgl_lahir];
				$baru[$s][tgl_keluar] = $data[$i][tgl_keluar];
				if($umur[tahun] > 64) {
					$baru[$s]['nam_lima'] = 1;
					$total['nam_lima'] += 1;
				} elseif ($umur[tahun] > 44) {
					$baru[$s]['pat_lima'] = 1;
					$total['pat_lima'] += 1;
				} elseif ($umur[tahun] > 24) {
					$baru[$s]['dua_lima'] = 1;
					$total['dua_lima'] += 1;
				} elseif ($umur[tahun] > 14) {
					$baru[$s]['lima_belas'] = 1;
					$total['lima_belas'] += 1;
				} elseif ($umur[tahun] > 4) {
					$baru[$s]['lima'] = 1;
					$total['lima'] += 1;
				} elseif ($umur[tahun] >=1) {
					$baru[$s]['satu'] = 1;
					$total['satu'] += 1;
				} elseif ($umur[hari] > 27) {
					$baru[$s]['dua_lapan'] = 1;
					$total['dua_lapan'] += 1;
				} else {
					$baru[$s]['nol'] = 1;
					$total['nol'] += 1;
				}

				//sex
				if($data[$i][sex] == "LAKI-LAKI") {
					$baru[$s][sex_laki] = 1;
					$total['sex_laki'] += 1;
					$total['total'] += 1;
				} else {
					$baru[$s][sex_prp] = 1;
					$total['sex_prp'] += 1;
					$total['total'] += 1;
				}
				if($data[$i][keadaan_keluar] == "MATI < 48 JAM" || $data[$i][keadaan_keluar] == "MATI >= 48 JAM") {
					$baru[$s][mati] = 1;
					$total['mati'] += 1;
				}
				$baru[$s][total] = $baru[$s][sex_prp] + $baru[$s][sex_laki];
			}
		}
		$tabel_all = new Table;
		$tabel_all->scroll = false;
		$tabel_all->extra_table = "style=\"width:27cm;margin:0\"";
		$tabel_all->cellspacing="0";
		$tabel_all->css_table="";
		$tabel_all->anime_bg_color="";
		$tabel_header = new Table;
		$tabel_header->scroll = false;
		$tabel_header->extra_tr_th = "";
		$tabel_header->cellspacing="0";
		$tabel_header->css_table="";
		$tabel_header->anime_bg_color="";
		$tabel_header->extra_table = "style=\"width:27cm;border:0;\"";
		$tabel_header->addTh("","DATA KEADAAN MORBIDITAS RAWAT INAP SURVEILANS TERPADU RUMAH SAKIT<br />BULAN : ".bulanIndo($val[bulan], "F")."<br />TAHUN : ".$val[tahun]."");
		//$tabel_header->addExtraTh("colspan=\"3\"");
		$tabel_header->addRow("","","Formulir RL2a1");
		//$tabel_header->addExtraTh();
		$tabel_header->addRow($_SESSION[setting][rs_nama], "", "No. Kode RS : " . $_SESSION[setting][rs_kode]);
		//$tabel_header->addExtraTh("colspan=\"3\"");

		$tabel_isi = new Table;
		$tabel_isi->scroll = false;
		$tabel_isi->cellspacing="0";
		$tabel_isi->extra_table = "style=\"width:27cm;font-size:7pt;\"";
		$tabel_header->css_table="";
		$tabel_isi->addTh(
			"NO. URUT", 
			"NO. DTD", 
			"NO. DAFTAR<br />TERPERINCI", 
			"GOLONGAN SEBAB-SEBAB SAKIT", 
			"PASIEN KELUAR (HIDUP &amp; MATI)<br />MENURUT GOLONGAN UMUR", 
			"PASIEN KELUAR<br />(HIDUP &amp; MATI)<br />MENURUT SEX", 
			"JUMLAH<br />PASIEN<br />KELUAR<br />(13+14)", 
			"JUMLAH<br />PASIEN<br />KELUAR<br />MATI"
		);
		$tabel_isi->addExtraTh("rowspan=\"2\"", "rowspan=\"2\"", "rowspan=\"2\"", "rowspan=\"2\"", "colspan=\"8\"", "colspan=\"2\"", "rowspan=\"2\"", "rowspan=\"2\"");
		$tabel_isi->addTh("0-28 HR", "28 HR - &lt;1 TH", "1-4 TH", "5-14 TH", "15-24 TH", "25-44 TH", "45-64 TH", "65+ TH", "LK", "PR");
		$tabel_isi->addTh("1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16");
		for($i=0;$i<sizeof($baru);$i++) {
			$tabel_isi->addRow(
				($i+1),
				$baru[$i][no_dtd],
				$baru[$i][kode_icd],
				$baru[$i][gol_sebab_sakit],
				$baru[$i][nol],
				$baru[$i][dua_lapan],
				$baru[$i][satu],
				$baru[$i][lima],
				$baru[$i][lima_belas],
				$baru[$i][dua_lima],
				$baru[$i][pat_lima],
				$baru[$i][nam_lima],
				$baru[$i][sex_laki],
				$baru[$i][sex_prp],
				$baru[$i][total],
				$baru[$i][mati]
			);
		}
		$tabel_isi->addRow(
			"","","","Total", 
			$total[nol], 
			$total[dua_lapan], 
			$total[satu], 
			$total[lima], 
			$total[lima_belas], 
			$total[dua_lima], 
			$total[pat_lima], 
			$total[nam_lima], 
			$total[sex_laki], 
			$total[sex_prp], 
			$total[total], 
			$total[mati]
		);
		$ret_tabel_header = $tabel_header->build();
		$ret_tabel_isi = $tabel_isi->build();
		$tabel_all->addRow($ret_tabel_header);
		$tabel_all->addRow($ret_tabel_isi);
		$ret = $tabel_all->build();
		unset($_SESSION[rekmed][lap_rl2a1]);
		$cetak = new Cetak;
		$tanda_tangan = $cetak->setTandaTangan();
		$ret .= $tanda_tangan;
		$_SESSION[rekmed][lap_rl2a1] = $ret;
		$objResponse->addAssign("list_data", "innerHTML", $ret);
		return $objResponse;
	}

}
$_xajax->registerFunction(array("get_lap_rl2a1", "Laporan_RL2a1", "get_lap_rl2a1"));
?>