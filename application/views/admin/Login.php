
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url()?>public/admin/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?php echo base_url()?>public/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url()?>public/admin/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

<script src="<?php echo base_url()?>public/admin/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url()?>public/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url()?>public/admin/dist/js/adminlte.min.js"></script>

 
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>


<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
<!--
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
-->
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
   <!-- Select2 -->
   <link rel="stylesheet" href="<?php echo base_url()?>public/admin/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?php echo base_url()?>public/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <script src="<?php echo base_url()?>public/admin/plugins/select2/js/select2.full.min.js"></script>


</head>
<style>

/* Define the color for the delete icon */


#recordTable {
        border-collapse: collapse;
        width: 100%;
    }

    #recordTable th,
    #recordTable td {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #recordTable th {
        background-color: #f2f2f2;
    }

    #recordTable tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    #recordTable tr:hover {
        background-color: #ddd;
    }

    .selected {
        background-color: yellow;
    }
    #recordTable td.column-align-center {
        text-align: center;
    }

    #recordTable td.column-align-right {
        text-align: right;
    }
    
    
    .select2-selection__rendered {
    line-height: 50px !important;
    
}
.select2-container .select2-selection--single {
    height: 50px !important;
    font-size: 20px;
    font-style: bold;
    color: #FFFFFF;
}
.select2-selection__arrow {
    height: 50px !important;
}
.delete-icon {
    color: red;
}

/* CSS for the confirmation dialog */
.confirmation-dialog {
    background-color: #fff; /* Background color of the dialog box */
    border: 2px solid #333; /* Border color of the dialog box */
    padding: 20px; /* Padding inside the dialog box */
    text-align: center;
}

/* CSS for the "Yes" button */
.btn-yes {
    background-color: #FF0000; /* Red background color for "Yes" button */
    color: #FFF; /* Text color for "Yes" button */
    padding: 10px 20px; /* Padding for the button */
    border: none; /* Remove button border */
    cursor: pointer;
}

/* CSS for the "No" button */
.btn-no {
    background-color: #333; /* Background color for "No" button */
    color: #FFF; /* Text color for "No" button */
    padding: 10px 20px; /* Padding for the button */
    border: none; /* Remove button border */
    cursor: pointer;
}

    </style>

<body class="hold-transition login-page" style="background: linear-gradient(135deg, #E3F2FD 0%, #BBDEFB 100%);">
<div class="login-box" style="width: 100%; max-width: 450px; margin: 7% auto; ">
  <div class="login-logo" style="text-align: center; margin-bottom: 30px;">
    <a href="../../index2.html" style="font-size: 28px; font-weight: bold; color: #1565C0;"><i class="fas fa-industry" style="margin-right: 10px;"></i><b>VOW</b> Supplilement</a>
  </div>

  <!-- /.login-logo -->
  <?php 
        if (!empty($this->session->flashdata('msg'))) {
            echo "<div class='alert alert-danger mb-3'>".$this->session->flashdata('msg')."</div>"; 
        }
    ?>
  <div class="card" style="border: none; border-radius: 10px; box-shadow: 0 4px 20px rgba(0,0,0,0.15);">
    <div class="card-body login-card-body" style="padding: 40px;">
      <p class="login-box-msg" style="font-size: 18px; color: #1565C0; font-weight: bold; margin-bottom: 30px;">Sign in to start your session</p>

      <form action="<?php echo base_url().'admin/login/authenticate'?>" name="loginForm" id="loginForm" method="post">

        <div class="form-group mb-3">
          <label for="compsel" style="font-weight: 600; color: #333; margin-bottom: 8px;">Select Company <span class="text-danger">*</span></label>
          <select class="form-control select2" name="compsel" id="compsel" style="font-size: 16px; height: 45px; border: 2px solid #BBDEFB; border-radius: 8px; padding: 8px 12px;">
            <option value="0">Select Company...</option>
            <?php
              if(isset($data['wndmcdata'])) {
                foreach ($data['wndmcdata'] as $each){	 
                  echo "<option value='".$each['mechine_id']."'>".$each['mechine_name']."</option>";
                }
              }
            ?>
          </select>
        </div>

        <div class="form-group mb-3">
          <label for="username" style="font-weight: 600; color: #333; margin-bottom: 8px;">Username</label>
          <div class="input-group" style="border: 2px solid #BBDEFB; border-radius: 8px; background-color: #fff; overflow: hidden;">
            <input type="text" name="username" id="username" class="form-control" placeholder="Enter your username" style="border: none; padding: 10px; font-size: 16px;">
            <div class="input-group-append" style="border: none;">
              <div class="input-group-text" style="border: none; background-color: #fff;">
                <span class="fas fa-user" style="color: #1565C0;"></span>
              </div>
            </div>
          </div>
          <?php echo form_error('username'); ?>
        </div>

        <div class="form-group mb-3">
          <label for="password" style="font-weight: 600; color: #333; margin-bottom: 8px;">Password</label>
          <div class="input-group" style="border: 2px solid #BBDEFB; border-radius: 8px; background-color: #fff; overflow: hidden;">
            <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" style="border: none; padding: 10px; font-size: 16px;">
            <div class="input-group-append" style="border: none;">
              <div class="input-group-text" style="border: none; background-color: #fff;">
                <span class="fas fa-lock" style="color: #1565C0;"></span>
              </div>
            </div>
          </div>
          <?php echo form_error('password'); ?>
        <div class="form-group mb-3">
          <div class="icheck-primary">
            <input type="checkbox" id="remember" style="margin-right: 8px;">
            <label for="remember" style="color: #555; cursor: pointer; margin: 0;">
              Remember Me
            </label>
          </div>
        </div>

        <div class="form-group mb-0">
          <button type="submit" id="signInBtn" class="btn btn-primary btn-block" style="height: 45px; font-size: 16px; font-weight: 600; background: linear-gradient(135deg, #1565C0 0%, #0D47A1 100%); border: none; border-radius: 8px; cursor: not-allowed; opacity: 0.6;" disabled>Sign In</button>
        </div>

      </form>

      <hr style="margin: 20px 0; border-color: #E0E0E0;">

      <p class="mb-2" style="text-align: center;">
        <a href="forgot-password.html" style="color: #1565C0; text-decoration: none; font-weight: 500;">Forgot your password?</a>
      </p>
      <p class="mb-0" style="text-align: center;">
        <a href="register.html" style="color: #1565C0; text-decoration: none; font-weight: 500;">Create a new account</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
</body>
</html>


<script>
  // Wrap your code in a document ready function
  $(document).ready(function() {
    // Initialize Select2
    $('.select2').select2();

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    });
    
    // Function to check if all required fields are filled
    function validateForm() {
      var company = $('#compsel').val();
      var username = $('#username').val().trim();
      var password = $('#password').val().trim();
      
      // Enable button only if all fields are filled
      if (company && company !== '0' && username !== '' && password !== '') {
        $('#signInBtn').prop('disabled', false);
        $('#signInBtn').css({
          'cursor': 'pointer',
          'opacity': '1'
        });
      } else {
        $('#signInBtn').prop('disabled', true);
        $('#signInBtn').css({
          'cursor': 'not-allowed',
          'opacity': '0.6'
        });
      }
    }
    
    // Listen to changes on all required fields
    $('#compsel, #username, #password').on('change keyup', function() {
      validateForm();
    });
    
    // Validate on page load
    validateForm();
 
    // Handle change event of the #compsel select
    $('#compsel').on('change', function() {
      validateForm();
    });
  });
</script>
