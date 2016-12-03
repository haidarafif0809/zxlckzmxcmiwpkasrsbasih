<?php include 'session_login.php';
include 'header.php';
include 'navbar.php';
include 'db.php';
include_once 'sanitasi.php';

$jam =  date("H:i:s");
$tanggal_sekarang = date("Y-m-d");
$waktu = date("Y-m-d H:i:s");
$bulan_php = date('m');
$tahun_php = date('Y');

$query7 = $db->query("SELECT * FROM registrasi WHERE jenis_pasien = 'Rawat Inap' AND status = 'menginap' AND status != 'Batal Rawat Inap' AND tanggal = '$tanggal_sekarang'ORDER BY id DESC ");

$qertu= $db->query("SELECT nama_dokter,nama_paramedik,nama_farmasi FROM penetapan_petugas ");
$ss = mysqli_fetch_array($qertu);

$q = $db->query("SELECT * FROM setting_registrasi");
$dq = mysqli_fetch_array($q);
?>

<style>
.disable1{
background-color:#cccccc;
opacity: 0.9;
    cursor: not-allowed;
}
.disable2{
background-color: #cccccc;
opacity: 0.9;
    cursor: not-allowed;
}
.disable3{
background-color: #cccccc;
opacity: 0.9;
    cursor: not-allowed;
}
.disable4{
background-color: #cccccc;
opacity: 0.9;
    cursor: not-allowed;
}
.disable5{
background-color: #cccccc;
opacity: 0.9;
    cursor: not-allowed;
}
.disable6{
background-color: #cccccc;
opacity: 0.9;
    cursor: not-allowed;
}

</style>
<div class="container">

<!-- Modal Untuk Confirm LAYANAN PERUSAHAAN-->
<div id="detail" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>       
    </div>
    <div class="modal-body">

      <span id="tampil_layanan">
      </span>
    </div>
    <div class="modal-footer">
        
        <button type="button" accesskey="e" class="btn btn-danger" data-dismiss="modal">Clos<u>e</u>d</button>
    </div>
    </div>
  </div>
</div>
<!--modal end Layanan Perusahaan-->


<!-- Modal Untuk Confirm KAMAR-->
<div id="modal_kamar" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
          <center><h2>Pindah Kamar</h2></center>       
    </div>
    <div class="modal-body">

      <span id="tampil_kamar">
      </span>
      <form role="form" method="POST">

      <div class="form-group" >
        <label for="bed">Kamar :</label>
        <input style="height: 20px" type="text" class="form-control" id="bed2" name="bed2" required="" readonly="" >
      </div>

      <div class="form-group" >
        <label for="bed">Group Bed:</label>
        <input style="height: 20px" type="text" class="form-control" id="group_bed2" name="group_bed2" required="" readonly="">
      </div>

 
       <button style='width:100px;'type='button' class='btn btn-warning pindah' data-id=""  data-reg="" data-bed="" data-group_bed="" id="pindah_kamar"> <i class="fa fa-reply"></i>Pindah</button>
       </div>
       <div class="modal-footer">
        
        <button type="button" class="btn btn-danger" data-dismiss="modal" ><i class="fa fa-remove"></i> Closed</button>
    </div>
    </div>
  </div>
</div>
<!--modal end Layanan KAMAR-->


<!-- Modal Untuk batal ranap-->
<div id="modal_batal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
          <center><h2>Pindah Kamar</h2></center>       
    </div>
    <div class="modal-body">

      <span id="tampil_batal">
      </span>
     
     <form role="form" method="POST">
     
     <div class="form-group">
     <label for="sel1">Keterangan</label>
     <textarea type="text" class="form-control" id="keterangan" name="keterangan"></textarea>
     </div>
     
     <input type="hidden" class="form-control" id="no_reg" name="no_reg" data-reg="" >
     
     <button type="submit" class="btn btn-info" id="input_keterangan" data-id=""> <i class="fa fa-send" ></i> Input Keterangan</button>
     </form>

       </div>
       <div class="modal-footer">
        
        <button type="button" class="btn btn-danger" data-dismiss="modal" ><i class="fa fa-remove"></i> Closed</button>
    </div>
    </div>
  </div>
</div>
<!--modal end batal ranap-->


<h3>DATA PASIEN RAWAT INAP</h3>
<hr>

<button data-toggle="collapse" accesskey="r" id="coba" class="btn btn-primary"><i class="fa fa-plus"></i> Daftar <u>R</u>awat Inap</button>


