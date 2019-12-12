		<div class="row">
  	<div class="col-md-12">
		<div class="card card-default ">
  			<div class="card-header def">
  				<h3 class="card-title">ADD  stu</h3>
			</div>
  			<!-- /.card-header -->
  			<div class="card-body">
  			<?= form_open('stu/edit/$id',array("class"=>"form-horizontal","id"=>"form_validation")); ?>
  				<div class="row">
				<div class="col-md-6">"
						<div class="form-group">
						<label for="name" class="col-md-4 control-label"><span class="text-danger">*</span>Name</label>
						<div class="col-md-12">
						<input type="text" name="name" value="<?= $this->input->post("name")?$this->input->post("name"):name ?>" class="form-control" id="name" required />
						<span class="text-danger"><?= form_error("name"); ?></span>
						</div>
						</div>
						</div><div class="col-md-6">"
						<div class="form-group">
						<label for="age" class="col-md-4 control-label"><span class="text-danger">*</span>Age</label>
						<div class="col-md-12">
						<input type="text" name="age" value="<?= $this->input->post("age")?$this->input->post("age"):age ?>" class="form-control" id="age" required />
						<span class="text-danger"><?= form_error("age"); ?></span>
						</div>
						</div>
						</div><div class="col-md-6">"
						<div class="form-group">
						<label for="school" class="col-md-4 control-label"><span class="text-danger">*</span>School</label>
						<div class="col-md-12">
						<input type="text" name="school" value="<?= $this->input->post("school")?$this->input->post("school"):school ?>" class="form-control" id="school" required />
						<span class="text-danger"><?= form_error("school"); ?></span>
						</div>
						</div>
						</div>

				</div>
			<?= form_close(); ?>
			</div>
		</div>
		</div>
	</div>	