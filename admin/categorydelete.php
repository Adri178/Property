<?php
session_start();
require("config.php");

// Cek apakah pengguna telah login sebagai admin
if(!isset($_SESSION['auser'])) {
    header("location:index.php");
    exit; // Hentikan eksekusi skrip jika pengguna belum login
}

// Pastikan hanya aksi penghapusan yang diizinkan
if(isset($_GET['act']) && $_GET['act'] == 'hapus') {
    // Pastikan parameter id_kategori ada dan tidak kosong
    if(isset($_GET['id']) && !empty($_GET['id'])) {
        // Lakukan sanitasi input untuk mencegah SQL injection
        $id_kategori = mysqli_real_escape_string($con, $_GET['id']);
        
        // Lakukan penghapusan kategori dari database
        $query = mysqli_query($con, "DELETE FROM kategori WHERE id_kategori = '$id_kategori'");
        
        if($query) {
            // Redirect ke halaman kategori dengan pesan sukses
            header("Location: category.php?msg=Kategori berhasil dihapus");
            exit;
        } else {
            // Jika gagal menghapus, redirect dengan pesan error
            header("Location: category.php?msg=Gagal menghapus kategori");
            exit;
        }
    } else {
        // Jika parameter id_kategori tidak ada, redirect dengan pesan error
        header("Location: category.php?msg=Parameter id_kategori tidak valid");
        exit;
    }
} else {
    // Jika aksi yang diminta tidak valid, redirect dengan pesan error
    header("Location: category.php?msg=Aksi tidak valid");
    exit;
}
?>
