<?php

namespace App\Controllers;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\API\ResponseTrait;
use Config\Services;
use App\Models\Home_model;
use Attribute;


class AuthController extends BaseController
{

    use ResponseTrait;
    public function __construct()
    {
        $this->session = session();
        helper(['form', 'text', 'url', 'filesystem', 'inflector']);
        $this->Home_model = new Home_model();
        $this->uri = current_url(true);
        $this->pager = \Config\Services::pager();
        $this->validation = \Config\Services::validation();
        $this->image = \Config\Services::image();
    }



        // ==============  Registration  ========== //

        public function registration()
        {
    
            if($this->session->get('isLogged')){
    
                return redirect()->to(base_url());
            }
    
            if (!$this->request->is('post')) {
                echo 'Method Not Allowed';
                return;
            }
    
            $rules = [
                'firstName' => [
                    'label' => 'First Name',
                    'rules' => 'trim|required|min_length[1]|max_length[50]|alpha_space'
    
                ],
                'lastName' => [
                    'label' => 'last Name',
                    'rules' => 'trim|required|min_length[1]|max_length[50]|alpha_space'
    
                ],
                'email' => [
                    'label' => 'Email',
                    'rules' => 'trim|required|valid_email|is_unique[user.email]',
                    'errors' => [
                        'is_unique' => 'This email address is already registered. Please try again with a different email address or log in to your existing account.',
    
                    ]
                ],
                'dob' => [
                    'label' => 'Date of Birth',
                    'rules' => 'trim|required|valid_date[Y-m-d]'
                ],
                'gender' => [
                    'label' => 'Gender',
                    'rules' => 'trim|required|in_list[1,2,3]',
                    'errors' => [
                        'in_list' => 'Gender Value allowed Male, Female, Others'
                    ]
                ],
                'password' => [
                    'label' => 'Password',
                    'rules' => 'trim|required|min_length[8]|max_length[16]',
                    'errors' => [
                        'min_length' => 'Please enter a password between 8 and 16 characters long.',
                        'max_length' => 'Please enter a password between 8 and 16 characters long.'
                    ]
                ]
            ];  // rules that are requirest when user Register.
    
            if (!$this->validate($rules)) {
    
                $response = [
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'Form field not valid',
                    'csrf' => csrf_hash(),
                    'data' => validation_errors()
    
                ];
    
                return  $this->setResponseFormat('json')->respond($response);
                // return json_encode($response);
    
    
    
    
            } else {
    
                $firstName = $this->sanitize($this->request->getVar('firstName'));
                $lastName = $this->sanitize($this->request->getVar('lastName'));
                $email = $this->sanitize($this->request->getVar('email'));
                $dob = $this->sanitize($this->request->getVar('dob'));
                $gender = $this->sanitize($this->request->getVar('gender'));
                $password = $this->__encrip_password($this->sanitize($this->request->getVar('password')));
    
                $insertData['first_name'] = $firstName;
                $insertData['last_name'] = $lastName;
                $insertData['email'] = $email;
                $insertData['dob'] = $dob;
                $insertData['gender'] = $gender;
                $insertData['password'] = $password;
                $insertData['ec_token'] = mt_rand('1111', '9999');
                $insertData['created_at'] =  date("Y-m-d h:i:s");
    
    
    
                $isValid = $this->Home_model->save_data('user', $insertData);
    
    
                if ($isValid) {
    
                    $data = [
                        'user_email' => $email
                    ];
                    $this->session->set($data);
    
    
    
                    //  Email Send To User 
                    $receiver_email = $email;
                    $subject = 'Confirm You Email To Verfiy';
                    $message = "Dear User, Pleadse Verify Your Email. 
                         Verification Code: " . $insertData['ec_token'] . " If you did not request this verification code or believe this email is sent to you by mistake, 
                         please ignore it. Your account security is of the utmost importance, Best regards, The panaceainfosec Team ";
                    $emailStatus  =  $this->sendEmail($receiver_email, $subject, $message);
    
                    // Email Send to Admin Abou Resgistration of user
    
                    $user_id = $this->Home_model->select_value('user', 'user_id', array(
                        'email' => $email
                    ));
                    $subject = "New User Resgistration";
                    $message = "Dear Admin,<br/> <br/>
                                           <h3>A new User " .  $insertData['first_name'] . " has been registered<br/>
                                           </h3><br/>
                                           Please check the Deatils Below.
                                           <br/> <br/>
                                           <a href='" . base_url('admin/user/') . $user_id . "'>
                                           Check Profile</a>
                                           <br/><br/>Thanks";
                    $this->sendEmail(ADMIN_EMAIL, $subject, $message);
    
                    $response = [
                        'status' => 'success',
                        'code' => 200,
                        'csrf' => csrf_hash(),
                        'message' => 'Congratulations! Your registration was successful. Please check your email and follow the instructions to verify your account',
    
    
                    ];
    
                    return  $this->setResponseFormat('json')->respond($response, 200);
                } else {
    
    
                    $response = [
                        'status' => 'error',
                        'code' => 500,
                        'message' => 'Something went wrong. We’re sorry for the inconvenience. Please try again later.',
    
                    ];
                    return  $this->setResponseFormat('json')->respond($response, 200);
                }
            }
        }
    
    
        // ===================   Email Verfication -- OTP ========================== //
    
