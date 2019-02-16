<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
	{
        parent::__construct();
        //connect to the LoginModel
        $this->load->model('Login_model', 'login');
    }

	public function checkLogin()
	{
		if(isset($_SESSION['user']))
		{
			echo true;
		}
		else
		{
			unset($_SESSION['user']);
			echo false;
		}
	}

	public function login()
	{
		$data = $this->getPostData();
		if(isset($data))
		{
			$email = $data['email'];
			$password = $data['password'];

			$getUser = (array)$this->login->getUser($email);

			if(isset($user))
			{
				$encryptedPass = md5($password . $getUser['salt_key']);
				if($user['password'] == $encryptedPass)
				{
					$_SESSION['user'] = $getUser;
					echo true;
				}
				else
				{
					echo "The username/password is incorrect";
				}
			}
			else
			{
				echo "The username/password is incorrect";
			}
		}
		else
		{
			echo "Something went wrong!";
		}
	}

	public function register()
	{
		$data = $this->getPostData();
		if(isset($data))
		{
			$email = $data['email'];
			$password = $data['password'];

			$createUser = (array)$this->login->createUser($email);
			if(isset($createUser))
			{
				$encryptedPass = md5($password . $createUser['salt_key']);
				$this->login->setPassword($createUser['id'], $encryptedPass);
				$_SESSION['user'] = $createUser;
				echo true;
			}
			else
			{
				echo "Cannot make an account";
			}
		}
		else
		{
			echo "Something went wrong";
		}
	}

	public function getPostData()
	{
        $postdata = file_get_contents("php://input");
        if(isset($postdata) && !empty($postdata))
		{
            return json_decode($postdata, true);
        }
        return null;
    }
}
