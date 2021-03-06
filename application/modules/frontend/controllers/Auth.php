<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Auth_model');

		//Codeigniter : Write Less Do More
	}

	function index()
	{ }


	public function register()
	{

		$seminar  = $this->Crud_model->listingOne('tbl_seminar', 'id_seminar', '1');

		if ($seminar->is_pendaftaran == 0) {
			$data = array(
				'title'         => 'Register',
				'pesan'					=> 'Pendaftaran telah ditutup',
				'isi'           => 'frontend/404_page'
			);
			$this->load->view('frontend/layout/wrapper', $data);
		} else {

			$valid = $this->form_validation;

			$valid->set_rules(
				'nama_no_title',
				'Nama',
				'required',
				array('required' => ' %s harus diisi')
			);



			if ($valid->run() === FALSE) {
				$data = array(
					'title'         => 'Register',
					'isi'           => 'frontend/auth/register'
				);
				$this->load->view('frontend/layout/wrapper', $data);
			} else {
				$i = $this->input;
				$data = array(
					'id_peserta' 			=> 'SN' . date('ymdhis'),
					'nama_no_title'		=> $i->post('nama_no_title'),
					'gender'		      => $i->post('gender'),
					'institusi'	      => $i->post('institusi'),
					'alamat'		      => $i->post('alamat'),
					'telp'		      => $i->post('telp'),
					'email'		        => $i->post('email'),
					'password'		    => md5($i->post('password'))
				);
				$this->Crud_model->add('tbl_peserta', $data);
				$this->session->set_flashdata('msg', ' Data telah ditambah');
				redirect(base_url('login_participant'), 'refresh');
			}
		}
	}

	function login()
	{
		$valid = $this->form_validation;

		$valid->set_rules(
			'email',
			'Email',
			'required',
			array('required' => '%s harus diisi')
		);
		$valid->set_rules(
			'password',
			'Password',
			'required|min_length[6]',
			array(
				'required' 	=> 'Password harus diisi',
				'min_length'  => 'Password minimal 6 karakter'
			)
		);

		if ($valid->run() === FALSE) {
			$data = array(
				'title' => 'Login Partisipan seminar',
				'isi'		=> 'frontend/auth/login_view'
			);
			$this->load->view('frontend/layout/wrapper', $data);
		} else {
			$i          = $this->input;
			$email   = $i->post('email');
			$password   = $i->post('password');
			$cek_login  = $this->Auth_model->login($email, $password);

			if (!empty($cek_login) == 1) {
				$s = $this->session;
				$s->set_userdata('id_peserta', $cek_login->id_peserta);
				$s->set_userdata('email', $cek_login->email);


				redirect(base_url(), 'refresh');
			} else {
				$data = array(
					'title'     => 'Login Partisipan',
					'pesan_er'  => 'Email atau password tidak cocok',
					'isi'		=> 'frontend/auth/login_view'
				);
				$this->load->view('frontend/layout/wrapper', $data);
			}
		}
	}


	function logout()
	{
		$s = $this->session;
		$s->unset_userdata('id_peserta');
		$s->unset_userdata('email');
		redirect(base_url(), 'refresh');
	}
}