<button style="display:none" data-toggle="collapse" accesskey="k" id="kembali" class="btn btn-primary"><i class="fa fa-reply"></i> <u>K</u>embali </button>



  <!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Pencarian Pasien </h4>
      </div>
      <div class="modal-body">
      <span id="hasil_migrasi"></span>
      
      </div>
      <div class="modal-footer">
        <button type="button" accesskey="e" class="btn btn-danger" data-dismiss="modal">Clos<u>e</u></button>
      </div>
    </div>

  </div>
</div>
 
<!-- akhir modal -->


 <!-- Modalkamar -->
<div id="myModal1" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content2 -->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Pencarian Kamar Pasien </h4>
      </div>
      <div class="modal-body">
      <div class="table-responsive">
        <table id="siswa1" class="table table-bordered table-hover table-striped">
          <thead>
          <tr>
          <th>Kelas</th>
          <th>Kode Kamar</th>
          <th>Nama Kamar</th>
          <th> Fasilitas</th>
          <th>Jumlah Bed</th>  
          <th>Sisa Bed</th>                                          
          </tr>
          </thead>
          <tbody>
          <?php
          //Data mentah yang ditampilkan ke tabel    
          include 'db.php';
          $hasil = $db->query("SELECT * FROM bed WHERE sisa_bed != 0 ");
                                        
          while ($data =  $hasil->fetch_assoc()) {
          ?>
          <tr class="pilih2" 
          data-nama="<?php echo $data['nama_kamar']; ?>" 
          data-group-bed ="<?php echo $data['group_bed']; ?>" >
          
          <td><?php echo $data['kelas']; ?></td>
          <td><?php echo $data['nama_kamar']; ?></td>
          <td><?php echo $data['group_bed']; ?></td>
          <td><?php echo $data['fasilitas']; ?></td>
           <td><?php echo $data['jumlah_bed']; ?></td>         
           <td><?php echo $data['sisa_bed']; ?></td>                           
          </tr>
          <?php
          }
          ?>
          </tbody>
          </table>  
       </div> <!-- table responsive  -->
        </div>
        <div class="modal-footer">
        <button type="button" accesskey="o" class="btn btn-danger" data-dismiss="modal">Cl<u>o</u>se</button>
        </div>
        </div>
        
        </div>
        </div> 
<!-- akhir modal Kamar-->

<!-- Modal rujukan lab-->
<div id="Modal3" class="modal fade" role="dialog">
 
<div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Rujuk Laboratorium </h4>

      </div>
      <div class="modal-body">
       <span id="rujukan_lab">
       </span> 
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
  
<!-- akhir modal3-->


<a href="rawat_inap_pasien_baru.php" accesskey="b" class="btn btn-info"> <i class="fa fa-plus"></i> Pasien <u>B</u>aru Rawat Inap</a>



<div id="demo" class="collapse">
<div class="row">

<br>
<div class="col-sm-4">

<form role="form" method="POST">

<button type="button" accesskey="c" class="btn btn-success" data-toggle="modal" data-target="#myModal1"> <i class="fa fa-search"></i> <u>C</u>ari kamar</button>
 <br>
 <br>

<div class="card card-block">

<div class="form-group" >
  <label for="bed">Kamar:</label>
  <input style="height: 20px;" type="text" class="form-control disable" id="group_bed" name="group_bed" required="" >
</div>


<div class="form-group" >
  <label for="bed">Bed:</label>
  <input style="height: 20px;" type="text" class="form-control disable" id="bed" name="bed" required="" >
</div>

</div>

<div class="card card-block">
   
<div class="form-group">
  <label for="sel1">Perujuk:</label>
  <select class="form-control" id="rujukan" name="rujukan" required="" autocomplete="off">
   <option value="Non Rujukan">Non Rujukan</option>
      <?php 
      $query = $db->query("SELECT nama FROM perujuk ");
      while ( $data = mysqli_fetch_array($query)) {
      echo "<option value='".$data['nama']."'>".$data['nama']."</option>";
      }
      ?>
  </select>
</div>



  
  <div class="form-group">
    <label for=""><u>C</u>ari Pasien Lama</label>
    <input style="height: 20px;" type="text" accesskey="c" class="form-control" name="cari" autocomplete="off" id="cari_migrasi" placeholder="Cari Nama Pasien Lama">

  </div>
