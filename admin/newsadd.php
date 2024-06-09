<?php 	
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require("config.php"); 
if(!isset($_SESSION['auser']))
{
	header("location:index.php");
}
// Fetch categories
$sql_kat = 'SELECT id_kategori, kategori FROM kategori ORDER BY kategori ASC';
$qry_kat = mysqli_query($con, $sql_kat);

// Add news
$error = "";
$msg = "";
if(isset($_POST['addabout']))
{
	$title = mysqli_real_escape_string($con, $_POST['title']);
	$kategori = $_POST['kategori'];
	$content = mysqli_real_escape_string($con, $_POST['content']);
	$file_name_gambar = $_FILES['aimage']['name'];
	$temp_name1 = $_FILES['aimage']['tmp_name'];
	$target_path_gambar = "../news/images/";
	$file_max_weight = 2048000; // 2 MB
	$ok_ext = array('jpg', 'png', 'gif', 'jpeg');

	$filename_gambar = explode(".", $file_name_gambar);
	$file_extension_gambar = end($filename_gambar);
	$file_weight_gambar = $_FILES['aimage']['size'];

	if (empty($file_name_gambar)) {
		$error .= "<p class='alert alert-warning'>Anda belum memilih file untuk gambar</p>";
	} elseif (!in_array($file_extension_gambar, $ok_ext)) {
		$error .= "<p class='alert alert-warning'>Type file tidak diperbolehkan</p>";
	} elseif ($file_weight_gambar > $file_max_weight) {
		$error .= "<p class='alert alert-warning'>Ukuran file terlalu besar</p>";
	} else {
		// // Debugging path
		// echo "<p class='alert alert-info'>Temporary path: $temp_name1</p>";
		// echo "<p class='alert alert-info'>Target path: " . $target_path_gambar . $file_name_gambar . "</p>";

		if (move_uploaded_file($temp_name1, $target_path_gambar . $file_name_gambar)) {
			$tgl_posting = date('Y-m-d H:i:s');
			$id_admin = $_SESSION['id_admin'];

			$insert_sql = "INSERT INTO berita (judul, id_kategori, gambar, teks_berita, tgl_posting, id_admin, dilihat) VALUES (
				'$title', '$kategori', '$file_name_gambar', '$content', '$tgl_posting', '$id_admin', '0')";
			$insert_qry = mysqli_query($con, $insert_sql);

			if($insert_qry) {
				$msg = "<p class='alert alert-success'>Data Berhasil Ditambah</p>";
			} else {
				$error .= "<p class='alert alert-warning'>* Not Inserted Some Error</p>";
			}
		} else {
			$error .= "<p class='alert alert-warning'>Gagal memindahkan file gambar</p>";
		}
	}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>LM HOMES | News</title>
    
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    
    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    
    <!-- Feathericon CSS -->
    <link rel="stylesheet" href="assets/css/feathericon.min.css">
    
    <!-- Select2 CSS -->
    <link rel="stylesheet" href="assets/css/select2.min.css">
    
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
                        <h3 class="page-title">News</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">News</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">News</h2>
                        </div>
                        <form method="post" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-12">
                                    <h5 class="card-title">Add News</h5>
                                    <?php echo $error; ?>
                                    <?php echo $msg; ?>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Title</label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control" name="title" required="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Image</label>
                                        <div class="col-lg-9">
                                            <input class="form-control" name="aimage" type="file" required="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Category</label>
                                        <div class="col-lg-9">
                                            <select class="form-control input-sm" name="kategori" required>
                                                <option value="">Pilih Kategori</option>
                                                <?php while ($kat = mysqli_fetch_assoc($qry_kat)) { ?>
                                                    <option value="<?php echo $kat['id_kategori']; ?>"><?php echo $kat['kategori']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">Content</label>
                                        <div class="col-lg-9">
                                            <textarea class="tinymce form-control" name="content" rows="10" cols="30"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-left">
                                <input type="submit" class="btn btn-primary"  value="Submit" name="addabout" style="margin-left:200px;">
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Wrapper -->
    <!-- /Main Wrapper -->

    <!-- TinyMCE -->
    <script src="assets/plugins/tinymce/tinymce.min.js"></script>
    <script src="assets/plugins/tinymce/init-tinymce.min.js"></script>
    <!-- jQuery -->
    <script src="assets/js/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap Core JS -->
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- Slimscroll JS -->
    <script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <!-- Select2 JS -->
    <script src="assets/js/select2.min.js"></script>
    <!-- Custom JS -->
    <script src="assets/js/script.js"></script>
</body>

</html>