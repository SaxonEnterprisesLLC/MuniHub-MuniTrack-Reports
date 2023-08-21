<?php
    #[AllowDynamicProperties]
    class Users extends Controller {
        public function __construct() {
            $this->userModel = $this->model('User');
            $this->reportModel = $this->model('Report');
        }

        public function register() {
            $OMClients = $this->reportModel->getClientList();
            // check for POST
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                //Process form

                // Sanitize POST Data 
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                // init data
                $data = [
                    'name' => trim($_POST['name']),
                    'email' => trim($_POST['email']),
                    'company' => trim($_POST['company']),
                    'password' => trim($_POST['password']),
                    'confirmPassword' => trim($_POST['confirmPassword']),
                    'nameErr' => '',
                    'emailErr' => '',
                    'companyErr' => '',
                    'confirmPasswordErr' => ''
                ];

                //validate fields 

                if (empty($data['email'])) {
                    $data['emailErr'] = "Please enter your email";
                } else {
                    if ($this->userModel->findUserByEmail($data['email'])) {
                        $data['emailErr'] = 'Email is already taken';
                    }
                }

                if (empty($data['name'])) {
                    $data['nameErr'] = "Please enter your name";
                }

                if (empty($data['company'])) {
                    $data['companyErr'] = "Please enter your company";
                }

                if (empty($data['password'])) {
                    $data['passwordErr'] = "Please enter your password";
                } elseif (strlen($data['password']) < 6) {
                    $data['passwordErr'] = "Password must be at least 6 characters";
                }

                if (empty($data['confirmPassword'])) {
                    $data['confirmPasswordErr'] = "Please confirm  password";
                } else {
                    if ($data['password'] != $data['confirmPassword']) {
                        $data['confirmPasswordErr'] = "Passwords do not match";
                    }
                } 
                
                // make sure errors are empty
                if (empty($data['emailErr']) && empty($data['nameErr']) && empty($data['companyErr']) && empty($data['passwordErr']) && empty($data['confirmPasswordErr'])) {

                    // hash password for security
                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                    // register user
                    if ($this->userModel->register($data)) {
                        flash('register_success', 'You are registered and can log in');
                        redirect('users/login');
                    } else {
                        die('Something went wrong');
                    }
                } else {
                    $this->view('users/register', $data);
                }
    
            } else {
                // init data
                
                $data = [
                    'name' => '',
                    'email' => '',
                    'company' => $OMClients,
                    'password' => '',
                    'confirmPassword' => '',
                    'nameErr' => '',
                    'emailErr' => '',
                    'emailErr' => '',
                    'passwordErr' => '',
                    'confirmPasswordErr' => ''
                ];

                // load view
                $_SESSION['OMClients'] = $OMClients;
                $this->view('users/register', $data);
            }
        }

        public function login() {
            // check for POST
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
                // Init data
                $data =[
                    'email' => trim($_POST['email']),
                    'password' => trim($_POST['password']),
                    'emailErr' => '',
                    'passwordErr' => '',      
                ];

                // Validate Email
                if(empty($data['email'])) {
                    $data['emailErr'] = 'Please enter email';
                }

                // Validate Password
                if(empty($data['password'])) {
                    $data['passwordErr'] = 'Please enter password';
                }

                if ($this->userModel->findUserByEmail($data['email'])) {

                } else {
                    // User not found
                    $data['emailErr'] = 'No user found';
                }

                // Make sure errors are empty
                if(empty($data['emailErr']) && empty($data['companyErr']) && empty($data['passwordErr'])) {
                // Validated
                    $loggedInUser = $this->userModel->login($data['email'], $data['password']);

                    if ($loggedInUser) {
                        // create session
                        $this->createUserSession($loggedInUser);
                    } else {
                        $data['passwordErr'] = 'Password incorrect';
                        $this->view('users/login', $data);
                    }
                } else {
                // Load view with errors
                    $this->view('users/login', $data);
                }

            } else {
                // init data
                $data = [
                    'email' => '',
                    'password' => '',
                    'company' => '',
                    'emailErr' => '',
                    'passwordErr' => ''  
                ];

                // load view
                $this->view('users/login', $data);
            }
        }
        // data comes from the $row
        public function createUserSession($user) {
            $_SESSION['user_id'] = $user->id;
            $_SESSION['user_email'] = $user->email;
            $_SESSION['user_name'] = $user->name;
            $_SESSION['user_company'] = $user->company;
            redirect('index');
        }

        public function logout() {
            unset($_SESSION['user_id']);
            unset($_SESSION['user_email']);
            unset($_SESSION['user_name']);
            unset($_SESSION['user_company']);
            session_destroy();
            redirect('users/login');

        }
    }