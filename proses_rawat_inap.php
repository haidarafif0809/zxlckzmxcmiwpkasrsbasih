<?php 
include 'db.php';
include_once 'sanitasi.php';
session_start();

$token = stringdoang($_POST['token']);


// start data agar tetap masuk 
try {
    // First of all, let's begin a transaction
$db->begin_transaction();
    // A set of queries; if one fails, an exception should be thrown
 // begin data

if ($token == '')
{
  
header("location:rawat_inap.php");

}
else
{

$username = stringdoang($_SESSION['user_name']);
$tanggal_lahir = tanggal($_POST['tanggal_lahir']);
$umur = stringdoang($_POST['umur']);
$no_rm = stringdoang($_POST['no_rm']);
$nama_lengkap = stringdoang($_POST['nama_lengkap']);
$alamat = stringdoang($_POST['alamat']);
$jenis_kelamin = stringdoang($_POST['jenis_kelamin']);
$hp_pasien = stringdoang($_POST['hp_pasien']);
$kondisi = stringdoang($_POST['kondisi']);
$penjamin = stringdoang($_POST['penjamin']);
$surat_jaminan = stringdoang($_POST['surat_jaminan']);
$menginap = angkadoang($_POST['perkiraan_menginap']);
$penanggung_jawab = stringdoang($_POST['penanggung_jawab']);
$alamat_penanggung = stringdoang($_POST['alamat_penanggung']);
$no_hp_penanggung = stringdoang($_POST['no_hp_penanggung']);
$pekerjaan = stringdoang($_POST['pekerjaan_penanggung']);
$hubungan_dengan_pasien = stringdoang($_POST['hubungan_dengan_pasien']);
$dokter_penanggung_jawab = stringdoang($_POST['dokter_penanggung_jawab']);
$bed = stringdoang($_POST['bed']);
$poli = stringdoang($_POST['poli']);
$dokter_pengirim = stringdoang($_POST['dokter_pengirim']);
$group_bed = stringdoang($_POST['group_bed']);
$tinggi_badan = stringdoang($_POST['tinggi_badan']);
$berat_badan = stringdoang($_POST['berat_badan']);
$suhu = stringdoang($_POST['suhu']);
$nadi = stringdoang($_POST['nadi']);
$respiratory_rate = stringdoang($_POST['respiratory_rate']);
$sistole_distole = stringdoang($_POST['sistole_distole']);
$perujuk = stringdoang($_POST['rujukan']);
$alergi = stringdoang($_POST['alergi']);


$jam =  date("H:i:s");
$tanggal_sekarang = date("Y-m-d");
$waktu = date("Y-m-d H:i:s");

$no_urut = 1;
$bulan_php = date("m");
$tahun_php = date("Y");

$select_to = $db->query("SELECT nama_pasien FROM registrasi WHERE jenis_pasien = 'Rawat Inap' ORDER BY id DESC LIMIT 1 ");
$keluar = mysqli_fetch_array($select_to);

if ($keluar['nama_pasien'] == $nama_lengkap )
{
header('location:rawat_inap.php');
}
else{
// START UNTUK AMBIL NO REG NYA LEWAT PROSES SAJA

// START UNTUK NO REG 

 $tahun_terakhir = substr($tahun_php, 2);

//ambil bulan dari tanggal penjualan terakhir

 $bulan_terakhir = $db->query("SELECT MONTH(tanggal) as bulan FROM registrasi ORDER BY id DESC LIMIT 1");
 $v_bulan_terakhir = mysqli_fetch_array($bulan_terakhir);
$bulan_terakhir_reg = $v_bulan_terakhir['bulan'];
//ambil nomor  dari penjualan terakhir
$no_terakhir = $db->query("SELECT no_reg FROM registrasi ORDER BY id DESC LIMIT 1");
 $v_no_terakhir = mysqli_fetch_array($no_terakhir);
$ambil_nomor = substr($v_no_terakhir['no_reg'],0,-8);

/*jika bulan terakhir dari penjualan tidak sama dengan bulan sekarang, 
maka nomor nya kembali mulai dari 1 ,
jika tidak maka nomor terakhir ditambah dengan 1
 
 */
 if ($bulan_terakhir_reg != $bulan_php) {
  # code...
 $no_reg = "1-REG-".$bulan_php."-".$tahun_terakhir;

 }

 else


 {

$nomor = 1 + $ambil_nomor ;

 $no_reg = $nomor."-REG-".$bulan_php."-".$tahun_terakhir;


 }
 // AKHIR UNTUK NO REG
                      // ENDING -- UNTUK AMBIL NO REG NYA LEWAT PROSES SAJA



$query2 = $db->prepare("INSERT INTO registrasi (alergi,rujukan,nama_pasien,jam,penjamin,status,no_reg,no_rm,tanggal_masuk,kondisi,petugas,alamat_pasien,umur_pasien,hp_pasien,bed,group_bed,menginap,dokter,dokter_pengirim,penanggung_jawab,alamat_penanggung_jawab,hp_penanggung_jawab,pekerjaan_penanggung_jawab,hubungan_dengan_pasien,jenis_kelamin,poli,jenis_pasien,tanggal) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

$query2->bind_param("ssssssssssssssssssssssssssss",$alergi,$perujuk,$nama_lengkap,$jam,$penjamin,$menginap_status,$no_reg,$no_rm,$tanggal_sekarang,$kondisi,$username,$alamat,$umur,$hp_pasien,$bed,$group_bed,$perkiraan_menginap,$dokter_penanggung_jawab,$dokter_pengirim,$penanggung_jawab,$alamat_penanggung,$no_hp_penanggung,$pekerjaan,$hubungan_dengan_pasien,$jenis_kelamin,$poli,$rw_inap,$tanggal_sekarang);


$menginap_status = "menginap";
$rw_inap = "Rawat Inap";

$query2->execute();



$sql0 = $db->prepare("INSERT INTO rekam_medik_inap
(group_bed,alergi,no_reg,no_rm,nama,alamat,umur,jenis_kelamin,sistole_distole,suhu,berat_badan,tinggi_badan,nadi,
respiratory,poli,tanggal_periksa,jam,dokter,kondisi,rujukan,dokter_penanggung_jawab,bed)
VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

$sql0->bind_param("ssssssssssssssssssssss",$group_bed,$alergi,$no_reg,$no_rm,$nama_lengkap,$alamat,$umur,$jenis_kelamin,$sistole_distole,$suhu,$berat_badan,$tinggi_badan,$nadi,$respiratory_rate,$poli,$tanggal_sekarang,$jam,$dokter_pengirim,$kondisi,$perujuk,$dokter_penanggung_jawab,$bed);


$sql0->execute();


// UPDATE PASIEN NYA
$update_pasien = "UPDATE pelanggan SET pekerjaan_suamiortu = '$pekerjaan', no_hp_penanggung = '$no_hp_penanggung', hubungan_dengan_pasien = '$hubungan_dengan_pasien', alamat_penanggung = '$alamat_penanggung', nama_penanggungjawab = '$penanggung_jawab', umur = '$umur', no_telp = '$hp_pasien', alamat_sekarang = '$alamat', penjamin = '$penjamin' WHERE no_rm = '$no_rm'";
if ($db->query($update_pasien) === TRUE) 
  {
} 
else 
    {
    echo "Error: " . $update_pasien . "<br>" . $db->error;
    } 

// UPDATE KAMAR
$query = $db->query("UPDATE bed SET sisa_bed = sisa_bed - 1 WHERE nama_kamar = '$bed' AND group_bed = '$group_bed'");
// END UPDATE KAMAR

  
// ambil bahan untuk kamar 
$query20 = $db->query(" SELECT * FROM penjamin WHERE nama = '$penjamin'");
$data20  = mysqli_fetch_array($query20);
$level_harga = $data20['harga'];

$cari_harga_kamar = $db->query("SELECT tarif,tarif_2,tarif_3,tarif_4,tarif_5,tarif_6,tarif_7 FROM bed WHERE nama_kamar = '$bed' AND group_bed = '$group_bed' ");
$kamar_luar = mysqli_fetch_array($cari_harga_kamar);
$harga_kamar1 = $kamar_luar['tarif'];
$harga_kamar2 = $kamar_luar['tarif_2'];
$harga_kamar3 = $kamar_luar['tarif_3'];
$harga_kamar4 = $kamar_luar['tarif_4'];
$harga_kamar5 = $kamar_luar['tarif_5'];
$harga_kamar6 = $kamar_luar['tarif_6'];
$harga_kamar7 = $kamar_luar['tarif_7'];
//end bahan untuk kamar




// harga_1 (pertama)
if ($level_harga == 'harga_1')
    {

$subtotal = $menginap * $harga_kamar1;


$query65 = "INSERT INTO tbs_penjualan (no_reg,kode_barang,nama_barang,jumlah_barang,harga,subtotal,tipe_barang,potongan,tax) VALUES ('$no_reg','$bed','$group_bed','$menginap','$harga_kamar1','$subtotal','Jasa','0','0')";
      if ($db->query($query65) === TRUE) 
      {
  
      } 
        else 
      {
    echo "Error: " . $query65 . "<br>" . $db->error;
      }


    }
//end harga_1 (pertama)

// harga_2 (pertama)
else if ($level_harga == 'harga_2')
{

$subtotal = $menginap * $harga_kamar2;


$query65 = "INSERT INTO tbs_penjualan (no_reg,kode_barang,nama_barang,jumlah_barang,harga,subtotal,tipe_barang,potongan,tax) VALUES ('$no_reg','$bed','$group_bed','$menginap','$harga_kamar2','$subtotal','Jasa','0','0')";
      if ($db->query($query65) === TRUE) 
      {
  
      } 
        else 
      {
         echo "Error: " . $query65 . "<br>" . $db->error;
      }


}
//end harga_2 (pertama)


// harga_3 (pertama)
else if ($level_harga == 'harga_3')
{

$subtotal = $menginap * $harga_kamar3;


$query65 = "INSERT INTO tbs_penjualan (no_reg,kode_barang,nama_barang,jumlah_barang,harga,subtotal,tipe_barang,potongan,tax) VALUES ('$no_reg','$bed','$group_bed','$menginap','$harga_kamar3','$subtotal','Jasa','0','0')";
      if ($db->query($query65) === TRUE) 
      {
  
      } 
        else 
      {
        echo "Error: " . $query65 . "<br>" . $db->error;
      }


}
// harga_3 (pertama)

// harga_4 (pertama)
else if ($level_harga == 'harga_4')
{

$subtotal = $menginap * $harga_kamar4;


$query65 = "INSERT INTO tbs_penjualan (no_reg,kode_barang,nama_barang,jumlah_barang,harga,subtotal,tipe_barang,potongan,tax) VALUES ('$no_reg','$bed','$group_bed','$menginap','$harga_kamar4','$subtotal','Jasa','0','0')";
      if ($db->query($query65) === TRUE) 
      {
        
      } 
        else 
      {
        echo "Error: " . $query65 . "<br>" . $db->error;
      }


}
// harga_4 (pertama)

else if ($level_harga == 'harga_5')
{

$subtotal = $menginap * $harga_kamar5;


$query65 = "INSERT INTO tbs_penjualan (no_reg,kode_barang,nama_barang,jumlah_barang,harga,subtotal,tipe_barang,potongan,tax) VALUES ('$no_reg','$bed','$group_bed','$menginap','$harga_kamar5','$subtotal','Jasa','0','0')";
      if ($db->query($query65) === TRUE) 
      {
  
      } 
        else 
      {

    echo "Error: " . $query65 . "<br>" . $db->error;

      }


}
// harga_5 (pertama)

else if ($level_harga == 'harga_6')
{

$subtotal = $menginap * $harga_kamar6;


$query65 = "INSERT INTO tbs_penjualan (no_reg,kode_barang,nama_barang,jumlah_barang,harga,subtotal,tipe_barang,potongan,tax) VALUES ('$no_reg','$bed','$group_bed','$menginap','$harga_kamar6','$subtotal','Jasa','0','0')";
      if ($db->query($query65) === TRUE) 
      {
  
      } 
        else 
      {

    echo "Error: " . $query65 . "<br>" . $db->error;

      }


}
// harga_6 (pertama)


else if ($level_harga == 'harga_7')
{

$subtotal = $menginap * $harga_kamar7;

$query65 = "INSERT INTO tbs_penjualan (no_reg,kode_barang,nama_barang,jumlah_barang,harga,subtotal,tipe_barang,potongan,tax) VALUES ('$no_reg','$bed','$group_bed','$menginap','$harga_kamar7','$subtotal','Jasa','0','0')";
      if ($db->query($query65) === TRUE) 
      {
  
      } 
        else 
      {
        echo "Error: " . $query65 . "<br>" . $db->error;
      }

}
// harga_7 (pertama)





} // biar gk double 
} // token



// Countinue data 
   // If we arrive here, it means that no exception was thrown
    // i.e. no query has failed, and we can commit the transaction
    $db->commit();
} catch (Exception $e) {
    // An exception has been thrown
    // We must rollback the transaction
    $db->rollback();
}
// ending agar data tetep masuk awalau koneksi putus 




?>

  <?php 

$query7 = $db->query("SELECT * FROM registrasi WHERE jenis_pasien = 'Rawat Inap' AND status = 'menginap' AND status != 'Batal Rawat Inap' AND tanggal = '$tanggal_sekarang'ORDER BY id DESC LIMIT 1 ");
  $data = mysqli_fetch_array($query7);
      

    echo "<tr class='tr-id-".$data['id']."'>
            <td>". $data['no_rm']."</td>
            <td>". $data['no_reg']."</td>
            <td>". $data['status']."</td>           
            <td>". $data['nama_pasien']."</td>
            <td>". $data['jam']."</td>           
            <td>". $data['penjamin']."</td>           
            <td>". $data['poli']."</td>
            <td>". $data['dokter_pengirim']."</td>
            <td>". $data['dokter']."</td>           
            <td>". $data['bed']."</td>
            <td>". $data['group_bed']."</td>
            <td>". tanggal($data['tanggal_masuk'])."</td>            
            <td>". $data['penanggung_jawab']."</td>
            <td>". $data['umur_pasien']."</td> 

            <td><a style='width:95px;' href='form-rujuk-lab-ri.php?no_reg=".$data['no_reg']."' class='btn btn-success'><i class='fa fa-hand-pointer-o'></i> Rujuk Lab</a></td>

          <td> <button style='width:120px;'  type='button' data-reg='".$data['no_reg']."' data-bed='".$data['bed']."' data-group-bed='".$data['group_bed']."' data-id='".$data['id']."' data-reg='".$data['no_reg']."'  class='btn btn-warning pindah'><i class='fa fa-reply'> Pindah Kamar</button></td>

          <td><button style='width:55px;' class='btn btn-danger' id='batal_ranap' data-reg='". $data['no_reg']. "' data-id='". $data['id']. "'><i class='fa fa-remove'> Batal</button></td>

      </tr>";
      
    ?>


<!--script disable hubungan pasien-->
<script type="text/javascript">
  $("#coba").click(function(){
  $("#demo").show();
  $("#kembali").show();
   $("#coba").hide();
  });
    $("#kembali").click(function(){
  $("#demo").hide();
  $("#coba").show();
  $("#kembali").hide();

  });

</script>