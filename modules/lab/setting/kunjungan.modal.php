<?

Class Kunjungan_Modal {

	function buka_kunjungan($id_kunjungan_kamar) {
		$objResponse = new xajaxResponse;
		$kon = new Konek;
		$sql = "
			SELECT 
				k.id as id_kunjungan,
				k.kunjungan_ke as kunjungan_ke,
				k.cara_masuk as cara_masuk,
				kk.cara_bayar as cara_bayar,
				k.perujuk_id as perujuk_id,
				kk.nomor as nomor,
				kk.pj_nama as pj_nama,
				kk.pj_alamat as pj_alamat,
				kk.pj_telp as pj_telp,
				kk.pj_hubungan_keluarga as pj_hubungan_keluarga,
				CONCAT_WS('-', SUBSTRING(p.id, 1,2), SUBSTRING(p.id, 3,2), SUBSTRING(p.id, 5,2), SUBSTRING(p.id, 7,2)) as no_rm,
				p.id as pasien_id,
				p.nama as nama,
				p.tgl_lahir as tgl_lahir,
				p.sex as jk,
				kk.id as id_kunjungan_kamar,
				DATE_FORMAT(kk.tgl_daftar, '%Y-%m-%d-%H-%i-%s') as tgl_daftar,
				DATE_FORMAT(kk.tgl_periksa, '%Y-%m-%d-%H-%i-%s') as tgl_periksa,
				DATE_FORMAT(kk.tgl_keluar, '%Y-%m-%d-%H-%i-%s') as tgl_keluar,
				kk.dokter_id as id_dokter,
				kk.kelanjutan as kelanjutan,
				kmr.id as id_kamar,
				pel.id as id_pelayanan,
				pel.jenis as jenis,
				
				kk.diagnosa_utama_id as diagnosa_utama_id,
				IF(i.id IS NULL, '&nbsp;', CONCAT(i.kode_icd, ' - ', i.nama)) as diagnosa_utama_nama
				
				
			FROM 
				kunjungan k
				JOIN pasien p ON (p.id = k.pasien_id)
				JOIN kunjungan_kamar kk ON (kk.kunjungan_id = k.id)
				JOIN kamar kmr ON (kmr.id = kk.kamar_id)
				JOIN pelayanan pel ON (pel.id = kmr.pelayanan_id)

				LEFT JOIN icd i ON (i.id = kk.diagnosa_utama_id)
			WHERE
				kk.id = '".$id_kunjungan_kamar."'
		";
		$kon->sql = $sql;
		$kon->execute();
		$data = $kon->getOne();
		
		//get data tindakan
		$kon->sql = "
			SELECT
				kkic.id as kunjungan_tindakan_id,
				ic.id as tindakan_id,
				ic.nama as tindakan_nama
			FROM
				kunjungan_kamar_icopim kkic
				JOIN icopim ic ON (ic.id = kkic.icopim_id)
			WHERE
				kkic.kunjungan_kamar_id = '".$id_kunjungan_kamar."'
			GROUP BY 
				kkic.id
		";
		$kon->execute();
		$data_ic = $kon->getAll();

		
		//get data BHP
		$kon->sql = "
			SELECT
				kkbhp.id as kunjungan_bhp_id,
				bhp.id as bhp_id,
				bhp.nama as bhp_nama
			FROM
				kunjungan_kamar_bhp kkbhp
				JOIN bhp ON (bhp.id = kkbhp.bhp_id)
			WHERE
				kkbhp.kunjungan_kamar_id = '".$id_kunjungan_kamar."'
			GROUP BY 
				kkbhp.id
		";
		$kon->execute();
		$data_bhp = $kon->getAll();
/*
		//get data im
		$kon->sql = "
			SELECT
				kki.id as kunjungan_imunisasi_id,
				im.id as imunisasi_id,
				im.nama as imunisasi_nama
			FROM
				kunjungan_kamar_imunisasi kki
				JOIN imunisasi im ON (im.id = kki.imunisasi_id)
			WHERE
				kki.kunjungan_kamar_id = '".$id_kunjungan_kamar."'
			GROUP BY
				kki.id
		";
		$kon->execute();
		$data_im = $kon->getAll();
		//$objResponse->addAlert(print_r($data_im));
*/
		$skr = date("Y-m-d");
		$usia = hitungUmur($data[tgl_lahir], $skr);
		$umur = empty($usia[tahun])?"":$usia[tahun] . "&nbsp;th&nbsp;&nbsp;";
		$umur .= empty($usia[bulan])?"":$usia[bulan] . "&nbsp;bl&nbsp;&nbsp;";
		$umur .= empty($usia[hari])?"":$usia[hari] . "&nbsp;hr&nbsp;&nbsp;";
		
		//$objResponse->addAssign("debug", "innerHTML", $sql);
		//info utama
		$objResponse->addAssign("input_no_rm", "innerHTML", $data[no_rm]);
		$objResponse->addAssign("input_pasien", "innerHTML", $data[nama]);
		$objResponse->addAssign("input_sex", "innerHTML", $data[jk]);
		$objResponse->addAssign("input_usia", "innerHTML", $umur);
		$objResponse->addAssign("input_id_kunjungan_kamar", "value", $data[id_kunjungan_kamar]);
		$objResponse->addAssign("input_id_kunjungan", "value", $data[id_kunjungan]);

		//tab data_kunjungan
		$objResponse->addAssign("input_jenis", "value", $data[jenis]);
		$objResponse->addScriptCall("xajax_ref_get_pelayanan", "input_pelayanan_id", $data[jenis], $data[id_pelayanan]);
		$objResponse->addScriptCall("xajax_ref_get_kamar", "input_kamar_id", $data[id_pelayanan], $data[id_kamar]);
		$objResponse->addScriptCall("xajax_ref_get_dokter", "input_dokter_id", $data[id_pelayanan], $data[id_dokter]);
		$objResponse->addAssign("input_kelanjutan", "value", $data[kelanjutan]);
		
		$tgl_daftar = explode("-", $data[tgl_daftar]);
		$objResponse->addAssign("input_tgl_daftar_tgl", "value", $tgl_daftar[2]);
		$objResponse->addAssign("input_tgl_daftar_bln", "value", $tgl_daftar[1]);
		$objResponse->addAssign("input_tgl_daftar_thn", "value", $tgl_daftar[0]);

		$objResponse->addAssign("input_tgl_daftar_jam", "value", $tgl_daftar[3]);
		$objResponse->addAssign("input_tgl_daftar_mnt", "value", $tgl_daftar[4]);
		$objResponse->addAssign("input_tgl_daftar_dtk", "value", $tgl_daftar[5]);

		$tgl_periksa = explode("-", $data[tgl_periksa]);
		$objResponse->addAssign("input_tgl_periksa_tgl", "value", $tgl_periksa[2]);
		$objResponse->addAssign("input_tgl_periksa_bln", "value", $tgl_periksa[1]);
		$objResponse->addAssign("input_tgl_periksa_thn", "value", $tgl_periksa[0]);

		$objResponse->addAssign("input_tgl_periksa_jam", "value", $tgl_periksa[3]);
		$objResponse->addAssign("input_tgl_periksa_mnt", "value", $tgl_periksa[4]);
		$objResponse->addAssign("input_tgl_periksa_dtk", "value", $tgl_periksa[5]);

		$tgl_keluar = explode("-", $data[tgl_keluar]);
		$objResponse->addAssign("input_tgl_keluar_tgl", "value", $tgl_keluar[2]);
		$objResponse->addAssign("input_tgl_keluar_bln", "value", $tgl_keluar[1]);
		$objResponse->addAssign("input_tgl_keluar_thn", "value", $tgl_keluar[0]);

		$objResponse->addAssign("input_tgl_keluar_jam", "value", $tgl_keluar[3]);
		$objResponse->addAssign("input_tgl_keluar_mnt", "value", $tgl_keluar[4]);
		$objResponse->addAssign("input_tgl_keluar_dtk", "value", $tgl_keluar[5]);


		//tab diagnosa_tindakan
		$objResponse->addAssign("input_diagnosa_utama", "value", $data[diagnosa_utama_id]);
		$objResponse->addAssign("input_diagnosa_utama_nama", "innerHTML", $data[diagnosa_utama_nama]);
		$objResponse->addScriptCall("xajax_add_button_tindakan", 1, $data_ic);
		$objResponse->addScriptCall("xajax_add_button_bhp", 1, $data_bhp);
		$objResponse->addScriptCall("xajax_add_button_imunisasi", 1, $data_im);

		//tab data_lain
		$objResponse->addAssign("input_kunjungan_ke", "value", $data[kunjungan_ke]);
		$objResponse->addAssign("input_cara_masuk", "value", $data[cara_masuk]);
		$objResponse->addScriptCall("xajax_ref_get_perujuk", "input_perujuk_id", $data[cara_masuk], $data[perujuk_id]);
		$objResponse->addAssign("input_cara_bayar", "value", $data[cara_bayar]);
		$objResponse->addScriptCall("showNomor", $data[cara_bayar]);
		$objResponse->addAssign("input_nomor", "value", $data[nomor]);
		$objResponse->addAssign("input_pj_nama", "value", $data[pj_nama]);
		$objResponse->addAssign("input_pj_alamat", "value", $data[pj_alamat]);
		$objResponse->addAssign("input_pj_telp", "value", $data[pj_telp]);
		$objResponse->addAssign("input_pj_hubungan_keluarga", "value", $data[pj_hubungan_keluarga]);

		//list kunjungan yg pernah dilakukan
		$objResponse->addScriptCall("xajax_tab_list_semua_kunjungan", '0', $data[pasien_id]);

		//tampilkan modal window input kunjungan
		$objResponse->addClear("modal_kunjungan", "style.display");
		return $objResponse;
	}

	function simpan_kunjungan($value, $kunjungan_baru = false) {
		$cleaner = new FormCleaner;
		$cleaner->setValue($value);
		$cleaner->clean();
		$val = $cleaner->getValue();
		if($kunjungan_baru == false) {
		//update
			$sql = "
			UPDATE
				kunjungan k 
				JOIN kunjungan_kamar kk ON (kk.kunjungan_id = k.id)
			SET
				k.kunjungan_ke = NULLIF('".$val[input_kunjungan_ke]."',''),
				k.cara_masuk = NULLIF('".$val[input_cara_masuk]."',''),
				k.perujuk_id = NULLIF('".$val[input_perujuk_id]."', ''),
				kk.cara_bayar = NULLIF('".$val[input_cara_bayar]."',''),
				kk.nomor = '".$val[input_nomor]."',
				kk.pj_nama = '".$val[input_pj_nama]."',
				kk.pj_alamat = '".$val[input_pj_alamat]."',
				kk.pj_telp = '".$val[input_pj_telp]."',
				kk.pj_hubungan_keluarga = NULLIF('".$val[input_pj_hubungan_keluarga]."',''),

				kk.kamar_id = NULLIF('".$val[input_kamar_id]."', ''),
				kk.dokter_id = NULLIF('".$val[input_dokter_id]."', ''),
				kk.kelanjutan = NULLIF('".$val[input_kelanjutan]."',''),
				kk.tgl_daftar = '".$val[input_tgl_daftar_thn]."-".$val[input_tgl_daftar_bln]."-".$val[input_tgl_daftar_tgl]." ".$val[input_tgl_daftar_jam].":".$val[input_tgl_daftar_mnt].":".$val[input_tgl_daftar_dtk]."',
				kk.tgl_periksa = '".$val[input_tgl_periksa_thn]."-".$val[input_tgl_periksa_bln]."-".$val[input_tgl_periksa_tgl]." ".$val[input_tgl_periksa_jam].":".$val[input_tgl_periksa_mnt].":".$val[input_tgl_periksa_dtk]."',
				kk.tgl_keluar = '".$val[input_tgl_keluar_thn]."-".$val[input_tgl_keluar_bln]."-".$val[input_tgl_keluar_tgl]." ".$val[input_tgl_keluar_jam].":".$val[input_tgl_keluar_mnt].":".$val[input_tgl_keluar_dtk]."',
				
				kk.diagnosa_utama_id = NULLIF('".$val[input_diagnosa_utama]."', '')
			WHERE
				kk.id = '".$val[input_id_kunjungan_kamar]."'
		";
		} else {
			$sql = "
			INSERT INTO
				kunjungan_kamar(
					kunjungan_id, 
					kamar_id, 
					dokter_id, 
					kelanjutan,
					tgl_daftar,
					tgl_periksa, 
					tgl_keluar,
					diagnosa_utama_id
				) 
			VALUES (
				'".$val[input_id_kunjungan]."',
				NULLIF('".$val[input_kamar_id]."', ''),
				NULLIF('".$val[input_dokter_id]."', ''),
				NULLIF('".$val[input_kelanjutan]."',''),
				'".$val[input_tgl_daftar_thn]."-".$val[input_tgl_daftar_bln]."-".$val[input_tgl_daftar_tgl]."',
				'".$val[input_tgl_periksa_thn]."-".$val[input_tgl_periksa_bln]."-".$val[input_tgl_periksa_tgl]."',
				'".$val[input_tgl_keluar_thn]."-".$val[input_tgl_keluar_bln]."-".$val[input_tgl_keluar_tgl]."',
				NULLIF('".$val[input_diagnosa_utama]."', '')
				)
			";
		}
		//}
		$kon = new Konek;
		$kon->sql = $sql;
		$kon->execute();
		$afek = $kon->affected_rows;
		$objResponse = new xajaxResponse();
		//$objResponse->addAssign("debug", "innerHTML", $sql);
		//ins upd del tindakan
		$is_insert_ic = false;
		for($i=0;$i<sizeof($val[input_tindakan]);$i++) {
			if(!$val[input_kunjungan_tindakan_id][$i] && $val[input_tindakan][$i]) {
				//insert
				$arr_insert_ic[] = "('".$val[input_id_kunjungan_kamar]."','".$val[input_tindakan][$i]."')";
				$is_insert_ic = true;
			} elseif($val[input_kunjungan_tindakan_id][$i] && $val[input_tindakan][$i]) {
				//update
				$kon->sql = "UPDATE kunjungan_kamar_icopim SET icopim_id = '".$val[input_tindakan][$i]."' WHERE id = '".$val[input_kunjungan_tindakan_id][$i]."'";
				$kon->execute();
			} elseif($val[input_kunjungan_tindakan_id][$i] && !$val[input_tindakan][$i]) {
				//delete
				$kon->sql = "DELETE FROM kunjungan_kamar_icopim WHERE id = '".$val[input_kunjungan_tindakan_id][$i]."'";
				$kon->execute();
			}
		}

		//extended insert tindakan
		if($is_insert_ic == true) {
			$inserted_ic = implode(", ", $arr_insert_ic);
			$kon->sql = "INSERT INTO kunjungan_kamar_icopim (kunjungan_kamar_id, icopim_id) VALUES " . $inserted_ic;	
			$kon->execute();
		}

		$is_insert_bhp = false;
		for($i=0;$i<sizeof($val[input_bhp]);$i++) {
			if(!$val[input_kunjungan_bhp_id][$i] && $val[input_bhp][$i]) {
				//insert
				$arr_insert_bhp[] = "('".$val[input_id_kunjungan_kamar]."','".$val[input_bhp][$i]."')";
				$is_insert_bhp = true;
			} elseif($val[input_kunjungan_bhp_id][$i] && $val[input_bhp][$i]) {
				//update
				$kon->sql = "UPDATE kunjungan_kamar_bhp SET bhp_id = '".$val[input_bhp][$i]."' WHERE id = '".$val[input_kunjungan_bhp_id][$i]."'";
				$kon->execute();
			} elseif($val[input_kunjungan_bhp_id][$i] && !$val[input_bhp][$i]) {
				//delete
				$kon->sql = "DELETE FROM kunjungan_kamar_bhp WHERE id = '".$val[input_kunjungan_bhp_id][$i]."'";
				$kon->execute();
			}
		}

		//extended insert bhp
		if($is_insert_bhp == true) {
			$inserted_bhp = implode(", ", $arr_insert_bhp);
			$kon->sql = "INSERT INTO kunjungan_kamar_bhp (kunjungan_kamar_id, bhp_id) VALUES " . $inserted_bhp;	
			$kon->execute();
		}


		$is_insert_im = false;
		//ins upd del imunisasi
		for($i=0;$i<sizeof($val[input_imunisasi]);$i++) {
			if(!$val[input_kunjungan_imunisasi_id][$i] && $val[input_imunisasi][$i]) {
				//insert
				$arr_insert_im[] = "('".$val[input_id_kunjungan_kamar]."','".$val[input_imunisasi][$i]."')";
				$is_insert_im = true;
			} elseif($val[input_kunjungan_imunisasi_id][$i] && $val[input_imunisasi][$i]) {
				//update
				$kon->sql = "UPDATE kunjungan_kamar_imunisasi SET imunisasi_id = '".$val[input_imunisasi][$i]."' WHERE id = '".$val[input_kunjungan_imunisasi_id][$i]."'";
				$kon->execute();
			} elseif($val[input_kunjungan_imunisasi_id][$i] && !$val[input_imunisasi][$i]) {
				//delete
				$kon->sql = "DELETE FROM kunjungan_kamar_imunisasi WHERE id = '".$val[input_kunjungan_imunisasi_id][$i]."'";
				$kon->execute();
			}
		}

		//extended insert im
		if($is_insert_im == true) {
			$inserted_im = implode(", ", $arr_insert_im);
			$kon->sql = "INSERT INTO kunjungan_kamar_imunisasi (kunjungan_kamar_id, imunisasi_id) VALUES " . $inserted_im;	
			$kon->execute();
		}

		if($afek < 0) {
			$objResponse->addAlert("Data Kunjungan Tidak Dapat Disimpan\nCek kembali nomor kunjungan");
		} else {
			$objResponse->addScriptCall("list_data", "0");
			$objResponse->addScriptCall("xajax_tutup_kunjungan");
			$objResponse->addScriptCall("show_status_simpan");
		}
		return $objResponse;
	}

	function simpan_kunjungan_check($val) {
		$objResponse = new xajaxResponse;
		$objResponse->addScriptCall("xajax_simpan_kunjungan", $val);
		return $objResponse;
	}

	function tutup_kunjungan() {
		$objResponse = new xajaxResponse;
		$objResponse->addAssign("modal_kunjungan", "style.display", "none");
		$objResponse->addAssign("input_diagnosa_utama_nama", "innerHTML", "&nbsp;");
		
		$objResponse->addClear("tabel_input_tindakan", "innerHTML");
		$objResponse->addClear("tabel_input_bhp", "innerHTML");
		$objResponse->addClear("tabel_input_imunisasi", "innerHTML");

		$objResponse->addClear("tab_list_semua_kunjungan_navi", "innerHTML");
		$objResponse->addClear("tab_list_semua_kunjungan", "innerHTML");

		$objResponse->addScriptCall("tutup_diagnosa");
		$objResponse->addScriptCall("tutup_imunisasi");
		$objResponse->addScriptCall("ref_clear_form", "input_kunjungan");
		return $objResponse;
	}

	function set_content_tab($divId) {
		$arr_tab_id = array("tab_data_kunjungan", "tab_diagnosa_tindakan", "tab_data_lain");
		for($i=0;$i<sizeof($arr_tab_id);$i++) {
			if($arr_tab_id[$i] != $divId) {
				$new_arr[] = $arr_tab_id[$i];
			}
		}
		$objResponse = new xajaxResponse();
		for($i=0;$i<sizeof($new_arr);$i++) {
			$objResponse->addAssign($new_arr[$i], "style.display", "none");
		}
		$objResponse->addClear($divId, "style.display");
		return $objResponse;
	}

	function tab_list_semua_kunjungan($hal=0, $pasien_id) {
		$paging = new MyPagina;
		$paging->onclick_func = "xajax_tab_list_semua_kunjungan";
		$paging->setOnclickValue($pasien_id);
		$paging->rows_on_page = 10;
		$paging->hal = $hal;
		$sql = "
			SELECT 
				k.id as id_kunjungan,
				kk.id as id_kunjungan_kamar,
				k.kunjungan_ke as kunjungan_ke,
				pel.jenis as jenis_pelayanan,
				pel.nama as pelayanan,
				kmr.nama as kamar,
				kk.tgl_periksa as tgl_periksa,
				kk.tgl_keluar as tgl_keluar,
				d.nama as dokter
			FROM 
				kunjungan k
				JOIN pasien p ON (p.id = k.pasien_id)
				JOIN kunjungan_kamar kk ON (kk.kunjungan_id = k.id)
				JOIN kamar kmr ON (kmr.id = kk.kamar_id)
				JOIN pelayanan pel ON (pel.id = kmr.pelayanan_id)

				LEFT JOIN dokter d ON (d.id = kk.dokter_id)
			WHERE
				p.id = '".$pasien_id."'
			GROUP BY
				kk.id
			ORDER BY 
				k.id DESC, kk.id ASC
		";
		$paging->sql = $sql;
		$paging->get_page_result();

		$data = $paging->data;
		$no = $paging->start_number();
		$navi = $paging->navi();
		$kon = new Konek;
		$table = new Table;
		$table->addTh(
			"No", 
			"Kunjungan Ke/<br />Tanggal Kunjung", 
			"Pemeriksaan",
			"Hapus"
		);	
		$table->addExtraTh(
			"style=\"width:30px;\"",
			"style=\"width:90px;\"",
			"",
			"style=\"width:70px;\"");
		for($i=0;$i<sizeof($data);$i++) {
		
			//get data tindakan
			$kon->sql = "
				SELECT
					kkic.id as kunjungan_tindakan_id,
					ic.id as tindakan_id,
					ic.nama as tindakan_nama
				FROM
					kunjungan_kamar_icopim kkic
					JOIN icopim ic ON (ic.id = kkic.icopim_id)
				WHERE
					kkic.kunjungan_kamar_id = '".$data[$i][id_kunjungan_kamar]."'
				GROUP BY 
					kkic.id
			";
			$kon->execute();
			$data_ic = $kon->getAll();

		
			//get data bhp
			$kon->sql = "
				SELECT
					kkbhp.id as kunjungan_bhp_id,
					bhp.id as bhp_id,
					bhp.nama as bhp_nama
				FROM
					kunjungan_kamar_bhp kkbhp
					JOIN bhp ON (bhp.id = kkbhp.bhp_id)
				WHERE
					kkbhp.kunjungan_kamar_id = '".$data[$i][id_kunjungan_kamar]."'
				GROUP BY 
					kkbhp.id
			";
			$kon->execute();
			$data_bhp = $kon->getAll();

			//get data im
			$kon->sql = "
				SELECT
					kki.id as kunjungan_imunisasi_id,
					im.id as imunisasi_id,
					im.nama as imunisasi_nama
				FROM
					kunjungan_kamar_imunisasi kki
					JOIN imunisasi im ON (im.id = kki.imunisasi_id)
				WHERE
					kki.kunjungan_kamar_id = '".$data[$i][id_kunjungan_kamar]."'
				GROUP BY
					kki.id
			";
			$kon->execute();
			$data_im = $kon->getAll();
			
			$pem = "<ul>";
			
			$pem .= "<li><b>Pelayanan :</b> " . $data[$i][jenis_pelayanan] . " - " . $data[$i][kamar] . "</li>";
			$pem .= "<li><b>Dokter :</b> " . (empty($data[$i][dokter])?"-":$data[$i][dokter]) . "</li>";
			$pem .= "<li><b>Diagnosa :</b> " . (empty($data[$i][diagnosa])?"-":"<br />".$data[$i][diagnosa]) . "</li>";
			$pem .= "<li><b>Tindakan :</b> ";
				if(!empty($data_ic)) {
					$pem .= "<ol>";
					for($j=0;$j<sizeof($data_ic);$j++) {
						$pem .= "<li>" . $data_ic[$j][tindakan_nama] . "</li>";
					}
					$pem .= "</ol>";
				} else $pem .= "-";
			$pem .= "</li>";
			$pem .= "<li><b>BHP :</b> ";
				if(!empty($data_bhp)) {
					$pem .= "<ol>";
					for($j=0;$j<sizeof($data_bhp);$j++) {
						$pem .= "<li>" . $data_bhp[$j][bhp_nama] . "</li>";
					}
					$pem .= "</ol>";
				} else $pem .= "-";
			$pem .= "</li>";
			$pem .= "<li><b>Imunisasi :</b> ";
				if(!empty($data_im)) {
					$pem .= "<ol>";
					for($j=0;$j<sizeof($data_im);$j++) {
						$pem .= "<li>" . $data_im[$j][imunisasi_nama] . "</li>";
					}
					$pem .= "</ol>";
				} else $pem .= "-";
			$pem .= "</li>";
			$pem .= "</ul>";
			$table->addRow(
				($no+$i), 
				$data[$i][kunjungan_ke] . "<hr />" . tanggalIndo($data[$i][tgl_periksa], 'j M Y'),
				$pem, 
				"<input type=\"button\" value=\"[  x  ]\" name=\"hapus\" class=\"inputan\" onclick=\"xajax_hapus_kunjungan_kamar_confirm('".$data[$i][id_kunjungan]."','".$data[$i][id_kunjungan_kamar]."', this)\" />"
				);
			
			$table->addOnclickTd(
				"xajax_tab_buka_kunjungan('".$data[$i][id_kunjungan_kamar]."')",
				"xajax_tab_buka_kunjungan('".$data[$i][id_kunjungan_kamar]."')",
				"xajax_tab_buka_kunjungan('".$data[$i][id_kunjungan_kamar]."')"
			);
			/*
			$table->addRow(
				($no+$i), 
				$data[$i][kunjungan_ke], 
				$data[$i][jenis_pelayanan] . "<br />" . $data[$i][pelayanan] . "<br />" . $data[$i][kamar], 
				tanggalIndo($data[$i][tgl_periksa], 'j M Y'), 
				tanggalIndo($data[$i][tgl_keluar], 'j M Y'), 
				$data[$i][status_periksa], 
				"<input type=\"button\" value=\"[  x  ]\" name=\"hapus\" class=\"inputan\" onclick=\"xajax_hapus_kunjungan_kamar_confirm('".$data[$i][id_kunjungan]."','".$data[$i][id_kunjungan_kamar]."', this)\" />");
			$table->addOnclickTd(
				"xajax_tab_buka_kunjungan('".$data[$i][id_kunjungan_kamar]."')",
				"xajax_tab_buka_kunjungan('".$data[$i][id_kunjungan_kamar]."')",
				"xajax_tab_buka_kunjungan('".$data[$i][id_kunjungan_kamar]."')",
				"xajax_tab_buka_kunjungan('".$data[$i][id_kunjungan_kamar]."')",
				"xajax_tab_buka_kunjungan('".$data[$i][id_kunjungan_kamar]."')",
				"xajax_tab_buka_kunjungan('".$data[$i][id_kunjungan_kamar]."')",
				"xajax_tab_buka_kunjungan('".$data[$i][id_kunjungan_kamar]."')"
			);
			*/
		}
		$ret = $table->build();
		$objResponse = new xajaxResponse();
		//$objResponse->addAssign("debug", "innerHTML", $sql);
		$objResponse->addAssign("tab_list_semua_kunjungan_navi", "innerHTML", $navi);
		$objResponse->addAssign("tab_list_semua_kunjungan", "innerHTML", $ret);
		return $objResponse;
	}

	function tab_buka_kunjungan($id) {
		$objResponse = new xajaxResponse;
		$objResponse->addClear("tabel_input_tindakan", "innerHTML");
		$objResponse->addClear("tabel_input_bhp", "innerHTML");
		$objResponse->addClear("tabel_input_imunisasi", "innerHTML");

		$objResponse->addScriptCall('xajax_buka_kunjungan', $id);
		return $objResponse;
	}

}

