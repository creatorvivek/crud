<?php 

// print_r($_POST);
// die;

$input_name= $_POST['input_name'];
$module_name= $_POST['module_name'];
$input_type= $_POST['input_type'];
     // print_r($input_name);die;
// $module_name="studentss";
@mkdir($module_name);
@mkdir($module_name."/controllers");
@mkdir($module_name."/models");
@mkdir($module_name."/views");
// die;
// mkdir($module_name."/controller/".$controller_name);
// mkdir($module_name."/controller/".$controller_name);
// mkdir($module_name."/controller/".$controller_name);
$class_name=ucfirst($module_name);
$controller_name=ucfirst($module_name.".php");
$model_name=ucfirst($module_name.'_model');
// controller file
$input_value='';
$ci_validation='';
$param_file='';

$select_query="\$this->".$model_name."->select(\$table_name,\$condition,array('*'))";
for($i=0;$i<count($input_name);$i++)
{
 $input_value.=   "$"."$input_name[$i] =htmlspecialchars(\$this->input->post('${input_name[$i]}',true));\n";
 $varibale_name_message=ucfirst($input_name[$i]);
 $ci_validation.="\$this->form_validation->set_rules('${input_name[$i]}','${varibale_name_message}','required|trim');\n";
 $param_file.="'${input_name[$i]}'"."=>$". "${input_name[$i]},\n\r";

}



$controller_file=<<<EOT


<?php if (!defined("BASEPATH")) exit("No direct script access allowed");

class $class_name extends MY_Controller
{

 function __construct()
 {
  parent::__construct();
  \$this->load->model('${model_name}');
}
public \$table_name="${module_name}s";

public function index()
{
  \$data["title"]="${module_name} list";
  \$data["$module_name"] = $select_query;
  \$data['_view'] = "${module_name}_list";
  \$this->load->view('index',\$data);

}

public function create()
{

 \$data["title"]=" Add $module_name";
 \$data['_view'] = "add_${module_name}";
 \$this->load->view('index',\$data);


}

public function store()
{
 \n\r

 ${input_value}
 \$this->load->library('form_validation');
 ${ci_validation}


 if(\$this->form_validation->run() )   \n  
 {  
   \$params=array(

   ${param_file}


   );
   \$insertData=\$this->${model_name}->insert('\$table_name',\$params);
   if(\$insertData)
   \$this->session->alerts = array(
   'severity'=> 'success',
   'title'=> 'successfully added'

   );
   redirect('${module_name}/index');

 }
 else
 {
  \$this->create();
}

}







##update function



function edit(\$id)
{


  \$checkCondition=array('id'=>\$id);
  \$fetch_data =\$this->${model_name}->select_id(\$table_name,\$checkCondition,array('*'));
  \$data['$module_name']=\$fetch_data;
  
  if(isset(\$fetch_data['id']))
  {
   ${input_value}
   \$this->load->library('form_validation');
   ${ci_validation}
   
   if(\$this->form_validation->run() )     
   {  

    \$params=array(
    ${param_file}


    );
    \$updateCondition=array('id'=>\$id);

    \$updateCol=\$this->${model_name}->update_col(\$table_name,\$updateCondition,\$params);



  }
  else
  {
    \$data['_view'] = 'edit';
    \$this->load->view('index',\$data);
  }

}
else
{
  show_error('this id is not exist');
}


}


}




EOT;



$controller_file= <<<EOT

<?php if (!defined("BASEPATH")) exit("No direct script access allowed");

class $class_name extends MY_Controller
{

       function __construct()
       {
        parent::__construct();
        \$this->load->model('${model_name}');
      }
      public \$table_name="${module_name}s";


