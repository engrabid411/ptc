<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->helper('url');

		$this->load->library('grocery_CRUD');
	}

	public function _user_output($output = null)
	{
		$this->load->view('admin.php',(array)$output);
	}

	
	public function index()
	{

		$this->_user_output((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
	}

	public function user_management()
	{
		try{
			$crud = new grocery_CRUD();

			$crud->set_theme('tablestrap');
			$crud->set_table('Users');
			$crud->set_relation('role_id','Roles','role');
			$crud->set_subject('Users');
			$crud->required_fields('name');
			$crud->columns('name','username','role_id');

			$output = $crud->render();

			$this->_user_output($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}
	public function student_management()
	{
		try{
			$crud = new grocery_CRUD();

			$crud->set_theme('tablestrap');
			$crud->set_table('Students');
			$crud->set_relation('parent_id','Users','name',array('role_id' => 1));
			$crud->set_subject('Students');
			$crud->required_fields('name');
			$crud->columns('name', 'phone', 'address');

			$output = $crud->render();

			$this->_user_output($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}
	public function school_management()
	{
		try{
			$crud = new grocery_CRUD();

			$crud->set_theme('tablestrap');
			$crud->set_table('Schools');
			$crud->set_subject('Schools');
			$crud->required_fields('name');
			$crud->columns('name', 'address', 'contact', 'branch');

			$output = $crud->render();

			$this->_user_output($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}

	public function classroom_management()
	{
		try{
			$crud = new grocery_CRUD();

			$crud->set_theme('tablestrap');
			$crud->set_table('ClassRoom');
			$crud->set_relation('school_id','Schools','name');
			$crud->set_subject('ClassRoom');
			$crud->required_fields('class');
			$crud->columns('class', 'section', 'school_id');

			$output = $crud->render();

			$this->_user_output($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}

	public function subjects_management()
	{
		try{
			$crud = new grocery_CRUD();

			$crud->set_theme('tablestrap');
			$crud->set_table('Subjects');
			$crud->set_subject('Subjects');
			$crud->required_fields('name');
			$crud->columns('name');

			$output = $crud->render();

			$this->_user_output($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}

	public function classes_management()
	{
		try{



			$crud = new grocery_CRUD();

			$crud->set_theme('tablestrap');
			$crud->set_table('Classes');
			$crud->set_relation('classroom_id','ClassRoom','{class} - {school_id}');
			$crud->set_relation('subject_id','Subjects','name');
			$crud->set_relation('teacher_id','Users','name',array('role_id' => 2));
			$crud->set_relation('student_id','Students','name');
			$crud->set_subject('CLasses');
			$crud->required_fields('class_id');
			$crud->columns('class_id', 'classroom_id', 'subject_id', 'teacher_id', 'student_id');

			$output = $crud->render();	

			$this->_user_output($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}



	
}
