<?php
session_start();
require("config.php");

if(!isset($_SESSION['auser'])) {
    header("location:index.php");
}

// Periksa apakah parameter query string msg ada
if(isset($_GET['msg'])) {
    $msg = $_GET['msg'];
    // Tampilkan pesan notifikasi
    echo "<script>alert('$msg');</script>";
}

// Process form submission to create or edit category
if(isset($_POST['submit'])) {
    $kategori = $_POST['kategori'];
    $action = $_POST['action'];

    if($action == 'add') {
        // Perform database insertion for new category
        mysqli_query($con, "INSERT INTO kategori (kategori) VALUES ('$kategori')");
        // After insertion, you might want to redirect or show a success message
        header("Location: category.php?msg=Category created successfully");
    } elseif($action == 'edit') {
        $id_kategori = $_POST['id_kategori'];
        // Perform database update for existing category
        mysqli_query($con, "UPDATE kategori SET kategori='$kategori' WHERE id_kategori='$id_kategori'");
        // After update, you might want to redirect or show a success message
        header("Location: category.php?msg=Category updated successfully");
    }
}

// Retrieve category data for editing
if(isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    // Retrieve category data from database based on edit_id
    $result = mysqli_query($con, "SELECT * FROM kategori WHERE id_kategori='$edit_id'");
    $row = mysqli_fetch_assoc($result);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>LM Homes | Admin</title>
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <!-- Feathericon CSS -->
    <link rel="stylesheet" href="assets/css/feathericon.min.css">
    <!-- Datatables CSS -->
    <link rel="stylesheet" href="assets/plugins/datatables/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="assets/plugins/datatables/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="assets/plugins/datatables/select.bootstrap4.min.css">
    <link rel="stylesheet" href="assets/plugins/datatables/buttons.bootstrap4.min.css">
    <!-- Main CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!--[if lt IE 9]>
        <script src="assets/js/html5shiv.min.js"></script>
        <script src="assets/js/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <!-- Main Wrapper -->
    <!-- Header -->
    <?php include("header.php"); ?>
    <!-- /Sidebar -->
    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title">Kategori</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Kategori</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title"><?php echo isset($_GET['edit_id']) ? 'Edit Kategori' : 'Tambah Kategori'; ?></h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="">
                                <input type="hidden" name="action" value="<?php echo isset($_GET['edit_id']) ? 'edit' : 'add'; ?>">
                                <?php if(isset($_GET['edit_id'])): ?>
                                    <input type="hidden" name="id_kategori" value="<?php echo $edit_id; ?>">
                                <?php endif; ?>
                                <div class="form-group">
                                    <label>Nama Kategori</label>
                                    <input class="form-control" name="kategori" type="text" placeholder="Masukkan Nama Kategori" value="<?php echo isset($row['kategori']) ? $row['kategori'] : ''; ?>" required>
                                </div>
                                <button type="submit" name="submit" class="btn btn-primary"><?php echo isset($_GET['edit_id']) ? 'Update' : 'Tambah'; ?></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Kategori List</h4>
                            <small>Jangan hapus data kategori, jika masih ada data berita</small>
                        </div>
                        <div class="card-body">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th width="10%" style="text-align: right">ID Kategori</th>
                                        <th width="70%">Kategori</th>
                                        <th width="20%" style="text-align: center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php 
                                $limit = 10;
                                if(isset($_GET['p'])) {
                                    $noPage = $_GET['p'];
                                } else {
                                    $noPage = 1;
                                }
                                $offset = ($noPage - 1) * $limit;

                                $sql = "SELECT id_kategori, kategori FROM kategori LIMIT ".$offset.",". $limit;
                                $qry = mysqli_query($con, $sql) or die (mysqli_error($con));

                                $sql_rec = "SELECT id_kategori FROM kategori";
                                $total_rec = mysqli_query($con, $sql_rec);
                                $total_rec_num = mysqli_num_rows($total_rec);
                                $total_page = ceil($total_rec_num/$limit);

                                while ($kat_list = $qry->fetch_assoc()) { ?>
                                    <tr>
                                        <td align="right"><?php echo $kat_list['id_kategori']; ?></td>
                                        <td><?php echo $kat_list['kategori'] ?></td>
                                        <td align="center">
                                            <?php if ($kat_list['kategori'] != 'Uncategorized') { ?>
                                                <a onclick="return confirm('Anda yakin ingin menghapus kategori ini?');" href="categorydelete.php?act=hapus&amp;id=<?php echo $kat_list['id_kategori']; ?>" class="btn btn-sm btn-danger">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                                <a href="category.php?edit_id=<?php echo $kat_list['id_kategori']; ?>" class="btn btn-sm btn-success">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>          
    </div>
    <!-- /Main Wrapper -->
    <!-- jQuery -->
    <script src="assets/js/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap Core JS -->
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- Slimscroll JS -->
    <script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <!-- Datatables JS -->
    <script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="assets/plugins/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="assets/plugins/datatables/dataTables.responsive.min.js"></script>
    <script src="assets/plugins/datatables/responsive.bootstrap4.min.js"></script>
    <script src="assets/plugins/datatables/dataTables.select.min.js"></script>
    <script src="assets/plugins/datatables/dataTables.buttons.min.js"></script>
    <script src="assets/plugins/datatables/buttons.bootstrap4.min.js"></script>
    <script src="assets/plugins/datatables/buttons.html5.min.js"></script>
    <script src="assets/plugins/datatables/buttons.flash.min.js"></script>
    <script src="assets/plugins/datatables/buttons.print.min.js"></script>
    <!-- Custom JS -->
    <script src="assets/js/script.js"></script>
</body>
</html>