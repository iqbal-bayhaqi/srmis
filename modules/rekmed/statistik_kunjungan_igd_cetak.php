<?
$_TITLE = "Statistik Kunjungan IGD";

$cetak = new Cetak;
$cetak->layout = "landscape";
$cetak->page_one = 5;
$cetak->page_other = 10;
$cetak->addThFromArray($_SESSION[rekmed][statistik_kunjungan_igd][th_0]);
$cetak->addExtraThFromArray($_SESSION[rekmed][statistik_kunjungan_igd][extra_th_0]);

$cetak->addThFromArray($_SESSION[rekmed][statistik_kunjungan_igd][th_1]);
$cetak->addLastRowFromArray($_SESSION[rekmed][statistik_kunjungan_igd][row]);
//$cetak->addRowFromArray($_SESSION[rekmed][statistik_kunjungan_igd][row]);
$cetak->setSubTitle(nl2br($_SESSION[rekmed][statistik_kunjungan_igd][title]));
$cetak->setContentBefore($_SESSION[rekmed][statistik_kunjungan_igd][graph]);
$ret = $cetak->build();
?>