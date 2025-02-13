<?php
// Koneksi database
$conn = mysqli_connect("localhost", "root", "", "db_donor");

// Fungsi untuk menghitung usia
function hitungUsia($ttl) {
    $birth_date = new DateTime($ttl);
    $today = new DateTime();
    $age = $today->diff($birth_date);
    return $age->y;
}

// Proses simpan data
if(isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $ttl = $_POST['ttl'];
    $goldar = $_POST['goldar'];
    $no_hp = $_POST['no_hp'];
    
    $query = "INSERT INTO tbl_pendonor (nama, alamat, ttl, goldar, no_hp) 
              VALUES ('$nama', '$alamat', '$ttl', '$goldar', '$no_hp')";
    mysqli_query($conn, $query);
    
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}

// Query untuk pencarian
$where = "";
if(isset($_GET['cari'])) {
    $cari = $_GET['cari'];
    $filter = $_GET['filter'];
    if($filter == 'goldar') {
        $where = "WHERE goldar LIKE '%$cari%'";
    } else {
        $where = "WHERE nama LIKE '%$cari%'";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Aplikasi Donor Darah</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar {
            background: linear-gradient(135deg, #ff4b4b, #ff6b6b);
            padding: 1rem 0;
            margin-bottom: 2rem;
        }
        .navbar-brand {
            color: white !important;
            font-size: 1.5rem;
            font-weight: bold;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
            transition: transform 0.2s;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card-header {
            background: linear-gradient(135deg, #ff4b4b, #ff6b6b);
            color: white;
            font-weight: bold;
            border-radius: 15px 15px 0 0 !important;
            padding: 1rem;
        }
        .btn-primary {
            background: linear-gradient(135deg, #ff4b4b, #ff6b6b);
            border: none;
            padding: 0.5rem 1.5rem;
            border-radius: 25px;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #ff6b6b, #ff4b4b);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .table {
            background: white;
            border-radius: 10px;
            overflow: hidden;
        }
        .table thead th {
            background: #ff4b4b;
            color: white;
            border: none;
        }
        .form-control {
            border-radius: 10px;
            border: 1px solid #ced4da;
            padding: 0.75rem;
        }
        .form-control:focus {
            box-shadow: 0 0 0 0.2rem rgba(255, 75, 75, 0.25);
            border-color: #ff4b4b;
        }
        .blood-icon {
            font-size: 2rem;
            color: #ff4b4b;
            margin-right: 10px;
        }
        .stats-card {
            text-align: center;
            padding: 1rem;
            background: white;
            border-radius: 15px;
            margin-bottom: 1rem;
        }
        .stats-number {
            font-size: 2rem;
            font-weight: bold;
            color: #ff4b4b;
        }
        .stats-label {
            color: #6c757d;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-heart blood-icon"></i>
                Sistem Informasi Donor Darah
            </a>
        </div>
    </nav>

    <div class="container">
        <!-- Statistik -->
        <div class="row mb-4">
            <?php
            $total_donor = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tbl_pendonor"));
            $total_a = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tbl_pendonor WHERE goldar='A'"));
            $total_b = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tbl_pendonor WHERE goldar='B'"));
            $total_o = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tbl_pendonor WHERE goldar='O'"));
            ?>
            <div class="col-md-3">
                <div class="stats-card">
                    <div class="stats-number"><?php echo $total_donor; ?></div>
                    <div class="stats-label">Total Pendonor</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card">
                    <div class="stats-number"><?php echo $total_a; ?></div>
                    <div class="stats-label">Golongan A</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card">
                    <div class="stats-number"><?php echo $total_b; ?></div>
                    <div class="stats-label">Golongan B</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card">
                    <div class="stats-number"><?php echo $total_o; ?></div>
                    <div class="stats-label">Golongan O</div>
                </div>
            </div>
        </div>

        <!-- Form Pendaftaran dan Pencarian dalam satu row -->
        <div class="row">
            <!-- Form Pendaftaran -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-user-plus me-2"></i>
                        Form Pendaftaran Donor
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label><i class="fas fa-user me-2"></i>Nama</label>
                                    <input type="text" name="nama" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label><i class="fas fa-phone me-2"></i>No. HP</label>
                                    <input type="text" name="no_hp" class="form-control" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label><i class="fas fa-map-marker-alt me-2"></i>Alamat</label>
                                <textarea name="alamat" class="form-control" required rows="2"></textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label><i class="fas fa-calendar me-2"></i>Tanggal Lahir</label>
                                    <input type="date" name="ttl" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label><i class="fas fa-tint me-2"></i>Golongan Darah</label>
                                    <select name="goldar" class="form-control" required>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="AB">AB</option>
                                        <option value="O">O</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" name="simpan" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Simpan
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Form Pencarian -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-search me-2"></i>
                        Pencarian Pendonor
                    </div>
                    <div class="card-body">
                        <form method="GET">
                            <div class="mb-3">
                                <label><i class="fas fa-keyboard me-2"></i>Kata Kunci</label>
                                <input type="text" name="cari" class="form-control" placeholder="Masukkan kata kunci...">
                            </div>
                            <div class="mb-3">
                                <label><i class="fas fa-filter me-2"></i>Filter Berdasarkan</label>
                                <select name="filter" class="form-control">
                                    <option value="nama">Nama Pendonor</option>
                                    <option value="goldar">Golongan Darah</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-search me-2"></i>Cari
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Pendonor -->
        <div class="card mt-4">
            <div class="card-header">
                <i class="fas fa-table me-2"></i>
                Daftar Pendonor
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>Tanggal Lahir</th>
                                <th>Usia</th>
                                <th>Golongan Darah</th>
                                <th>No. HP</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT * FROM tbl_pendonor $where ORDER BY id DESC";
                            $result = mysqli_query($conn, $query);
                            $no = 1;
                            while($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>".$no++."</td>";
                                echo "<td>".$row['nama']."</td>";
                                echo "<td>".$row['alamat']."</td>";
                                echo "<td>".date('d-m-Y', strtotime($row['ttl']))."</td>";
                                echo "<td>".hitungUsia($row['ttl'])." tahun</td>";
                                echo "<td><span class='badge bg-danger'>".$row['goldar']."</span></td>";
                                echo "<td>".$row['no_hp']."</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>