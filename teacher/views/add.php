
<div class="row">
  	<div class="col-md-12">
		<div class="card card-default ">
  			<div class="card-header def">
  				<h3 class="card-title">ADD  teacher</h3>
			</div>
  			<!-- /.card-header -->
  			<div class="card-body">
  			<?= form_open('stu/add',array("class"=>"form-horizontal","id"=>"form_validation")); ?>
  				<div class="row">
				<div class="col-md-6">"
						<div class="form-group">
						<label for="name" class="col-md-4 control-label"><span class="text-danger">*</span>Name</label>
						<div class="col-md-12">
						<input type="text" name="name" value="<?= $this->input->post("name"); ?>" class="form-control" id="name" required />
						<span class="text-danger"><?= form_error("name"); ?></span>
						</div>
						</div>
						</div>

				</div>
			<?= form_close(); ?>
			</div>
		</div>
		</div>
	</div>			