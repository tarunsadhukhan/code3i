<?php
 

class Itemadd extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        // Load the necessary libraries.
        $this->load->library('image_library');
        $this->load->helper('file');
    }

    public function save() {
        // Get the employee data from the request.
        $empcode = $this->input->post('empcode');
        $name = $this->input->post('name');
        $photo = $this->input->post('photo');

        // Resize the photo to a common size.
        $this->image_library->resize($photo, 200, 200);

        // Save the employee data to the MySQL database.
        $otherdb = $this->load->database('empmill12', TRUE); 
		
       $otherdb->insert('employees', [
            'empcode' => $empcode,
            'name' => $name,
            'photo' => file_get_contents($photo)
        ]);

        // Redirect the user to the employee list page.
   //     redirect('/employee/list');
    }
}



?>
