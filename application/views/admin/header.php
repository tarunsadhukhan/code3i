
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Vow Supplement  </title>

 <!-- Font Awesome -->
 
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="<?php echo base_url()?>public/admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url()?>public/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="<?php echo base_url()?>public/admin/plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url()?>public/admin/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?php echo base_url()?>public/admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url()?>public/admin/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="<?php echo base_url()?>public/admin/plugins/summernote/summernote-bs4.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">



  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?php echo base_url()?>public/admin/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url()?>public/admin/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

<style>
    .brand-text-wrapper {
        display: block; /* Makes it a block-level element, so it appears on a new line */
        margin-top: 5px; /* Adjust the top margin to control spacing */
        font-size: 14px; /* Adjust the font size as needed */
        /* Add any other styling you want here */
    }
</style>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      
    </ul>

    <!-- SEARCH FORM -->
    

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      
        <a class="nav-link" data-toggle="dropdown" href="#">
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="<?php echo base_url()?>public/admin/dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="<?php echo base_url()?>public/admin/dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="<?php echo base_url()?>public/admin/dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
      <?php 
                     $cmpname = $this->session->userdata('company_name');
                     $username = $this->session->userdata('username');
           ?>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
           Welcome,<strong><?php echo $username; ?></strong>
     
        </a>
       <div class ="dropdown-menu dropdown-menu-lg dropdown-menu right">
        <div class="dropdown-divider"></div>
        <a href="<?php echo base_url().'admin/login/logout'; ?>" class="dropdown-item">
            logout
        </a>  
      </div>
      </li>
     
    </ul>
  </nav>
  <!-- Main Sidebar Container -->

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
    <img src="<?php echo base_url()?>public/admin/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
        style="opacity: .8">
    <div class="brand-text-wrapper">
        <span class="brand-text font-weight-light"><?php echo $cmpname; ?></span>
    </div>
</a>


     

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

               <li class="nav-item has-treeview ">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Starter Pages
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
              <a href="<?php echo base_url().'admin/Daily_Attendance_Entry'; ?>" class="nav-link active">
   
                  <i class="far fa-circle nav-icon"></i>
                  <p>Daily Attendance Entry</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Inactive Page</p>
                </a>
              </li>
            </ul>
          </li>


               <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
               Dashboard
               
              </p>
            </a>
          </li>
     
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Catagories
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo base_url().'admin/category/create'; ?>" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Catagories</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url().'admin/category'; ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>View Catagories</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item has-treeview ">
         
         <a href="#" class="nav-link">
           <i class="far fa-circle nav-icon"></i>
           <p>Reports</p>
         </a>
     
   
   <ul class="nav nav-treeview">
    
       <li class="nav-item">
         <a href="<?php echo base_url().'admin/reports/Pfesidata'; ?>" class="nav-link active">
           <i class="far fa-circle nav-icon"></i>
           <p>PF ESI Reports</p>
         </a>
       </li>
       <li class="nav-item">
         <a href="<?php echo base_url().'admin/reports/Employee_vow_report'; ?>" class="nav-link">
           <i class="far fa-circle nav-icon"></i>
           <p>Employee VOW Report</p>
         </a>
       </li>
       <li class="nav-item">
       <a href="<?php echo base_url().'admin/Pfesi'; ?>" class="nav-link ">
           <i class="far fa-circle nav-icon"></i>
           <p>View Articles</p>
         </a>
       </li>
     </ul>
   </li>


   <li class="nav-item has-treeview ">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Spinning Doffing 
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
            <a href="<?php echo base_url().'admin/doffdata'; ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Doff Entry
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url().'admin/doffdata/frame_qc_entry'; ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Frame Wise Quality Entry  
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url().'admin/quality_act_count'; ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Daily Actual Count Entry 
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url().'admin/Hylt_entry'; ?>" class="nav-link">
              <i class="nav-icon fas fa-clipboard-list"></i>
              <p>
                Hylt Entry 
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url().'admin/Hylt_master'; ?>" class="nav-link">
              <i class="nav-icon fas fa-database"></i>
              <p>
                Hylt Master 
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url().'admin/Doffmodexp'; ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Doff Modification 
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url().'admin/reports/doff10report'; ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Doff 10 Report 
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url().'admin/reports/onlinedoffreport'; ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                On Line Doff Report 
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url().'admin/Spining_daily_entry'; ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Spinning Daily Entry 
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>

        </ul>
          </li>


<li class="nav-item has-treeview">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                <strong > Winding </strong>
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
            <a href="<?php echo base_url().'admin/Winding_doff_data'; ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Daily Winding Production Entry
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url().'admin/Winding_jugar_entry'; ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
              Daily Winding Jugar Entry  
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url().'admin/winding_quality_entry'; ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Daily Quality Entry 
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url().'admin/reports/winding_data_reports'; ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Winding Data Reports 
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
            <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?php echo base_url().'admin/reports/winding_data_reports'; ?>" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Winding Data Reports</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo base_url().'admin/reports/Winding_performance_report'; ?>" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Winder Performance Report</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Level 3B</p>
                    </a>
                  </li>
                </ul>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url().'admin/reports/Winding_quality_wise_report'; ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Winding quality Wise Report 
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url().'admin/reports/Winder_wise_production_report'; ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Winder'S Production Report 
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url().'admin/reports/Winding_duplicate_mc_checking'; ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Winding Duplicate Mechine CheckingS 
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>

        </ul>
          </li>



 

