<?php
$graph = new PieGraph(500,300,"auto");
$graph->SetShadow();
//$graph->title->Set($_SESSION[rekmed][statistik_penyakit_daerah][title]);
//$graph->title->SetFont(FF_FONT1,FS_BOLD);

$p1 = new PiePlot3D($_SESSION[rekmed][statistik_penyakit_daerah][jml]);
$p1->ExplodeAll();
$p1->SetCenter(0.5);
$p1->SetLabels($_SESSION[rekmed][statistik_penyakit_daerah][kode]);
//$p1->SetLegends($_SESSION[rekmed][statistik_penyakit_daerah][kode]);
$graph->Add($p1);
$graph->Stroke();
?>