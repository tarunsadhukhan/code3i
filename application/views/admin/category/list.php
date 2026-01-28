  <!-- /.navbar -->

  <?php $this->load->view('admin/header'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Category</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Category</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
        <?php if($this->session->flashdata('success') !="" ) { ?> 
             <div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?>  </div>
         <?php } ?>    


             <div class="card">
              <div class="card-header">
                <div class="card-title">
                  <form id="searchFrm" name="searchFrm" method="get" action="">
                      <div class="input-group mb-0">
                          <input type="text" value="" placeholder="Search" name="q">
                          <div class="input-group-append">
                            <button class="input-group-text" id="basic-addon1">
                              <i class="fas fa-search"></i>
                            </button>
                          </div>
                      </div>
                  </form>
                </div>
                <div class="card-tools">
                  <a href="<?php echo base_url().'admin/category/create'; ?>" class="btn btn-primary"><i class="fas fa-plus"></i>Create
                </a>
                </div>
              </div>
            
        <div class="card-body">
            <table class="table table-striped">
              <tr>
                  <th>#</th>
                  <th >Name</th>
                  <th width="100">Status</th>
                   <th width="100" class="text-center">Action</th>
               </tr>
          <tr>
           <?php if(!empty($categories))  { ?>
                <?php foreach($categories as $categoryRow) {  ?>
                  <tr>
                    <td><?php echo $categoryRow['rec_id']; ?> </td>
                    <td><?php echo $categoryRow['dept_desc']; ?> </td>
                   <td>Status</td>
                
            <td>
              <span class="badge badge-success">Status</span>
            </td>
          <td class="text-center">
            <a href="" class="btn btn-primary btn-sm">
              <i class="far fa-edit"></i> Edit</a>
            <a href="" class="btn btn-danger btn -sm"><i class="far fa-trash-alt"></i>Delete</a>

          </td>
          </tr>         

              <?php } ?>          
          <?php } else { ?>
              <tr>
                  <td colspan="4">Records Not Found</td>
              </tr>

          <?php } ?>
     
   
   
        </table>
        </div>


          
            </div><!-- /.card -->
          </div>
          <!-- /.col-md-6 -->
          <div class="col-lg-6">
            <div class="card">
            </div>

          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php $this->load->view('admin/footer'); ?>


<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="<?php echo base_url()?>public/admin/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url()?>public/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url()?>public/admin/dist/js/adminlte.min.js"></script>
</body>
</html>