<li class="nav-item has-treeview">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                <strong > Weaving </strong>
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
            <a href="<?php echo base_url().'admin/weaving_daily_entry'; ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Weaving Daily Entry 
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
          <a href="<?php echo base_url().'admin/reports/finishing_data_export'; ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Finishing Data Exports  
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url().'admin/reports/Daily_loom_report'; ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Loom Daily Report 
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url().'admin/reports/S4_incentive_report'; ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                S4 Incentive Report
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url().'admin/Loom_hrs_prod_updt'; ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Loom Hours/Prod Update 
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url().'admin/reports/onlinedoffreport'; ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                On Line Doff Report 
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>

        </ul>
          </li>

          <li class="nav-item has-treeview">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                <strong > Data Exports </strong>
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
            <a href="<?php echo base_url().'admin/reports/weaving_data_export'; ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Weaving Data Exports
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
          <a href="<?php echo base_url().'admin/reports/beaming_data_export'; ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Beaming Data Export  
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url().'admin/reports/item_master_report'; ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Item MasterS
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
          <a href="<?php echo base_url().'admin/Daily_spell_spreader_entry'; ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
              Spreader Meter Entry  
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url().'admin/Daily_spell_drawing_entry'; ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Daily Drawing Entry 
                <span class="right badge badge-danger">New</span>
              </p>
            </a>

          </li>
          <li class="nav-item">
          <a href="<?php echo base_url().'admin/reports/Daily_batch_report'; ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
              Daily Batch Report
                             <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url().'admin/Daily_spellwise_drawing_entry'; ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Daily Spell Wise Drawing Entry 
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
          <a href="<?php echo base_url().'admin/Daily_vo'; ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
              Daily Vow Data Transfer
                             <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
          <a href="<?php echo base_url().'admin/reports/Loom_data_exp'; ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Loom Data Export
                  <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>



          
    
        </ul>
          </li>


          




    <li class="nav-item">
    <a href="<?php echo base_url().'admin/reports/weaving_data_export'; ?>" class="nav-link active">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Weaving Data Export 
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
     <a href="<?php echo base_url().'admin/Other_daily_atten'; ?>" class="nav-link active">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Other Attendance 
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>

          <li class="nav-item has-treeview">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                <strong > Absent Warnings</strong>
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
            <a href="<?php echo base_url().'admin/reports/Absent_warning_entry'; ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Issue Warnings
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
           <li class="nav-item">
          <a href="<?php echo base_url().'admin/reports/Absent_warning_status'; ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Warning Status 
                  <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
           <li class="nav-item">
          <a href="<?php echo base_url().'admin/reports/WorkerGatePass'; ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Gate Pass 
                  <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>

    
        </ul>
          </li>

          <li class="nav-item has-treeview">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                <strong > Lay Out </strong>
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
            <a href="<?php echo base_url().'admin/reports/Daily_layout_print'; ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Lay Out Print
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
       

          
    
        </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                <strong > Wastage </strong>
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
            <a href="<?php echo base_url().'admin/Wastage_entry'; ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Wastage Entry
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url().'admin/reports/Wastage_stock_report'; ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Wastage Stock Report
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>



        </ul>

        <li class="nav-item has-treeview">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                <strong > Jute </strong>
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo base_url().'admin/Recepentry'; ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Receipt Entry 
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url().'admin/Issueentry'; ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Issue Entry 
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url().'admin/reports/Wastage_stock_report'; ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Spreader Issue
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url().'admin/reports/Wastage_stock_report'; ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Spreader Reports
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url().'admin/reports/Wastage_stock_report'; ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Spreader Stock Reports
              
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url().'admin/misc_prod_entry'; ?>" class="nav-link">
              <i class="nav-icon fas fa-clipboard-list"></i>
              <p>
                Misc Prod Entry
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url().'admin/daily_finishing_entry'; ?>" class="nav-link">
              <i class="nav-icon fas fa-industry"></i>
              <p>
                Daily Finishing Entry
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url().'admin/spreader_lapping_entry'; ?>" class="nav-link">
              <i class="nav-icon fas fa-layer-group"></i>
              <p>
                Spreader Lapping Entry
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url().'admin/break_down_entry'; ?>" class="nav-link">
              <i class="nav-icon fas fa-tools"></i>
              <p>
                Break Down Entries
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>

        


      </nav>
      <!-- /.sidebar-menu -->

      
    </div>

    <!-- /.sidebar -->
  </aside>