Class Diagnosa {
	
	function cari_diagnosa($hal = 0, $val) {
		$val[diagnosa] = addslashes($val[diagnosa]);
		$q = " AND (kode_icd LIKE '%".$val[diagnosa]."%' OR nama LIKE '%".$val[diagnosa]."%' OR gol_sebab_sakit LIKE '%".$val[diagnosa]."%')";
		$paging = new MyPagina;
		$paging->rows_on_page = 10;
		$paging->hal = $hal;
		
		$paging->sql = "
			SELECT 
				id,
				REPLACE(UPPER(kode_icd), '".$val[diagnosa]."','<b>".$val[diagnosa]."</b>') as kode_icd,
				REPLACE(UPPER(nama), '".$val[diagnosa]."','<b>".$val[diagnosa]."</b>') as nama,
				REPLACE(UPPER(gol_sebab_sakit), '".$val[diagnosa]."','<b>".$val[diagnosa]."</b>') as gol_sebab_sakit
			FROM 
				icd
			WHERE
				1=1 
				$q
			ORDER BY 
				kode_icd
			";
		$paging->onclick_func = "xajax_cari_diagnosa";
		$paging->setOnclickValue("xajax.getFormValues('cari_diagnosa')");
		$paging->get_page_result();

		$diagnosa_data = $paging->data;
		$diagnosa_no = $paging->start_number();
		$diagnosa_navi = $paging->navi();
		
		$objResponse = new xajaxResponse();
		$objResponse->addAssign("diagnosa_navi", "innerHTML", $diagnosa_navi);
		$table = new Table;
		$table->addTh("No", "Kode", "Nama", "Gol. Sebab Sakit");
		$table->addExtraTh("style=\"width:40px\"", "style=\"width:40px\"", "style=\"width:200px\"");
		
		for($i=0;$i<sizeof($diagnosa_data);$i++) {
			$table->addRow(($diagnosa_no+$i), $diagnosa_data[$i]['kode_icd'], $diagnosa_data[$i]['nama'], $diagnosa_data[$i]['gol_sebab_sakit']);

			$table->addOnclickTd(
				"get_diagnosa(" . $diagnosa_data[$i][id] . ", '" . $diagnosa_data[$i]['kode_icd'] . "-" . addslashes($diagnosa_data[$i]['nama']) . "');",
				"get_diagnosa(" . $diagnosa_data[$i][id] . ", '" . $diagnosa_data[$i]['kode_icd'] . "-" . addslashes($diagnosa_data[$i]['nama']) . "');",
				"get_diagnosa(" . $diagnosa_data[$i][id] . ", '" . $diagnosa_data[$i]['kode_icd'] . "-" . addslashes($diagnosa_data[$i]['nama']) . "');",
				"get_diagnosa(" . $diagnosa_data[$i][id] . ", '" . $diagnosa_data[$i]['kode_icd'] . "-" . addslashes($diagnosa_data[$i]['nama']) . "');"
			);
		}
		$tabel = $table->build();
		$objResponse->addAssign("list_diagnosa","innerHTML", $tabel);
		return $objResponse;
	}

}