        public function verfication()
        {
    
            if($this->session->get('isLogged')){
    
                return redirect()->to(base_url());
            }
            if (!$this->request->is('post')) {
                echo 'Method Not Allowed';
                return;
            }
    
            $rules = [
                'verficationCode' => [
                    'label' => 'OTP',
                    'rules' => 'trim|required|min_length[4]|max_length[4]|integer'
    
    
                ],
    
    
            ];  // rules that are requirest when user Register.
    
            if (!$this->validate($rules)) {
    
                $response = [
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'OTP is not valid',
                    'csrf' => csrf_hash(),
                    'data' => validation_errors()
    
                ];
    
                return  $this->setResponseFormat('json')->respond($response);
                // return json_encode($response);
            }
    
            $verficationCode = $this->sanitize($this->request->getVar('verficationCode'));
    
    
    
            if ($this->session->has('user_email')) {
    
                $email = $this->session->get('user_email');
            }
            $isVerify = $this->Home_model->select_value('user', 'ec_token', array(
                'email' => $email,
                'ec_token' => $verficationCode,
            ));
    
            if (!$isVerify) {
    
                $response = [
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'OTP is incorrect',
                    'csrf' => csrf_hash(),
                    'data' => [
                        'verficationCode' => 'OTP is incorrect'
                    ]
    
                ];
                return  $this->setResponseFormat('json')->respond($response, 200);
            }
    
    
            $updateData['is_active'] = 1;
            $updateData['modified_at'] = date('Y-m-d H:i:s');
            $updateData['log_date'] = date('Y-m-d H:i:s');
            $updateData['ec_token'] = '';
            $updateData['rp_token'] = '';
    
            $isUpdate = $this->Home_model->update_data('user', $updateData, array(
                'email' => $email
            ));
    
            if (!$isUpdate) {
    
                $response = [
                    'status' => 'error',
                    'code' => 500,
                    'message' => 'OTP is incorrect',
                    'csrf' => csrf_hash(),
                    'data' => [
                        'verficationCode' => 'Something Went Wrong Try Again'
                    ]
    
                ];
                return  $this->setResponseFormat('json')->respond($response, 200);
            }
    
            $userData = $this->Home_model->select_data('user', '*', array(
    
                'email' => $email
    
            ));
    
            $sessionData = [
                'user_id' => $userData[0]->user_id,
                'user_name' => $userData[0]->first_name,
                'user_email' => $userData[0]->email,
                'isLogged' => true,
            ];
    
            $this->session->set($sessionData);
            $response = [
                'status' => 'success',
                'code' => 400,
                'csrf' => csrf_hash(),
                'message' => 'OTP is Correct',
                'name' =>  $this->session->get('user_name')
    
            ];
            return  $this->setResponseFormat('json')->respond($response, 200);
        }
    
        // ===================== Login ================================= //
    
