<?php 


// $file = fopen("data.php","r");

// echo $file;
// while(!feof($file))
// {
// echo fgets($file);



$input_name= $_POST['input_name'];
$module_name= $_POST['module_name'];
     // print_r($input_name);die;
// $module_name="studentss";
@mkdir($module_name);
@mkdir($module_name."/controller");
@mkdir($module_name."/models");
@mkdir($module_name."/view");
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
 $ci_validation.="\$this->form_validation->set_rules('${input_name[$i]}','${varibale_name_message}','required|trim');\n\r";
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



$file = fopen($module_name."/controller/".$controller_name,"w");
echo fwrite($file,$controller_file);
fclose($file);










?>