<button id="submit_cari" accesskey="a" type="button" class="btn btn-success"><i class="fa fa-search"></i> C<u>a</u>ri</button>
  <br>
<br>


<div class="form-group" >
 <label for="penjamin">Penjamin:</label>
 <select class="form-control" id="penjamin" name="penjamin" required="" autocomplete="off">
 <?php 
  $query = $db->query("SELECT nama FROM penjamin ");
  while ( $data = mysqli_fetch_array($query)) {
  echo "<option value='".$data['nama']."'>".$data['nama']."</option>";
  }
  ?>
  </select>
</div>
  
<button class="btn btn-success" accesskey="l" id="lay"><i class="fa fa-list"></i> Lihat <u>L</u>ayanan </button>
     
   <br>
  <br>
<div class="form-group">
    <label for="no_rm">No RM:</label>
    <input style="height: 20px;" type="text" class="form-control" id="no_rm" name="no_rm" required="" readonly="" >
</div>

<div class="form-group">
    <label for="nama_lengkap">Nama Lengkap Pasien:</label>
    <input style="height: 20px;" type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" required="" readonly="">
</div>

<div class="form-group" >
  <label for="umur">Jenis Kelamin:</label>
<input style="height: 20px;" type="text" class="form-control" id="jenis_kelamin" name="jenis_kelamin" required="" readonly="" >
</div>

  
<div class="form-group" style="display: none">
    <input style="height: 20px;" type="text" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required="" autocomplete="off">
</div>

<div class="form-group">
    <label for="nama_lengkap">Umur:</label>
    <input style="height: 20px;" type="text" class="form-control" id="umur" name="umur" required="" readonly="" >
</div>


<div class="form-group">
    <label for="alamat">Alamat:</label>
    <textarea class="form-control" id="alamat" name="alamat"required="" ></textarea>
</div>



<div class="form-group">
    <label for="alamat">No Hp:</label>
    <input style="height: 20px;" type="text" class="form-control" id="hp_pasien" name="hp_pasien" required="" >
</div>

</div>


</div><!-- penutp colm 1-->


<!-- SPAN untuk PENANGGUNG-->


<div class="col-sm-4">
<br>
<br>
<br>

<!-- SPAN untuk TTV -->
<div class="card card-block">
  

<?php if ($dq['tampil_data_pasien_umum'] == 1): ?>


<div class="form-group" >
  <label for="umur">Penanggung Jawab Pasien:</label>
  <input style="height: 20px;" type="text" class="form-control" id="penanggung_jawab" name="penanggung_jawab" required="" autocomplete="off">
</div>

<div class="form-group" >
  <label for="umur">Alamat Penanggung Jawab:</label>
  <input style="height: 20px;" type="text" class="form-control" id="alamat_penanggung" name="alamat_penanggung" required="" autocomplete="off">
</div> 

<div class="form-group" >
  <label for="umur">No Telp / HP Penanggung  :</label>
  <input style="height: 20px;" type="text" class="form-control" id="no_hp_penanggung" name="no_hp_penanggung" maxlenght="12" required="" autocomplete="off">
</div>

<div class="form-group" >
 <label for="umur">Pekerjaan Penanggung Jawab:</label>
 <input style="height: 20px;" type="text" class="form-control" id="pekerjaan_penanggung" name="pekerjaan_penanggung" required="" autocomplete="off">
</div>



<div class="form-group" >
  <label for="umur">Hubungan Dengan Pasien:</label>
  <select id="hubungan_dengan_pasien" class="form-control " name="hubungan_dengan_pasien" required="" autocomplete="off">
      
      <option value="Orang Tua">Orang Tua</option>
      <option value="Suami/Istri">Suami/Istri</option>
      <option value="Anak">Anak</option>
      <option value="Keluarga">keluarga</option>
      <option value="Teman">Teman</option>
      <option value="Lain - Lain">Lain - Lain</option>  
  </select>  
</div>

  
<?php endif ?>

</div>


<div class="card card-block">


<div class="form-group" >
  <label for="umur">Perkiraan Menginap:</label>
  <input style="height: 20px;" type="text" class="form-control" id="perkiraan_menginap" name="perkiraan_menginap" required=""  autocomplete="off">
</div>

<div class="form-group" >
    <label for="umur">Surat Jaminan:</label>
    <input style="height: 20px;" type="text" class="form-control" id="surat_jaminan"  name="surat_jaminan" required="" autocomplete="off">
