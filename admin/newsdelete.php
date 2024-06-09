<?php
include("config.php");
if(isset($_GET['id'])) {
    $aid = $_GET['id'];

    // Ambil nama file gambar sebelum menghapus entri
    $sql = "SELECT gambar FROM berita WHERE id_berita='$aid'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);
    $img = $row["gambar"];

    // Hapus gambar dari server
    if (!empty($img)) {
        @unlink('../news/images/' . $img);
    }

    // Hapus entri dari database
    $sql = "DELETE FROM berita WHERE id_berita = {$aid}";
    $result = mysqli_query($con, $sql);

    if($result == true) {
        $msg="<p class='alert alert-success'>News Deleted</p>";
        header("Location:newsview.php?msg=$msg");
    } else {
        $msg="<p class='alert alert-warning'>News not Deleted</p>";
        header("Location:newsview.php?msg=$msg");
    }
} else {
    $msg="<p class='alert alert-danger'>Invalid request</p>";
    header("Location:newsview.php?msg=$msg");
}

mysqli_close($con);
?>