 /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "${module_name} List" user interface                 
    *                     
    * @param           : null
    * @return          : null 
    * ********************************************************** */
				   public function index()
				{
				  \$data["title"]="${module_name} list";
				  \$data["$module_name"] = $select_query;
				  \$data['_view'] = "${module_name}_list";
				  \$this->load->view('index',\$data);

				}



    
    /*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Load "Add new ${module_name}" user interface                 
    *                    and process to store "${module_name}" into database 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function add() {

       

        if (\$this->input->post()) {
            \$this->_prepare_${module_name}_validation();
            if (\$this->form_validation->run() === TRUE) {
                \$data = \$this->_get_posted_${module_name}_data();

                \$insert_id = \$this->${model_name}->insert(\$table_name, \$data);
                if (\$insert_id) {
                    
                    create_log('Has been added a ${module_name} : '.\$data['name']);
                    
                    success(\$this->lang->line('insert_success'));
                    redirect('${module_name}');
                } else {
                    error(\$this->lang->line('insert_failed'));
                    redirect('${module_name}/add');
                }
            } else {

                \$this->data['post'] = \$this->input->post();
            }
        }

        \$this->data['${module_name}s'] = \$this->${module_name}->get_${module_name}_list();
     
        
        \$data['_view'] = "add_${module_name}";
 \$this->load->view('index',\$data);
    }

    
    /*****************Function edit**********************************
    * @type            : Function
    * @function name   : edit
    * @description     : Load Update "${module_name}" user interface                 
    *                    with populate "${module_name}" value 
    *                    and process to update "${module_name}" into database    
    * @param           : \$id integer value
    * @return          : null 
    * ********************************************************** */
    public function edit(\$id = null) {

       

        if(!is_numeric(\$id)){
             error(\$this->lang->line('unexpected_error'));
              redirect('${module_name}/index');
        }
        
        if (\$this->input->post()) {
            \$this->_prepare_${module_name}_validation();
            if (\$this->form_validation->run() === TRUE) {
                \$data = \$this->_get_posted_${module_name}_data();
                \$updated = \$this->${module_name}->update('${module_name}s', \$data, array('id' => \$this->input->post('id')));

                if (\$updated) {
                    
                    create_log('Has been updated a ${module_name} : '.\$data['name']);
                    
                    success(\$this->lang->line('update_success'));
                    redirect('${module_name}/index');
                } else {
                    error(\$this->lang->line('update_failed'));
                    redirect('${module_name}/edit/' . \$this->input->post('id'));
                }
            } else {
                \$this->data['${module_name}'] = \$this->${module_name}->get_single_${module_name}(\$this->input->post('id'));
            }
        }

        if (\$id) {
            \$this->data['${module_name}'] = \$this->${module_name}->get_single_${module_name}(\$id);

            if (!\$this->data['${module_name}']) {
                redirect('${module_name}/index');
            }
        }

        \$this->data['${module_name}s'] = \$this->${module_name}->get_${module_name}_list();
        \$this->data['roles'] = \$this->${module_name}->get_list('roles', array('status' => 1), '', '', '', 'id', 'ASC');
        
        \$this->data['edit'] = TRUE;
        \$this->layout->title(\$this->lang->line('edit') . ' ' . \$this->lang->line('${module_name}') . ' | ' . SMS);
        \$this->layout->view('${module_name}/index', \$this->data);
    }

    
    /*****************Function view**********************************
    * @type            : Function
    * @function name   : view
    * @description     : Load user interface with specific ${module_name} data                 
    *                       
    * @param           : $${module_name}_id integer value
    * @return          : null 
    * ********************************************************** */
    public function view($${module_name}_id = null) {

       

        if(!is_numeric($${module_name}_id)){
             error(\$this->lang->line('unexpected_error'));
             redirect('${module_name}/index');
        }
        
        \$this->data['${module_name}s'] = \$this->${module_name}->get_${module_name}_list();
      
        
        
        \$this->data['${module_name}'] = \$this->${module_name}->get_single_${module_name}($${module_name}_id);
        
        
        
        \$this->data['detail'] = TRUE;
        \$this->layout->title(\$this->lang->line('view') . ' ' . \$this->lang->line('${module_name}') . ' | ' . SMS);
        \$this->layout->view('${module_name}/index', \$this->data);
    }
    
    
         /*****************Function get_single_${module_name}**********************************
     * @type            : Function
     * @function name   : get_single_${module_name}
     * @description     : "Load single ${module_name} information" from database                  
     *                    to the user interface   
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function get_single_${module_name}(){
        
       $${module_name}_id = \$this->input->post('${module_name}_id');
       
       \$this->data['${module_name}'] = \$this->${module_name}->get_single_${module_name}($${module_name}_id);
      
       
       echo \$this->load->view('get-single-${module_name}', \$this->data);
    }
    
        
    /*****************Function _prepare_${module_name}_validation**********************************
    * @type            : Function
    * @function name   : _prepare_${module_name}_validation
    * @description     : Process "${module_name}" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_${module_name}_validation() {
        \$this->load->library('form_validation');
        \$this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');
        ${ci_validation}
    }

                        
   
   
       
    /*****************Function _get_posted_${module_name}_data**********************************
    * @type            : Function
    * @function name   : _get_posted_${module_name}_data
    * @description     : Prepare "${module_name}" user input data to save into database                  
    *                       
    * @param           : null
    * @return          : \$data array(); value 
    * ********************************************************** */
    private function _get_posted_${module_name}_data() {

        ${input_value}
       

        if (\$this->input->post('id')) {
            \$data['modified_at'] = date('Y-m-d H:i:s');
            \$data['modified_by'] = logged_in_user_id();
        } else {
            \$data['created_at'] = date('Y-m-d H:i:s');
            \$data['created_by'] = logged_in_user_id();
            \$data['modified_at'] = date('Y-m-d H:i:s');
            \$data['modified_by'] = logged_in_user_id();
            \$data['status'] = 1;
            // create user 
            \$data['user_id'] = \$this->${module_name}->create_user();
        }

       

        return \$data;
    }

    
          
    
    
