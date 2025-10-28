<footer class="footer footer-transparent d-print-none">
	<div class="container-xl">
		<div class="row text-center align-items-center flex-row-reverse">
			<div class="col-lg-auto ms-lg-auto">
			</div>
			<div class="col-12 col-lg-auto mt-3 mt-lg-0">
				<ul class="list-inline list-inline-dots mb-0">
					<li class="list-inline-item">
						<?= $data['footer_caption']; ?>
					</li>
					<li class="list-inline-item">
						<a href="<?= $data['url']; ?>" target="_blank">
							<?= $data['url_caption']; ?>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</footer>
</div>
</div>
<!-- jquery latest version -->
<script src="<?= base_url(); ?>assets/js/vendor/jquery.min.js"></script>
<script src="<?= base_url(); ?>assets/js/vendor/jquery-ui.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Libs JS -->
<script src=<?= base_url() . "assets/libs/apexcharts/dist/apexcharts.min.js" ?> defer></script>
<script src=<?= base_url() . "assets/libs/jsvectormap/dist/js/jsvectormap.min.js" ?> defer></script>
<script src=<?= base_url() . "assets/libs/jsvectormap/dist/maps/world.js" ?> defer></script>
<script src=<?= base_url() . "assets/libs/jsvectormap/dist/maps/world-merc.js" ?> defer></script>
<script src=<?= base_url() . "assets/libs/tom-select/dist/js/tom-select.base.min.js" ?> defer></script>
<!-- Tabler Core -->
<script src=<?= base_url() . "assets/js/demo-theme.min.js" ?>></script>
<script src=<?= base_url() . "assets/js/tabler.min.js" ?> defer></script>
<script src=<?= base_url() . "assets/js/demo.min.js" ?> defer></script>
<script src=<?= base_url() . "assets/js/refresh.js" ?>></script>
<!-- bootstrap 4 js -->
<script src="<?= base_url(); ?>assets/js/popper.min.js"></script>
<script src="<?= base_url(); ?>assets/js/bootstrap.min.js"></script>
<!-- dataTablses -->
<script src="<?= base_url(); ?>assets/vendor/datatables/datatables.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/datatables/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/datatables/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/datatables/js/responsive.bootstrap.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/fixheader/js/dataTables.fixedheader.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/datatables/js/dataTables.fixedColumns.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/datatables/js/fixedColumns.bootstrap4.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/datatables/js/dataTables.scroller.js"></script>

