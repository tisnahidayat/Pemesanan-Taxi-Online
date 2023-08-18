<?php

// Instruksi Kerja Nomor 1.
// Variabel $kendaraan berisi data jenis kendaraan yang dipesan dalam bentuk array satu dimensi.
$kendaraan = array("Sedan", "Minivan", "Minibus", "Sepeda Motor", "Pickup");

// Instruksi Kerja Nomor 2.
// Mengurutkan array $kendaraan secara Ascending.
asort($kendaraan);

// Instruksi Kerja Nomor 6.
// Baris Komentar: ......
function hitung_sewa($biaya_platform, $jarak, $biaya_per_km)
{
	// Instruksi Kerja Nomor 6.
	// Isi dari fungsi hitung_sewa adalah nilai_sewa = biaya platform + (jarak X biaya per kilometer)
	$nilai_sewa = $biaya_platform + ($jarak * $biaya_per_km);
	// Instruksi Kerja Nomor 6.
	// Fungsi mengembalikan nilai nilai_sewa
	return $nilai_sewa;
}
?>

<!DOCTYPE html>
<html>

<head>
	<title>Pemesanan Taxi Online</title>
	<!-- Instruksi Kerja Nomor 4. -->
	<!-- Menghubungkan dengan library/berkas CSS. -->
	<link rel="stylesheet" href="css/bootstrap.css">
</head>

<body>
	<div class="container border">
		<!-- Menampilkan judul halaman -->
		<h3>Pemesanan Taxi Online</h3>

		<!-- Instruksi Kerja Nomor 5. -->
		<!-- Menampilkan logo Taxi Online -->
		<img src="img/logo.jpg" alt="logo">

		<!-- Form untuk memasukkan data pemesanan. -->
		<form action="index.php" method="post" id="formPemesanan">
			<!-- Isi form seperti yang Anda inginkan -->
			<div class="row">
				<!-- Masukan data nama pelanggan. Tipe data text. -->
				<div class="col-lg-2"><label for="nama">Nama Pelanggan:</label></div>
				<div class="col-lg-2"><input type="text" id="nama" name="nama"></div>
			</div>
			<div class="row">
				<!-- Masukan data nomor HP pelanggan. Tipe data number. -->
				<div class="col-lg-2"><label for="nomor">Nomor HP:</label></div>
				<div class="col-lg-2"><input type="number" id="noHP" name="noHP" maxlength="16"></div>
			</div>
			<div class="row">
				<!-- Masukan pilihan jenis kendaraan. -->
				<div class="col-lg-2"><label for="tipe">Jenis Kendaraan:</label></div>
				<div class="col-lg-2">
					<select id="kendaraan" name="kendaraan">
						<option value="">- Jenis kendaraan -</option>
						<?php
						// Instruksi Kerja Nomor 3.
						// Menampilkan dropdown pilihan jenis kendaraan berdasarkan data pada array $kendaraan menggunakan perulangan.
						foreach ($kendaraan as $jenis) {
							echo "<option value=\"$jenis\">$jenis</option>";
						}
						?>
					</select>
				</div>
			</div>

			<div class="row">
				<!-- Masukan data Jarak Tempuh. Tipe data number. -->
				<div class="col-lg-2"><label for="nomor">Jarak:</label></div>
				<div class="col-lg-2"><input type="number" id="jarak" name="jarak" maxlength="4"></div>
			</div>
			<div class="row">
				<!-- Tombol Submit -->
				<div class="col-lg-2"><button class="btn btn-primary" type="submit" form="formPemesanan" value="Pesan" name="Pesan">Pesan</button></div>
				<div class="col-lg-2"></div>
			</div>
			<!-- ... (Form input dan tombol Submit) ... -->
		</form>
	</div>


	<?php
	if (isset($_POST['Pesan'])) {
		$dataPesanan = array(
			'nama' => $_POST['nama'],
			'noHP' => $_POST['noHP'],
			'kendaraan' => $_POST['kendaraan'],
			'jarak' => $_POST['jarak']
		);

		$jarak_tempuh = $_POST['jarak'];

		if ($_POST['kendaraan'] == 'Sedan') {
			$biaya_platform = 10000;
			$sewa_per_km = 5000;
		} elseif ($_POST['kendaraan'] == 'Minivan') {
			$biaya_platform = 12000;
			$sewa_per_km = 6000;
		} elseif ($_POST['kendaraan'] == 'Minibus') {
			$biaya_platform = 15000;
			$sewa_per_km = 10000;
		} elseif ($_POST['kendaraan'] == 'Sepeda Motor') {
			$biaya_platform = 5000;
			$sewa_per_km = 3000;
		} elseif ($_POST['kendaraan'] == 'Pickup') {
			$biaya_platform = 15000;
			$sewa_per_km = 8000;
		}

		$biaya_sewa = hitung_sewa($biaya_platform, $jarak_tempuh, $sewa_per_km);

		$_file_json = file_get_contents('data/data.json');
		$data_pemesanan = json_decode($_file_json, true);

		$_dataPesanan = [];

		foreach ($data_pemesanan as $order) {
			$_dataPesanan[] = [
				'nama' => $order['nama'],
				'noHP' => $order['noHP'], // Perhatikan kunci array yang sesuai
				'kendaraan' => $order['kendaraan'],
				'jarak' => $order['jarak'],
			];
		}

		$_dataPesanan[] = [
			'nama' => $_POST['nama'],
			'noHP' => $_POST['noHP'], // Perhatikan kunci array yang sesuai
			'kendaraan' => $_POST['kendaraan'],
			'jarak' => $_POST['jarak'],
			'biaya_sewa' => $biaya_sewa
		];

		$new_pemesanan = json_encode($_dataPesanan, JSON_PRETTY_PRINT);
		$file = fopen('data/data.json', 'w');
		fwrite($file, $new_pemesanan);
		fclose($file);
	}
	?>

	<?php
	if (isset($_POST['Pesan']) && isset($dataPesanan)) {
		echo "
    <br>
    <div class='container'>

        <div class='row'>
            <div class='col-lg-2'>Nama Pelanggan:</div>
            <div class='col-lg-2'>" . $dataPesanan['nama'] . "</div>
        </div>
        <div class='row'>
            <div class='col-lg-2'>Nomor HP:</div>
            <div class='col-lg-2'>" . $dataPesanan['noHP'] . "</div>
        </div>
        <div class='row'>
            <div class='col-lg-2'>Jenis Kendaraan:</div>
            <div class='col-lg-2'>" . $dataPesanan['kendaraan'] . "</div>
        </div>
        <div class='row'>
            <div class='col-lg-2'>Jarak(km):</div>
            <div class='col-lg-2'>" . $dataPesanan['jarak'] . " km</div>
        </div>
        <div class='row'>
            <div class='col-lg-2'>Total:</div>
            <div class='col-lg-2'>Rp" . number_format($biaya_sewa, 0, ".", ".") . ",-</div>
        </div>

    </div>
    ";
	}
	?>
</body>

</html>