
<?php if (!defined("BASEPATH")) exit("No direct script access allowed");

class Vivek extends MY_Controller
{

       function __construct()
       {
        parent::__construct();
        $this->load->model('Vivek_model');
      }
      public $table_name="viveks";


 /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "vivek List" user interface                 
    *                     
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function index() {

        
        $data['viveks'] = $this->Vivek_model->select('$table_name','',array('*'));
        
        
        
        $data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_vivek'));
        $this->layout->view('index', $data);
    }

    
    /*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Load "Add new vivek" user interface                 
    *                    and process to store "vivek" into database 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function add() {

       

        if ($this->input->post()) {
            $this->_prepare_vivek_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_vivek_data();

                $insert_id = $this->Vivek_model->insert($table_name, $data);
                if ($insert_id) {
                    
                    create_log('Has been added a vivek : '.$data['name']);
                    
                    success($this->lang->line('insert_success'));
                    redirect('vivek');
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('vivek/add');
                }
            } else {

                $this->data['post'] = $this->input->post();
            }
        }

        $this->data['viveks'] = $this->vivek->get_vivek_list();
     
        
        $this->data['add'] = TRUE;
        $this->layout->title($this->lang->line('add') . ' ' . $this->lang->line('vivek') . ' | ' . SMS);
        $this->layout->view('index', $this->data);
    }

    
    /*****************Function edit**********************************
    * @type            : Function
    * @function name   : edit
    * @description     : Load Update "vivek" user interface                 
    *                    with populate "vivek" value 
    *                    and process to update "vivek" into database    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function edit($id = null) {

       

        if(!is_numeric($id)){
             error($this->lang->line('unexpected_error'));
              redirect('vivek/index');
        }
        
        if ($this->input->post()) {
            $this->_prepare_vivek_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_vivek_data();
                $updated = $this->vivek->update('viveks', $data, array('id' => $this->input->post('id')));

                if ($updated) {
                    
                    create_log('Has been updated a vivek : '.$data['name']);
                    
                    success($this->lang->line('update_success'));
                    redirect('vivek/index');
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('vivek/edit/' . $this->input->post('id'));
                }
            } else {
                $this->data['vivek'] = $this->vivek->get_single_vivek($this->input->post('id'));
            }
        }

        if ($id) {
            $this->data['vivek'] = $this->vivek->get_single_vivek($id);

            if (!$this->data['vivek']) {
                redirect('vivek/index');
            }
        }

        $this->data['viveks'] = $this->vivek->get_vivek_list();
        $this->data['roles'] = $this->vivek->get_list('roles', array('status' => 1), '', '', '', 'id', 'ASC');
        
        $this->data['edit'] = TRUE;
        $this->layout->title($this->lang->line('edit') . ' ' . $this->lang->line('vivek') . ' | ' . SMS);
        $this->layout->view('vivek/index', $this->data);
    }

    
    /*****************Function view**********************************
    * @type            : Function
    * @function name   : view
    * @description     : Load user interface with specific vivek data                 
    *                       
    * @param           : $vivek_id integer value
    * @return          : null 
    * ********************************************************** */
    public function view($vivek_id = null) {

       

        if(!is_numeric($vivek_id)){
             error($this->lang->line('unexpected_error'));
             redirect('vivek/index');
        }
        
        $this->data['viveks'] = $this->vivek->get_vivek_list();
      
        
        
        $this->data['vivek'] = $this->vivek->get_single_vivek($vivek_id);
        
        
        
        $this->data['detail'] = TRUE;
        $this->layout->title($this->lang->line('view') . ' ' . $this->lang->line('vivek') . ' | ' . SMS);
        $this->layout->view('vivek/index', $this->data);
    }
    
    
         /*****************Function get_single_vivek**********************************
     * @type            : Function
     * @function name   : get_single_vivek
     * @description     : "Load single vivek information" from database                  
     *                    to the user interface   
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function get_single_vivek(){
        
       $vivek_id = $this->input->post('vivek_id');
       
       $this->data['vivek'] = $this->vivek->get_single_vivek($vivek_id);
       $this->data['students'] = $this->vivek->get_student_list($vivek_id);
       $this->data['invoices'] = $this->vivek->get_invoice_list($vivek_id);  
       
       echo $this->load->view('get-single-vivek', $this->data);
    }
    
        
    /*****************Function _prepare_vivek_validation**********************************
    * @type            : Function
    * @function name   : _prepare_vivek_validation
    * @description     : Process "vivek" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_vivek_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');
        $this->form_validation->set_rules('','','required|trim');

    }

                        
   
   
       
    /*****************Function _get_posted_vivek_data**********************************
    * @type            : Function
    * @function name   : _get_posted_vivek_data
    * @description     : Prepare "vivek" user input data to save into database                  
    *                       
    * @param           : null
    * @return          : $data array(); value 
    * ********************************************************** */
    private function _get_posted_vivek_data() {

        $ =htmlspecialchars($this->input->post('',true));

       

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
            $data['user_id'] = $this->vivek->create_user();
        }

       

        return $data;
    }

    
          
    
    
    /*****************Function delete**********************************
    * @type            : Function
    * @function name   : delete
    * @description     : delete "vivek" data from database                  
    *                    and unlink vivek photo from server   
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function delete($id = null) {

       
        
        if(!is_numeric($id)){
             error($this->lang->line('unexpected_error'));
             redirect('vivek/index');
        }
        
        $vivek = $this->vivek->get_single('viveks', array('id' => $id));
        if (!empty($vivek)) {

            // delete vivek data
            $this->vivek->delete('viveks', array('id' => $id));
            // delete vivek login data
            $this->vivek->delete('users', array('id' => $vivek->user_id));

            
            
            create_log('Has been deleted a vivek : '.$vivek->name);

            success($this->lang->line('delete_success'));
        } else {
            error($this->lang->line('delete_failed'));
        }
       redirect('vivek/index');
    }