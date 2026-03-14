<?php
// Koneksi ke database
$koneksi = new mysqli('localhost', 'root', '', '');

// Ambil data transaksi
$query = 'SELECT * FROM transaksi ORDER BY tanggal_booking DESC';
$result = $koneksi->query($query);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Riwayat Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="bg-dark text-white p-3" style="width:250px; height:100vh;">
            <h4 class="mb-4">Admin Panel</h4>
            <ul class="nav flex-column">
                <li class="nav-item"><a href="#" class="nav-link text-white">Dashboard</a></li>
                <li class="nav-item"><a href="#" class="nav-link text-white">Kelola Lapangan</a></li>
                <li class="nav-item"><a href="#" class="nav-link text-white">Kelola Pengguna</a></li>
                <li class="nav-item"><a href="#" class="nav-link text-white">Laporan</a></li>
            </ul>
            <div class="mt-auto">
                <a href="logout.php" class="btn btn-danger w-100">Logout</a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-grow-1 p-4">
            <h2>Riwayat Transaksi</h2>
            <p>Daftar Transaksi Yang Telah Dilakukan</p>

            <!-- Filter -->
            <div class="d-flex mb-3">
                <input type="date" class="form-control me-2" />
                <select class="form-select me-2">
                    <option>Semua</option>
                    <option>Berhasil</option>
                    <option>Pending</option>
                </select>
                <input type="text" class="form-control me-2" placeholder="Cari Nama Pelanggan / Lapangan" />
                <button class="btn btn-primary">Export PDF</button>
            </div>

            <!-- Table -->
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Tanggal Booking</th>
                        <th>Lapangan</th>
                        <th>Jam Booking</th>
                        <th>Durasi</th>
                        <th>Nama Penyewa</th>
                        <th>Total Bayar</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
        $no = 1;
        while($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $row['tanggal_booking'] ?></td>
                        <td><?= $row['lapangan'] ?></td>
                        <td><?= $row['jam_booking'] ?></td>
                        <td><?= $row['durasi'] ?> Jam</td>
                        <td><?= $row['nama_penyewa'] ?></td>
                        <td>Rp. <?= number_format($row['total_bayar'], 0, ',', '.') ?></td>
                        <td>
                            <?php if($row['status'] == 'Berhasil'){ ?>
                            <span class="badge bg-success">Berhasil</span>
                            <?php } else { ?>
                            <span class="badge bg-warning"><?= $row['status'] ?></span>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
