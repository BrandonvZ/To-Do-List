<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
	{
        parent::__construct();
        //connect to the Login_model
        $this->load->model('Login_model', 'login');
    }

	// this function will check whether the user still has a session
	public function checkLogin()
	{
		// if the session still exists, sends back the session data
		if(isset($_SESSION['user']))
		{
			echo json_encode($_SESSION['user']);
		}
		// if the session doesn't exist, unset it for savety precautions and sends back false as string
		else
		{
			unset($_SESSION['user']);
			echo "false";
		}
	}

	//this function will handle the logout request
	public function logout()
	{
		// if the session $_SESSION['user'] is set
		if(isset($_SESSION['user']))
		{
			// unset the session $_SESSION['user']
			unset($_SESSION['user']);
		}
	}

	// this function will handle the login request
	public function login()
	{
		// sets inputted data to variable $data
		$data = $this->getPostData();

		// if the $data is set
		if(isset($data))
		{
			// set inputted data to 2 variables
			$email = $data['email'];
			$password = $data['password'];

			// sends $email to getUser function in Login_model.php (model), then sets it to $getUser variable
			$getUser = (array)$this->login->getUser($email);

			// if the $getUser is set
			if(isset($getUser))
			{
				// encrypt the password with md5 encryption + real password + salt_key, then set is to $encryptedPass variable
				$encryptedPass = md5($password . $getUser['salt_key']);

				// if the inputted password is equal to the $encryptedPass
				if($getUser['password'] == $encryptedPass)
				{
					// create session and sends back the session data
					$_SESSION['user'] = $getUser;
					echo json_encode($_SESSION['user']);
				}
				// if the inputted password doesn't match with the $encryptedPass
				else
				{
					echo "The username/password is incorrect";
				}
			}
			// if the $getUser is not set
			else
			{
				echo "The username/password is incorrect";
			}
		}
		// if the $data is not set
		else
		{
			echo "Something went wrong!";
		}
	}

	// this function will handle the register request
	public function register()
	{
		// sets inputted data to variable $data
		$data = $this->getPostData();

		// if the $data is set
		if(isset($data))
		{
			// set inputted data to 2 variables
			$email = $data['email'];
			$password = $data['password'];

			// sends $email to createUser function in Login_model.php (model), then sets it to $createUser variable
			$createUser = (array)$this->login->createUser($email);

			// if the $createUser is set
			if(isset($createUser))
			{
				// encrypt the password with md5 encryption + real password + salt_key, then set is to $encryptedPass variable
				$encryptedPass = md5($password . $createUser['salt_key']);

				// sends $createUser['id'] and $encryptedPass to setPassword function in Login_model (model)
				$this->login->setPassword($createUser['id'], $encryptedPass);

				// creates session with the data from $createUser and sends back the session data
				$_SESSION['user'] = $createUser;
				echo json_encode($_SESSION['user']);
			}
			// if the $createUser is not set
			else
			{
				echo "Cannot make an account";
			}
		}
		// if the $data is not set
		else
		{
			echo "Something went wrong";
		}
	}

	// this function will get all users
	public function getUsers()
	{
		// converts array to json
		echo json_encode($this->login->getUsers());
	}

	// this function will make the user an admin or an user
	public function adminToggle()
	{
		// sets inputted data to variable $data
		$data = $this->getPostData();

		// if the $data is set
		if(isset($data['id']))
		{
			// sends $data['id'] and $data['role_id'] to adminToggle function in Login_model (model)
			$this->login->adminToggle($data['id'], $data['role_id']);

			// if the session id is equal to the id that got sent
			if($_SESSION['user']['id'] == $data['id'])
			{
				// sets session role_id to the $data['role_id']
				$_SESSION['user']['role_id'] = $data['role_id'];
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