Class Tindakan {
	
	function cari_tindakan($hal = 0, $val) {
		$val[tindakan] = addslashes($val[tindakan]);
		$q = " AND nama LIKE '%".$val[tindakan]."%' ";
		$paging = new MyPagina;
		$paging->rows_on_page = 10;
		$paging->hal = $hal;
		
		$paging->sql = "
			SELECT 
				id as id,
				kode as kode,
				REPLACE(UPPER(nama), '".$val[tindakan]."','<b>".$val[tindakan]."</b>') as nama
			FROM 
				icopim
			WHERE
				1 = 1 
				$q
			ORDER BY 
				nama
			";
		
		$paging->onclick_func = "xajax_cari_tindakan";
		$paging->setOnclickValue("xajax.getFormValues('cari_tindakan')");
		$paging->get_page_result();

		$tindakan_data = $paging->data;
		$tindakan_no = $paging->start_number();
		$tindakan_navi = $paging->navi();
		
		$objResponse = new xajaxResponse();
		
		$table = new Table;
		$table->addTh("No", "Kode", "Tindakan");
		$table->addExtraTh("style=\"width:30px\"", "style=\"width:50px\"", "style=\"width:200px\"");
		for($i=0;$i<sizeof($tindakan_data);$i++) {
			$table->addRow(($tindakan_no+$i), $tindakan_data[$i]['kode'], $tindakan_data[$i]['nama']);
			$table->addOnclickTd(
				"get_tindakan(" . $tindakan_data[$i][id] . ", '" . addslashes($tindakan_data[$i]['nama']) . "', '".$val[add_btn_tindakan_again]."');",
				"get_tindakan(" . $tindakan_data[$i][id] . ", '" . addslashes($tindakan_data[$i]['nama']) . "', '".$val[add_btn_tindakan_again]."');",
				"get_tindakan(" . $tindakan_data[$i][id] . ", '" . addslashes($tindakan_data[$i]['nama']) . "', '".$val[add_btn_tindakan_again]."');"
			);
		}
		$tabel = $table->build();
		$objResponse->addAssign("tindakan_navi", "innerHTML", $tindakan_navi);
		$objResponse->addAssign("list_tindakan","innerHTML", $tabel);
		return $objResponse;
	}

	function add_button_tindakan($n, $val = array()) {
		if(!empty($val)) {
			$jml = sizeof($val);
			for($i=0;$i<$jml;$i++) {
				$ret .= "<li><a href=\"javascript:void(0)\" title=\"Edit Tindakan\" onclick=\"buka_tindakan('input_tindakan_".$i."', '0')\"><img src=\"".IMAGES_URL."add.gif\" alt=\"\" border=\"0\" /></a>&nbsp;&nbsp;<a href=\"javascript:void(0)\" title=\"Hapus Tindakan\" onclick=\"clear_tindakan('input_tindakan_".$i."')\"><img src=\"".IMAGES_URL."remove.png\" alt=\"\" border=\"0\" /></a>&nbsp;&nbsp;&nbsp;<span id=\"input_tindakan_".$i."_nama\">".$val[$i][tindakan_nama]."</span><input type=\"hidden\" name=\"input_kunjungan_tindakan_id[]\" id=\"input_kunjungan_tindakan_id_".$i."\" value=\"".$val[$i][kunjungan_tindakan_id]."\" /><input type=\"hidden\" name=\"input_tindakan[]\" id=\"input_tindakan_".$i."\" value=\"".$val[$i][tindakan_id]."\" /></li>";
			}
		} else {
			$jml = $n;
		}
		$ret .= "<li><a href=\"javascript:void(0)\" title=\"Add Tindakan\" onclick=\"buka_tindakan('input_tindakan_".$jml."', '1')\"><img src=\"".IMAGES_URL."add.gif\" alt=\"\" border=\"0\" /></a>&nbsp;&nbsp;<a href=\"javascript:void(0)\" title=\"Hapus Tindakan\" onclick=\"clear_tindakan('input_tindakan_".$jml."')\"><img src=\"".IMAGES_URL."remove.png\" alt=\"\" border=\"0\" /></a>&nbsp;&nbsp;&nbsp;<span id=\"input_tindakan_".$jml."_nama\"></span><input type=\"hidden\" name=\"input_kunjungan_tindakan_id[]\" id=\"input_kunjungan_tindakan_id_".$jml."\" value=\"\" /><input type=\"hidden\" name=\"input_tindakan[]\" id=\"input_tindakan_".$jml."\" value=\"\" /></li>";
		
		$objResponse = new xajaxResponse;
		$objResponse->addAssign('jml_tindakan', "value", ($jml+1));
		$objResponse->addAppend('tabel_input_tindakan', "innerHTML", $ret);
		return $objResponse;
	}

}


