<div class="row">
  <div class="col-md-12 col-sm-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">EMPLOYEE LIST</h3>
        <div class="card-tools pull-right">
          <a href="<?= site_url("employee/add"); ?>" class="btn btn-success">Add</a> 
        </div>
      </div>
      <div class="card-body">
<div class="table-responsive">
		 <table id="employee_table" class="table display table-bordered table-hover">
            <thead>
              <tr>
                <th></th>
                
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
             
              <?php foreach($vivek as $row){ ?>
                <tr>
                  <td>$row['']</td>
                  <td>
					<div class="btn-group" >
                     <a href="<?= base_url() ?>/employee/edit/<?= \$row["id"] ?>" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Edit" ><i class="fa fa-pencil"></i></a>
                     <button type="button" class="btn btn-danger" onclick="delFunction(<?php echo \$row["id"] ?>);" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></button>
                     <!-- <a href="#" id="<?= \$row["id"]?>" class="btn btn-info view_data" data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-eye"></i></a> -->
                     <a href="<?= base_url() ?>employee/employee_details/<?= \$row["id"] ?>" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="View" target="_blank"><i class="fa fa-eye"></i></a>
                   </div>
                 </td>
                 
                </tr>
              <?php } ?>
            </tbody>    
          </table>
		 <script>
            $(document).ready( function () {
              $("#employee_table").DataTable();
            });
         
           var url="<?php echo base_url();?>";
           function delFunction(id)
           {

    bootbox.confirm("Are you sure to delete  record ?", function(result) {
      if(result)

        window.location = url+"employee/remove/"+id ;

    });
  }
</script>