        public function login(){
    
            if($this->session->get('isLogged')){
    
                return redirect()->to(base_url());
            }
            if (!$this->request->is('post')) {
                $response = [
                    'status' => 'error',
                    'code' => 405,
                    'message' => 'Method Not Allowed',
    
                ];
                return $this->setResponseFormat('json')->respond($response, 200);
            }
            $rules = [
    
                'email' => [
                    'label' => 'Email',
                    'rules' => 'trim|required|valid_email',
                ],
                'password' => [
                    'label' => 'Password',
                    'rules' => 'trim|required|min_length[8]|max_length[16]',
                    'errors' => [
                        'min_length' => 'Please enter a password between 8 and 16 characters long.',
                        'max_length' => 'Please enter a password between 8 and 16 characters long.'
                    ]
                ]
            ];  // rules that are requirest when user Register.
    
    
    
    
    
            if (!$this->validate($rules)) {
    
                $response = [
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'Login Field not valid',
                    'csrf' => csrf_hash(),
                    'data' => validation_errors()
                ];
                return $this->setResponseFormat('json')->respond($response, 200);
            } else {
    
                $email = $this->sanitize($this->request->getVar('email'));
                $password = $this->sanitize($this->request->getVar('password'));
    
    
                $hashPassword = $this->Home_model->select_value('user', 'password', array(
                    'email' => $email,
                ));
    
                if (!$hashPassword) {
    
                    $response = [
                        'status' => 'error',
                        'code' => 400,
                        'csrf' => csrf_hash(),
                        'message' => 'Login Failed: Email is not register.',
                        'data' => [
                            'errorWrapper' => 'Login Failed: Email is not register'
                        ]
    
                    ];
                    return $this->setResponseFormat('json')->respond($response, 200);
                }
    
                $isPasswordVerify = password_verify($password, $hashPassword);
    
                if (!$isPasswordVerify) {
    
    
                    $failed_login_count = $this->Home_model->select_data('user', 'login_failed_count, account_is_locked, user_id', array(
                        'email' => $email,
                    ));
    
                    $updateData['log_date'] =  date("Y-m-d H:i:s");
    
                    $insertData['user_id'] = $failed_login_count[0]->user_id;
                    $insertData['ip'] = $this->request->getIPAddress();
                    $insertData['user_agent'] = $this->request->getUserAgent();
                    $insertData['log_date'] = date("Y-m-d h:i");
    
                    $this->Home_model->save_data('user_log', $insertData);
    
                    if ($failed_login_count[0]->account_is_locked != "0") {
    
                        $response = [
                            'status' => 'error',
                            'code' => 401,
                            'csrf' => csrf_hash(),
                            'message' => 'Your Account is locked. Forget password to unlock the account',
                            'data' => [
                                'errorWrapper' => 'Your Account is locked. Forget password to unlock the account'
                            ]
    
                        ];
                        return $this->setResponseFormat('json')->respond($response, 200);
                    }
    
                    $failed_login_count = intval($failed_login_count[0]->login_failed_count);
    
                    if ($failed_login_count > 9) {
    
                        $updateData['login_failed_count'] = $failed_login_count + 1;
                        $updateData['account_is_locked'] = 1;
    
                        $this->Home_model->update_data("user", $updateData, array(
                            'email' => $email
    
                        ));
    
                        $response = [
                            'status' => 'error',
                            'code' => 401,
                            'csrf' => csrf_hash(),
                            'message' => 'Login Failed: Your account is locked. Forget password to unlock account',
                            'data' => [
                                'errorWrapper' => 'Login Failed: Your account is locked. Forget password to unlock account'
                            ]
    
                        ];
                        return $this->setResponseFormat('json')->respond($response, 200);
                    } else {
    
                        $updateData['login_failed_count'] = $failed_login_count + 1;
                        $this->Home_model->update_data("user", $updateData, array(
    
                            'email' => $email
    
                        ));
    
    
    
                        if ($failed_login_count < 5) {
    
                            $response = [
                                'status' => 'error',
                                'code' => 401,
                                'csrf' => csrf_hash(),
                                'message' => 'Login Failed: Your email Or password do not match. Please try again.',
                                'data' => [
                                    'errorWrapper' => 'Login Failed: Your email Or password do not match. Please try again.'
                                ]
    
                            ];
                            return $this->setResponseFormat('json')->respond($response, 200);
                        } else {
                            $response = [
                                'status' => 'error',
                                'code' => 401,
                                'csrf' => csrf_hash(),
                                'message' => 'Login Failed: Your email Or password do not match. Last attempt before account is locked.',
                                'data' => [
                                    'errorWrapper' => 'Login Failed: Your email Or password do not match. Last attempt before account is locked.'
                                ]
    
                            ];
                            return $this->setResponseFormat('json')->respond($response, 200);
                        }
                    }
                } else {
    
                    $userData = $this->Home_model->select_data('user', '*', array(
                        'email' => $email,
    
    
                    ));
    
    
                    if ($userData[0]->is_active === "0") {
                        $response = [
                            'status' => 'error',
                            'code' => 401,
                            'csrf' => csrf_hash(),
                            'message' => 'Email is not verified. Please verify your email or forget password to receive an email for verification.',
                            'data' => [
                                'errorWrapper' => 'Email is not verified. Please verify your email or forget password to receive an email for verification.'
                            ]
    
    
                        ];
                        return $this->setResponseFormat('json')->respond($response, 200);
                    }
                    if ($userData[0]->is_active === "2") {
                        $response = [
                            'status' => 'error',
                            'code' => 401,
                            'csrf' => csrf_hash(),
                            'message' => 'Your account is blocked. To Unblock it Contact Service Center',
                            'data' => [
                                'errorWrapper' => 'Your account is blocked. To Unblock it Contact Service Center'
                            ]
    
                        ];
                        return $this->setResponseFormat('json')->respond($response, 200);
                    }
    
                    if ($userData[0]->account_is_locked !== "0") {
    
                        $response = [
                            'status' => 'error',
                            'code' => 401,
                            'csrf' => csrf_hash(),
                            'message' => 'Your Account is locked. Forget password to unlock the account',
                            'data' => [
                                'errorWrapper' => 'Your Account is locked. Forget password to unlock the account'
                            ]
    
                        ];
                        return $this->setResponseFormat('json')->respond($response, 200);
                    }
    
    
    
    
                    $updateData['log_date'] =  date("Y-m-d H:i:s");
                    $updateData['login_failed_count'] = 0;
                    $updateData['account_is_locked'] = 0;
                    $updateData['rp_token'] = '';
                    $updateData['ec_token'] = '';
                    $updateData['rp_token_created_at'] = '';
    
                    $insertData['user_id'] = $userData[0]->user_id;
                    $insertData['ip'] = $this->request->getIPAddress();
                    $insertData['user_agent'] = $this->request->getUserAgent();
                    $insertData['log_date'] = date("Y-m-d H:i:s");
                    $this->Home_model->save_data('user_log', $insertData);
    
                    $this->Home_model->update_data("user", $updateData, array(
                        'email' => $email
    
                    ));
                    $id = $userData[0]->user_id;
                    $email = $userData[0]->email;
    
                    $sessionData = [
                        'user_id' => $userData[0]->user_id,
                        'user_name' => $userData[0]->first_name,
                        'user_email' => $userData[0]->email,
                        'isLogged' => true,
                    ];
    
                    $this->session->set($sessionData);
    
    
                    $page = $this->request->getGet('page');
    
    
                      //   if user has items in cart in session in login put this iteams in cart table 
                    if ($this->session->has('cart') && !empty($this->session->cart)) {
    
    
    
                        $cartCreated = date("Y-m-d H:i:s");
    
                        $cartAll = array();
    
    
                        foreach ($this->session->cart as $row) {
                            $singleIteam = array();
                            $singleIteam['user_id'] = $id;
                            $singleIteam['product_id'] = $row['product_id'];
                            $singleIteam['quantity'] =  $row['quantity'];
                            $singleIteam['price'] =  $row['price'];
                            $singleIteam['product_meta'] = json_encode($row['product_meta']);
                            $singleIteam['created_at'] = $cartCreated;
                            $cartAll[] = $singleIteam;
                        }
    
                        $this->Home_model->save_data_batch('cart', $cartAll);
                    }
    
                    $response = [
                        'status' => 'success',
                        'code' => 200,
                        'csrf' => csrf_hash(),
                        'message' => 'Login Successfully.',
                        'page' => $page,
                        'name' => $userData[0]->first_name
    
                    ];
                    return $this->setResponseFormat('json')->respond($response, 200);
                }
            }
        }
    
    
        //  =================== Signout ================== //
    
        public function signout()
        {
    
            if(!$this->session->get('isLogged')){
    
                return redirect()->to(base_url());
            }
            if (!$this->request->is('post')) {
                $response = [
                    'status' => 'error',
                    'code' => 405,
                    'message' => 'Method Not Allowed',
    
                ];
                return $this->setResponseFormat('json')->respond($response, 200);
            }
            
    
            $redirectUrl = $this->request->getPost('url');
            $this->session->destroy();
    
            if ($redirectUrl) {
    
                return redirect()->to($redirectUrl);
            }
          
            return redirect()->to(base_url());
        }
    
    
    

   
}