Class BHP {
	
	function cari_bhp($hal = 0, $val) {
		$val[bhp] = addslashes($val[bhp]);
		$q = " AND nama LIKE '%".$val[bhp]."%' ";
		$paging = new MyPagina;
		$paging->rows_on_page = 10;
		$paging->hal = $hal;
		
		$paging->sql = "
			SELECT 
				id as id,
				REPLACE(UPPER(nama), '".$val[bhp]."','<b>".$val[bhp]."</b>') as nama
			FROM 
				bhp
			WHERE
				1 = 1 
				$q
			ORDER BY 
				nama
			";
		
		$paging->onclick_func = "xajax_cari_bhp";
		$paging->setOnclickValue("xajax.getFormValues('cari_bhp')");
		$paging->get_page_result();

		$bhp_data = $paging->data;
		$bhp_no = $paging->start_number();
		$bhp_navi = $paging->navi();
		
		$objResponse = new xajaxResponse();
		
		$table = new Table;
		$table->addTh("No", "BHP");
		$table->addExtraTh("style=\"width:30px\"", "style=\"width:200px\"");
		for($i=0;$i<sizeof($bhp_data);$i++) {
			$table->addRow(($bhp_no+$i), $bhp_data[$i]['nama']);
			$table->addOnclickTd(
				"get_bhp(" . $bhp_data[$i][id] . ", '" . addslashes($bhp_data[$i]['nama']) . "', '".$val[add_btn_bhp_again]."');",
				"get_bhp(" . $bhp_data[$i][id] . ", '" . addslashes($bhp_data[$i]['nama']) . "', '".$val[add_btn_bhp_again]."');",
				"get_bhp(" . $bhp_data[$i][id] . ", '" . addslashes($bhp_data[$i]['nama']) . "', '".$val[add_btn_bhp_again]."');"
			);
		}
		$tabel = $table->build();
		$objResponse->addAssign("bhp_navi", "innerHTML", $bhp_navi);
		$objResponse->addAssign("list_bhp","innerHTML", $tabel);
		return $objResponse;
	}

	function add_button_bhp($n, $val = array()) {
		if(!empty($val)) {
			$jml = sizeof($val);
			for($i=0;$i<$jml;$i++) {
				$ret .= "<li><a href=\"javascript:void(0)\" title=\"Edit BHP\" onclick=\"buka_bhp('input_bhp_".$i."', '0')\"><img src=\"".IMAGES_URL."add.gif\" alt=\"\" border=\"0\" /></a>&nbsp;&nbsp;<a href=\"javascript:void(0)\" title=\"Hapus BHP\" onclick=\"clear_bhp('input_bhp_".$i."')\"><img src=\"".IMAGES_URL."remove.png\" alt=\"\" border=\"0\" /></a>&nbsp;&nbsp;&nbsp;<span id=\"input_bhp_".$i."_nama\">".$val[$i][bhp_nama]."</span><input type=\"hidden\" name=\"input_kunjungan_bhp_id[]\" id=\"input_kunjungan_bhp_id_".$i."\" value=\"".$val[$i][kunjungan_bhp_id]."\" /><input type=\"hidden\" name=\"input_bhp[]\" id=\"input_bhp_".$i."\" value=\"".$val[$i][bhp_id]."\" /></li>";
			}
		} else {
			$jml = $n;
		}
		$ret .= "<li><a href=\"javascript:void(0)\" title=\"Add BHP\" onclick=\"buka_bhp('input_bhp_".$jml."', '1')\"><img src=\"".IMAGES_URL."add.gif\" alt=\"\" border=\"0\" /></a>&nbsp;&nbsp;<a href=\"javascript:void(0)\" title=\"Hapus BHP\" onclick=\"clear_bhp('input_bhp_".$jml."')\"><img src=\"".IMAGES_URL."remove.png\" alt=\"\" border=\"0\" /></a>&nbsp;&nbsp;&nbsp;<span id=\"input_bhp_".$jml."_nama\"></span><input type=\"hidden\" name=\"input_kunjungan_bhp_id[]\" id=\"input_kunjungan_bhp_id_".$jml."\" value=\"\" /><input type=\"hidden\" name=\"input_bhp[]\" id=\"input_bhp_".$jml."\" value=\"\" /></li>";
		
		$objResponse = new xajaxResponse;
		$objResponse->addAssign('jml_bhp', "value", ($jml+1));
		$objResponse->addAppend('tabel_input_bhp', "innerHTML", $ret);
		return $objResponse;
	}

}

