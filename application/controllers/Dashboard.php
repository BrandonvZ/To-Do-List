<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct()
	{
        parent::__construct();
        //connect to the Dashboard_model
        $this->load->model('Dashboard_model', 'dashboard');
    }

	// loads the templates and the page (index.php)
	public function index()
	{
		$this->load->view('templates/header');
		$this->load->view('pages/index');
		$this->load->view('templates/footer');
	}

	// this function will get all lists
	public function getLists()
	{
		// sends $_SESSION['user']['id'] to the getLists function in Dashboard_model (model) and sets is to the $lists variable
		$lists = (array)$this->dashboard->getLists($_SESSION['user']['id']);

		// loops through all lists
		for($i = 0; $i < count($lists); $i++)
		{
			// sets specific list to $list variable
			$list = (array)$lists[$i];

			// sends $list['id'] to the getItems function in Dashboard_model (model) and sets is to the $list['content'] variable
			$list['content'] = $this->dashboard->getItems($list['id']);

			// sets list to $list
			$lists[$i] = $list;
		}
		echo json_encode($lists);
	}

	// this function will show all lists for a specific user (admin functionality)
	public function showUserList()
	{
		// sets inputted data to variable $data
		$data = $this->getPostData();

		// if the $data is set
		if(isset($data['id']))
		{
			// sends data['id'] to the getLists function in Dashboard_model (model) and sets is to the $lists variable
			$lists = (array)$this->dashboard->getLists($data['id']);

			// loops through all lists
			for($i = 0; $i < count($lists); $i++)
			{
				// sets specific list to $list variable
				$list = (array)$lists[$i];

				// sends $list['id'] to the getItems function in Dashboard_model (model) and sets is to the $list['content'] variable
				$list['content'] = $this->dashboard->getItems($list['id']);

				// sets list to $list
				$lists[$i] = $list;
			}
			echo json_encode($lists);
		}

	}

	// this function will create a list
	public function createList()
	{
		// converts array to json and sends $_SESSION['user']['id'] to the createList function in Dashboard_model (model)
		echo json_encode($this->dashboard->createList($_SESSION['user']['id']));
	}

	// this function will delete a list
	public function deleteList()
	{
		// sets inputted data to variable $data
		$data = $this->getPostData();

		// if the $data is set
		if(isset($data))
		{
			// sends $data['id'] to the deleteList function in Dashboard_model (model)
			$this->dashboard->deleteList($data['id']);
		}
	}

	// this function will update the list title
	public function updateListTitle()
	{
		// sets inputted data to variable $data
		$data = $this->getPostData();

		// if the $data is set
		if(isset($data))
		{
			// sends $data['id'] and $data['value'] to the updateListTitle function in Dashboard_model (model)
			$this->dashboard->updateListTitle($data['id'], $data['value']);
		}
	}

	// this function will toggle the list item completion
	public function acceptListItem()
	{
		// sets inputted data to variable $data
		$data = $this->getPostData();

		// if the $data is set
		if(isset($data))
		{
			// sends $data['id'] and $data['value'] to the acceptListItem function in Dashboard_model (model)
			$this->dashboard->acceptListItem($data['id'], $data['value']);
		}
	}

	// this function will create the list item
	public function createListItem()
	{
		// sets inputted data to variable $data
		$data = $this->getPostData();

		// if the $data is set
		if(isset($data))
		{
			// sends $data['list_id'] to the createListItem function in Dashboard_model (model)
			echo json_encode($this->dashboard->createListItem($data['list_id']));
		}
	}

	// this function will update the list item
	public function updateListItem()
	{
		// sets inputted data to variable $data
		$data = $this->getPostData();

		// if the $data is set
		if(isset($data))
		{
			// sends $data['id'] and $data['value'] to the updateListItem function in Dashboard_model (model)
			$this->dashboard->updateListItem($data['id'], $data['value']);
		}
	}

	// this function will update the list item duration
	public function updateListItemTime()
	{
		// sets inputted data to variable $data
		$data = $this->getPostData();

		// if the $data is set
		if(isset($data))
		{
			// sends $data['id'] and $data['value'] to the updateListItemTime function in Dashboard_model (model)
			$this->dashboard->updateListItemTime($data['id'], $data['value']);
		}
	}

	// this function will delete the list item
	public function deleteListItem()
	{
		// sets inputted data to variable $data
		$data = $this->getPostData();

		// if the $data is set
		if(isset($data))
		{
			// sends $data['id'] to the deleteListItem function in Dashboard_model (model)
			$this->dashboard->deleteListItem($data['id']);
		}
	}

	// this function will delete the specific user (admin functionality)
	public function deleteUser()
	{
		// sets inputted data to variable $data
		$data = $this->getPostData();

		// if the $data is set
		if(isset($data))
		{
			// sends $data['id'] to the deleteUser function in Dashboard_model (model)
			$this->dashboard->deleteUser($data['id']);

			// sends data['id'] to the getLists function in Dashboard_model (model) and sets is to the $lists variable
			$lists = (array)$this->dashboard->getLists($data['id']);

			// loop through all lists
			for($i = 0; $i < count($lists); $i++)
			{
				// sets specific list to $list variable
				$list = (array)$lists[$i];

				// sends $list['id'] to the deleteList function in Dashboard_model (model)
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
