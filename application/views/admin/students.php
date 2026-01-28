<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<script src="https://code.jquery.com/jquery-3.3.1.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

</head>
<body> 

<div id="show_modal" class="modal fade" role="dialog" style="background: #000;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 style="font-size: 24px; color: #17919e; text-shadow: 1px 1px #ccc;"><i class="fa fa-folder"></i> Student Details</h3>
      </div>
      <div class="modal-body">
        <table class="table table-bordered table-striped">
          <thead class="btn-primary">
            <tr>
              <th>Name</th>
              <th>Email</th>
              <th>Phone</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><p id="student_name"></p></td> //here i am showing the data with the help of id
              <td><p id="student_email"></p></td>//here i am showing the data with the help of id
              <td><p id="student_phone"></p></td>//here i am showing the data with the help of id
            </tr>
          </tbody>
       </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
      </div>
    </div>
  </div>
</div>

<table class="table table-bordered table-striped">
   <thead>
       <tr>
           <th>S.No</th>
           <th>Name</th>
           <th>Email</th>
           <th>Phone</th>
           <th></th>
       </tr>
   </thead>
   <tbody>
      <?php $i = 1; foreach ($student_list as $student) { ?>
      <tr>
         <td><?php echo $i; ?></td>
         <td><?php echo $student->worker_name; ?></td>
         <td><?php echo $student->eb_no; ?></td>
         <td><?php echo $student->last_name; ?></td>
         <td>
            <button class="btn btn-primary view_detail" relid="<?php echo $student->eb_id;  ?>">View</button>
        </td>
      </tr>
      <?php } ?> 
   </tbody>
</table>
<button class="btn btn-primary view_detail" relid="<?php echo $student->eb_id;  ?>">View</button>
</body>

</html>
<script type="text/javascript">
    $(document).ready(function() {

      $('.view_detail').click(function(){
          
          var id = $(this).attr('relid'); //get the attribute value
        
          $.ajax({
              url : "<?php echo base_url(); ?>admin/Students/get_student_data",
              data:{id : id},
              method:'GET',
              dataType:'json',
              success:function(response) {
                $('#student_name').html(response.worker_name); //hold the response in id and show on popup
                $('#student_email').html(response.eb_no);
                $('#student_phone').html(response.phone);
                $('#show_modal').modal({backdrop: 'static', keyboard: true, show: true});
            }
          });
      });
    });
</script>