Class Imunisasi {
	
	function cari_imunisasi($hal = 0, $val) {
		$val[imunisasi] = addslashes($val[imunisasi]);
		$q = " AND nama LIKE '%".$val[imunisasi]."%' ";
		$paging = new MyPagina;
		$paging->rows_on_page = 10;
		$paging->hal = $hal;
		
		$paging->sql = "
			SELECT 
				id,
				REPLACE(UPPER(nama), '".$val[imunisasi]."','<b>".$val[imunisasi]."</b>') as nama,
				usia
			FROM 
				imunisasi
			WHERE
				1 = 1 
				$q
			ORDER BY 
				nama
			";
		
		$paging->onclick_func = "xajax_cari_imunisasi";
		$paging->setOnclickValue("xajax.getFormValues('cari_imunisasi')");
		$paging->get_page_result();

		$imunisasi_data = $paging->data;
		$imunisasi_no = $paging->start_number();
		$imunisasi_navi = $paging->navi();
		
		$objResponse = new xajaxResponse();
		$table = new Table;
		$table->addTh("No", "Nama", "Usia");
		$table->addExtraTh("style=\"width:40px\"", "style=\"width:200px\"");
		
		for($i=0;$i<sizeof($imunisasi_data);$i++) {
			$table->addRow(($imunisasi_no+$i), $imunisasi_data[$i]['nama'], $imunisasi_data[$i]['usia']);
			$table->addOnclickTd(
				"get_imunisasi(" . $imunisasi_data[$i][id] . ", '" . addslashes($imunisasi_data[$i]['nama']) . "', '".$val[add_btn_imunisasi_again]."');",
				"get_imunisasi(" . $imunisasi_data[$i][id] . ", '" . addslashes($imunisasi_data[$i]['nama']) . "', '".$val[add_btn_imunisasi_again]."');",
				"get_imunisasi(" . $imunisasi_data[$i][id] . ", '" . addslashes($imunisasi_data[$i]['nama']) . "', '".$val[add_btn_imunisasi_again]."');"
			);
		}
		$tabel = $table->build();
		$objResponse->addAssign("imunisasi_navi", "innerHTML", $imunisasi_navi);
		$objResponse->addAssign("list_imunisasi","innerHTML", $tabel);
		return $objResponse;
	}

	function add_button_imunisasi($n, $val = array()) {
		if(!empty($val)) {
			$jml = sizeof($val);
			for($i=0;$i<$jml;$i++) {
				$ret .= "<li><a href=\"javascript:void(0)\" title=\"Edit Imunisasi\" onclick=\"buka_imunisasi('input_imunisasi_".$i."', '0')\"><img src=\"".IMAGES_URL."add.gif\" alt=\"\" border=\"0\" /></a>&nbsp;&nbsp;<a href=\"javascript:void(0)\" title=\"Hapus Imunisasi\" onclick=\"clear_imunisasi('input_imunisasi_".$i."')\"><img src=\"".IMAGES_URL."remove.png\" alt=\"\" border=\"0\" /></a>&nbsp;&nbsp;&nbsp;<span id=\"input_imunisasi_".$i."_nama\">".$val[$i][imunisasi_nama]."</span><input type=\"hidden\" name=\"input_kunjungan_imunisasi_id[]\" id=\"input_kunjungan_imunisasi_id_".$i."\" value=\"".$val[$i][kunjungan_imunisasi_id]."\" /><input type=\"hidden\" name=\"input_imunisasi[]\" id=\"input_imunisasi_".$i."\" value=\"".$val[$i][imunisasi_id]."\" /></li>";
			}
		} else {
			$jml = $n;
		}
		$ret .= "<li><a href=\"javascript:void(0)\" title=\"Add Imunisasi\" onclick=\"buka_imunisasi('input_imunisasi_".$jml."', '1')\"><img src=\"".IMAGES_URL."add.gif\" alt=\"\" border=\"0\" /></a>&nbsp;&nbsp;<a href=\"javascript:void(0)\" title=\"Hapus Imunisasi\" onclick=\"clear_imunisasi('input_imunisasi_".$jml."')\"><img src=\"".IMAGES_URL."remove.png\" alt=\"\" border=\"0\" /></a>&nbsp;&nbsp;&nbsp;<span id=\"input_imunisasi_".$jml."_nama\"></span><input type=\"hidden\" name=\"input_kunjungan_imunisasi_id[]\" id=\"input_kunjungan_imunisasi_id_".$jml."\" value=\"\" /><input type=\"hidden\" name=\"input_imunisasi[]\" id=\"input_imunisasi_".$jml."\" value=\"\" /></li>";
		
		$objResponse = new xajaxResponse;
		$objResponse->addAssign('jml_imunisasi', "value", ($jml+1));
		$objResponse->addAppend('tabel_input_imunisasi', "innerHTML", $ret);
		return $objResponse;
	}


}
//Class Kunjungan_Modal
$_xajax->registerFunction(array("buka_kunjungan", "Kunjungan_Modal", "buka_kunjungan"));
$_xajax->registerFunction(array("simpan_kunjungan", "Kunjungan_Modal", "simpan_kunjungan"));
$_xajax->registerFunction(array("simpan_kunjungan_check", "Kunjungan_Modal", "simpan_kunjungan_check"));
$_xajax->registerFunction(array("tutup_kunjungan", "Kunjungan_Modal", "tutup_kunjungan"));
$_xajax->registerFunction(array("set_content_tab", "Kunjungan_Modal", "set_content_tab"));
$_xajax->registerFunction(array("tab_list_semua_kunjungan", "Kunjungan_Modal", "tab_list_semua_kunjungan"));
$_xajax->registerFunction(array("tab_buka_kunjungan", "Kunjungan_Modal", "tab_buka_kunjungan"));

//diagnosa
$_xajax->registerFunction(array("cari_diagnosa", "Diagnosa", "cari_diagnosa"));

//tindakan
$_xajax->registerFunction(array("cari_tindakan", "Tindakan", "cari_tindakan"));
$_xajax->registerFunction(array("add_button_tindakan", "Tindakan", "add_button_tindakan"));
//bhp
$_xajax->registerFunction(array("cari_bhp", "BHP", "cari_bhp"));
$_xajax->registerFunction(array("add_button_bhp", "BHP", "add_button_bhp"));

//imunisasi
$_xajax->registerFunction(array("cari_imunisasi", "Imunisasi", "cari_imunisasi"));
$_xajax->registerFunction(array("add_button_imunisasi", "Imunisasi", "add_button_imunisasi"));
?>