<!-- application/views/menu_view.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Menu Query</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
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

<script src="./example/vendor/jquery.mousewheel.js"></script>
  <script src="./example/vendor/select2.js"></script>
  <script src="./dist/select2.optgroupSelect.js"></script>
  <link rel="stylesheet" type="text/css" href="./example/vendor/select2.css">
  <link rel="stylesheet" type="text/css" href="./dist/select2.optgroupSelect.css">


</head>
<body>
<?php //var_dump($menu_data); ?>
        <select id="menuSelect" style="width: 100%;">
        <?php echo 'nnnn'; 
       ?>
            <?php
            foreach ($menu_data as $menu_item): ?>
              <?php // 'Checking'; ?>
            
              <?php   var_dump($menu_data); ?>
                <optgroup label="<?= $menu_item["parent_name"] ?>">
                </optgroup>
            <?php endforeach; ?>
        </select>
     
    <script>
      $(function(){
      $.fn.select2.amd.require(["optgroup-data", "optgroup-results"],
          function (OptgroupData, OptgroupResults) {
          $('#target').select2({
              dataAdapter: OptgroupData,
              resultsAdapter: OptgroupResults,
              closeOnSelect: false,
        placeholder: "Search"
          });
      });
  });

    </script>
</body>
</html>