</div>


</div>

<!-- AKHIR UNTUK PANEL TTV -->

<div class="card card-block">

<div class="form-group">
          <label for="alamat">Dokter Penanggung Jawab:</label>
          <select class="form-control" id="dokter_pengirim" name="dokter_pengirim" required="" autocomplete="off">
           <option value="<?php echo $ss['nama_dokter'];?>"><?php echo $ss['nama_dokter'];?></option>
                   <option value="Tidak Ada">Tidak Ada</option>
                  <?php 
                  $query = $db->query("SELECT nama FROM user WHERE otoritas = 'Dokter' ");
                  while ( $data = mysqli_fetch_array($query)) {
                  echo "<option value='".$data['nama']."'>".$data['nama']."</option>";
                  }
                  ?>
          </select>
</div>

<div class="form-group">
    <label for="alamat">Asal Poli :</label>
    <select class="form-control" id="poli" name="poli" required="" autocomplete="off">
     
          <?php 
          $query = $db->query("SELECT nama FROM poli ");
          while ( $data = mysqli_fetch_array($query)) {
          echo "<option value='".$data['nama']."'>".$data['nama']."</option>";
          }
          ?>
    </select>
</div> 


<div class="form-group">
    <label for="alamat">Dokter Pelaksana:</label>
    <select class="form-control" id="dokter_penanggung_jawab" name="dokter_penanggung_jawab" required="" autocomplete="off">
          <option value="<?php echo $ss['nama_dokter'];?>"><?php echo $ss['nama_dokter'];?></option>
                  <option value="Tidak Ada">Tidak Ada</option>
    <?php 
    $query = $db->query("SELECT nama FROM user WHERE otoritas = 'Dokter' ");
    while ( $data = mysqli_fetch_array($query)) {
    echo "<option value='".$data['nama']."'>".$data['nama']."</option>";
    }
    ?>
  </select>
</div>

<div class="form-group">
  <label for="sel1">Keadaan Umum Pasien:</label>
  <select class="form-control" id="kondisi" name="kondisi" required="" autocomplete="off">
 
    <option value="Tampak Normal">Tampak Normal</option>
    <option value="Pucat dan Lemas">Pucat dan Lemas</option>
    <option value="Sadar dan Cidera">Sadar dan Cidera</option>
    <option value="Pingsan / Tidak Sadar">Pingsan / Tidak Sadar</option>
    <option value="Meninggal Sebelum Tiba">Meninggal Sebelum Tiba</option>
  </select>
</div>



<div class="form-group ">
  <label >Alergi Obat *</label>
  <input style="height: 20px;" type="text" class="form-control" id="alergi" name="alergi" value="Tidak Ada" required="" placeholder="Wajib Isi" autocomplete="off"> 
</div>

</div>

<?php if ($dq['tampil_ttv'] == 0): ?>
  <button accesskey="d" style="width:100px" class="btn btn-info" id="daftar"><i class="fa fa-plus">
</i>  <u>D</u>aftar</button>
<?php endif ?>

</div>



<!-- SPAN untuk DATA DIRI LANJUTAN -->

<!-- PANEL DATA DIRI AKHIR -->
<br><br><br>


<div class="col-sm-4">

<?php if ($dq['tampil_ttv'] == 1): ?>
  
<div class="card card-block">

<center><h4>Tanda Tanda Vital</h4></center>
<div class="form-group">
 <label >Sistole /Diastole (mmHg):</label>
 <input style="height: 20px;" type="text" class="form-control" id="sistole_distole" required="" name="sistole_distole"  autocomplete="off" >
</div>

<div class="form-group ">
  <label >Frekuensi Pernapasan (kali/menit):</label>
  <input style="height: 20px;" type="text" class="form-control" id="respiratory_rate" required="" name="respiratory_rate"  autocomplete="off" > 
</div>

<div class="form-group">
  <label >Suhu  (°C):</label>
  <input style="height: 20px;" type="text" class="form-control" id="suhu" name="suhu" required="" autocomplete="off"  > 
</div>   

<div class="form-group ">
 <label >Nadi (kali/menit):</label>
 <input style="height: 20px;" type="text" class="form-control" id="nadi" name="nadi" required="" autocomplete="off"> 
</div>

