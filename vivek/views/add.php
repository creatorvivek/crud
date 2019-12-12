
<div class="row">
  	<div class="col-md-12">
		<div class="card card-default ">
  			<div class="card-header def">
  				<h3 class="card-title">ADD  vivek</h3>
			</div>
  			<!-- /.card-header -->
  			<div class="card-body">
  			<?= form_open('stu/add',array("class"=>"form-horizontal","id"=>"form_validation")); ?>
  				<div class="row">
				<div class="col-md-6">"
						<div class="form-group">
						<label for="" class="col-md-4 control-label"><span class="text-danger">*</span></label>
						<div class="col-md-12">
						<input type="text" name="" value="<?= $this->input->post(""); ?>" class="form-control" id="" required />
						<span class="text-danger"><?= form_error(""); ?></span>
						</div>
						</div>
						</div>

				</div>
			<?= form_close(); ?>
			</div>
		</div>
		</div>
	</div>			