    /*****************Function delete**********************************
    * @type            : Function
    * @function name   : delete
    * @description     : delete "${module_name}" data from database                  
    *                    and unlink ${module_name} photo from server   
    * @param           : \$id integer value
    * @return          : null 
    * ********************************************************** */
    public function delete(\$id = null) {

       
        
        if(!is_numeric(\$id)){
             error(\$this->lang->line('unexpected_error'));
             redirect('${module_name}/index');
        }
        
        $${module_name} = \$this->${module_name}->get_single('${module_name}s', array('id' => \$id));
        if (!empty($${module_name})) {

            // delete ${module_name} data
            \$this->${module_name}->delete('${module_name}s', array('id' => \$id));
            // delete ${module_name} login data
            \$this->${module_name}->delete('users', array('id' => \$${module_name}->user_id));

            
            
            create_log('Has been deleted a ${module_name} : '.$${module_name}->name);

            success(\$this->lang->line('delete_success'));
        } else {
            error(\$this->lang->line('delete_failed'));
        }
       redirect('${module_name}/index');
    }
EOT;

/*****************model Coding start**********************************/

$model_file= <<<EOT
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
		class ${class_name}_model extends MY_Model{
		    function __construct(){
		        parent::__construct();
		    	}

	}
	?>
EOT;

/*---------------------\end model--------------------------------**/


/*****************View coding start**********************************/

if(count($input_type)>0)
	{
		$parameter_input='';
		$heading_list_view='';
		$coloumn_list_view='';
		$edit_parameter_input='';
		for($v=0;$v<count($input_type);$v++)
		{
			$input_name_modified=$input_name[$v];
				$upper_name_modified=ucfirst($input_name[$v]);

				##for list view

				$heading_list_view.="<th>${upper_name_modified}</th>";
				$coloumn_list_view.="<td>\$row['${upper_name_modified}']</td>";
				

			if($input_type[$v]==1)
			{
				$parameter_input.= 
				
						'<div class="col-md-6">"
						<div class="form-group">
						<label for="'.$input_name_modified.'" class="col-md-4 control-label"><span class="text-danger">*</span>'.$upper_name_modified.'</label>
						<div class="col-md-12">
						<input type="text" name="'.$input_name_modified.'" value="<?= $this->input->post("'.$input_name_modified.'"); ?>" class="form-control" id="'.$input_name_modified.'" required />
						<span class="text-danger"><?= form_error("'.$input_name_modified.'"); ?></span>
						</div>
						</div>
						</div>'
						;

				$edit_parameter_input.=	
						'<div class="col-md-6">"
						<div class="form-group">
						<label for="'.$input_name_modified.'" class="col-md-4 control-label"><span class="text-danger">*</span>'.$upper_name_modified.'</label>
						<div class="col-md-12">
						<input type="text" name="'.$input_name_modified.'" value="<?= $this->input->post("'.$input_name_modified.'")?$this->input->post("'.$input_name_modified.'"):'.$input_name_modified.' ?>" class="form-control" id="'.$input_name_modified.'" required />
						<span class="text-danger"><?= form_error("'.$input_name_modified.'"); ?></span>
						</div>
						</div>
						</div>'
						;
	
			}	
			
			if($input_type[$v]==2)
			{
				$parameter_input.= 
				
						'<div class="col-md-6">"
						<div class="form-group">
						<label for="'.$input_name_modified.'" class="col-md-4 control-label"><span class="text-danger">*</span>'.$upper_name_modified.'</label>
						<div class="col-md-12">
						<input type="password" name="'.$input_name_modified.'" value="<?= $this->input->post("'.$input_name_modified.'"); ?>" class="form-control" id="'.$input_name_modified.'" required />
						<span class="text-danger"><?= form_error("'.$input_name_modified.'"); ?></span>
						</div>
						</div>
						</div>'
						;
					$edit_parameter_input.=	
						'<div class="col-md-6">"
						<div class="form-group">
						<label for="'.$input_name_modified.'" class="col-md-4 control-label"><span class="text-danger">*</span>'.$upper_name_modified.'</label>
						<div class="col-md-12">
						<input type="text" name="'.$input_name_modified.'" value="<?= $this->input->post("'.$input_name_modified.'")?$this->input->post("'.$input_name_modified.'"):'.$input_name_modified.' ?>" class="form-control" id="'.$input_name_modified.'" required />
						<span class="text-danger"><?= form_error("'.$input_name_modified.'"); ?></span>
						</div>
						</div>
						</div>'
						;
			}
			if($input_type[$v]==3)
			{
				$parameter_input.= 
				
						'<div class="col-md-6">"
						<div class="form-group">
						<label for="'.$input_name_modified.'" class="col-md-4 control-label"><span class="text-danger">*</span>'.$upper_name_modified.'</label>
						<div class="col-md-12">
						<select name="'.$input_name_modified.'" class="form-control">
							<option value="">--Select here--</option>
						</select>
						<span class="text-danger"><?= form_error("'.$input_name_modified.'"); ?></span>
						</div>
						</div>
						</div>'
						;
				$edit_parameter_input.= 
				
						'<div class="col-md-6">"
						<div class="form-group">
						<label for="'.$input_name_modified.'" class="col-md-4 control-label"><span class="text-danger">*</span>'.$upper_name_modified.'</label>
						<div class="col-md-12">
						<select name="'.$input_name_modified.'" class="form-control">
							<option value="">--Select here--</option>
							
						</select>
						<span class="text-danger"><?= form_error("'.$input_name_modified.'"); ?></span>
						</div>
						</div>
						</div>'
						;
			}
			
		}
	}

$view_add_file= <<<EOT

<div class="row">
  	<div class="col-md-12">
		<div class="card card-default ">
  			<div class="card-header def">
  				<h3 class="card-title">ADD  ${module_name}</h3>
			</div>
  			<!-- /.card-header -->
  			<div class="card-body">
  			<?= form_open('stu/add',array("class"=>"form-horizontal","id"=>"form_validation")); ?>
  				<div class="row">
				${parameter_input}

