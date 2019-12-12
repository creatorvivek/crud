
<?php if (!defined("BASEPATH")) exit("No direct script access allowed");

class Stu extends MY_Controller
{

       function __construct()
       {
        parent::__construct();
        $this->load->model('Stu_model');
      }
      public $table_name="stus";


 /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "stu List" user interface                 
    *                     
    * @param           : null
    * @return          : null 
    * ********************************************************** */
				   public function index()
				{
				  $data["title"]="stu list";
				  $data["stu"] = $this->Stu_model->select($table_name,$condition,array('*'));
				  $data['_view'] = "stu_list";
				  $this->load->view('index',$data);

				}



    
    /*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Load "Add new stu" user interface                 
    *                    and process to store "stu" into database 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function add() {

       

        if ($this->input->post()) {
            $this->_prepare_stu_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_stu_data();

                $insert_id = $this->Stu_model->insert($table_name, $data);
                if ($insert_id) {
                    
                    create_log('Has been added a stu : '.$data['name']);
                    
                    success($this->lang->line('insert_success'));
                    redirect('stu');
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('stu/add');
                }
            } else {

                $this->data['post'] = $this->input->post();
            }
        }

        $this->data['stus'] = $this->stu->get_stu_list();
     
        
        $data['_view'] = "add_stu";
 $this->load->view('index',$data);
    }

    
    /*****************Function edit**********************************
    * @type            : Function
    * @function name   : edit
    * @description     : Load Update "stu" user interface                 
    *                    with populate "stu" value 
    *                    and process to update "stu" into database    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function edit($id = null) {

       

        if(!is_numeric($id)){
             error($this->lang->line('unexpected_error'));
              redirect('stu/index');
        }
        
        if ($this->input->post()) {
            $this->_prepare_stu_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_stu_data();
                $updated = $this->stu->update('stus', $data, array('id' => $this->input->post('id')));

                if ($updated) {
                    
                    create_log('Has been updated a stu : '.$data['name']);
                    
                    success($this->lang->line('update_success'));
                    redirect('stu/index');
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('stu/edit/' . $this->input->post('id'));
                }
            } else {
                $this->data['stu'] = $this->stu->get_single_stu($this->input->post('id'));
            }
        }

        if ($id) {
            $this->data['stu'] = $this->stu->get_single_stu($id);

            if (!$this->data['stu']) {
                redirect('stu/index');
            }
        }

        $this->data['stus'] = $this->stu->get_stu_list();
        $this->data['roles'] = $this->stu->get_list('roles', array('status' => 1), '', '', '', 'id', 'ASC');
        
        $this->data['edit'] = TRUE;
        $this->layout->title($this->lang->line('edit') . ' ' . $this->lang->line('stu') . ' | ' . SMS);
        $this->layout->view('stu/index', $this->data);
    }

    
    /*****************Function view**********************************
    * @type            : Function
    * @function name   : view
    * @description     : Load user interface with specific stu data                 
    *                       
    * @param           : $stu_id integer value
    * @return          : null 
    * ********************************************************** */
    public function view($stu_id = null) {

       

        if(!is_numeric($stu_id)){
             error($this->lang->line('unexpected_error'));
             redirect('stu/index');
        }
        
        $this->data['stus'] = $this->stu->get_stu_list();
      
        
        
        $this->data['stu'] = $this->stu->get_single_stu($stu_id);
        
        
        
        $this->data['detail'] = TRUE;
        $this->layout->title($this->lang->line('view') . ' ' . $this->lang->line('stu') . ' | ' . SMS);
        $this->layout->view('stu/index', $this->data);
    }
    
    
         /*****************Function get_single_stu**********************************
     * @type            : Function
     * @function name   : get_single_stu
     * @description     : "Load single stu information" from database                  
     *                    to the user interface   
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function get_single_stu(){
        
       $stu_id = $this->input->post('stu_id');
       
       $this->data['stu'] = $this->stu->get_single_stu($stu_id);
      
       
       echo $this->load->view('get-single-stu', $this->data);
    }
    
        
    /*****************Function _prepare_stu_validation**********************************
    * @type            : Function
    * @function name   : _prepare_stu_validation
    * @description     : Process "stu" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_stu_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');
        $this->form_validation->set_rules('name','Name','required|trim');
$this->form_validation->set_rules('age','Age','required|trim');
$this->form_validation->set_rules('school','School','required|trim');

    }

                        
   
   
       
    /*****************Function _get_posted_stu_data**********************************
    * @type            : Function
    * @function name   : _get_posted_stu_data
    * @description     : Prepare "stu" user input data to save into database                  
    *                       
    * @param           : null
    * @return          : $data array(); value 
    * ********************************************************** */
    private function _get_posted_stu_data() {

        $name =htmlspecialchars($this->input->post('name',true));
$age =htmlspecialchars($this->input->post('age',true));
$school =htmlspecialchars($this->input->post('school',true));

       

        if ($this->input->post('id')) {
            $data['modified_at'] = date('Y-m-d H:i:s');
            $data['modified_by'] = logged_in_user_id();
        } else {
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = logged_in_user_id();
            $data['modified_at'] = date('Y-m-d H:i:s');
            $data['modified_by'] = logged_in_user_id();
            $data['status'] = 1;
            // create user 
            $data['user_id'] = $this->stu->create_user();
        }

       

        return $data;
    }

    
          
    
    
    /*****************Function delete**********************************
    * @type            : Function
    * @function name   : delete
    * @description     : delete "stu" data from database                  
    *                    and unlink stu photo from server   
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function delete($id = null) {

       
        
        if(!is_numeric($id)){
             error($this->lang->line('unexpected_error'));
             redirect('stu/index');
        }
        
        $stu = $this->stu->get_single('stus', array('id' => $id));
        if (!empty($stu)) {

            // delete stu data
            $this->stu->delete('stus', array('id' => $id));
            // delete stu login data
            $this->stu->delete('users', array('id' => $stu->user_id));

            
            
            create_log('Has been deleted a stu : '.$stu->name);

            success($this->lang->line('delete_success'));
        } else {
            error($this->lang->line('delete_failed'));
        }
       redirect('stu/index');
    }