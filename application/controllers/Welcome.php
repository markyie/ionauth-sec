<?php defined('BASEPATH') OR exit('No direct script access allowed');

use SimpleExcel\SimpleExcel;

class Welcome extends My_Controller{
    
//    function __construct() {
//        parent::__construct();
//    }
    
    private $_uploaded;

    public function index(){
        $_SESSION['user'] = 'markyie';      
        $this->load->view('welcome_message');
    }
    
    public function test_template(){
        //$this->data['pagetitle'] = 'test'; ...you can at any time change the variables declared in the MY_Controller...
        $this->render('homepage_view');
        //$this->render(NULL, 'json'); ....if we want to render a json string. Also, if a request is made using ajax, we can simply do $this->render()
    }
    
    public function upload_imgs(){
        $data = array();
        $data['title'] = 'Multiple File Upload';
        
        // let's consider that the form would come with more fields than just the files to be uploaded. If this is the case, we would need to do some sort of validation. If we are talking about images, the only method of validation for us would be to put the upload process inside a validation callback
        $this->load->library('form_validation');
        
        //now we set a callback as rule for the upload field
        $this->form_validation->set_rules('uploadedimages[]','Upload image','callback_fileupload_check');
        
        // was something posted?
        if($this->input->post()) {
            
            // run validation
            if($this->form_validation->run()) {
                // for now let's just verify if all went ok with the upload...
                echo '<pre>';
                print_r($this->_uploaded);
                echo '</pre>';
            }
        }
        $this->load->view('upload_form', $data);
    }
    
    // now the callback validation that deals with the upload of files
    public function fileupload_check() {
        // retrieve the number of images uploads
        $number_of_files = sizeof($_FILES['uploadedimages']['tmp_name']);
        // considering that do_upload() accepts single files, we will have to do a small hack so that we can upload multiple files. For this we will have to keep the data of uploaded files in a variable, and redo the $_FILE.
        $files = $_FILES['uploadedimages'];

        // first make sure no error in up uploading the files
        for($i=0; $i<$number_of_files; $i++) {
            if($_FILES['uploadedimages']['error'][$i]!=0) {
                // save the error message and return false, the validation of uploaded files failed
                $this->form_validation->set_message('fileupload_check', 'Couldn\'t upload file(s).');
                return FALSE;
            }
        }

        // we first load the upload library
        $this->load->library('upload');
        // next we pass the upload path for the images
        $config['upload_path'] = FCPATH .'/upload';
        // also, we make sure we allow only certain type of images
        $config['allowed_types'] = 'gif|jpg|png';
        for($i = 0; $i < $number_of_files; $i++){
            $_FILES['uploadedimage']['name'] = $files['name'][$i];
            $_FILES['uploadedimage']['type'] = $files['type'][$i];
            $_FILES['uploadedimage']['tmp_name'] = $files['tmp_name'][$i];
            $_FILES['uploadedimage']['error'] = $files['error'][$i];
            $_FILES['uploadedimage']['size'] = $files['size'][$i];

            //now we initialize the upload library
            $this->upload->initialize($config);
            // we retrieve the number of files that were uploaded
            if($this->upload->do_upload('uploadedimage')) {
                $data['uploads'][$i] = $this->upload->data();
            }else{
                $this->form_validation->set_message('fileuoload_check', $this->upload->display_errors());
                return FALSE;
            }
        }
        return TRUE;
    }

    private function _image_creation($image) {
        // we make sure we receive an array. if no array is given or the array is empty, return false
        if(!is_array($image) || empty($image)) {
            return FALSE;
        }
        
        //let's have an array to return
        $new_images = array();
        
        //we return the array with the new images
        return $new_images;
    }

    public function test_composer() {
      $excel = new \SimpleExcel\SimpleExcel('xml'); // instantiate new object (will automatically construct the parser & writer type as XML)

      $excel->writer->setData(
        array
        (
          array('ID', 'Name', 'Kode' ),
          array('1', 'Kab. Bogor', '1' ),
          array('2', 'Kab. Cianjur', '1' ),
          array('3', 'Kab. Sukabumi', '1' ),
          array('4', 'Kab. Tasikmalaya', '2' )
        )
      ); // add some data to the writer
      $excel->writer->saveFile('example'); // save the file with specified name (example.xml)
      // and specified target (default to browser)
    }
    
    public function testing() {
        echo $_SESSION['user'];
    }
}