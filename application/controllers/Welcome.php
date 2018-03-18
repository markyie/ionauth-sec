<?php defined('BASEPATH') OR exit('No direct script access allowed');

use SimpleExcel\SimpleExcel;

class Welcome extends CI_Controller {

    public function index()
    {
        $_SESSION['user'] = 'markyie';    
        $this->load->view('welcome_message');
    }

    public function test_composer()
    {
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
    
    public function testing()
    {
        echo $_SESSION['user'];
    }
}