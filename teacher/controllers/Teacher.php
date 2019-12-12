
<?php if (!defined("BASEPATH")) exit("No direct script access allowed");

class Teacher extends MY_Controller
{

       function __construct()
       {
        parent::__construct();
        $this->load->model('Teacher_model');
      }
      public $table_name="teachers";


 /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "teacher List" user interface                 
    *                     
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function index() {

        
        $data['teachers'] = $this->Teacher_model->select('$table_name','',array('*'));
        
        
        
        $data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_teacher'));
        $this->layout->view('index', $data);
    }

    
    /*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Load "Add new teacher" user interface                 
    *                    and process to store "teacher" into database 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function add() {

       

        if ($this->input->post()) {
            $this->_prepare_teacher_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_teacher_data();

                $insert_id = $this->Teacher_model->insert($table_name, $data);
                if ($insert_id) {
                    
                    create_log('Has been added a teacher : '.$data['name']);
                    
                    success($this->lang->line('insert_success'));
                    redirect('teacher');
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('teacher/add');
                }
            } else {

                $this->data['post'] = $this->input->post();
            }
        }

        $this->data['teachers'] = $this->teacher->get_teacher_list();
     
        
        $this->data['add'] = TRUE;
        $this->layout->title($this->lang->line('add') . ' ' . $this->lang->line('teacher') . ' | ' . SMS);
        $this->layout->view('index', $this->data);
    }

    
    /*****************Function edit**********************************
    * @type            : Function
    * @function name   : edit
    * @description     : Load Update "teacher" user interface                 
    *                    with populate "teacher" value 
    *                    and process to update "teacher" into database    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function edit($id = null) {

       

        if(!is_numeric($id)){
             error($this->lang->line('unexpected_error'));
              redirect('teacher/index');
        }
        
        if ($this->input->post()) {
            $this->_prepare_teacher_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_teacher_data();
                $updated = $this->teacher->update('teachers', $data, array('id' => $this->input->post('id')));

                if ($updated) {
                    
                    create_log('Has been updated a teacher : '.$data['name']);
                    
                    success($this->lang->line('update_success'));
                    redirect('teacher/index');
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('teacher/edit/' . $this->input->post('id'));
                }
            } else {
                $this->data['teacher'] = $this->teacher->get_single_teacher($this->input->post('id'));
            }
        }

        if ($id) {
            $this->data['teacher'] = $this->teacher->get_single_teacher($id);

            if (!$this->data['teacher']) {
                redirect('teacher/index');
            }
        }

        $this->data['teachers'] = $this->teacher->get_teacher_list();
        $this->data['roles'] = $this->teacher->get_list('roles', array('status' => 1), '', '', '', 'id', 'ASC');
        
        $this->data['edit'] = TRUE;
        $this->layout->title($this->lang->line('edit') . ' ' . $this->lang->line('teacher') . ' | ' . SMS);
        $this->layout->view('teacher/index', $this->data);
    }

    
    /*****************Function view**********************************
    * @type            : Function
    * @function name   : view
    * @description     : Load user interface with specific teacher data                 
    *                       
    * @param           : $teacher_id integer value
    * @return          : null 
    * ********************************************************** */
    public function view($teacher_id = null) {

       

        if(!is_numeric($teacher_id)){
             error($this->lang->line('unexpected_error'));
             redirect('teacher/index');
        }
        
        $this->data['teachers'] = $this->teacher->get_teacher_list();
      
        
        
        $this->data['teacher'] = $this->teacher->get_single_teacher($teacher_id);
        
        
        
        $this->data['detail'] = TRUE;
        $this->layout->title($this->lang->line('view') . ' ' . $this->lang->line('teacher') . ' | ' . SMS);
        $this->layout->view('teacher/index', $this->data);
    }
    
    
         /*****************Function get_single_teacher**********************************
     * @type            : Function
     * @function name   : get_single_teacher
     * @description     : "Load single teacher information" from database                  
     *                    to the user interface   
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function get_single_teacher(){
        
       $teacher_id = $this->input->post('teacher_id');
       
       $this->data['teacher'] = $this->teacher->get_single_teacher($teacher_id);
       $this->data['students'] = $this->teacher->get_student_list($teacher_id);
       $this->data['invoices'] = $this->teacher->get_invoice_list($teacher_id);  
       
       echo $this->load->view('get-single-teacher', $this->data);
    }
    
        
    /*****************Function _prepare_teacher_validation**********************************
    * @type            : Function
    * @function name   : _prepare_teacher_validation
    * @description     : Process "teacher" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_teacher_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');
        $this->form_validation->set_rules('name','Name','required|trim');

    }

                        
   
   
       
    /*****************Function _get_posted_teacher_data**********************************
    * @type            : Function
    * @function name   : _get_posted_teacher_data
    * @description     : Prepare "teacher" user input data to save into database                  
    *                       
    * @param           : null
    * @return          : $data array(); value 
    * ********************************************************** */
    private function _get_posted_teacher_data() {

        $name =htmlspecialchars($this->input->post('name',true));

       

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
            $data['user_id'] = $this->teacher->create_user();
        }

       

        return $data;
    }

    
          
    
    
    /*****************Function delete**********************************
    * @type            : Function
    * @function name   : delete
    * @description     : delete "teacher" data from database                  
    *                    and unlink teacher photo from server   
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function delete($id = null) {

       
        
        if(!is_numeric($id)){
             error($this->lang->line('unexpected_error'));
             redirect('teacher/index');
        }
        
        $teacher = $this->teacher->get_single('teachers', array('id' => $id));
        if (!empty($teacher)) {

            // delete teacher data
            $this->teacher->delete('teachers', array('id' => $id));
            // delete teacher login data
            $this->teacher->delete('users', array('id' => $teacher->user_id));

            
            
            create_log('Has been deleted a teacher : '.$teacher->name);

            success($this->lang->line('delete_success'));
        } else {
            error($this->lang->line('delete_failed'));
        }
       redirect('teacher/index');
    }