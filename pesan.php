<?php
session_start();
require_once "../function.php";

// Cek apakah user sudah login
if (!isset($_SESSION["akun-user"])) {
    header("Location: login.php");
    exit;
}

// Ambil username dari session
$username = $_SESSION['akun-user']['username'];

// Ambil id_user dari tabel user berdasarkan username
$query_user = "SELECT id_user FROM user WHERE username = '$username'";
$result_user = mysqli_query($koneksi, $query_user);

if (!$result_user || mysqli_num_rows($result_user) === 0) {
    echo "User tidak ditemukan.";
    exit;
}

$id_user = mysqli_fetch_assoc($result_user)['id_user'];

// Validasi input menu
if (!isset($_POST['kode_menu']) || !is_array($_POST['kode_menu'])) {
    echo "Tidak ada menu yang dipilih.";
    exit;
}

$kode_pesanan = uniqid("PSN");
$waktu = date("Y-m-d H:i:s");
$nama_pelanggan = mysqli_real_escape_string($koneksi, $_POST['pelanggan']);
$kode_menu_terpilih = $_POST['kode_menu'];
$qty_data = isset($_POST['qty']) && is_array($_POST['qty']) ? $_POST['qty'] : [];

$success = false;

foreach ($kode_menu_terpilih as $kode_menu) {
    $qty = isset($qty_data[$kode_menu]) ? (int)$qty_data[$kode_menu] : 0;

    if ($qty > 0) {
        $kode_menu = mysqli_real_escape_string($koneksi, $kode_menu);
        $query_pesanan = "INSERT INTO pesanan (kode_pesanan, kode_menu, qty, id_user, keterangan) 
                          VALUES ('$kode_pesanan', '$kode_menu', '$qty','$id_user','Belum Selesai')";
        $result_pesanan = mysqli_query($koneksi, $query_pesanan);

        if ($result_pesanan) {
            $success = true;
        }
    }
}

// Simpan ke transaksi jika ada pesanan berhasil
if ($success) {
    $query_transaksi = "INSERT INTO transaksi (kode_pesanan, nama_pelanggan, waktu) 
                        VALUES ('$kode_pesanan', '$nama_pelanggan', '$waktu')";
    $result_transaksi = mysqli_query($koneksi, $query_transaksi);

    if ($result_transaksi) {
        echo "pesanan berhasil";
        exit;
    } else {
        echo "Gagal menambahkan ke transaksi.";
    }
} else {
    echo "Tidak ada pesanan valid yang disimpan.";
}
?>
