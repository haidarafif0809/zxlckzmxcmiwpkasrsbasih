<?php 


include 'db.php';

$id = $_POST['id'];


$query = $db->query("DELETE FROM poli WHERE id = '$id'");


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>
