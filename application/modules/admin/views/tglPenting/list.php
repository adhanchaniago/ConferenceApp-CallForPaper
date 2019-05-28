<section class="panel">
  <header class="panel-heading">
    <div class="panel-actions">
      <a href="#" class="fa fa-caret-down"></a>
      <a href="#" class="fa fa-times"></a>
    </div>

    <h4><b> Fasilitas Seminar</b></h4>
  </header>
  <div class="panel-body">

  <?php

echo validation_errors('<div class="alert alert-warning"><i class="fa fa-warning"></i> ','</div>');


//notifikassi
if($this->session->flashdata('msg')){
  echo '<div class="alert alert-success"><i class="fa fa-check"></i>'; 
  echo $this->session->flashdata('msg');
  echo '</div>';
}

?>

<div class="pull-left">
<p>
  <a href="<?php echo base_url('admin/seminar/addTglPenting') ?>" class="btn btn-success"><i class="fa fa-plus"></i> Tambah</a>
</p>
</div>
<div class="clearfix">
</div>


    <table class="table DataTables table-responsive table-bordered primary">
     <thead>
      <tr>
        <th width="20px">No</th>
        <th width="300px">Deskripsi</th>
        <th width="200px">Tanggal</th>
        <th width="100px"></th>
      </tr>
      </thead>

      <tbody>
          <?php $no=1; foreach($tglPenting as $row): ?>
          <tr>
            <td><?= $no ?></td>
            <td><?= $row->deskripsi ?></td>
            <td><?= $row->tanggal ?></td>
            <td>
                <a href="<?= base_url('admin/seminar/editTglPenting/'.$row->id_tgl_penting) ?>" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i></a>
                <?php include('delete.php') ?>
            </td>
          </tr>

          <?php $no++; endforeach ?>
      </tbody>  
    </table>
  </div>
</section>

