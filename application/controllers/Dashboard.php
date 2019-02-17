<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct()
	{
        parent::__construct();
        //connect to the Dashboard_model
        $this->load->model('Dashboard_model', 'dashboard');
    }

	public function index()
	{
		$this->load->view('templates/header');
		$this->load->view('pages/index');
		$this->load->view('templates/footer');
	}

	public function getLists()
	{
		$lists = (array)$this->dashboard->getLists($_SESSION['user']['id']);
		for($i = 0; $i < count($lists); $i++)
		{
			$list = (array)$lists[$i];
			$list['content'] = $this->dashboard->getItems($list['id']);
			$lists[$i] = $list;
		}
		echo json_encode($lists);
	}

	public function showUserList()
	{
		$data = $this->getPostData();
		if(isset($data['id']))
		{
			$lists = (array)$this->dashboard->getLists($data['id']);
			for($i = 0; $i < count($lists); $i++)
			{
				$list = (array)$lists[$i];
				$list['content'] = $this->dashboard->getItems($list['id']);
				$lists[$i] = $list;
			}
			echo json_encode($lists);
		}

	}

	public function createList()
	{
		echo json_encode($this->dashboard->createList($_SESSION['user']['id']));
	}

	public function deleteList()
	{
		$data = $this->getPostData();
		if(isset($data))
		{
			$this->dashboard->deleteList($data['id']);
		}
	}

	public function updateListTitle()
	{
		$data = $this->getPostData();
		if(isset($data))
		{
			$this->dashboard->updateListTitle($data['id'], $data['value']);
		}
	}

	public function acceptListItem()
	{
		$data = $this->getPostData();
		if(isset($data))
		{
			$this->dashboard->acceptListItem($data['id'], $data['value']);
		}
	}

	public function createListItem()
	{
		$data = $this->getPostData();
		if(isset($data))
		{
			echo json_encode($this->dashboard->createListItem($data['list_id']));
		}
	}

	public function updateListItem()
	{
		$data = $this->getPostData();
		if(isset($data))
		{
			$this->dashboard->updateListItem($data['id'], $data['value']);
		}
	}

	public function updateListItemTime()
	{
		$data = $this->getPostData();
		if(isset($data))
		{
			$this->dashboard->updateListItemTime($data['id'], $data['value']);
		}
	}

	public function deleteListItem()
	{
		$data = $this->getPostData();
		if(isset($data))
		{
			$this->dashboard->deleteListItem($data['id']);
		}
	}

	public function deleteUser()
	{
		$data = $this->getPostData();
		if(isset($data))
		{
			$this->dashboard->deleteUser($data['id']);
			$lists = (array)$this->dashboard->getLists($data['id']);
			for($i = 0; $i < count($lists); $i++)
			{
				$list = (array)$lists[$i];
				$this->dashboard->deleteList($list['id']);
			}
		}
	}

	// this function will get all data from angular HTTP
	public function getPostData()
	{
		// get all data from post and store it in the $postdata variable
        $postData = file_get_contents("php://input");

		// if $postData data is set
        if(isset($postData) && !empty($postData))
		{
			// returns the inputted data
            return json_decode($postData, true);
        }

		// if no data was found, return null
        return null;
    }
}