<div class="form-group ">
  <label >Berat Badan (kg):</label>
  <input style="height: 20px;" type="text" class="form-control" id="berat_badan" required="" name="berat_badan" autocomplete="off"> 
</div>

<div class="form-group ">
 <label >Tinggi Badan (cm):</label>
 <input style="height: 20px;" type="text" class="form-control" id="tinggi_badan" required="" name="tinggi_badan"autocomplete="off"> 
</div>

<br>
  <input style="height: 20px;" type="hidden" class="form-control" id="token" name="token" value="Kosasih" autocomplete="off"> 

  <button accesskey="d" style="width:100px" class="btn btn-info" id="daftar"><i class="fa fa-plus">
</i>  <u>D</u>aftar</button>

</div>
<!-- Akhir panel untuk PENANGGUNG -->
<?php endif ?>


</form>
</div> <!-- -->
</div> <!-- row utama -->
</div> <!-- end colapse -->

<!-- PEMBUKA DATA TABLE -->

<br>

<style>

tr:nth-child(even){background-color: #f2f2f2}

</style>

<span id="table_baru">
<div class="table-responsive">
<table id="table_rawat_inap" class="table table-bordered">
 
    <thead>
      <tr>
          <th style='background-color: #4CAF50; color: white'>No RM</th>
          <th style='background-color: #4CAF50; color: white'>No REG </th>
          <th style='background-color: #4CAF50; color: white'>Status</th>
          <th style='background-color: #4CAF50; color: white'>Nama  </th>
          <th style='background-color: #4CAF50; color: white'>Jam</th>
          <th style='background-color: #4CAF50; color: white'>Penjamin</th>    
          <th style='background-color: #4CAF50; color: white'>Asal Poli</th>
          <th style='background-color: #4CAF50; color: white'>Dokter Pengirim</th>
          <th style='background-color: #4CAF50; color: white'>Dokter Pelaksana</th>
          <th style='background-color: #4CAF50; color: white'>Bed</th>
          <th style='background-color: #4CAF50; color: white'>Kamar</th>
          <th style='background-color: #4CAF50; color: white'>Tanggal Masuk</th>
          <th style='background-color: #4CAF50; color: white'>Penanggung Jawab</th>    
          <th style='background-color: #4CAF50; color: white'>Umur</th>
          <th style='background-color: #4CAF50; color: white'> Rujuk Laboratium </th>
          <th style='background-color: #4CAF50; color: white'>Pindah Kamar</th>
          <th style='background-color: #4CAF50; color: white'>Batal</th>
    </tr>
    </thead>
    <tbody id="tbody">
    
   <?php while($data = mysqli_fetch_array($query7))
      
      {
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

            <td><a href='form-rujuk-lab-ri.php?no_reg=".$data['no_reg']."' class='btn btn-floating btn-small btn-success'><i class='fa fa-hand-pointer-o'></i> </a></td>

          <td> <button type='button' data-reg='".$data['no_reg']."' data-bed='".$data['bed']."' data-group-bed='".$data['group_bed']."' data-id='".$data['id']."' data-reg='".$data['no_reg']."'  class='btn btn-floating btn-small btn-warning pindah'><i class='fa fa-reply'></i>  </button></td>

          <td><button style='width:55px;' class='btn btn-floating btn-small btn-danger' id='batal_ranap' data-reg='". $data['no_reg']. "' data-id='". $data['id']. "'><i class='fa fa-remove'></i> </button></td>

      </tr>";
      
      }
    ?>
  </tbody>
 </table>
</div>

</span>
 <!-- AKHIR TABLE -->
</div> <!-- penutup container-->

<!--datatable-->
<script type="text/javascript">
  $(function () {
  $("table").dataTable({"ordering": false});
  }); 
</script>
<!--end datatable--> 

<script type="text/javascript">
  
  $("#submit_cari").click(function(){
  
    var cari = $("#cari_migrasi").val();
    if (cari == '') {
  
  $("#hasil_migrasi").html('');
  
    }
    else
    {
            $("#myModal").modal('show');
      $("#hasil_migrasi").html('Loading..');
   $.post("cek_data_pasien_lama.php",{cari:cari},function(data){
      $("#hasil_migrasi").html(data);
  
    });
  
    }
   
  
  });
  </script>




   <script>
   //untuk menampilkan data yang diambil pada form tbs penjualan berdasarkan id=formtambahproduk
  $("#daftar").click(function(){

    var group_bed = $("#group_bed").val();
    var bed = $("#bed").val();
    var rujukan = $("#rujukan").val();
    var penjamin = $("#penjamin").val();
    var no_rm = $("#no_rm").val();
    var nama_lengkap = $("#nama_lengkap").val();
    var jenis_kelamin = $("#jenis_kelamin").val();
    var tanggal_lahir = $("#tanggal_lahir").val();
    var umur = $("#umur").val();
    var alamat = $("#alamat").val();
    var hp_pasien = $("#hp_pasien").val();
    var penanggung_jawab = $("#penanggung_jawab").val();
    var alamat_penanggung = $("#alamat_penanggung").val();
    var no_hp_penanggung = $("#no_hp_penanggung").val();
    var pekerjaan_penanggung = $("#pekerjaan_penanggung").val();
    var hubungan_dengan_pasien = $("#hubungan_dengan_pasien").val();
    var perkiraan_menginap = $("#perkiraan_menginap").val();
    var surat_jaminan = $("#surat_jaminan").val();
    var dokter_pengirim = $("#dokter_pengirim").val();
    var poli = $("#poli").val();
    var dokter_penanggung_jawab = $("#dokter_penanggung_jawab").val();
    var kondisi = $("#kondisi").val();
    var sistole_distole = $("#sistole_distole").val();
    var respiratory_rate = $("#respiratory_rate").val();
    var suhu = $("#suhu").val();
    var nadi = $("#nadi").val();
    var berat_badan = $("#berat_badan").val();
    var tinggi_badan = $("#tinggi_badan").val();
    var alergi = $("#alergi").val();
    var token = $("#token").val();
    
    $("#kembali").hide();
    $("#daftar").show();

 $.post("proses_rawat_inap.php",{group_bed:group_bed,bed:bed,rujukan:rujukan,penjamin:penjamin,no_rm:no_rm,nama_lengkap:nama_lengkap,jenis_kelamin:jenis_kelamin,tanggal_lahir:tanggal_lahir,umur:umur,alamat:alamat,hp_pasien:hp_pasien,penanggung_jawab:penanggung_jawab,alamat_penanggung:alamat_penanggung,no_hp_penanggung:no_hp_penanggung,pekerjaan_penanggung:pekerjaan_penanggung,hubungan_dengan_pasien:hubungan_dengan_pasien,perkiraan_menginap:perkiraan_menginap,surat_jaminan:surat_jaminan,dokter_pengirim:dokter_pengirim,poli:poli,dokter_penanggung_jawab:dokter_penanggung_jawab,kondisi:kondisi,sistole_distole:sistole_distole,respiratory_rate:respiratory_rate,suhu:suhu,nadi:nadi,berat_badan:berat_badan,tinggi_badan:tinggi_badan,alergi:alergi,token:token},function(data){
     
     $("#demo").hide();
     $("#tbody").prepend(data);
     $("#group_bed").val('');
     $("#bed").val('');
     $("#rujukan").val('');
     $("#penjamin").val('');
     $("#no_rm").val('');
     $("#nama_lengkap").val('');
     $("#jenis_kelamin").val('');
     $("#tanggal_lahir").val('');
     $("#umur").val('');
     ("#alamat").val('');
     $("#hp_pasien").val('');
     $("#penanggung_jawab").val('');
     $("#alamat_penanggung").val('');
     $("#no_hp_penanggung").val('');
     $("#pekerjaan_penanggung").val('');
     $("#hubungan_dengan_pasien").val('');
     $("#perkiraan_menginap").val('');
     $("#surat_jaminan").val('');
     $("#dokter_pengirim").val('');
     $("#poli").val('');
     $("#dokter_penanggung_jawab").val('');
     $("#kondisi").val('');
     $("#sistole_distole").val('');
     $("#respiratory_rate").val('');
     $("#suhu").val('');
     $("#nadi").val('');
     $("#berat_badan").val('');
     $("#tinggi_badan").val('');
     $("#alergi").val('');
     $("#token").val('');
     
     });

      
  });

    $("form").submit(function(){
    return false;
    
    });


   </script>




<!-- cari untuk pegy natio -->
<script type="text/javascript">
  $("#cari").keyup(function(){
var q = $(this).val();

$.post('table_baru_rawat_inap.php',{q:q},function(data)
{
  $("#table_baru").html(data);
  
});
});
</script>
<!-- END script cari untuk pegy natio -->

<!-- data ambil dari pasien  -->
<script type="text/javascript">
//            jika dipilih, nim akan masuk ke input dan modal di tutup
            $(document).on('click', '.pilih', function (e) {
                document.getElementById("no_rm").value = $(this).attr('data-no');
                document.getElementById("nama_lengkap").value = $(this).attr('data-nama');
                document.getElementById("tanggal_lahir").value = $(this).attr('data-lahir');
                document.getElementById("alamat").value = $(this).attr('data-alamat');
                document.getElementById("jenis_kelamin").value = $(this).attr('data-jenis-kelamin');
                document.getElementById("hp_pasien").value = $(this).attr('data-hp');
                document.getElementById("penjamin").value = $(this).attr('data-penjamin');

                $('#myModal').modal('hide');


// untuk update umur ketika sudah beda bulan dan tahun

function hitung_umur(tanggal_input){

var now = new Date(); //Todays Date   
var birthday = tanggal_input;
birthday=birthday.split("/");   

var dobMonth= birthday[0]; 
var dobDay= birthday[1];
var dobYear= birthday[2];

var nowDay= now.getDate();
var nowMonth = now.getMonth() + 1;  //jan=0 so month+1
var nowYear= now.getFullYear();

var ageyear = nowYear- dobYear;
var agemonth = nowMonth - dobMonth;
var ageday = nowDay- dobDay;
if (agemonth < 0) {
       ageyear--;
       agemonth = (12 + agemonth);
        }
if (nowDay< dobDay) {
      agemonth--;
      ageday = 30 + ageday;
      }


if (ageyear <= 0) {
 var val = agemonth + " Bulan";
}
else {

 var val = ageyear + " Tahun";
}
return val;
}



    var tanggal_lahir = $("#tanggal_lahir").val();
    var umur = hitung_umur(tanggal_lahir);
    if (tanggal_lahir == '')
    {
    
    }
    else
    {
    $("#umur").val(umur);
    }


});

      //   tabel lookup mahasiswa        
</script>
<!-- end data ambil dari pasien  -->

<!-- modal ke rujukan lab  -->
<script type="text/javascript">

//            jika dipilih, nim akan masuk ke input dan modal di tutup
    $(document).on('click', '.rujuk-lab', function (e) {
            var id = $(this).attr('data-id');

    $.post("form-rujuk-lab-ri.php",{id:id},function(info){
    $("#rujukan_lab").html(info);

    });

    $('#Modal3').modal('show');
    
    });
           
</script>
<!-- akhir modal ke rujukan lab  -->



<script type="text/javascript">

            // jika dipilih, nim akan masuk ke input dan modal di tutup
            $(document).on('click', '.pilih3', function (e) {
            document.getElementById("bed2").value = $(this).attr('data-nama');
            document.getElementById("group_bed2").value = $(this).attr('data-group-bed');
                
  });
      
  $(function () {
  $("#siswaki").dataTable();
  });      
          
</script>


<!--   script untuk detail layanan PINDAH KAMAR-->
<script type="text/javascript">
     $(".pindah").click(function(){   
            
            var id = $(this).attr('data-id');
            var reg = $(this).attr('data-reg');
            var bed = $(this).attr('data-bed');
            var group_bed = $(this).attr('data-group-bed');
            var no_reg = $(this).attr('data-reg');

            $("#pindah_kamar").attr("data-id",id);
            $("#pindah_kamar").attr("data-reg",reg);
            $("#pindah_kamar").attr("data-bed",bed);
            $("#pindah_kamar").attr("data-group_bed",group_bed);

                $.post("pindah_kamar.php",{reg:reg,bed:bed,group_bed:group_bed},function(data){
                $("#tampil_kamar").html(data);
                $("#modal_kamar").modal('show');
          
                });
            });
//            tabel lookup mahasiswa         


  $(document).on('click', '#pindah_kamar', function (e) {
    var reg_before = $(this).attr("data-reg");
    var bed_before = $(this).attr("data-bed");
    var group_bed_before = $(this).attr("data-group_bed");
    var group_bed2 = $("#group_bed2").val();
    var bed2 = $("#bed2").val();
    var id = $(this).attr("data-id");

      $(".tr-id-"+id+"").remove();
      $.post("update_pindah_kamar.php",{reg_before:reg_before,bed_before:bed_before,group_bed_before:group_bed_before,group_bed2:group_bed2,bed2:bed2,id:id},function(data){
      
      $("#modal_kamar").modal('hide');
      $("#tbody").prepend(data);


      });
  });
</script>


<script type="text/javascript">
  

  $(document).on('click', '#batal_ranap', function (e) {
    var no_reg = $(this).attr("data-reg");
    var id = $(this).attr("data-id");
     $("#no_reg").val(no_reg);
     $("#input_keterangan").attr("data-id",id)

    $("#modal_batal").modal('show');
      
  });


  $(document).on('click', '#input_keterangan', function (e) {
    var no_reg = $("#no_reg").val();
    var keterangan = $("#keterangan").val();
    var id = $(this).attr("data-id");

      $(".tr-id-"+id+"").remove();
      $.post("proses_keterangan_batal_ri.php",{no_reg:no_reg, keterangan:keterangan},function(data){
      
      $("#modal_batal").modal('hide');

      });
  });

</script>


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



<script>

function hitung_umur(tanggal_input){



var now = new Date(); //Todays Date   
var birthday = tanggal_input;
birthday=birthday.split("/");   

var dobMonth= birthday[0]; 
var dobDay= birthday[1];
var dobYear= birthday[2];

var nowDay= now.getDate();
var nowMonth = now.getMonth() + 1;  //jan=0 so month+1
var nowYear= now.getFullYear();

var ageyear = nowYear- dobYear;
var agemonth = nowMonth - dobMonth;
var ageday = nowDay- dobDay;
if (agemonth < 0) {
       ageyear--;
       agemonth = (12 + agemonth);
        }
if (nowDay< dobDay) {
      agemonth--;
      ageday = 30 + ageday;
      }


if (ageyear <= 0) {
 var val = agemonth + " Bulan";
}
else {

 var val = ageyear + " Tahun";
}
return val;
}


$( "#tanggal_lahir" ).change(function(){
    var tanggal_lahir = $("#tanggal_lahir").val();
    var umur = hitung_umur(tanggal_lahir);
if (tanggal_lahir == '')
{

}
else
{
  $("#umur").val(umur);
}

});
</script>


<script>
  $(function() {
  $( "#tanggal_lahir" ).pickadate({ selectYears: 100, format: 'dd/mm/yyyy'});
  });
  </script>
<!--end script datepicker-->


<!-- modal ambil data dari table RI  -->
<script type="text/javascript">

//            jika dipilih, nim akan masuk ke input dan modal di tutup
  $(document).on('click', '.pilih2', function (e) {
            document.getElementById("bed").value = $(this).attr('data-nama');
            document.getElementById("group_bed").value = $(this).attr('data-group-bed');
                
  $('#myModal1').modal('hide');
  });
      
  $(function () {
  $("#siswa1").dataTable();
  });
// tabel lookup mahasiswa
  
          
</script>
<!-- end ambil data RI  -->



<!--   script untuk detail layanan PERUSAHAAN PENJAMIN-->
<script type="text/javascript">
     $("#lay").click(function() 
{   
    var penjamin = $("#penjamin").val();

                $.post("detail_layanan_perusahaan2.php",{penjamin:penjamin},function(data){
                    $("#tampil_layanan").html(data);
               $("#detail").modal('show');
          
                });
            });
//            tabel lookup mahasiswa         
</script>
<!--  end script untuk akhir detail layanan PERUSAHAAN -->


<script type="text/javascript">
//berfunsi untuk mencekal username ganda
 $(document).ready(function(){
  $(document).on('click', '.pilih', function (e) {
    var no_rm = $("#no_rm").val();
    var nama_pasien = $("#nama_pasien").val();

 $.post('cek_pasien_ranap.php',{no_rm:no_rm,nama_pasien:nama_pasien}, function(data){
  
  if(data == 1){
    alert("Anda Tidak Bisa Menambahkan Pasien Yang Sudah Ada!");
    $("#no_rm").val('');
    $("#nama_pasien").val('');
    $("#no_hp").val('');
    $("#tanggal_lahir").val('');
    $("#alamat").val('');
    $("#jenis_kelamin").val('');
    $("#penjamin").val('');
    $("#gol_darah").val('');
    $("#umur").val('');

   }//penutup if

    });////penutup function(data)

    });//penutup click(function()
  });//penutup ready(function()
</script>


<!-- footer  -->
<?php 
include 'footer.php'; 
?>
<!-- end footer  -->