<script src="<?= base_url(); ?>assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/toast/jquery.toast.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/select2/js/select2.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/litepicker/dist/litepicker.js"></script>
<script src="<?= base_url(); ?>assets/vendor/nprogress/nprogress.js"></script>
<?php if (ENVIRONMENT != 'development') { ?>
	<script>
		$(document).keydown(function(event) {
			if (event.keyCode == 123) { // Prevent F12
				return false;
			} else if (event.ctrlKey && event.shiftKey && event.keyCode == 73) { // Prevent Ctrl+Shift+I        
				return false;
			}
		});
		$(document).on("contextmenu", function(e) {
			e.preventDefault();
		});
	</script>
<?php } ?>
<?php $updatejs = '1761295277'; ?>
<!-- Custom JS -->
<script src="<?= base_url(); ?>assets/js/myscript.js?<?= $updatejs; ?>"></script>
<!-- <script src="<?= base_url(); ?>assets/js/refresh.js"></script> -->
<?php if (isset($fungsi) && $fungsi == 'userapps') { ?>
	<script src="<?= base_url(); ?>assets/js/own/userapps.js?<?= $updatejs; ?>"></script>
<?php } ?>
<?php if (isset($fungsi) && $fungsi == 'barang') { ?>
	<script src="<?= base_url(); ?>assets/js/own/barang.js?<?= $updatejs; ?>"></script>
<?php } ?>
<?php if (isset($fungsi) && $fungsi == 'dept') { ?>
	<script src="<?= base_url(); ?>assets/js/own/dept.js?<?= $updatejs; ?>"></script>
<?php } ?>
<?php if (isset($fungsi) && $fungsi == 'pb') { ?>
	<script src="<?= base_url(); ?>assets/js/own/pb.js?<?= $updatejs; ?>"></script>
<?php } ?>
<?php if (isset($fungsi) && $fungsi == 'personil') { ?>
	<script src="<?= base_url(); ?>assets/js/own/personil.js?<?= $updatejs; ?>"></script>
<?php } ?>
<?php if (isset($fungsi) && $fungsi == 'in') { ?>
	<script src="<?= base_url(); ?>assets/js/own/in.js?<?= $updatejs; ?>"></script>
<?php } ?>
<?php if (isset($fungsi) && $fungsi == 'out') { ?>
	<script src="<?= base_url(); ?>assets/js/own/out.js?<?= $updatejs; ?>"></script>
<?php } ?>
<?php if (isset($fungsi) && $fungsi == 'inv') { ?>
	<script src="<?= base_url(); ?>assets/js/own/inv.js?<?= $updatejs; ?>"></script>
<?php } ?>
<?php if (isset($fungsi) && $fungsi == 'bbl') { ?>
	<script src="<?= base_url(); ?>assets/js/own/bbl.js?<?= $updatejs; ?>"></script>
<?php } ?>
<?php if (isset($fungsi) && $fungsi == 'po') { ?>
	<script src="<?= base_url(); ?>assets/js/own/po.js?<?= $updatejs; ?>"></script>
<?php } ?>
<?php if (isset($fungsi) && $fungsi == 'ib') { ?>
	<script src="<?= base_url(); ?>assets/js/own/ib.js?<?= $updatejs; ?>"></script>
<?php } ?>
<?php if (isset($fungsi) && $fungsi == 'ibx') { ?>
	<script src="<?= base_url(); ?>assets/js/own/ibbcdok.js?<?= $updatejs; ?>"></script>
<?php } ?>
<?php if (isset($fungsi) && $fungsi == 'akb') { ?>
	<script src="<?= base_url(); ?>assets/js/own/akb.js?<?= $updatejs; ?>"></script>
<?php } ?>
<?php if (isset($fungsi) && $fungsi == 'adj') { ?>
	<script src="<?= base_url(); ?>assets/js/own/adj.js?<?= $updatejs; ?>"></script>
<?php } ?>
<?php if (isset($fungsi) && $fungsi == 'pendingtask') { ?>
	<script src="<?= base_url(); ?>assets/js/own/pendingtask.js?<?= $updatejs; ?>"></script>
<?php } ?>
<?php if (isset($fungsi) && $fungsi == 'logact') { ?>
	<script src="<?= base_url(); ?>assets/js/own/logact.js?<?= $updatejs; ?>"></script>
<?php } ?>
<?php if (isset($fungsi) && $fungsi == 'hargamat') { ?>
	<script src="<?= base_url(); ?>assets/js/own/hargamat.js?<?= $updatejs; ?>"></script>
<?php } ?>
<?php if (isset($fungsi) && $fungsi == 'datamesin') { ?>
	<script src="<?= base_url(); ?>assets/js/own/mastermsn.js?<?= $updatejs; ?>"></script>
<?php } ?>
<?php if (isset($fungsi) && $fungsi == 'invmesin') { ?>
	<script src="<?= base_url(); ?>assets/js/own/invmesin.js?<?= $updatejs; ?>"></script>
<?php } ?>
<?php if (isset($fungsi) && $fungsi == 'bcmasuk') { ?>
	<script src="<?= base_url(); ?>assets/js/own/bcmasuk.js?<?= $updatejs; ?>"></script>
<?php } ?>
<?php if (isset($fungsi) && $fungsi == 'bckeluar') { ?>
	<script src="<?= base_url(); ?>assets/js/own/bckeluar.js?<?= $updatejs; ?>"></script>
<?php } ?>
<?php if (isset($fungsi) && $fungsi == 'kontrak') { ?>
	<script src="<?= base_url(); ?>assets/js/own/kontrak.js?<?= $updatejs; ?>"></script>
<?php } ?>
<?php if (isset($fungsi) && $fungsi == 'benang') { ?>
	<script src="<?= base_url(); ?>assets/js/own/benang.js?<?= $updatejs; ?>"></script>
<?php } ?>
<?php if (isset($fungsi) && $fungsi == 'billmaterial') { ?>
	<script src="<?= base_url(); ?>assets/js/own/billmaterial.js?<?= $updatejs; ?>"></script>
<?php } ?>
<?php if (isset($fungsi) && $fungsi == 'billmaterial_cost') { ?>
	<script src="<?= base_url(); ?>assets/js/own/billmaterial_cost.js?<?= $updatejs; ?>"></script>
<?php } ?>
<?php if (isset($fungsi) && $fungsi == 'main') { ?>
	<script src="<?= base_url(); ?>assets/js/own/main.js?<?= $updatejs; ?>"></script>
<?php } ?>
<?php if (isset($fungsi) && $fungsi == 'main') {
	if($this->session->flashdata('errortanggalbcmon')!=''){
		echo "<script>pesan('".$this->session->flashdata('errortanggalbcmon')."','error'); </script>";
	}
	// print_r(json_encode($dataproduksi['data_isi'])); 
	// echo 'XXXX';
	// echo json_encode($personlogin->result_array());
	$arraylogin = [];
	$arraylogindate = [];
	$arraydate = [];
	$arrayusd = [];
	$arrayjpy = [];
	$date = date('Y-m-d');
	for ($x = 30; $x >= 1; $x--) {
		$dateawal =  strtotime('-' . $x . ' day', strtotime($date));
		$xdate = date('Y-m-d', $dateawal);
		$kurssekarang = $this->helpermodel->getkurssekarang($xdate)->row_array();
		if (isset($kurssekarang['usd']) && $kurssekarang['usd'] != null) {
			$usd = round($kurssekarang['usd'], 0);
		} else {
			$usd = 0;
		}
		if (isset($kurssekarang['jpy']) && $kurssekarang['jpy'] != null) {
			$jpy = round($kurssekarang['jpy'], 2);
		} else {
			$jpy = 0;
		}
		array_push($arraydate, $xdate);
		array_push($arrayusd, $usd);
		array_push($arrayjpy, $jpy);
	}
	foreach($personlogin->result_array() as $personlog){
		array_push($arraylogin,$personlog['personlog']);
		array_push($arraylogindate,$personlog['tgllog']);
	}
	$arraydatebc = [];
	$bc23=[];
	$bc40=[];$bc25=[];$bc30=[];$bc41=[];
	$bc261=[];$bc262=[];
	$bc40m=[];$bc41m=[];
	$jumlahhari = jumlahhari(date('Y-m-d', $this->session->userdata('tglmonbcawal')), date('Y-m-d', $this->session->userdata('tglmonbcakhir')));
	$datuk = date('Y-m-d', $this->session->userdata('tglmonbcakhir'));
	for ($x = $jumlahhari; $x >= 0; $x--) {
		$dateawal =  strtotime('-'.$x . ' day', strtotime($datuk));
		$xdate = date('Y-m-d', $dateawal);
		$getdata = $this->helpermodel->getdatabc2bulan($xdate,1);
		for($y=1;$y<=9;$y++){
			switch ($y) {
				case 1:
					$inx = '230';
					$ar = $bc23;
					break;
				case 2:
					$inx = '400';
					$ar = $bc40;
					break;
				case 3:
					$inx = '250';
					$ar = $bc25;
					break;
				case 4:
					$inx = '300';
					$ar = $bc30;
					break;
				case 5:
					$inx = '410';
					$ar = $bc41;
					break;
				case 6:
					$inx = '2610';
					$ar = $bc261;
					break;
				case 7:
					$inx = '2620';
					$ar = $bc262;
					break;
				case 8:
					$inx = '411';
					$ar = $bc41m;
					break;
				case 9:
					$inx = '401';
					$ar = $bc40m;
					break;
				default:
					# code...
					break;
			}
			$cekada = 0;
			if($getdata->num_rows() > 0){
				foreach($getdata->result_array() as $datbc){
					if($inx == trim($datbc['jns_bc']).$datbc['bc_makloon']){
						switch ($y) {
							case 1:
								array_push($bc23,$datbc['jmlbc']);
								break;
							case 2:
								array_push($bc40,$datbc['jmlbc']);
								break;
							case 3:
								array_push($bc25,$datbc['jmlbc']);
								break;
							case 4:
								array_push($bc30,$datbc['jmlbc']);
								break;
							case 5:
								array_push($bc41,$datbc['jmlbc']);
								break;
							case 6:
								array_push($bc261,$datbc['jmlbc']);
								break;
							case 7:
								array_push($bc262,$datbc['jmlbc']);
								break;
							case 8:
								array_push($bc41m,$datbc['jmlbc']);
								break;
							case 9:
								array_push($bc40m,$datbc['jmlbc']);
								break;
							default:
								# code...
								break;
						}
						$cekada=1;
						break;
					}
				}
			}
			if($cekada==0){
				switch ($y) {
					case 1:
						array_push($bc23,0);
						break;
					case 2:
						array_push($bc40,0);
						break;
					case 3:
						array_push($bc25,0);
						break;
					case 4:
						array_push($bc30,0);
						break;
					case 5:
						array_push($bc41,0);
						break;
					case 6:
						array_push($bc261,0);
						break;
					case 7:
						array_push($bc262,0);
						break;
					case 8:
						array_push($bc41m,0);
						break;
					case 9:
						array_push($bc40m,0);
						break;
					default:
						# code...
						break;
				}
			}
			// array_push($bc23,100);
		}
		array_push($arraydatebc,$xdate);
	}
	// print_r(json_encode($arraydate));
?>
	<?php
	// Untuk Warna Chart Produksi 
	$pembagi = $dataproduksi['data_prod_bulan_lalu'] == 0 ? 1 : $dataproduksi['data_prod_bulan_lalu'];
	$persenproduksi = (($dataproduksi['data_prod_bulan_ini'] - $dataproduksi['data_prod_bulan_lalu']) / $pembagi) * 100;
	switch (true) {
		case $persenproduksi < 0:
			$warna = "danger";
			break;
		case $persenproduksi = 0:
			$warna = "primary";
			break;
		case $persenproduksi > 0:
			$warna = "success";
			break;
		default:
			$warna = "teal";
			break;
	}
	?>
	<script>
		// @formatter:off
		document.addEventListener("DOMContentLoaded", function() {
			window.ApexCharts && (new ApexCharts(document.getElementById('chart-revenue-bg'), {
				chart: {
					type: "area",
					fontFamily: 'inherit',
					height: 40.0,
					sparkline: {
						enabled: true
					},
					animations: {
						enabled: false
					},
				},
				dataLabels: {
					enabled: false,
				},
				fill: {
					opacity: .16,
					type: 'solid'
				},
				stroke: {
					width: 2,
					lineCap: "round",
					curve: "smooth",
				},
				series: [{
					name: "Kgs",
					// data: [37.2, 35, 44, 28, 36, 24, 65, 31, 37, 39, 62, 51, 35, 41, 35, 27, 93, 53, 61, 27, 54, 43, 19, 46, 39, 62, 51, 35, 41, 67]
					data: <?php echo json_encode($dataproduksi['data_isi']) ?>
				}],
				tooltip: {
					theme: 'dark'
				},
				grid: {
					strokeDashArray: 4,
				},
				xaxis: {
					labels: {
						padding: 0,
					},
					tooltip: {
						enabled: false
					},
					axisBorder: {
						show: false,
					},
					type: 'number',
				},
				yaxis: {
					labels: {
						padding: 4
					},
				},
				// labels: [
				// 	'2020-06-20', '2020-06-21', '2020-06-22', '2020-06-23', '2020-06-24', '2020-06-25', '2020-06-26', '2020-06-27', '2020-06-28', '2020-06-29', '2020-06-30', '2020-07-01', '2020-07-02', '2020-07-03', '2020-07-04', '2020-07-05', '2020-07-06', '2020-07-07', '2020-07-08', '2020-07-09', '2020-07-10', '2020-07-11', '2020-07-12', '2020-07-13', '2020-07-14', '2020-07-15', '2020-07-16', '2020-07-17', '2020-07-18', '2020-07-19'
				// ],
				labels: <?php echo json_encode($dataproduksi['data_tgl']) ?>,
				colors: [tabler.getColor('<?= $warna; ?>')],
				legend: {
					show: false,
				},
			})).render();
		});
		// @formatter:on
	</script>
	<script>
		// @formatter:off
		document.addEventListener("DOMContentLoaded", function() {
			window.ApexCharts && (new ApexCharts(document.getElementById('chart-active-users'), {
				chart: {
					type: "line",
					fontFamily: 'inherit',
					height: 40.0,
					sparkline: {
						enabled: true
					},
					animations: {
						enabled: false
					},
				},
				fill: {
					opacity: 1,
				},
				stroke: {
					width: [2, 1],
					dashArray: [0, 3],
					lineCap: "round",
					curve: "smooth",
				},
				series: [{
					name: "USD",
					// data: [37, 35, 44, 28, 36, 24, 65, 31, 37, 39, 62, 51, 35, 41, 35, 27, 93, 53, 61, 27, 54, 43, 4, 46, 39, 62, 51, 35, 41, 67]
					data: <?= json_encode($arrayusd) ?>
				}, {
					name: "JPY",
					// data: [93, 54, 51, 24, 35, 35, 31, 67, 19, 43, 28, 36, 62, 61, 27, 39, 35, 41, 27, 35, 51, 46, 62, 37, 44, 53, 41, 65, 39, 37]
					data: <?= json_encode($arrayjpy) ?>
				}],
				tooltip: {
					theme: 'dark'
				},
				grid: {
					strokeDashArray: 4,
				},
				xaxis: {
					labels: {
						padding: 0,
					},
					tooltip: {
						enabled: false
					},
					type: 'datetime',
				},
				yaxis: {
					labels: {
						padding: 4
					},
				},
				// labels: [
				// 	'2020-06-20', '2020-06-21', '2020-06-22', '2020-06-23', '2020-06-24', '2020-06-25', '2020-06-26', '2020-06-27', '2020-06-28', '2020-06-29', '2020-06-30', '2020-07-01', '2020-07-02', '2020-07-03', '2020-07-04', '2020-07-05', '2020-07-06', '2020-07-07', '2020-07-08', '2020-07-09', '2020-07-10', '2020-07-11', '2020-07-12', '2020-07-13', '2020-07-14', '2020-07-15', '2020-07-16', '2020-07-17', '2020-07-18', '2020-07-19'
				// ],
				labels: <?= json_encode($arraydate) ?>,
				colors: [tabler.getColor("blue"), tabler.getColor("gray-600")],
				legend: {
					show: false,
				},
			})).render();
		});
		// @formatter:on
	</script>
	<script>
		// @formatter:off
		document.addEventListener("DOMContentLoaded", function() {
			window.ApexCharts && (new ApexCharts(document.getElementById('chart-dokbcmasuk'), {
				chart: {
					type: "line",
					fontFamily: 'inherit',
					height: 60.0,
					sparkline: {
						enabled: true
					},
					animations: {
						enabled: false
					},
				},
				fill: {
					opacity: 1,
				},
				stroke: {
					width: [2, 1],
					dashArray: [0, 3],
					lineCap: "round",
					curve: "smooth",
				},
				series: [{
					name: "BC 23",
					// data: [37, 35, 44, 28, 36, 24, 65, 31, 37, 39, 62, 51, 35, 41, 35, 27, 93, 53, 61, 27, 54, 43, 4, 46, 39, 62, 51, 35, 41, 67]
					data: <?= json_encode($bc23) ?>
				}, {
					name: "BC 40",
					// data: [93, 54, 51, 24, 35, 35, 31, 67, 19, 43, 28, 36, 62, 61, 27, 39, 35, 41, 27, 35, 51, 46, 62, 37, 44, 53, 41, 65, 39, 37]
					data: <?= json_encode($bc40) ?>
				}],
				tooltip: {
					theme: 'light'
				},
				grid: {
					strokeDashArray: 4,
				},
				xaxis: {
					labels: {
						padding: 0,
					},
					tooltip: {
						enabled: false
					},
					type: 'datetime',
				},
				yaxis: {
					labels: {
						padding: 4
					},
				},
				// labels: [
				// 	'2020-06-20', '2020-06-21', '2020-06-22', '2020-06-23', '2020-06-24', '2020-06-25', '2020-06-26', '2020-06-27', '2020-06-28', '2020-06-29', '2020-06-30', '2020-07-01', '2020-07-02', '2020-07-03', '2020-07-04', '2020-07-05', '2020-07-06', '2020-07-07', '2020-07-08', '2020-07-09', '2020-07-10', '2020-07-11', '2020-07-12', '2020-07-13', '2020-07-14', '2020-07-15', '2020-07-16', '2020-07-17', '2020-07-18', '2020-07-19'
				// ],
				labels: <?= json_encode($arraydatebc) ?>,
				colors: [tabler.getColor("pink"), tabler.getColor("gray-600")],
				legend: {
					show: false,
				},
			})).render();
		});
		// @formatter:on
	</script>
	<script>
		// @formatter:off
		document.addEventListener("DOMContentLoaded", function() {
			window.ApexCharts && (new ApexCharts(document.getElementById('chart-dokbckeluar'), {
				chart: {
					type: "line",
					fontFamily: 'inherit',
					height: 60.0,
					sparkline: {
						enabled: true
					},
					animations: {
						enabled: false
					},
				},
				fill: {
					opacity: 1,
				},
				stroke: {
					width: [2, 1],
					dashArray: [0, 3],
					lineCap: "round",
					curve: "smooth",
				},
				series: [{
					name: "BC 25",
					// data: [37, 35, 44, 28, 36, 24, 65, 31, 37, 39, 62, 51, 35, 41, 35, 27, 93, 53, 61, 27, 54, 43, 4, 46, 39, 62, 51, 35, 41, 67]
					data: <?= json_encode($bc25) ?>
				}, {
					name: "BC 30",
					// data: [93, 54, 51, 24, 35, 35, 31, 67, 19, 43, 28, 36, 62, 61, 27, 39, 35, 41, 27, 35, 51, 46, 62, 37, 44, 53, 41, 65, 39, 37]
					data: <?= json_encode($bc30) ?>
				}, {
					name: "BC 41",
					// data: [93, 54, 51, 24, 35, 35, 31, 67, 19, 43, 28, 36, 62, 61, 27, 39, 35, 41, 27, 35, 51, 46, 62, 37, 44, 53, 41, 65, 39, 37]
					data: <?= json_encode($bc41) ?>
				}],
				tooltip: {
					theme: 'light'
				},
				grid: {
					strokeDashArray: 4,
				},
				xaxis: {
					labels: {
						padding: 0,
					},
					tooltip: {
						enabled: false
					},
					type: 'datetime',
				},
				yaxis: {
					labels: {
						padding: 4
					},
				},
				// labels: [
				// 	'2020-06-20', '2020-06-21', '2020-06-22', '2020-06-23', '2020-06-24', '2020-06-25', '2020-06-26', '2020-06-27', '2020-06-28', '2020-06-29', '2020-06-30', '2020-07-01', '2020-07-02', '2020-07-03', '2020-07-04', '2020-07-05', '2020-07-06', '2020-07-07', '2020-07-08', '2020-07-09', '2020-07-10', '2020-07-11', '2020-07-12', '2020-07-13', '2020-07-14', '2020-07-15', '2020-07-16', '2020-07-17', '2020-07-18', '2020-07-19'
				// ],
				labels: <?= json_encode($arraydatebc) ?>,
				colors: [tabler.getColor("green"), tabler.getColor("gray-600"),tabler.getColor("orange")],
				legend: {
					show: false,
				},
			})).render();
		});
		// @formatter:on
	</script>
	<script>
		// @formatter:off
		document.addEventListener("DOMContentLoaded", function() {
			window.ApexCharts && (new ApexCharts(document.getElementById('chart-dokbcsubkon'), {
				chart: {
					type: "line",
					fontFamily: 'inherit',
					height: 60.0,
					sparkline: {
						enabled: true
					},
					animations: {
						enabled: false
					},
				},
				fill: {
					opacity: 1,
				},
				stroke: {
					width: [2, 1],
					dashArray: [0, 3],
					lineCap: "round",
					curve: "smooth",
				},
				series: [{
					name: "BC 261",
					// data: [37, 35, 44, 28, 36, 24, 65, 31, 37, 39, 62, 51, 35, 41, 35, 27, 93, 53, 61, 27, 54, 43, 4, 46, 39, 62, 51, 35, 41, 67]
					data: <?= json_encode($bc261) ?>
				}, {
					name: "BC 26",
					// data: [93, 54, 51, 24, 35, 35, 31, 67, 19, 43, 28, 36, 62, 61, 27, 39, 35, 41, 27, 35, 51, 46, 62, 37, 44, 53, 41, 65, 39, 37]
					data: <?= json_encode($bc262) ?>
				}],
				tooltip: {
					theme: 'light'
				},
				grid: {
					strokeDashArray: 4,
				},
				xaxis: {
					labels: {
						padding: 0,
					},
					tooltip: {
						enabled: false
					},
					type: 'datetime',
				},
				yaxis: {
					labels: {
						padding: 4
					},
				},
				// labels: [
				// 	'2020-06-20', '2020-06-21', '2020-06-22', '2020-06-23', '2020-06-24', '2020-06-25', '2020-06-26', '2020-06-27', '2020-06-28', '2020-06-29', '2020-06-30', '2020-07-01', '2020-07-02', '2020-07-03', '2020-07-04', '2020-07-05', '2020-07-06', '2020-07-07', '2020-07-08', '2020-07-09', '2020-07-10', '2020-07-11', '2020-07-12', '2020-07-13', '2020-07-14', '2020-07-15', '2020-07-16', '2020-07-17', '2020-07-18', '2020-07-19'
				// ],
				labels: <?= json_encode($arraydatebc) ?>,
				colors: [tabler.getColor("red"), tabler.getColor("gray-600")],
				legend: {
					show: false,
				},
			})).render();
		});
		// @formatter:on
	</script>
	<script>
		// @formatter:off
		document.addEventListener("DOMContentLoaded", function() {
			window.ApexCharts && (new ApexCharts(document.getElementById('chart-dokbcmakloon'), {
				chart: {
					type: "line",
					fontFamily: 'inherit',
					height: 60.0,
					sparkline: {
						enabled: true
					},
					animations: {
						enabled: false
					},
				},
				fill: {
					opacity: 1,
				},
				stroke: {
					width: [2, 1],
					dashArray: [0, 3],
					lineCap: "round",
					curve: "smooth",
				},
				series: [{
					name: "BC 40",
					// data: [37, 35, 44, 28, 36, 24, 65, 31, 37, 39, 62, 51, 35, 41, 35, 27, 93, 53, 61, 27, 54, 43, 4, 46, 39, 62, 51, 35, 41, 67]
					data: <?= json_encode($bc40m) ?>
				}, {
					name: "BC 41",
					// data: [93, 54, 51, 24, 35, 35, 31, 67, 19, 43, 28, 36, 62, 61, 27, 39, 35, 41, 27, 35, 51, 46, 62, 37, 44, 53, 41, 65, 39, 37]
					data: <?= json_encode($bc41m) ?>
				}],
				tooltip: {
					theme: 'light'
				},
				grid: {
					strokeDashArray: 4,
				},
				xaxis: {
					labels: {
						padding: 0,
					},
					tooltip: {
						enabled: false
					},
					type: 'datetime',
				},
				yaxis: {
					labels: {
						padding: 4
					},
				},
				// labels: [
				// 	'2020-06-20', '2020-06-21', '2020-06-22', '2020-06-23', '2020-06-24', '2020-06-25', '2020-06-26', '2020-06-27', '2020-06-28', '2020-06-29', '2020-06-30', '2020-07-01', '2020-07-02', '2020-07-03', '2020-07-04', '2020-07-05', '2020-07-06', '2020-07-07', '2020-07-08', '2020-07-09', '2020-07-10', '2020-07-11', '2020-07-12', '2020-07-13', '2020-07-14', '2020-07-15', '2020-07-16', '2020-07-17', '2020-07-18', '2020-07-19'
				// ],
				labels: <?= json_encode($arraydatebc) ?>,
				colors: [tabler.getColor("purple"), tabler.getColor("gray-600")],
				legend: {
					show: false,
				},
			})).render();
		});
		// @formatter:on
	</script>
	<script>
		// @formatter:off
		document.addEventListener("DOMContentLoaded", function() {
			window.ApexCharts && (new ApexCharts(document.getElementById('chart-new-clients'), {
				chart: {
					type: "bar",
					fontFamily: 'inherit',
					height: 40.0,
					sparkline: {
						enabled: true
					},
					animations: {
						enabled: false
					},
				},
				plotOptions: {
					bar: {
						columnWidth: '50%',
					}
				},
				dataLabels: {
					enabled: false,
				},
				fill: {
					opacity: 1,
				},
				series: [{
					name: "Person Login",
					// data: [37, 35, 44, 28, 36, 24, 65, 31, 37, 39, 62, 51, 35, 41, 35, 27, 93, 53, 61, 27, 54, 43, 19, 46, 39, 62, 51, 35, 41, 67]
					data: <?= json_encode($arraylogin) ?>
				}],
				tooltip: {
					theme: 'dark'
				},
				grid: {
					strokeDashArray: 4,
				},
				xaxis: {
					labels: {
						padding: 0,
					},
					tooltip: {
						enabled: false
					},
					axisBorder: {
						show: false,
					},
					type: 'datetime',
				},
				yaxis: {
					labels: {
						padding: 4
					},
				},
				// labels: [
				// 	'2020-06-20', '2020-06-21', '2020-06-22', '2020-06-23', '2020-06-24', '2020-06-25', '2020-06-26', '2020-06-27', '2020-06-28', '2020-06-29', '2020-06-30', '2020-07-01', '2020-07-02', '2020-07-03', '2020-07-04', '2020-07-05', '2020-07-06', '2020-07-07', '2020-07-08', '2020-07-09', '2020-07-10', '2020-07-11', '2020-07-12', '2020-07-13', '2020-07-14', '2020-07-15', '2020-07-16', '2020-07-17', '2020-07-18', '2020-07-19'
				// ],
				labels: <?= json_encode($arraylogindate) ?>,
				colors: [tabler.getColor("pink")],
				legend: {
					show: false,
				},
			})).render();
		});
		// @formatter:on
	</script>
	<script>
		// @formatter:off
		document.addEventListener("DOMContentLoaded", function() {
			window.ApexCharts && (new ApexCharts(document.getElementById('chart-mentions'), {
				chart: {
					type: "bar",
					fontFamily: 'inherit',
					height: 240,
					parentHeightOffset: 0,
					toolbar: {
						show: false,
					},
					animations: {
						enabled: false
					},
					stacked: true,
				},
				plotOptions: {
					bar: {
						columnWidth: '50%',
					}
				},
				dataLabels: {
					enabled: false,
				},
				fill: {
					opacity: 1,
				},
				series: [{
					name: "Web",
					data: [1, 0, 0, 0, 0, 1, 1, 0, 0, 0, 2, 12, 5, 8, 22, 6, 8, 6, 4, 1, 8, 24, 29, 51, 40, 47, 23, 26, 50, 26, 41, 22, 46, 47, 81, 46, 6]
				}, {
					name: "Social",
					data: [2, 5, 4, 3, 3, 1, 4, 7, 5, 1, 2, 5, 3, 2, 6, 7, 7, 1, 5, 5, 2, 12, 4, 6, 18, 3, 5, 2, 13, 15, 20, 47, 18, 15, 11, 10, 0]
				}, {
					name: "Other",
					data: [2, 9, 1, 7, 8, 3, 6, 5, 5, 4, 6, 4, 1, 9, 3, 6, 7, 5, 2, 8, 4, 9, 1, 2, 6, 7, 5, 1, 8, 3, 2, 3, 4, 9, 7, 1, 6]
				}],
				tooltip: {
					theme: 'dark'
				},
				grid: {
					padding: {
						top: -20,
						right: 0,
						left: -4,
						bottom: -4
					},
					strokeDashArray: 4,
					xaxis: {
						lines: {
							show: true
						}
					},
				},
				xaxis: {
					labels: {
						padding: 0,
					},
					tooltip: {
						enabled: false
					},
					axisBorder: {
						show: false,
					},
					type: 'datetime',
				},
				yaxis: {
					labels: {
						padding: 4
					},
				},
				labels: [
					'2020-06-20', '2020-06-21', '2020-06-22', '2020-06-23', '2020-06-24', '2020-06-25', '2020-06-26', '2020-06-27', '2020-06-28', '2020-06-29', '2020-06-30', '2020-07-01', '2020-07-02', '2020-07-03', '2020-07-04', '2020-07-05', '2020-07-06', '2020-07-07', '2020-07-08', '2020-07-09', '2020-07-10', '2020-07-11', '2020-07-12', '2020-07-13', '2020-07-14', '2020-07-15', '2020-07-16', '2020-07-17', '2020-07-18', '2020-07-19', '2020-07-20', '2020-07-21', '2020-07-22', '2020-07-23', '2020-07-24', '2020-07-25', '2020-07-26'
				],
				colors: [tabler.getColor("primary"), tabler.getColor("primary", 0.8), tabler.getColor("green", 0.8)],
				legend: {
					show: false,
				},
			})).render();
		});
		// @formatter:on
	</script>
	<script>
		// @formatter:on
		document.addEventListener("DOMContentLoaded", function() {
			const map = new jsVectorMap({
				selector: '#map-world',
				map: 'world',
				backgroundColor: 'transparent',
				regionStyle: {
					initial: {
						fill: tabler.getColor('body-bg'),
						stroke: tabler.getColor('border-color'),
						strokeWidth: 2,
					}
				},
				zoomOnScroll: false,
				zoomButtons: false,
				// -------- Series --------
				visualizeData: {
					scale: [tabler.getColor('bg-surface'), tabler.getColor('primary')],
					values: {
						"AF": 16,
						"AL": 11,
						"DZ": 158,
						"AO": 85,
						"AG": 1,
						"AR": 351,
						"AM": 8,
						"AU": 1219,
						"AT": 366,
						"AZ": 52,
						"BS": 7,
						"BH": 21,
						"BD": 105,
						"BB": 3,
						"BY": 52,
						"BE": 461,
						"BZ": 1,
						"BJ": 6,
						"BT": 1,
						"BO": 19,
						"BA": 16,
						"BW": 12,
						"BR": 2023,
						"BN": 11,
						"BG": 44,
						"BF": 8,
						"BI": 1,
						"KH": 11,
						"CM": 21,
						"CA": 1563,
						"CV": 1,
						"CF": 2,
						"TD": 7,
						"CL": 199,
						"CN": 5745,
						"CO": 283,
						"KM": 0,
						"CD": 12,
						"CG": 11,
						"CR": 35,
						"CI": 22,
						"HR": 59,
						"CY": 22,
						"CZ": 195,
						"DK": 304,
						"DJ": 1,
						"DM": 0,
						"DO": 50,
						"EC": 61,
						"EG": 216,
						"SV": 21,
						"GQ": 14,
						"ER": 2,
						"EE": 19,
						"ET": 30,
						"FJ": 3,
						"FI": 231,
						"FR": 2555,
						"GA": 12,
						"GM": 1,
						"GE": 11,
						"DE": 3305,
						"GH": 18,
						"GR": 305,
						"GD": 0,
						"GT": 40,
						"GN": 4,
						"GW": 0,
						"GY": 2,
						"HT": 6,
						"HN": 15,
						"HK": 226,
						"HU": 132,
						"IS": 12,
						"IN": 1430,
						"ID": 695,
						"IR": 337,
						"IQ": 84,
						"IE": 204,
						"IL": 201,
						"IT": 2036,
						"JM": 13,
						"JP": 5390,
						"JO": 27,
						"KZ": 129,
						"KE": 32,
						"KI": 0,
						"KR": 986,
						"KW": 117,
						"KG": 4,
						"LA": 6,
						"LV": 23,
						"LB": 39,
						"LS": 1,
						"LR": 0,
						"LY": 77,
						"LT": 35,
						"LU": 52,
						"MK": 9,
						"MG": 8,
						"MW": 5,
						"MY": 218,
						"MV": 1,
						"ML": 9,
						"MT": 7,
						"MR": 3,
						"MU": 9,
						"MX": 1004,
						"MD": 5,
						"MN": 5,
						"ME": 3,
						"MA": 91,
						"MZ": 10,
						"MM": 35,
						"NA": 11,
						"NP": 15,
						"NL": 770,
						"NZ": 138,
						"NI": 6,
						"NE": 5,
						"NG": 206,
						"NO": 413,
						"OM": 53,
						"PK": 174,
						"PA": 27,
						"PG": 8,
						"PY": 17,
						"PE": 153,
						"PH": 189,
						"PL": 438,
						"PT": 223,
						"QA": 126,
						"RO": 158,
						"RU": 1476,
						"RW": 5,
						"WS": 0,
						"ST": 0,
						"SA": 434,
						"SN": 12,
						"RS": 38,
						"SC": 0,
						"SL": 1,
						"SG": 217,
						"SK": 86,
						"SI": 46,
						"SB": 0,
						"ZA": 354,
						"ES": 1374,
						"LK": 48,
						"KN": 0,
						"LC": 1,
						"VC": 0,
						"SD": 65,
						"SR": 3,
						"SZ": 3,
						"SE": 444,
						"CH": 522,
						"SY": 59,
						"TW": 426,
						"TJ": 5,
						"TZ": 22,
						"TH": 312,
						"TL": 0,
						"TG": 3,
						"TO": 0,
						"TT": 21,
						"TN": 43,
						"TR": 729,
						"TM": 0,
						"UG": 17,
						"UA": 136,
						"AE": 239,
						"GB": 2258,
						"US": 4624,
						"UY": 40,
						"UZ": 37,
						"VU": 0,
						"VE": 285,
						"VN": 101,
						"YE": 30,
						"ZM": 15,
						"ZW": 5
					},
				},
			});
			window.addEventListener("resize", () => {
				map.updateSize();
			});
		});
		// @formatter:off
	</script>
	<script>
		// @formatter:off
		// document.addEventListener("DOMContentLoaded", function() {
		// 	window.ApexCharts && (new ApexCharts(document.getElementById('sparkline-activity'), {
		// 		chart: {
		// 			type: "radialBar",
		// 			fontFamily: 'inherit',
		// 			height: 40,
		// 			width: 40,
		// 			animations: {
		// 				enabled: false
		// 			},
		// 			sparkline: {
		// 				enabled: true
		// 			},
		// 		},
		// 		tooltip: {
		// 			enabled: false,
		// 		},
		// 		plotOptions: {
		// 			radialBar: {
		// 				hollow: {
		// 					margin: 0,
		// 					size: '75%'
		// 				},
		// 				track: {
		// 					margin: 0
		// 				},
		// 				dataLabels: {
		// 					show: false
		// 				}
		// 			}
		// 		},
		// 		colors: [tabler.getColor("blue")],
		// 		series: [35],
		// 	})).render();
		// });
		// @formatter:on
	</script>
	<script>
		// @formatter:off
		// document.addEventListener("DOMContentLoaded", function() {
		// 	window.ApexCharts && (new ApexCharts(document.getElementById('chart-development-activity'), {
		// 		chart: {
		// 			type: "area",
		// 			fontFamily: 'inherit',
		// 			height: 192,
		// 			sparkline: {
		// 				enabled: true
		// 			},
		// 			animations: {
		// 				enabled: false
		// 			},
		// 		},
		// 		dataLabels: {
		// 			enabled: false,
		// 		},
		// 		fill: {
		// 			opacity: .16,
		// 			type: 'solid'
		// 		},
		// 		stroke: {
		// 			width: 2,
		// 			lineCap: "round",
		// 			curve: "smooth",
		// 		},
		// 		series: [{
		// 			name: "Purchases",
		// 			data: [3, 5, 4, 6, 7, 5, 6, 8, 24, 7, 12, 5, 6, 3, 8, 4, 14, 30, 17, 19, 15, 14, 25, 32, 40, 55, 60, 48, 52, 70]
		// 		}],
		// 		tooltip: {
		// 			theme: 'dark'
		// 		},
		// 		grid: {
		// 			strokeDashArray: 4,
		// 		},
		// 		xaxis: {
		// 			labels: {
		// 				padding: 0,
		// 			},
		// 			tooltip: {
		// 				enabled: false
		// 			},
		// 			axisBorder: {
		// 				show: false,
		// 			},
		// 			type: 'datetime',
		// 		},
		// 		yaxis: {
		// 			labels: {
		// 				padding: 4
		// 			},
		// 		},
		// 		labels: [
		// 			'2020-06-20', '2020-06-21', '2020-06-22', '2020-06-23', '2020-06-24', '2020-06-25', '2020-06-26', '2020-06-27', '2020-06-28', '2020-06-29', '2020-06-30', '2020-07-01', '2020-07-02', '2020-07-03', '2020-07-04', '2020-07-05', '2020-07-06', '2020-07-07', '2020-07-08', '2020-07-09', '2020-07-10', '2020-07-11', '2020-07-12', '2020-07-13', '2020-07-14', '2020-07-15', '2020-07-16', '2020-07-17', '2020-07-18', '2020-07-19'
		// 		],
		// 		colors: [tabler.getColor("primary")],
		// 		legend: {
		// 			show: false,
		// 		},
		// 		point: {
		// 			show: false
		// 		},
		// 	})).render();
		// });
		// @formatter:on
	</script>
	<script>
		// @formatter:off
		// document.addEventListener("DOMContentLoaded", function() {
		// 	window.ApexCharts && (new ApexCharts(document.getElementById('sparkline-bounce-rate-1'), {
		// 		chart: {
		// 			type: "line",
		// 			fontFamily: 'inherit',
		// 			height: 24,
		// 			animations: {
		// 				enabled: false
		// 			},
		// 			sparkline: {
		// 				enabled: true
		// 			},
		// 		},
		// 		tooltip: {
		// 			enabled: false,
		// 		},
		// 		stroke: {
		// 			width: 2,
		// 			lineCap: "round",
		// 		},
		// 		series: [{
		// 			color: tabler.getColor("primary"),
		// 			data: [17, 24, 20, 10, 5, 1, 4, 18, 13]
		// 		}],
		// 	})).render();
		// });
		// @formatter:on
	</script>
	<script>
		// @formatter:off
		// document.addEventListener("DOMContentLoaded", function() {
		// 	window.ApexCharts && (new ApexCharts(document.getElementById('sparkline-bounce-rate-2'), {
		// 		chart: {
		// 			type: "line",
		// 			fontFamily: 'inherit',
		// 			height: 24,
		// 			animations: {
		// 				enabled: false
		// 			},
		// 			sparkline: {
		// 				enabled: true
		// 			},
		// 		},
		// 		tooltip: {
		// 			enabled: false,
		// 		},
		// 		stroke: {
		// 			width: 2,
		// 			lineCap: "round",
		// 		},
		// 		series: [{
		// 			color: tabler.getColor("primary"),
		// 			data: [13, 11, 19, 22, 12, 7, 14, 3, 21]
		// 		}],
		// 	})).render();
		// });
		// @formatter:on
	</script>
	<script>
		// @formatter:off
		// document.addEventListener("DOMContentLoaded", function() {
		// 	window.ApexCharts && (new ApexCharts(document.getElementById('sparkline-bounce-rate-3'), {
		// 		chart: {
		// 			type: "line",
		// 			fontFamily: 'inherit',
		// 			height: 24,
		// 			animations: {
		// 				enabled: false
		// 			},
		// 			sparkline: {
		// 				enabled: true
		// 			},
		// 		},
		// 		tooltip: {
		// 			enabled: false,
		// 		},
		// 		stroke: {
		// 			width: 2,
		// 			lineCap: "round",
		// 		},
		// 		series: [{
		// 			color: tabler.getColor("primary"),
		// 			data: [10, 13, 10, 4, 17, 3, 23, 22, 19]
		// 		}],
		// 	})).render();
		// });
		// @formatter:on
	</script>
	<script>
		// @formatter:off
		// document.addEventListener("DOMContentLoaded", function() {
		// 	window.ApexCharts && (new ApexCharts(document.getElementById('sparkline-bounce-rate-4'), {
		// 		chart: {
		// 			type: "line",
		// 			fontFamily: 'inherit',
		// 			height: 24,
		// 			animations: {
		// 				enabled: false
		// 			},
		// 			sparkline: {
		// 				enabled: true
		// 			},
		// 		},
		// 		tooltip: {
		// 			enabled: false,
		// 		},
		// 		stroke: {
		// 			width: 2,
		// 			lineCap: "round",
		// 		},
		// 		series: [{
		// 			color: tabler.getColor("primary"),
		// 			data: [6, 15, 13, 13, 5, 7, 17, 20, 19]
		// 		}],
		// 	})).render();
		// });
		// @formatter:on
	</script>
	<script>
		// @formatter:off
		// document.addEventListener("DOMContentLoaded", function() {
		// 	window.ApexCharts && (new ApexCharts(document.getElementById('sparkline-bounce-rate-5'), {
		// 		chart: {
		// 			type: "line",
		// 			fontFamily: 'inherit',
		// 			height: 24,
		// 			animations: {
		// 				enabled: false
		// 			},
		// 			sparkline: {
		// 				enabled: true
		// 			},
		// 		},
		// 		tooltip: {
		// 			enabled: false,
		// 		},
		// 		stroke: {
		// 			width: 2,
		// 			lineCap: "round",
		// 		},
		// 		series: [{
		// 			color: tabler.getColor("primary"),
		// 			data: [2, 11, 15, 14, 21, 20, 8, 23, 18, 14]
		// 		}],
		// 	})).render();
		// });
		// @formatter:on
	</script>
	<script>
		// @formatter:off
		// document.addEventListener("DOMContentLoaded", function() {
		// 	window.ApexCharts && (new ApexCharts(document.getElementById('sparkline-bounce-rate-6'), {
		// 		chart: {
		// 			type: "line",
		// 			fontFamily: 'inherit',
		// 			height: 24,
		// 			animations: {
		// 				enabled: false
		// 			},
		// 			sparkline: {
		// 				enabled: true
		// 			},
		// 		},
		// 		tooltip: {
		// 			enabled: false,
		// 		},
		// 		stroke: {
		// 			width: 2,
		// 			lineCap: "round",
		// 		},
		// 		series: [{
		// 			color: tabler.getColor("primary"),
		// 			data: [22, 12, 7, 14, 3, 21, 8, 23, 18, 14]
		// 		}],
		// 	})).render();
		// });
		// @formatter:on
	</script>
<?php } ?>
</body>

</html>