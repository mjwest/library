<?php

class Library extends Controller {

	function Library()
	{
		parent::Controller();	
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('markdown');
	}
	
	function index()
	{
		$this->load->view('library/header');
		
		$this->db->where('status !=', 'deleted');
		$query = $this->db->get('library');
		if($query->num_rows() > 0){
			$entries = array();
			foreach($query->result() as $entry){
				$entries[$entry->idEntry] = array(
					'title' => $entry->title,
					'author' => $entry->author,
					'link' => $entry->link,
					'description' => nl2br($entry->description),
					'type' => $entry->type,
					'imagePath' => $entry->imagePath
				);
			}
			$data['entries'] = $entries;
			
			$this->load->view('library/main', $data);
		} else {
			echo "There are no entries";
		}
	}
	
	function alert($type, $message)
	{
		$data['type'] = $type;
		$data['message'] = $message;
		$this->load->view('library/alert', $data);
	}
	
	function addEntry()
	{
		if($this->input->post('passphrase') == "commonplace") {
			$entry = array(
				'title' => $this->input->post('title'),
				'author' => $this->input->post('author'),
				'link' => $this->input->post('link'),
				'description' => $this->input->post('description'),
				'type' => 'entry'
			);	
			$this->alert('success', "Entry added");
			$this->db->insert('library', $entry);		
		} else {
			$this->alert('danger', "Incorrect passphrase");
		}
		$this->index();
	}
	
	function addImage()
	{
		if($this->input->post('passphrase') == "commonplace") {
		
			$config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size']	= '2000';
			$config['max_width']  = '1024';
			$config['max_height']  = '768';
			
			$this->load->library('upload', $config);
			
			if ( ! $this->upload->do_upload('image'))
			{
				$this->alert('danger', $this->upload->display_errors());
			} else {
				$uploadResult = $this->upload->data();
						
				$entry = array(
					'title' => $this->input->post('title'),
					'author' => $this->input->post('author'),
					'link' => $this->input->post('link'),
					'imagePath' => '/kit/uploads/'.$uploadResult['file_name'],
					'type' => 'image'
				);
				
				$this->alert('success', "Image added");
				$this->db->insert('library', $entry);
			}
		} else {
			$this->alert('danger', "Incorrect passphrase");
		}
		$this->index();
	}
	
	function ajaxDelete()
	{
		//set status to deleted
		$this->db->where('idEntry', $this->input->post('idToDelete'));
		$this->db->set('status', 'deleted');
		$this->db->update('library');
	
		echo $this->getTitle($this->input->post('idToDelete'));
	}
	
	function ajaxTest()
	{
		echo "Hello world, ".$this->input->post('name');
	}
		
	function ajaxUpdate()
	{		
		$this->db->where('idEntry', $this->input->post('idToUpdate'));
		$this->db->set('description', $this->input->post('textUpdated'));
		$this->db->update('library');
		
		echo $this->getTitle($this->input->post('idToUpdate'));
	}
	
	function getTitle($id)
	{
		//get name to pass back in success message
		$this->db->where('idEntry', $id);
		$query = $this->db->get('library');
		if($query->num_rows() == 1){
			$entry = $query->row();
			return $entry->title;	
		}
	}
	
	function revive()
	{
		$this->db->set('status', '');
		$this->db->update('library');
	}
}