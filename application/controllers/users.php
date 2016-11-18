<?php
class Users extends CI_Controller {
  public function __construct()
  {
    parent::__construct();
    $this->load->model('User');
    $this->load->helper('url');
    // $this->output->enable_profiler(TRUE);
  }
  public function index()
  {
    $this->load->view('index');
  }
  public function register()
  {
    $this->load->library("form_validation");
    $this->form_validation->set_rules("name", "Name", "trim|required");
    $this->form_validation->set_rules("alias", "Alias", "trim|required");
    $this->form_validation->set_rules("email", "Email", "trim|required|valid_email");
    $this->form_validation->set_rules("password", "Password", "trim|required|min_length[8]");
    $this->form_validation->set_rules("conf_pass", "Confirm Password", "trim|required|matches[password]");

    if($this->form_validation->run() === FALSE)
    {
      $this->session->set_flashdata('message', validation_errors());
      redirect('/');
    }elseif (strtotime($this->input->post('dob'))>strtotime('now')) {
      $this->session->set_flashdata('message', "Please pick a valid birthday.");
      redirect('/');
    }
    else
    {
      $password = md5($this->input->post('password'));
      $user = array(
        'name' => $this->input->post('name'),
        'alias' => $this->input->post('alias'),
        'email' => $this->input->post('email'),
        'password'=>$password,
        'dob'=>$this->input->post('dob')
      );
      $user_session = array(
        'email'=>$this->input->post('email'),
      );
      $this->session->set_userdata($user_session);
      $this->User->add_user($user);
      redirect('/users/pokes');
    }
  }
  public function login()
  {
    $user = $this->User->find_by_email($this->input->post('email'));
    $password = md5($this->input->post('password'));
    if($user && $user['password']==$password)
    {
      $user_session = array(
        'email'=>$user['email']
      );
      $this->session->set_userdata($user_session);
      redirect('/users/pokes');
    }
    else {
      $this->session->set_flashdata('message', 'Invalid Login');
      redirect('/');
    }
  }
  public function pokes(){
    if(!isset($this->session->userdata['email'])){
      redirect('/');
    }
    $view_data['user'] = $this->User->find_by_email($this->session->userdata['email']);
    $view_data['all_users']=$this->User->get_users($this->session->userdata['email']);
    $view_data['poked_you']=$this->User->poked_you($view_data['user']['id']);
    // var_dump($view_data['poked_you']);
    $this->load->view('main', $view_data);
  }
  public function poke($id){
    if(!isset($this->session->userdata['email'])){
      redirect('/');
    }
    $user = $this->User->find_by_email($this->session->userdata['email']);
    echo $user['id'];
    echo $id;
    $this->User->add_poke($user['id'], $id);
    redirect('/users/pokes');
  }
  public function logout(){
    $this->session->sess_destroy();
    redirect('/');
  }
}
 ?>
