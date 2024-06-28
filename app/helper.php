<?php
function rupiah($val){
	$hasil_rupiah = "Rp " . number_format($val,2,',','.');
	return $hasil_rupiah;
}

function rupiahh($val){
	$hasil_rupiah = "Rp " . number_format($val,2,'.',',');
	return $hasil_rupiah;
}
