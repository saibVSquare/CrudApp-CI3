<?php
defined('BASEPATH') or exit('No direct script access allowed');
class ItemCRUD extends CI_Controller
{
	public $itemCRUD;

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('ItemCRUDModel');
		$this->itemCRUD = new ItemCRUDModel;
	}


	public function index()
	{
		$data['data'] = $this->itemCRUD->get_itemCRUD();
		$this->load->view('itemCRUD/list', $data);
	}


	public function show($id)
	{
		$item = $this->itemCRUD->find_item($id);
		$this->load->view('itemCRUD/show', array('item' => $item));
	}


	public function create()
	{
		$this->load->view('itemCRUD/create');
	}


	public function store()
	{
		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('description', 'Description', 'required');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('errors', validation_errors());
			redirect(base_url('itemCRUD/create'));
		} else {
			$this->itemCRUD->insert_item();
			redirect(base_url('itemCRUD'));
		}
	}


	public function edit($id)
	{
		$item = $this->itemCRUD->find_item($id);
		$this->load->view('itemCRUD/edit', array('item' => $item));
	}


	public function update($id)
	{
		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('description', 'Description', 'required');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('errors', validation_errors());
			redirect(base_url('itemCRUD/edit/' . $id));
		} else {
			$this->itemCRUD->update_item($id);
			redirect(base_url('itemCRUD'));
		}
	}


	public function delete($id)
	{
		$item = $this->itemCRUD->delete_item($id);
		redirect(base_url('itemCRUD'));
	}
}