				</div>
			<?= form_close(); ?>
			</div>
		</div>
		</div>
	</div>			
EOT;

$view_edit_file = <<<EOT
		<div class="row">
  	<div class="col-md-12">
		<div class="card card-default ">
  			<div class="card-header def">
  				<h3 class="card-title">ADD  ${module_name}</h3>
			</div>
  			<!-- /.card-header -->
  			<div class="card-body">
  			<?= form_open('stu/edit/\$id',array("class"=>"form-horizontal","id"=>"form_validation")); ?>
  				<div class="row">
				${edit_parameter_input}

				</div>
			<?= form_close(); ?>
			</div>
		</div>
		</div>
	</div>	
EOT;




###list file
$list_file=
'<div class="row">
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
                '.$heading_list_view.'
                
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
             
              <?php foreach($'.$module_name.' as $row){ ?>
                <tr>
                  '.$coloumn_list_view.'
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
</script>';
##--end list file##
/*---------------------\end model--------------------------------**/
$c_file = fopen($module_name."/controllers/".$controller_name,"w");
echo fwrite($c_file,$controller_file);
fclose($c_file);
$m_file = fopen($module_name."/models/".$model_name.".php","w");
echo fwrite($m_file,$model_file);
fclose($m_file);


#view files
$view_file_create_add = fopen($module_name."/views/add.php","w");
echo fwrite($view_file_create_add,$view_add_file);
fclose($view_file_create_add);

##view edit file

$view_file_create_edit = fopen($module_name."/views/edit.php","w");
echo fwrite($view_file_create_edit,$view_edit_file);
fclose($view_file_create_edit);

##view list

$view_file_create_list = fopen($module_name."/views/index.php","w");
echo fwrite($view_file_create_list,$list_file);
fclose($view_file_create_list);




?>