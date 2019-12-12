<!DOCTYPE html>
<html lang="en">
<head>
  <title>HMVC CURD GENERATOR OF CODEIGNITER</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body>

  <div class="container">
    <h2>Select Your requirement here</h2>
    <form action="create_two.php" method="post">
      <div class="form-group">
        <label for="email">Module Name</label>
        <input type="text" class="form-control" id="module" placeholder="Module name" name="module_name">
      </div>
      <div class="row">
        <div class="form-group col-md-6">
          <label for="email">Input name</label>
          <input type="text" class="form-control"  placeholder="name" name="input_name[]">
        </div>
        <div class="form-group col-md-4">
          <label for="input_type">Input Type</label>
          <select class="form-control" name="input_type[]">
            <option value="1">Text</option>
            <option value="2">Password</option>
            <option value="3">Select</option>
           
          </select>
        </div>
        <div class="col-md-2">
          <label for="email"></label>
          <button type="button" class="btn btn-info" id="add_button">+</button>
        </div>
      </div>
      <div class="row" id="newRow">
        
      </div>

      <div class="align-center">
        <button type="submit" class="btn btn-default">Submit</button>
      </div>
    </form>
  </div>
<script type="text/javascript">
  $('#add_button').click(function(){
    let data=`

<div class="form-group col-md-6">
          <label for="email">Input name</label>
          <input type="text" class="form-control"  placeholder="name" name="input_name[]">
        </div>
        <div class="form-group col-md-4">
          <label for="input_type">Input Type</label>
          <select class="form-control" name="input_type[]">
            <option value="1">Text</option>
            <option value="2">Password</option>
            <option value="3">Select</option>
           
          </select>
        </div>
        <div class="col-md-2">
          <label for="email"></label>
          <button class="btn btn-info" id="add_button">+</button>
        </div>




    `
    $('#newRow').append(data);
  });

</script>
</body>
</html>
