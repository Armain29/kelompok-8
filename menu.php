<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Masakan</title>
    <!-- Bootstrap 4 & Icons -->
    <link rel="stylesheet" href="../asset/bootstrap/css/bootstrap.min.css">
    <link href="../asset/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', sans-serif;
        }

        .card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card:hover {
            transform: scale(1.02);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        .navbar-light {
            background-color: #e9f7ef;
            border-radius: 8px;
            padding: 1rem;
        }

        .card-header {
            font-weight: bold;
            background: #17a2b8;
            color: white;
        }

        .btn-success, .btn-primary {
            border-radius: 25px;
        }

        .table td {
            vertical-align: middle;
        }

        .card-body {
            padding: 1rem;
        }

        .form-row {
            margin-bottom: 20px;
        }

        .btn-warning, .btn-danger {
            border-radius: 20px;
        }

        /* Mengatur ukuran card agar otomatis mengikuti konten */
        .card {
            width: auto;  /* Card menyesuaikan lebar konten */
            height: auto; /* Card menyesuaikan tinggi konten */
        }

        /* Agar tombol tidak terdistorsi dan lebih responsif */
        .btn {
            width: auto; /* Tombol dengan lebar otomatis */
        }
    </style>
</head>
<body class="container py-4">

    <!-- Search & Tambah -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <form action="index.php" method="GET" class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" autocomplete="off" name="key-search" placeholder="Cari menu...">
            <button class="btn btn-success my-2 my-sm-0" name="search">
                <i class="bi bi-search"></i> Cari
            </button>
        </form>
    </div>

    <!-- Pemesanan -->
    <?php if (isset($_SESSION["akun-user"])) { ?>
    <form action="halaman/pesan.php" method="POST" class="mb-4">
        <div class="form-row align-items-center">
            <div class="col-sm-8 my-1">
                <input type="text" class="form-control" name="pelanggan" placeholder="Nama Pelanggan" required autocomplete="off">
            </div>
            <div class="col-auto my-1">
                <div class="d-flex  mt-1">
                    <input type="hidden" name="kode_menu" value="<?= $m['kode_menu']; ?>">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-cart-check-fill"></i> Pesan
                    </button>
                </div>
            </div>
        </div>
    
    <?php } ?>

    <!-- Menu Masakan -->
    <div class="row m-4">
         <!-- Menambahkan form untuk pemesanan -->
            <?php 
            $i = 1;
            foreach ($menu as $m) { ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-90 shadow-sm border-0">
                        <div class="card-header d-flex align-items-center">
                            <input 
                                type="checkbox" 
                                class="form-check-input ml-3 mb-1" 
                                name="kode_menu[]" 
                                value="<?= $m['kode_menu']; ?>" 
                                id="menu<?= $i; ?>">
                            <label for="menu<?= $i; ?>" class="mb-0 ml-5"><?= $m["nama"]; ?></label>
                        </div>

                        <div class="card-body text-center">
                            <img class="rounded mb-3" src="src/img/<?= $m["gambar"]; ?>" width="150">
                            <input type="hidden" name="kode_menu<?= $i; ?>" value="<?= $m["kode_menu"]; ?>">

                            <table class="table table-sm text-left">
                                <tr><td>Harga </td><td>:</td><td>Rp<?= number_format($m["harga"], 0, ',', '.'); ?></td></tr>
                                <tr><td>Kategori</td><td>:</td><td><?= $m["kategori"]; ?></td></tr>
                                <tr><td>Status</td><td>:</td><td><?= $m["status"]; ?></td></tr>
                                <tr>
                                    <td>Qty</td><td>:</td>
                                    <td>
                                        <input type="number" min="0" class="form-control form-control-sm w-50 mx-auto" name="qty[<?= $m['kode_menu']; ?>]" value="0">
                                    </td>
                                </tr>
                            </table>

                            
                        </div>
                    </div>
                </div>



            <?php $i++; } ?>

            
        </form>
    </div>
</body>
</html>

