<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\API\ResponseTrait;
use Config\Services;
use App\Models\Home_model;
use App\Models\Admin_model;


class Admin extends BaseController
{

    use ResponseTrait;
    public function __construct()
    {
        $this->session = session();
        helper(['form', 'text', 'url', 'filesystem', 'inflector']);
        $this->Home_model = new Home_model();
        $this->Admin_model = new Admin_model();
        $this->uri = current_url(true);
        $this->pager = \Config\Services::pager();
        $this->validation = \Config\Services::validation();
        $this->image = \Config\Services::image();
    }



    public function index()
    {

        $header = [
            'title' => 'Insurance Sorted',
            'metaTitle' => 'Insurance Broker Brisbane Australia | Near Me – Sureinsure',
            'metaDescription' => 'Looking for Insurance Broker near me? Then SureInsure is an Insurance advisor Brisbane Australia. We provides cost-effective professional insurance advice.',
            'metaKeywords' => 'Insurance'
        ];
        return view('backend/tpl/header', $header)
            . view('backend/dashboard')
            . view('backend/tpl/footer');
    }

    // ============================ Login ============================== //

    public function getLogin()
    {
        if ($this->session->get('ad_is_logged_in')) {
            return redirect()->to('admin/dashboard');
        }

        $page = 'login';
        $header = [
            'page'=> $page,
            'title' => 'Insurance Sorted',
            'metaTitle' => 'Insurance Broker Brisbane Australia | Near Me – Sureinsure',
            'metaDescription' => 'Looking for Insurance Broker near me? Then SureInsure is an Insurance advisor Brisbane Australia. We provides cost-effective professional insurance advice.',
            'metaKeywords' => 'Insurance'
        ];
        return view('backend/login', $header);
    }


    public function login()
    {
        if (!$this->request->is('post')) {
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Login Failed!</strong> Method Not Allowed
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>');

            return redirect()->to(base_url('admin/login'));
        }
        $rules = [
            'email' => [
                'label'=> 'Email',
                'rules'=> 'trim|required|valid_email|is_not_unique[admin_user.email]',
                 'errors'=> [
                   'is_not_unique'=> 'Email Id is not valid'
                 ]
            ],
            'password' => 'trim|required'
        ];

        if (!$this->validate($rules)) {
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
          <strong>Login Failed!</strong> ' . validation_list_errors() . '
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>');

            return redirect()->to(base_url('admin/login'));
        } else {


            $email =  $this->sanitize($this->request->getPost('email'));
            $hashPassword = $this->Home_model->select_value('admin_user', 'password', array(
                'email' => $email,
            ));
            $password = $this->sanitize($this->request->getPost('password'));

            $passwordHash = password_verify($password, $hashPassword);
            if (!$passwordHash) {
                $failed_login_count = $this->Home_model->select_data('admin_user', 'login_failed_count, account_is_locked, admin_id', array(
                    'email' => $email,
                ));

                $insertData['admin_id'] = $failed_login_count[0]->admin_id;
                $insertData['ip'] = $this->request->getIPAddress();
                $insertData['user_agent'] = $this->request->getUserAgent();
                $inserData['is_success'] = 1;
                $insertData['log_date'] = date("Y-m-d h:i");

                $this->Home_model->save_data('admin_log', $insertData);

                if ($failed_login_count[0]->account_is_locked != "0") {

                    $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Login Failed!</strong> Your Account is Locked.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>');
                    return redirect()->to(base_url('admin/login'));
                }

                $failed_login_count = intval($failed_login_count[0]->login_failed_count);

                if ($failed_login_count > 5) {

                    $updateData['login_failed_count'] = $failed_login_count + 1;
                    $updateData['account_is_locked'] = 1;

                    $this->Home_model->update_data("admin_user", $updateData, array(
                        'email' => $email

                    ));

                    $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Login Failed!</strong> Your Account is Locked.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>');
                    return redirect()->to(base_url('admin/login'));
                } else {

                    $updateData['login_failed_count'] = $failed_login_count + 1;
                    $this->Home_model->update_data("admin_user", $updateData, array(
                        'email' => $email
                    ));



                    if ($failed_login_count < 5) {

                        $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Login Failed!</strong> Email or Password Not Match.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>');
                        return redirect()->to(base_url('admin/login'));
                    } else {
                        $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Login Failed!</strong> Login Failed: Your email Or password do not match. Last attempt before account is locked..
                               <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                              </div>');
                        return redirect()->to(base_url('admin/login'));
                    }
                }

                $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Login Failed!</strong> Login Failed: Your email Or password do not match. Last attempt before account is locked..
               <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>');
                return redirect()->to(base_url('admin/login'));
            }


            $isValid = $this->Home_model->select_data('admin_user', '*', array(
                'email' => $email,
                'is_active' => 1

            ), '', '', '', 1);


            if ($isValid[0]->account_is_locked !== "0") {

                $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Login Failed!</strong> Your Account is Locked.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>');
                return redirect()->to(base_url('admin/login'));
            }

            if ($isValid) {
                $data = array(
                    'ad_user_name' => $isValid[0]->user_name,
                    'ad_user_email' => $isValid[0]->email,
                    'ad_is_verfication' => true
                );
                $this->session->set($data);

                $updateData['log_date'] = date('Y-m-d H:i:s');
                $updateData['login_failed_count'] = 0;
                $updateData['rp_token'] = '';
                $updateData['ec_token'] = mt_rand('1111', '9999');
                $updateData['rp_created_at'] = '';
                $saveData = $this->Home_model->update_data('admin_user', $updateData, array(
                    'email' => $email
                ));
                $receiver_email = $isValid[0]->email;
                $subject = 'OTP verification  for richmane login';
                $message = " Please Verify Your Email. 
                     Verification Code: " . $updateData['ec_token'] . " If you did not request this verification code or believe this email is sent to you by mistake, 
                     please ignore it. Your account security is of the utmost importance, Best regards, The richmane Team ";
                $emailStatus  =  $this->sendEmail($receiver_email, $subject, $message);
                $insertData['admin_id'] = $isValid[0]->admin_id;
                $insertData['ip'] = $this->request->getIPAddress();
                $insertData['user_agent'] = $this->request->getUserAgent();
                $inserData['is_success'] = 0;
                $insertData['log_date'] = date("Y-m-d h:i");

                $this->Home_model->save_data('admin_log', $insertData);

                return redirect()->to('admin/otp-verification');
            } else {
                $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Login Failed!</strong> SomeThing Went Wrong .
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>');
                return redirect()->to(base_url('admin/login'));
            }
        }
    }

    // ======================== Otp Verfication ======================================= //

    public function getOtpVerification()
    {
        if (!$this->session->get('ad_is_verfication')) {
            return redirect()->to('admin/login');
        }
        if ($this->session->get('ad_is_logged_in')) {
            return redirect()->to('admin/dashboard');
        }
        $page = 'otpVerfication';
        $header = [
            'page'=> $page,
            'title' => 'Insurance Sorted',
            'metaTitle' => 'Insurance Broker Brisbane Australia | Near Me – Sureinsure',
            'metaDescription' => 'Looking for Insurance Broker near me? Then SureInsure is an Insurance advisor Brisbane Australia. We provides cost-effective professional insurance advice.',
            'metaKeywords' => 'Insurance'
        ];
        return view('backend/otpVerfication', $header);
    }

    public function OtpVerification()
    {
        if ($this->session->get('ad_is_logged_in')) {
            return redirect()->to('admin/dashboard');
        }
        if (!$this->request->is('post')) {

            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Login Failed!</strong> Method Not Allowed
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>');

            return redirect()->to(base_url('admin/otp-verification'));
        }
        $rules = [
            'otp' => [
                'label' => 'OTP',
                'rules' => 'trim|required|numeric|max_length[4]',
                'errors' => [
                    'number' => 'OTP is not Valid',
                    'max_lenght' => 'OTP is not Valid'
                ]
            ],

        ];
        if (!$this->validate($rules)) {
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
          <strong>Login Failed!</strong> ' . validation_list_errors() . '
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>');

            return redirect()->to(base_url('admin/otp-verification'));
        } else {


            $userEmail = $this->session->get('ad_user_email');

            $otp =  $this->sanitize($this->request->getPost('otp'));

            $isVerification = $this->Home_model->select_data('admin_user', '*', array(
                'email' => $userEmail,
                'ec_token' => $otp

            ), '', '', '', 1);

            if (!$isVerification) {
                $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Login Failed!</strong> OTP is Wrong.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>');
                return redirect()->to(base_url('admin/otp-verification'));
            }

            if ($isVerification) {
                $data = array(
                    'ad_user_name' => $isVerification[0]->user_name,
                    'ad_user_email' => $isVerification[0]->email,
                    'ad_is_logged_in' => true
                );
                $this->session->set($data);

                $updateData['ec_token'] = '';
                $saveData = $this->Home_model->update_data('admin_user', $updateData, array(
                    'email' => $userEmail
                ));

                return redirect()->to('admin/dashboard');
            } else {
                $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Login Failed!</strong> SomeThing Went Wrong .
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>');
                return redirect()->to(base_url('admin/login'));
            }
        }
    }

    // ======================== Resend OTp ============================//  
    public function resendOtp()
    {
        $userEmail = $this->session->get('ad_user_email');
        if ($userEmail == '' && empty($userEmail)) {
            $response = [
                'status' => 'error',
                'code' => 500,
                'message' => 'Session Is expired',
            ];
            return  $this->setResponseFormat('json')->respond($response, 200);
        }
        $updateData['ec_token'] = mt_rand('1111', '9999');

        $isValid = $this->Home_model->update_data('admin_user', $updateData, array(
            'email' => $userEmail
        ));

        if (!$isValid) {
            $response = [
                'status' => 'error',
                'code' => 500,
                'message' => 'Something went wrong. We’re sorry for the inconvenience. Please try again later.',

            ];
            return  $this->setResponseFormat('json')->respond($response, 200);
        }
        //  Email Send To User 
        $receiver_email = $userEmail;
        $subject = 'OTP verification  for Insurance Sorted login';
        $message = " Please Verify Your Email. 
             Verification Code: " . $updateData['ec_token'] . " If you did not request this verification code or believe this email is sent to you by mistake, 
             please ignore it. Your account security is of the utmost importance, Best regards, The Insurace Sorted Team ";
        $emailStatus  =  $this->sendEmail($receiver_email, $subject, $message);


        $response = [
            'status' => 'success',
            'code' => 200,
            'message' => 'OTP is send to your register Email Address',

        ];

        return  $this->setResponseFormat('json')->respond($response, 200);
    }
    // =================================== Logout ======================//
    public function logout()
    {
        if ($this->session->get('ad_is_logged_in')) {
            $this->session->destroy();
            return redirect()->to('admin/login');
        } else {
            return redirect()->to('admin/login');
        }
    }
    // ========================== Forget Password =======================//
    public function getForgetPassword()
    {
        if ($this->session->get('ad_is_logged_in')) {
            return redirect()->to('admin/dashboard');
        }

        $page = 'forget-password';
        $header = [
             'page'=> $page,
            'title' => 'Forget Password',
            'metaTitle' => 'Insurance Broker Brisbane Australia | Near Me – Sureinsure',
            'metaDescription' => 'Looking for Insurance Broker near me? Then SureInsure is an Insurance advisor Brisbane Australia. We provides cost-effective professional insurance advice.',
            'metaKeywords' => 'Insurance'
        ];
        return view('backend/forgetPassword', $header);
    }
    public function forgetPassword()
    {

        if (!$this->request->is('post')) {

            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Login Failed!</strong> Method Not Allowed
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>');

            return redirect()->to(base_url('admin/forget-password'));
        }
        if ($this->session->get('ad_is_logged_in')) {
            return redirect()->to('admin/dashboard');
        }
        $rules = [
            'email' => 'trim|required|valid_email'
        ];
        if (!$this->validate($rules)) {
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error !</strong> ' . validation_list_errors() . '
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>');
            return redirect()->to(base_url('admin/forget-password'));
        } else {

            $isValid = $this->Home_model->select_data('admin_user', 'admin_id', array(
                'email' => $this->request->getPost('email'),

            ));
            if ($isValid) {
                $insertData['rp_token'] = random_string('alnum', 50);
                $insertData['rp_created_at'] = date('Y-m-d H:i:s');
                $where['email'] = $this->request->getPost('email');
                $this->Home_model->update_data('admin_user', $insertData, $where);
                $receiver_email = $this->request->getPost('email');
                $subject = 'Reset Your Richmane Admin Password';
                $message = "Dear Admin,<br/> <br/>
                    <h3>Please click on the link to reset your password:<br/>
                    </h3><br/>
                    <a href=" . base_url() . "admin/reset-password/" . $insertData['rp_token'] . ">Password Reset Link</a>
                    <br/><br/>Thanks, <br/>Insurace Sorted Team";
                $emailStatus  =  $this->sendEmail($receiver_email, $subject, $message);
                if ($emailStatus) {
                    $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success !</strong> Check Your email. Link is send To your Email.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>');
                    return redirect()->to(base_url('admin/forget-password'));
                } else {
                    $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error !</strong> Email is not sent Please Try Again.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>');
                    return redirect()->to(base_url('admin/forget-password'));
                }
            } else {
                $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error !</strong> Link is Sent to Your Registered Email.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div> ');
                return redirect()->to(base_url('admin/forget-password'));
            }
        }
    }
    // ==================== reset  password ================================//


    public function getResetPassword($token)
    {
        if ($this->session->get('ad_is_logged_in')) {
            return redirect()->to('admin/dashboard');
        }

        $page = 'Reset password';
        $header = [
            'page'=> $page,
            'title' => 'Reset Password - Insurance Sorted',
            'metaTitle' => 'Insurance Broker Brisbane Australia | Near Me – Sureinsure',
            'metaDescription' => 'Looking for Insurance Broker near me? Then SureInsure is an Insurance advisor Brisbane Australia. We provides cost-effective professional insurance advice.',
            'metaKeywords' => 'Insurance'
        ];

        $data['token'] = $token;
        return view('backend/resetPassword', $header + $data);
    }
    public function resetPassword()
    {
        $password = $this->request->getPost('password');
        $password = $this->request->getPost('cpassword');
        $token = $this->request->getPost('token');

        if (!$this->request->is('post')) {

            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Login Failed!</strong> Method Not Allowed
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>');

            return redirect()->to(base_url('admin/reset-password/' . $token));
        }
        $rules = [
            'password' => [
                'label' => 'Password',
                'rules' => 'trim|required|min_length[8]',

            ],
            'cpassword' => [
                'label' => 'Confirm password',
                'rules' => 'trim|required|matches[password]',

            ]
        ];
        if (!$this->validate($rules)) {
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error !</strong> ' . validation_list_errors() . '.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>');
            return redirect()->to(base_url('admin/reset-password/' . $token));
        } else {
            $password = $this->sanitize($this->request->getPost('password'));


            $where['rp_token'] = $token;
            $updateData['password'] = $this->__encrip_password($password);
            $updateData['rp_token'] = '';
            $updateData['rp_created_at'] = '';
            $valid = $this->Home_model->update_data('admin_user', $updateData, $where);
            if ($valid) {
                $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success !</strong> Password Successfully Changed. Please Log In.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>');
                return redirect()->to('admin/login');
            } else {
                $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success !</strong>Something Went Wrong Try Again.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>');
                return redirect()->to(base_url('admin/reset-password/' . $token));
            }
        }
    }
// ======== Inbox Email =============== //
public function inbox()
{
    // if (!$this->session->get('ad_is_logged_in')) {
    //     return redirect()->to('admin/login');
    // }

    $page = 'inbox';
    if (!is_file(APPPATH . 'Views/backend/' . $page . '.php')) {
        // Whoops, we don't have a page for that!
        throw new PageNotFoundException($page);
    }


    // $page    = (int) ($this->request->getGet('page') ?? 1);
    // $perPage = 20;
    // $data['total'] = $this->Home_model->select_value('wholesaler_details', 'COUNT(id)', '');
    // $data['pager_links'] = '';
    // $total = 0;
    // if($data['total']){
    //     $total = $data['total'];
    // }
    // $searchTerm = $this->sanitize($this->request->getVar('search'));
    // $messageType = $this->sanitize($this->request->getVar('messageType'));
    // $data['searchTerm'] = $searchTerm;

    // $next = ($page - 1) * $perPage;

    $header = [
        'page' => "inbox",
        'title' => 'New Blog Richmean show',
        'metaTitle' => 'Shop hair systems for men | Non-surgical hair replacement systems | Lordhair',
        'metaDescription' => 'Shop online for hair systems for men with the best discounts. Non-surgical hair replacement systems 
                             with 100% real human hair and undetectable hairlines for a truly realistic look. All with a 30-day money-back
                             guarantee.',
        'metaKeywords' => 'hair, replacement, systems, hair replacement system, non surgical 
                           hair replacement, hair replacement systems, system, surgical'


    ];
    // $data['backendAllPages'] =  $this->backendAllPages();


    // $data['totalUnread'] = $this->Home_model->select_value('wholesaler_details', 'COUNT(id)', array(
    //     'is_readed'=> 0
    // ));
    // if($searchTerm !='' && !empty($searchTerm)){
    //     $data['emails'] = $this->Admin_model->select_inbox($searchTerm, $perPage, $next);
    //     $data['totalData'] = $this->Admin_model->select_inbox($searchTerm);

    //     if($data['totalData']){
    //         $total = count($data['totalData']);

    //         $data['total'] = $total;

    //     }else{
    //         $total = 0;
    //         $data['total'] = $total;
    //     }
    // }else if($messageType !='' && !empty($messageType)){

    //     $messageType = $messageType == 'read'? 1 : 0 ;
    //     $data['emails'] = $this->Home_model->select_data('wholesaler_details', '*', array(
    //         'is_readed'=> $messageType
    //     ),$order_by = 'id',$order= 'DESC','',$perPage, $next);
    //     $data['totalData'] = $this->Home_model->select_data('wholesaler_details', '*', array(
    //         'is_readed'=> $messageType
    //     ));
    //     if($data['totalData']){
    //         $total = count($data['totalData']);
    //         $data['total'] = $total;
    //     }else{
    //         $total = 0;
    //         $data['total'] = $total;
    //     }
    
    // }
    // else{

    //     $data['emails'] = $this->Home_model->select_data('wholesaler_details', '*', '',$order_by = 'id',$order= 'DESC','',$perPage, $next);
    // }

    // if ($total > $perPage) {
    //     $data['pager_links'] =    $this->pager->makeLinks($page, $perPage, $total);
    // }



    return view('backend/tpl/header', $header)
        . view('backend/inbox')
        . view('backend/tpl/footer');
}


public function inboxDetails($id)
{
    if (!$this->session->get('ad_is_logged_in')) {
        return redirect()->to('admin/login');
    }

    $page = 'inbox-details';
    if (!is_file(APPPATH . 'Views/backend/' . $page . '.php')) {
        // Whoops, we don't have a page for that!
        throw new PageNotFoundException($page);
    }


    $header = [
        'page' => $page,
        'title' => 'New Blog Richmean show',
        'metaTitle' => 'Shop hair systems for men | Non-surgical hair replacement systems | Lordhair',
        'metaDescription' => 'Shop online for hair systems for men with the best discounts. Non-surgical hair replacement systems 
                             with 100% real human hair and undetectable hairlines for a truly realistic look. All with a 30-day money-back
                             guarantee.',
        'metaKeywords' => 'hair, replacement, systems, hair replacement system, non surgical 
                           hair replacement, hair replacement systems, system, surgical'


    ];
    

    $data['backendAllPages'] =  $this->backendAllPages();

        $data['inbox'] = $this->Home_model->select_data('wholesaler_details', '*', array(
            'id'=> base64_decode($id)
        ),'', '', '', $limit = 1);


        $updateData['is_readed'] = 1;
        $this->Home_model->update_data('wholesaler_details',$updateData , array(
            'id'=> base64_decode($id)
        ));

        $data['totalUnread'] = $this->Home_model->select_value('wholesaler_details', 'COUNT(id)', array(
            'is_readed'=> 0
        ));
    return view('backend/tpl/header', $header + $data)
        . view('backend/inbox-details')
        . view('backend/tpl/footer');
}


public function inboxDelete()
{
    if (!$this->session->get('ad_is_logged_in')) {
        return redirect()->to('admin/login');
    }

    $id = $this->sanitize($this->request->getVar('id'));

 
  $isDeleted =   $this->Home_model->delete_data('wholesaler_details', array(
        'id'=> $id

  ));

  if(!$isDeleted){
    $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissable alert-style-1">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <i class="zmdi zmdi-info-outline"></i> Something Went Wrong! Inbox not delted 
            </div>');
  return   redirect()->to('admin/inbox');
  }

  $this->session->setFlashdata('message', '<div class="alert alert-info alert-dismissable alert-style-1">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
  <i class="zmdi zmdi-info-outline"></i> Inbox is deleted Successfully
</div>');

return   redirect()->to('admin/inbox');
}



    // =========== Get Single User Details ============== //
    public function getUserDetail($userId)
    {


        if (!$this->session->get('ad_is_logged_in')) {
            return redirect()->to('admin/login');
        }

        $page = 'getUserDetail';
        $header = [
            'page' => $page,
            'title' => 'Richmean show',
            'metaTitle' => 'Shop hair systems for men | Non-surgical hair replacement systems | Lordhair',
            'metaDescription' => 'Shop online for hair systems for men with the best discounts. Non-surgical hair replacement systems 
                                with 100% real human hair and undetectable hairlines for a truly realistic look. All with a 30-day money-back
                                guarantee.',
            'metaKeywords' => 'hair, replacement, systems, hair replacement system, non surgical 
                              hair replacement, hair replacement systems, system, surgical'


        ];

        $data['backendAllPages'] =  $this->backendAllPages();

        if (!$this->request->is('get')) {

            $response = [
                'status' => 'error',
                'code' => 500,
                'message' => 'Method is not Allowed',

            ];

            return  $this->setResponseFormat('json')->respond($response);
        }


        $userId = $this->sanitize($userId);


        if (!is_numeric($userId)) {
            $response = [
                'status' => 'error',
                'code' => 500,
                'message' => 'Something went wrong. Please try again ',

            ];

            return  $this->setResponseFormat('json')->respond($response);
        }

        $data['userDetail'] = $this->Home_model->select_data(
            'user',
            'user.*',
            array(
                'user_id' => $userId
            )
        );


        if (!$data) {
            $response = [
                'status' => 'error',
                'code' => 200,
                'message' => 'Something Went wrong.',


            ];

            return  $this->setResponseFormat('json')->respond($response);
        }

        return view('backend/tpl/header', $header + $data)
            . view('backend/single-user')
            . view('backend/tpl/footer');
    }

    public function getUser()
    {


        if (!$this->session->get('ad_is_logged_in')) {
            return redirect()->to('admin/login');
        }

        $page = 'user_page';
        $header = [
            'page' => $page,
            'title' => 'Richmean show',
            'metaTitle' => 'Shop hair systems for men | Non-surgical hair replacement systems | Lordhair',
            'metaDescription' => 'Shop online for hair systems for men with the best discounts. Non-surgical hair replacement systems 
                                with 100% real human hair and undetectable hairlines for a truly realistic look. All with a 30-day money-back
                                guarantee.',
            'metaKeywords' => 'hair, replacement, systems, hair replacement system, non surgical 
                              hair replacement, hair replacement systems, system, surgical'


        ];
        $data['backendAllPages'] =  $this->backendAllPages();

        $page    = (int) ($this->request->getGet('page') ?? 1);
        $perPage = 20;
        $data['total'] = $this->Home_model->select_value('user', 'COUNT(user_id)', '');
        $searchTerm = $this->sanitize($this->request->getVar('search'));
        $status = $this->sanitize($this->request->getVar('status'));

        $data['pager_links'] = '';
        $data['perPage'] = $perPage;

        $data['searchTerm'] = $searchTerm;

        $next = ($page - 1) * $perPage;


        $data['user'] = $this->Admin_model->select_user($searchTerm,  $status,  $perPage, $next);
        if ($data['user']) {
            $total = count($this->Admin_model->select_user($searchTerm,  $status));
        } else {
            $total = 0;
        }
        if ($total > $perPage) {
            $data['pager_links'] =    $this->pager->makeLinks($page, $perPage, $total);
        }

        return view('backend/tpl/header', $header + $data)
            . view('backend/user')
            . view('backend/tpl/footer');
    }

    // ===============Get User Detail =====//
    public function getQuickUserDetail($userId)
    {


        if (!$this->session->get('ad_is_logged_in')) {
            return redirect()->to('admin/login');
        }

        if (!$this->request->is('get')) {

            $response = [
                'status' => 'error',
                'code' => 500,
                'message' => 'Method is not Allowed',

            ];

            return  $this->setResponseFormat('json')->respond($response);
        }


        $userId = $this->sanitize($userId);


        if (!is_numeric($userId)) {
            $response = [
                'status' => 'error',
                'code' => 500,
                'message' => 'Something went wrong. Please try again ',

            ];

            return  $this->setResponseFormat('json')->respond($response);
        }





        $data = $this->Home_model->select_data(
            'user',
            'user.*',
            array(
                'user_id' => $userId
            )
        );


        if (!$data) {
            $response = [
                'status' => 'error',
                'code' => 200,
                'message' => 'Something Went wrong.',


            ];

            return  $this->setResponseFormat('json')->respond($response);
        }

        $response = [
            'status' => 'success',
            'code' => 200,
            'message' => 'User Detail ',
            'data' => $data

        ];

        return  $this->setResponseFormat('json')->respond($response);
    }




    // =================== Update user ========================= //
    public function updateUser()
    {


        if (!$this->session->get('ad_is_logged_in')) {
            return redirect()->to('admin/login');
        }

        if (!$this->request->is('post')) {

            $response = [
                'status' => 'error',
                'code' => 500,
                'message' => 'Method is not Allowed',
                'data' => [
                    'errorWrapper' => "Method Not Allowed"
                ]

            ];

            return  $this->setResponseFormat('json')->respond($response);
        }
        $rules = [
            'user_id' => [
                'label' =>  'Id',
                'rules' => 'trim|required|numeric'
            ],
            'userStatus' => [
                'label' =>  'User status',
                'rules' => 'trim|required|in_list[0,1,2]'
            ],


        ];

        if (!$this->validate($rules)) {

            $response = [
                'status' => 'error',
                'code' => 400,
                'message' => 'Form field not valid',
                'data' => [
                    'error' => validation_errors()
                ]

            ];
            return  $this->setResponseFormat('json')->respond($response);
            // return json_encode($response);
        }
        $id = $this->sanitize($this->request->getVar('user_id'));
        $userStatus = $this->sanitize($this->request->getVar('userStatus'));

        $updateData['is_active'] = $userStatus;

        $isUpdate = $this->Home_model->update_data('user', $updateData, array(
            'user_id' => $id
        ));

        if (!$isUpdate) {

            $response = [
                'status' => 'error',
                'code' => 400,
                'message' => 'Form field not valid',
                'data' => [
                    'error' => [
                        'errorWrapper' => 'Something went Wrong Please Try again'
                    ]
                ]
            ];

            return  $this->setResponseFormat('json')->respond($response);
        }


        if ($userStatus  == 0) {
            $userStatus = 'Unverfied';
        } else if ($userStatus == 1) {
            $userStatus == 'Active';
        } else if ($userStatus == 2) {
            $userStatus == 'Blocked';
        }

        $response = [
            'status' => 'success',
            'code' => 200,
            'message' => 'Form field not valid',
            'data' => [
                'userStatus' =>  $userStatus,


            ]

        ];

        return  $this->setResponseFormat('json')->respond($response);
    }
    // =========== Delete User =========== //


    public function deleteUser($userId)
    {

        if (!$this->session->get('ad_is_logged_in')) {
            return redirect()->to('admin/login');
        }

        if (!$this->request->is('delete')) {

            $response = [
                'status' => 'error',
                'code' => 500,
                'message' => 'Method is not Allowed',
                'data' => [
                    'errorWrapper' => "Method Not Allowed"
                ]

            ];

            return  $this->setResponseFormat('json')->respond($response);
        }

        if (!is_numeric($userId)) {

            $response = [
                'status' => 'error',
                'code' => 400,
                'message' => 'Form field not valid',
                'data' => [
                    'error' => 'User Id Not correct'
                ]

            ];

            return  $this->setResponseFormat('json')->respond($response);
            // return json_encode($response);

        }

        $userId = $this->sanitize($userId);


        $isDeleted = $this->Home_model->delete_data('user', array(
            'user_id' => $userId
        ));

        if (!$isDeleted) {


            $response = [
                'status' => 'error',
                'code' => 400,
                'message' => 'Something Went Worng. Please Try again',
                'data' => [
                    'error' => [
                        'errorWrapper' => 'Something went Wrong Please Try again'
                    ]
                ]

            ];

            return  $this->setResponseFormat('json')->respond($response);
        }
        $response = [
            'status' => 'success',
            'code' => 200,
            'message' => 'User is deleted',
            'data' => [
                'id' => $userId
            ]


        ];

        return  $this->setResponseFormat('json')->respond($response);
    }

    public function deleteBulkUser()
    {

        if (!$this->session->get('ad_is_logged_in')) {
            return redirect()->to('admin/login');
        }

        if (!$this->request->is('post')) {

            $response = [
                'status' => 'error',
                'code' => 500,
                'message' => 'Method is not Allowed',
                'data' => [
                    'errorWrapper' => "Method Not Allowed"
                ]

            ];

            return  $this->setResponseFormat('json')->respond($response);
        }





        $userIds = implode(",", $this->request->getVar('userIds'));





        $isDeleted = $this->Admin_model->delete_data_batch('user', 'user_id', $userIds);

        if (!$isDeleted) {
            $response = [
                'status' => 'error',
                'code' => 400,
                'message' => 'Something Went Worng. Please Try again',
                'data' => [
                    'error' => [
                        'errorWrapper' => 'Something went Wrong Please Try again'
                    ]
                ]

            ];

            return  $this->setResponseFormat('json')->respond($response);
        }



        $response = [
            'status' => 'success',
            'code' => 200,
            'message' => 'User is deleted',
            'data' => [
                'userIds' => explode(",", $userIds)
            ]


        ];

        return  $this->setResponseFormat('json')->respond($response);
    }




    public function test()
    {

        if (!$this->session->get('ad_is_logged_in')) {
            return redirect()->to('admin/login');
        }

        $page = 'test';
        $header = [
            'page' => $page,
            'title' => 'Richmean show',
            'metaTitle' => 'Shop hair systems for men | Non-surgical hair replacement systems | Lordhair',
            'metaDescription' => 'Shop online for hair systems for men with the best discounts. Non-surgical hair replacement systems 
                                with 100% real human hair and undetectable hairlines for a truly realistic look. All with a 30-day money-back
                                guarantee.',
            'metaKeywords' => 'hair, replacement, systems, hair replacement system, non surgical 
                              hair replacement, hair replacement systems, system, surgical'


        ];
        $data['backendAllPages'] =  $this->backendAllPages();


        return view('backend/tpl/header', $header + $data)
            . view('backend/test')
            . view('backend/tpl/footer');
    }

    public function cmsPages()
    {

        if (!$this->session->get('ad_is_logged_in')) {
            return redirect()->to('admin/login');
        }

        $page =  $this->uri->getSegment(4);
        if (!is_file(APPPATH . 'Views/backend/edit-table.php')) {
            // Whoops, we don't have a page for that!
            throw new PageNotFoundException($page);
        }


        if ($this->uri->getSegment(5)) {



            $header = [
                'title' => 'Richmean show',
                'metaTitle' => 'Shop hair systems for men | Non-surgical hair replacement systems | Lordhair',
                'metaDescription' => 'Shop online for hair systems for men with the best discounts. Non-surgical hair replacement systems 
                                    with 100% real human hair and undetectable hairlines for a truly realistic look. All with a 30-day money-back
                                    guarantee.',
                'metaKeywords' => 'hair, replacement, systems, hair replacement system, non surgical 
                                  hair replacement, hair replacement systems, system, surgical'


            ];
            $data['data'] = $this->Home_model->select_data('cms', '*', array(
                'cms_id' =>  base64_decode($this->uri->getSegment(5)),

            ));

            $data['backendAllPages'] =  $this->backendAllPages();
            return view('backend/tpl/header', $header + $data)
                . view('backend/edit-cms')
                . view('backend/tpl/footer');
        }

        $data['backendAllPages'] =  $this->backendAllPages();


        $header = [
            'title' => 'Richmean show',
            'metaTitle' => 'Shop hair systems for men | Non-surgical hair replacement systems | Lordhair',
            'metaDescription' => 'Shop online for hair systems for men with the best discounts. Non-surgical hair replacement systems 
                                with 100% real human hair and undetectable hairlines for a truly realistic look. All with a 30-day money-back
                                guarantee.',
            'metaKeywords' => 'hair, replacement, systems, hair replacement system, non surgical 
                              hair replacement, hair replacement systems, system, surgical'


        ];
        $data['data'] = $this->Home_model->select_data('cms', '*', array(
            'page' =>  $page,
           
        ));
        return view('backend/tpl/header', $header + $data)
            . view('backend/edit-table')
            . view('backend/tpl/footer');
    }



    public function cmsUpdate()
    {

        if (!$this->session->get('ad_is_logged_in')) {
            return redirect()->to('admin/login');
        }

        $redirectUrl = $this->request->getPost('url');

        $imgName1 = '';
        $imgName2 = '';

        if ($this->request->getFile('image1') != '') {


            $rules = [
                'image1' => 'uploaded[image1]|is_image[image1]|mime_in[image1,image/jpg,image/jpeg,image/png,image/webp]',
            ];


            if (!$this->validate($rules)) {
                $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible  show" role="alert">
            <strong>Error !</strong> File Type Not Allowed.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>');
                return redirect()->to($redirectUrl);
            } else {

                $img = $this->request->getFile('image1');
                if (!$img->hasMoved()) {
                    $imgName1 = $img->getRandomName();
                    $insertDataUpload = [
                        'slug' => 'public/assets/uploads/media/' . $imgName1
                    ];



                    $this->Home_model->save_data('upload', $insertDataUpload);
                    $img->move(ROOTPATH . 'public/assets/uploads/media/', $imgName1);


                    $imageUpload = base_url('public/backend/uploads/') . $imgName1;
                } else {

                    $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible  show" role="alert">
                <strong>Error !</strong> The file has already been moved..
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>');
                    return redirect()->to($redirectUrl);
                }
$update['image_1'] =  $imgName1 ;
            }
        }
        if ($this->request->getFile('image2') != '') {

            $rules = [
                'image2' => 'uploaded[image2]|is_image[image2]|mime_in[image2,image/jpg,image/jpeg,image/png,image/webp]',
            ];


            if (!$this->validate($rules)) {
                $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible show" role="alert">
            <strong>Error !</strong> File Type Not Allowed.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>');
                return redirect()->to($redirectUrl);
            } else {

                $img = $this->request->getFile('image2');
                if (!$img->hasMoved()) {
                    $imgName2 = $img->getRandomName();
                    $insertDataUpload = [
                        'slug' => 'public/assets/uploads/media/' . $imgName2
                    ];

                    $updateData = [
                        'image_2' => $imgName2
                    ];

                    $this->Home_model->save_data('upload', $insertDataUpload);
                    $img->move(ROOTPATH . 'public/assets/uploads/media/', $imgName2);

                    $imageUpload = base_url('public/backend/uploads/') . $imgName2;
                } else {

                    $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible  show" role="alert">
                <strong>Error !</strong> The file has already been moved..
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>');

                    return redirect()->to($redirectUrl);
                }
            }

            $update['image_2'] =  $imgName2;
        }

        $updateData = [
            'heading' => $this->request->getPost('heading'),
            'sub_heading' => $this->request->getPost('subHeading'),
            'description' => $this->request->getPost('description'),
            'youtube_link' => $this->request->getPost('youtubeLink'),
            'btn_name' => $this->request->getPost('btnName'),
            'btn_link' => $this->request->getPost('btnLink'),
            'is_active' => $this->request->getPost('active'),

        ];
        $where = [
            'cms_id' => base64_decode($this->request->getPost('id'))
        ];
        $valid = $this->Home_model->update_data('cms', $updateData, $where);

        if ($valid) {

            $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible  show" role="alert">
            <strong>Update !</strong> Data has Bee Updated Successfuly.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>');
            return redirect()->to($redirectUrl);
        } else {

            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible  show" role="alert">
            <strong>Error !</strong> Data Not Updated .
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>');
            return redirect()->to($redirectUrl);
        }
    }

    public function getFooter()
    {


        if (!$this->session->get('ad_is_logged_in')) {
            return redirect()->to('admin/login');
        }


        $page =  'edit-footer';
        if (!is_file(APPPATH . 'Views/backend/edit-footer.php')) {
            // Whoops, we don't have a page for that!
            throw new PageNotFoundException($page);
        }



        $header = [
            'page' => $page,
            'title' => 'Richmean show',
            'metaTitle' => 'Shop hair systems for men | Non-surgical hair replacement systems | Lordhair',
            'metaDescription' => 'Shop online for hair systems for men with the best discounts. Non-surgical hair replacement systems 
                                with 100% real human hair and undetectable hairlines for a truly realistic look. All with a 30-day money-back
                                guarantee.',
            'metaKeywords' => 'hair, replacement, systems, hair replacement system, non surgical 
                              hair replacement, hair replacement systems, system, surgical'


        ];
        $data['backendAllPages'] =  $this->backendAllPages();


        $data['col1'] = $this->Home_model->select_data('footer', '*', array(
            'location' => 'col-1'
        ));
        $data['col2'] = $this->Home_model->select_data('footer', '*', array(
            'location' => 'col-2'
        ));
        $data['col3'] = $this->Home_model->select_data('footer', '*', array(
            'location' => 'col-3'
        ));
        $data['col4'] = $this->Home_model->select_data('footer', '*', array(
            'location' => 'col-4'
        ));
        $data['socialLinks'] = $this->Home_model->select_data('footer', '*', array(
            'location' => 'social-links'
        ));
        $data['newsletter'] = $this->Home_model->select_data('footer', '*', array(
            'location' => 'newsletter'
        ));

        return view('backend/tpl/header', $header + $data)
            . view('backend/edit-footer')
            . view('backend/tpl/footer');
    }

    public function updateFooter()
    {

        if (!$this->session->get('ad_is_logged_in')) {
            return redirect()->to('admin/login');
        }

        $redirectUrl = base_url('admin/edit-footer');

        $imgName1 = '';

        $location = $this->request->getVar('location');
        if ($location == "col-1") {

            $data  = array();
            if ($this->request->getFile('footerlogo') != '') {

                $rules = [
                    'footerlogo' => 'uploaded[footerlogo]|is_image[footerlogo]|mime_in[footerlogo,image/jpg,image/jpeg,image/png,image/webp]',
                ];


                if (!$this->validate($rules)) {
                    $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible  show" role="alert">
                    <strong>Error !</strong> File Type Not Allowed.
                     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>');
                    return redirect()->to($redirectUrl . '?section=col-1');
                } else {

                    $img = $this->request->getFile('footerlogo');
                    if (!$img->hasMoved()) {
                        $imgName1 = $img->getRandomName();
                        $insertDataUpload = [
                            'slug' => 'public/assets/uploads/logo/' . $imgName1
                        ];



                        $this->Home_model->save_data('upload', $insertDataUpload);
                        $img->move(ROOTPATH . 'public/assets/uploads/logo/', $imgName1);
                    } else {

                        $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible  show" role="alert">
                    <strong>Error !</strong> The file has already been moved..
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>');
                        return redirect()->to($redirectUrl . '?section=col-1');
                    }
                }
            }



            $footerData = array();
            $footerData['footer_id']  = 1;
            $footerData['title']  = 'About';
            $footerData['description']  = $this->sanitize($this->request->getVar('description'));
            $footerData['slug']  = '';
            $data[] = $footerData;


            if ($imgName1 != '' && !empty($imgName1)) {
                $footerData = array();
                $footerData['footer_id']  = 2;
                $footerData['title']  = 'logo';
                $footerData['description']  = '';
                $footerData['slug']  = $imgName1;

                $data[] = $footerData;
            }

            $footerData = array();
            $footerData['footer_id']  = 3;
            $footerData['title']  = $this->sanitize($this->request->getVar('email'));
            $footerData['description']  = '';
            $footerData['slug']  = '';
            $data[] = $footerData;

            $footerData = array();
            $footerData['footer_id']  = 4;
            $footerData['title']  = $this->sanitize($this->request->getVar('phone'));
            $footerData['description']  = '';
            $footerData['slug']  = '';
            $data[] = $footerData;
        } else if (
            $location == "col-2"
            || $location == "col-3" ||
            $location == "col-4"
        ) {



            if ($this->request->getVar('location') == "col-2") {

                $headingId = 5;
                $startId = 6;
                $endId = 13;
            } else if ($this->request->getVar('location') == "col-3") {
                $headingId = 13;
                $startId = 14;
                $endId = 21;
            } else if ($this->request->getVar('location') == "col-4") {
                $headingId = 21;
                $startId = 22;
                $endId = 29;
            }





            $data = array();
            $footerData = array();
            $footerData['footer_id']  = $headingId;
            $footerData['title']  = $this->sanitize($this->request->getVar('heading'));
            $footerData['slug']  = '';
            $footerData['is_active']  = 1;
            $data[] = $footerData;




            for ($i = $startId; $i < $endId; $i++) {

                $footerData = array();
                $footerData['footer_id']  = $i;
                $footerData['title']  = $this->sanitize($this->request->getVar('sublinks' . $i));
                $footerData['slug']  = $this->sanitize($this->request->getVar('url' . $i));
                $footerData['is_active']  = $this->sanitize($this->request->getVar('active' . $i));
                $data[] = $footerData;
            }
        } else if ($location == "social-icons") {
            $data  = array();
            $startId = 29;
            $endId = 32;
            for ($i = $startId; $i < $endId; $i++) {

                $footerData = array();
                $footerData['footer_id']  = $i;
                $footerData['slug']  = $this->sanitize($this->request->getVar('url' . $i));
                $footerData['is_active']  = $this->sanitize($this->request->getVar('active' . $i));
                $data[] = $footerData;
            }
        } else if ($location == 'newsletter') {


            $data = array();
            $footerData = array();
            $footerData['footer_id']  = 33;
            $footerData['title']  = $this->sanitize($this->request->getVar('title'));
            $footerData['description']  = $this->sanitize($this->request->getVar('subTitle'));;

            $data[] = $footerData;
        }


        $isUpdated = $this->Home_model->update_data_batch('footer', $data, ['footer_id']);

        if (!$isUpdated) {


            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible  show" role="alert">
                  <strong>Error !</strong> Data Not Updated .
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>');
            return redirect()->to($redirectUrl . "?section=" . $location);
        }
        $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible  show" role="alert">
               <strong>Update !</strong> Data has Bee Updated Successfuly.
               <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                   </div>');
        return redirect()->to($redirectUrl . "?section=" . $location);
    }


    // ================== Header ======================= //
    public function getHeader($slug)
    {
        if (!$this->session->get('ad_is_logged_in')) {
            return redirect()->to('admin/login');
        }

        $page =  'edit-header';
        if (!is_file(APPPATH . 'Views/backend/edit-header.php')) {
            // Whoops, we don't have a page for that!
            throw new PageNotFoundException($page);
        }



        $header = [
            'page' => $page,
            'title' => 'Richmean show',
            'metaTitle' => 'Shop hair systems for men | Non-surgical hair replacement systems | Lordhair',
            'metaDescription' => 'Shop online for hair systems for men with the best discounts. Non-surgical hair replacement systems 
                            with 100% real human hair and undetectable hairlines for a truly realistic look. All with a 30-day money-back
                            guarantee.',
            'metaKeywords' => 'hair, replacement, systems, hair replacement system, non surgical 
                          hair replacement, hair replacement systems, system, surgical'


        ];
        $data['backendAllPages'] =  $this->backendAllPages();

        $slug = $this->sanitize($slug);
        $data['link'] = $this->Home_model->select_data('header', '*', array(
            'location' => 'link',
            'slug' => $slug
        ), '', '', '', $limit = 1);

        $data['list'] = '';

        if ($data['link']) {
            $data['list'] = $this->Home_model->select_data('header', '*', array(
                'location' => 'subLink',
                'parent_id' => $data['link'][0]->header_id
            ));
        } else {
            return view('backend/tpl/header', $header + $data)
                . view('backend/edit-header')
                . view('backend/tpl/footer');
        }

        $data['sublink'] = false;
        if ($data['link'][0]->header_id == 2 || $data['link'][0]->header_id == 5 || $data['link'][0]->header_id == 7) {

            $sublinkIds = [13, 16, 19, 20, 50, 51, 52, 53];

            $data['sublink'] = $this->Home_model->select_data_in('header', '*', 'parent_id', $sublinkIds);
        }

        $headerIds = array();
        if ($data['list']) {
            foreach ($data['list'] as $row) {

                $headerIds[] = $row->header_id;
            }
            $headerIds = array_merge($headerIds, [27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42]);
            $headerIds = implode(',', $headerIds);
            $data['headerProduct'] = $this->Admin_model->select_header_product($headerIds);
        }

        $data['allProduct'] = $this->Home_model->select_data('product', 'product_name, product_id', array(
            'product_id !=' => 1
        ));

        return view('backend/tpl/header', $header + $data)
            . view('backend/edit-header')
            . view('backend/tpl/footer');
    }

    public function updateHeader()
    {

        if (!$this->session->get('ad_is_logged_in')) {
            return redirect()->to('admin/login');
        }


        $redirectUrl = base_url('admin/edit-header/' . $this->request->getVar('currentUrl'));
        $updateData['title'] = $this->sanitize($this->request->getVar('title'));
        $updateData['slug'] = $this->sanitize($this->request->getVar('url'));
        $updateData['is_active'] = $this->sanitize($this->request->getVar('active'));

        $headerId = $this->sanitize($this->request->getVar('id'));


        if (
            $headerId == 2 || $headerId == 3 || $headerId == 4 || $headerId == 5
            || $headerId == 6 || $headerId == 7 || $headerId == 8

        ) {

            $redirectUrl = base_url('admin/edit-header/' . $updateData['slug']);
        }
        if (($headerId == 14 || $headerId == 54 || $headerId == 55 || $headerId == 56 || $headerId == 57)
            && $this->request->getFile('featureImage') != '' && !empty($this->request->getFile('featureImage'))
        ) {
            $oldImage = $this->request->getVar('oldImage');
            $rules = [
                'featureImage' => [
                    'label' => 'feature Image',
                    'rules' => 'trim|uploaded[featureImage]|max_size[featureImage, 5000]|ext_in[featureImage,png,jpg,webp,jpeg]|is_image[featureImage]',
                    'errors' => [
                        'ext_in' => 'Image only allowed is (png,jpg,jpeg,webp)',
                        'max_size' => 'Max Size of image uploaded is 5MB'
                    ]
                ]
            ];


            if (!$this->validate($rules)) {

                $this->session->setFlashdata('message', '<div class="alert alert-info alert-dismissable alert-style-1">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <i class="zmdi zmdi-info-outline"></i>' . $this->validator->listErrors() . '. 
            </div>');

                return redirect()->back()->withInput();
            }

            $img = $this->request->getFile('featureImage');
            if (!$img->hasMoved()) {


                $location = 'public/assets/uploads/media/';

                $imgName = $img->getRandomName();
                $img->move(ROOTPATH . $location, $imgName);

                if (!empty($oldImage) && $oldImage != '') {
                    if (file_exists($location . $oldImage)) {
                        unlink($location . $oldImage);
                    }
                }
            } else {

                $this->session->setFlashdata('message', '<div class="alert alert-info alert-dismissable alert-style-1">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <i class="zmdi zmdi-info-outline"></i> Image not Uploded try again 
            </div>');

                return redirect()->back()->withInput();
            }
            $updateData['input_name'] =  $imgName;
        }
        $isUpdated = $this->Home_model->update_data('header', $updateData, array(
            'header_id' => $headerId
        ));

        if (!$isUpdated) {


            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible  show" role="alert">
              <strong>Error !</strong> Data Not Updated .
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>');
            return redirect()->to($redirectUrl . "?section=" . $headerId);
        }
        $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible  show" role="alert">
           <strong>Update !</strong> Data has Bee Updated Successfuly.
           <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
               </div>');
        return redirect()->to($redirectUrl . "?section=" . $headerId);
    }



    public function updateHeaderBulk(){
        
        if (!$this->session->get('ad_is_logged_in')) {
            return redirect()->to('admin/login');
        }

        $redirectUrl = base_url('admin/edit-header/' . $this->request->getVar('currentUrl'));
        $headerId = $this->request->getVar('id');
        $title = $this->request->getVar('title');
        $slug = $this->request->getVar('url');
        $active = $this->request->getVar('active');

        $data = array();

        for ($i = 0; $i < count($headerId); $i++) {

            $updateData = array();
            $updateData['header_id'] = $headerId[$i];
            $updateData['title'] = $title[$i];
            $updateData['slug'] = $slug[$i];
            $updateData['is_active'] = $active[$i];

            $data[] = $updateData;
        }

        $isUpdated = $this->Home_model->update_data_batch('header', $data, ['header_id']);

        if (!$isUpdated) {

            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible  show" role="alert">
              <strong>Error !</strong> Data Not Updated .
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>');
            return redirect()->to($redirectUrl . "?section=" . $headerId[0]);
        }
        $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible  show" role="alert">
           <strong>Update !</strong> Data has Bee Updated Successfuly.
           <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
               </div>');
        return redirect()->to($redirectUrl . "?section=" . $headerId[0]);

    }

    

    public function updateHeaderProduct()
    {

        if (!$this->session->get('ad_is_logged_in')) {
            return redirect()->to('admin/login');
        }

        $redirectUrl = base_url('admin/edit-header/' . $this->request->getVar('currentUrl'));

        $location = $this->request->getVar('headerId');

        $headerProductId = $this->request->getVar('headerProduct');

        $product = $this->request->getVar('product');
        $active = $this->request->getVar('active');


        $data = array();


        for ($i = 0; $i < count($headerProductId); $i++) {

            $hederProduct = array();


            $hederProduct['id'] = $headerProductId[$i];

            $hederProduct['product_id'] = $product[$i];
            $hederProduct['is_active'] = $active[$i];

            $data[] = $hederProduct;
        }

        $isUpdated = $this->Home_model->update_data_batch('header_product', $data, ['id']);

        if (!$isUpdated) {


            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible  show" role="alert">
                  <strong>Error !</strong> Data Not Updated .
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>');
            return redirect()->to($redirectUrl . "?section=" . $location);
        }
        $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible  show" role="alert">
               <strong>Update !</strong> Data has Bee Updated Successfuly.
               <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                   </div>');
        return redirect()->to($redirectUrl . "?section=" . $location);
    }


    // =================== Seach Quick Conncet ======================= //

    public function getSearchQuick()
    {

        if (!$this->session->get('ad_is_logged_in')) {
            return redirect()->to('admin/login');
        }

        $page =  'edit-search-suggestion';
        if (!is_file(APPPATH . 'Views/backend/edit-search-suggestion.php')) {
            // Whoops, we don't have a page for that!
            throw new PageNotFoundException($page);
        }



        $header = [
            'page' => $page,
            'title' => 'Richmean show',
            'metaTitle' => 'Shop hair systems for men | Non-surgical hair replacement systems | Lordhair',
            'metaDescription' => 'Shop online for hair systems for men with the best discounts. Non-surgical hair replacement systems 
                                with 100% real human hair and undetectable hairlines for a truly realistic look. All with a 30-day money-back
                                guarantee.',
            'metaKeywords' => 'hair, replacement, systems, hair replacement system, non surgical 
                              hair replacement, hair replacement systems, system, surgical'


        ];
        $data['backendAllPages'] =  $this->backendAllPages();


        $data['searchQuickLinks'] = $this->Home_model->select_data('footer', '*', array(
            'location' => 'search-quick'
        ));


        return view('backend/tpl/header', $header + $data)
            . view('backend/edit-search-suggestion')
            . view('backend/tpl/footer');
    }
    public function updateSearchQuick()
    {
        if (!$this->session->get('ad_is_logged_in')) {
            return redirect()->to('admin/login');
        }


        $data = array();
        $footerId = $this->request->getVar('id');

        $title = $this->request->getVar('title');
        $url = $this->request->getVar('url');
        $active = $this->request->getVar('active');




        for ($i = 0; $i < count($footerId); $i++) {

            $quickLinks = array();


            $quickLinks['footer_id'] = $footerId[$i];

            $quickLinks['title'] = $title[$i];
            $quickLinks['slug'] = $url[$i];
            $quickLinks['is_active'] = $active[$i];

            $data[] = $quickLinks;
        }


        $isUpdated = $this->Home_model->update_data_batch('footer', $data, ['footer_id']);

        if (!$isUpdated) {


            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible  show" role="alert">
                  <strong>Error !</strong> Data Not Updated .
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>');
            return redirect()->to(base_url('admin/edit-search-quick'));
        }
        $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible  show" role="alert">
               <strong>Update !</strong> Data has Bee Updated Successfuly.
               <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                   </div>');
        return redirect()->to(base_url('admin/edit-search-quick'));
    }
    // ================ Blogs ======================== //

    public function addBlog()
    {
        if (!$this->session->get('ad_is_logged_in')) {
            return redirect()->to('admin/login');
        }

        $page = 'add-blog';
        if (!is_file(APPPATH . 'Views/backend/' . $page . '.php')) {
            // Whoops, we don't have a page for that!
            throw new PageNotFoundException($page);
        }


        $header = [
            'page' => $page,
            'title' => 'New Blog Richmean show',
            'metaTitle' => 'Shop hair systems for men | Non-surgical hair replacement systems | Lordhair',
            'metaDescription' => 'Shop online for hair systems for men with the best discounts. Non-surgical hair replacement systems 
                                 with 100% real human hair and undetectable hairlines for a truly realistic look. All with a 30-day money-back
                                 guarantee.',
            'metaKeywords' => 'hair, replacement, systems, hair replacement system, non surgical 
                               hair replacement, hair replacement systems, system, surgical'


        ];
        $data['backendAllPages'] =  $this->backendAllPages();


        $data['category'] = $this->Home_model->select_data('blog_category', 'blog_category_id, category_name', array(
            'is_active' => 1
        ));


        return view('backend/tpl/header', $header + $data)
            . view('backend/add-blog')
            . view('backend/tpl/footer');
    }


    public function saveBlog()
    {

        if (!$this->session->get('ad_is_logged_in')) {
            return redirect()->to('admin/login');
        }

        if (!$this->request->is('post')) {

            $this->session->setFlashdata('message', '<div class="alert alert-info alert-dismissable alert-style-1">
         <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
         <i class="zmdi zmdi-info-outline"></i>Method Not Allowed. 
         </div>');
            return  redirect()->to(base_url('admin/add-product'));
        }
        $rules = [
            'heading' => [
                'label' =>  'Heading',
                'rules' => 'trim|required|max_length[210]'
            ],
            'shortDescription' => [
                'label' => 'Short Description',
                'rules' => 'trim|max_length[250]'
            ],
            'category' => [
                'label' =>  'Category',
                'rules' => 'trim|numeric|required'
            ],
            'blogDescription' => [
                'label' => 'Blog Description',
                'rules' => 'trim'
            ],
            'featureImage' => [
                'label' => 'Feature Image',
                'rules' => 'uploaded[featureImage]'
            ]

        ];

        if (!$this->validate($rules)) {


            $this->session->setFlashdata('message', '<div class="alert alert-info alert-dismissable alert-style-1">
         <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
         <i class="zmdi zmdi-info-outline"></i>' . $this->validator->listErrors() . '. 
           </div>');

            return redirect()->to(base_url('admin/add-product'))->withInput();
        }


        if ($this->request->getFile('featureImage') != '') {

            $rules = [
                'featureImage' => [
                    'label' => 'feature Image',
                    'rules' => 'trim|uploaded[featureImage]|max_size[featureImage, 600]|ext_in[featureImage,png,jpg,webp,jpeg]|is_image[featureImage]',
                    'errors' => [
                        'ext_in' => 'Image only allowed is (png,jpg,jpeg,webp)',
                        'max_size' => 'Max Size of image uploaded is 500Kb'
                    ]
                ]
            ];


            if (!$this->validate($rules)) {

                $this->session->setFlashdata('message', '<div class="alert alert-info alert-dismissable alert-style-1">
             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
             <i class="zmdi zmdi-info-outline"></i>' . $this->validator->listErrors() . '. 
                   </div>');

                return redirect()->to(base_url('admin/add-product'))->withInput();
            }

            $img = $this->request->getFile('featureImage');
            if (!$img->hasMoved()) {


                $location = 'public/assets/uploads/blog/';
                $imgName = $img->getRandomName();
                // $imgName =  $this->sanitize($img->getClientName());
                $img->move(ROOTPATH . $location, $imgName);
            } else {

                $this->session->setFlashdata('message', '<div class="alert alert-info alert-dismissable alert-style-1">
             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
             <i class="zmdi zmdi-info-outline"></i> Image not Uploded try again 
                  </div>');

                return redirect()->to(base_url('admin/add-product'))->withInput();
            }
        }

        $heading = $this->sanitize($this->request->getVar('heading'));
        $shortDescription = $this->sanitize($this->request->getVar('shortDescription'));
        $category = $this->sanitize($this->request->getVar('category'));
        $blogDescription = $this->request->getVar('blogDescription');
        $slug = $this->sanitize($this->createSlug($heading));


        $insertData['heading'] = $heading;
        $insertData['short_description'] = $shortDescription;
        $insertData['description'] = $blogDescription;
        $insertData['category'] = $category;
        $insertData['feature_image'] = $imgName;
        $insertData['slug'] = $slug;
        $insertData['created_by'] = $this->session->get('ad_user_name');
        $insertData['created_at'] = date('Y-m-d  H:i:s');

        $isSave = $this->Home_model->save_data('blog', $insertData);

        if (!$isSave) {
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissable alert-style-1">
             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
             <i class="zmdi zmdi-info-outline"></i>Something Went Wrong. Blog Not Added. Please Try again. 
         </div>');

            return redirect()->to(base_url('admin/add-product'))->withInput();
        }
        $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissable alert-style-1">
         <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
         <i class="zmdi zmdi-check"></i></i><strong>
         Successful!</strong> Blog is Added. 
                </div>');

        return redirect()->to(base_url('admin/blogs'));
    }



    public function getBlogs()
    {

        if (!$this->session->get('ad_is_logged_in')) {
            return redirect()->to('admin/login');
        }


        $page = 'blogs';
        if (!is_file(APPPATH . 'Views/backend/' . $page . '.php')) {
            // Whoops, we don't have a page for that!
            throw new PageNotFoundException($page);
        }


        $header = [
            'page' => $page,
            'title' => 'Blogs Richmean show',
            'metaTitle' => 'Shop hair systems for men | Non-surgical hair replacement systems | Lordhair',
            'metaDescription' => 'Shop online for hair systems for men with the best discounts. Non-surgical hair replacement systems 
                             with 100% real human hair and undetectable hairlines for a truly realistic look. All with a 30-day money-back
                             guarantee.',
            'metaKeywords' => 'hair, replacement, systems, hair replacement system, non surgical 
                           hair replacement, hair replacement systems, system, surgical'


        ];
        $data['backendAllPages'] =  $this->backendAllPages();


        $page    = (int) ($this->request->getGet('page') ?? 1);
        $perPage = 20;
        $total   = $this->Home_model->select_value("blog", "count(blog_id)", '');

        $data['category'] = $this->Home_model->select_data('blog_category', 'blog_category_id, category_name', '');
        $searchTerm = $this->sanitize($this->request->getVar('search'));

        $data['pager_links'] = '';
        $data['perPage'] = $perPage;
        $data['total'] = $total;
        $data['searchTerm'] = $searchTerm;
        $next = ($page - 1) * $perPage;


        if ($searchTerm != '' &&  !empty($searchTerm)) {
            $data['data'] = $this->Admin_model->select_blog_search($searchTerm, $perPage, $next);
            if ($data['data']) {
                $total = count($data['data']);
            } else {
                $total = 0;
            }
        } else if ($this->request->getVar("category")) {

            $category =  $this->sanitize($this->request->getVar('category'));

            if ($category != 'all') {

                $data['data'] = $this->Home_model->select_data_join(
                    "blog",
                    "*, blog.slug as blog_slug",
                    array(
                        'category' => $category
                    ),
                    'blog_category',
                    'blog.category = blog_category.blog_category_id',
                    'LEFT',
                    $perPage,
                    $next,
                    'blog_id',
                    'DESC'
                );
            } else {
                $data['data'] = $this->Home_model->select_data_join(
                    "blog",
                    "*, blog.slug as blog_slug",
                    '',
                    'blog_category',
                    'blog.category = blog_category.blog_category_id',
                    'LEFT',
                    $perPage,
                    $next,
                    'blog_id',
                    'DESC'
                );
            }

            if ($data['data']) {
                $total = count($data['data']);
            } else {
                $total = 0;
            }
        } else {

            $data['data'] = $this->Home_model->select_data_join(
                "blog",
                "*, blog.slug as blog_slug",
                '',
                'blog_category',
                'blog.category = blog_category.blog_category_id',
                'LEFT',
                $perPage,
                $next,
                'blog_id',
                'DESC'
            );
        }



        if ($total > $perPage) {
            $data['pager_links'] =    $this->pager->makeLinks($page, $perPage, $total);
        }
        return view('backend/tpl/header', $header + $data)
            . view('backend/blogs')
            . view('backend/tpl/footer');
    }


    public function editBlog($slug)
    {

        if (!$this->session->get('ad_is_logged_in')) {
            return redirect()->to('admin/login');
        }

        $page = 'edit-blog';
        if (!is_file(APPPATH . 'Views/backend/' . $page . '.php')) {
            // Whoops, we don't have a page for that!
            throw new PageNotFoundException($page);
        }

        $header = [
            'page' => $page,
            'title' => 'Richmean show',
            'metaTitle' => 'Shop hair systems for men | Non-surgical hair replacement systems | Lordhair',
            'metaDescription' => 'Shop online for hair systems for men with the best discounts. Non-surgical hair replacement systems 
                             with 100% real human hair and undetectable hairlines for a truly realistic look. All with a 30-day money-back
                             guarantee.',
            'metaKeywords' => 'hair, replacement, systems, hair replacement system, non surgical 
                           hair replacement, hair replacement systems, system, surgical'


        ];
        $data['backendAllPages'] =  $this->backendAllPages();

        $slug = $this->sanitize($slug);

        $data['data'] = $this->Home_model->select_data_join(
            'blog',
            'blog.*, blog.slug as blog_slug, blog_category.category_name, blog_category.blog_category_id',
            array(
                'blog.slug' => $slug
            ),
            'blog_category',
            'blog.category = blog_category.blog_category_id',
            'LEFT',
            $limit = 1,

        );

        $data['category'] = $this->Home_model->select_data('blog_category', 'blog_category_id, category_name', array(
            'is_active' => 1
        ));

        return view('backend/tpl/header', $header + $data)
            . view('backend/edit-blog')
            . view('backend/tpl/footer');
    }


    public function getBlogDetail($id)
    {

        if (!$this->session->get('ad_is_logged_in')) {
            return redirect()->to('admin/login');
        }


        if (!$this->request->is('get')) {

            $response = [
                'status' => 'error',
                'code' => 500,
                'message' => 'Method is not Allowed',

            ];

            return  $this->setResponseFormat('json')->respond($response);
        }


        $id = $this->sanitize($id);


        if (!is_numeric($id)) {
            $response = [
                'status' => 'error',
                'code' => 500,
                'message' => 'Something went wrong. Please try again ',

            ];

            return  $this->setResponseFormat('json')->respond($response);
        }
        $data = $this->Home_model->select_data_join(
            'blog',
            '*, blog.slug as blog_slug ',
            array(
                'blog_id' => $id
            ),
            'blog_category',
            'blog_category.blog_category_id = blog.category',
            'LEFT',
            $limit = 1
        );

        if (!$data) {
            $response = [
                'status' => 'error',
                'code' => 200,
                'message' => 'Something Went wrong.',

            ];

            return  $this->setResponseFormat('json')->respond($response);
        }
        $response = [
            'status' => 'success',
            'code' => 200,
            'message' => 'Blog Detail ',
            'data' => $data

        ];

        return  $this->setResponseFormat('json')->respond($response);
    }

    // ========================== Product Cateogory ===================== //
    public function getBlogCategory()
    {
        if (!$this->session->get('ad_is_logged_in')) {
            return redirect()->to('admin/login');
        }

        if (!$this->request->is('get')) {

            $response = [
                'status' => 'error',
                'code' => 500,
                'message' => 'Method is not Allowed',

            ];

            return  $this->setResponseFormat('json')->respond($response);
        }
        $data = $this->Home_model->select_data('blog_category', '*', '', $orderBy = 'category_name', $order = "ASC");


        if (!$data) {
            $response = [
                'status' => 'error',
                'code' => 200,
                'message' => 'Something Went wrong.',
            ];

            return  $this->setResponseFormat('json')->respond($response);
        }

        $li = '';
        foreach ($data as $row) {

            $li .= '<option value="' . $row->blog_category_id . '">' . $row->category_name . '</option>';
        }

        $response = [
            'status' => 'success',
            'code' => 200,
            'message' => 'Product category ',
            'data' => $li

        ];

        return  $this->setResponseFormat('json')->respond($response);
    }

    // =========== Update Single Product Details =========== //


    public function updateBlog()
    {
        if (!$this->session->get('ad_is_logged_in')) {
            return redirect()->to('admin/login');
        }

        if (!$this->request->is('post')) {

            $response = [
                'status' => 'error',
                'code' => 500,
                'message' => 'Method is not Allowed',
                'data' => [
                    'errorWrapper' => "Method Not Allowed"
                ]

            ];

            return  $this->setResponseFormat('json')->respond($response);
        }


        $rules = [
            'heading' => [
                'label' =>  'Heading',
                'rules' => 'trim|required|max_length[210]'
            ],
            'category' => [
                'label' =>  'Category',
                'rules' => 'trim|numeric|required'
            ],
            'slug' => [
                'label' => 'Slug',
                'rules' => 'trim|required'
            ],
            'isActive' => [
                'label' => 'Acitve',
                'rules' => 'trim|in_list[1,0]'
            ],
            'author' => [
                'label' => 'Author',
                'rules' => 'trim|alpha_numeric_punct'
            ]
        ];
        if (!$this->validate($rules)) {
            $response = [
                'status' => 'error',
                'code' => 400,
                'message' => 'Form field not valid',
                'data' => [
                    'error' => validation_errors()
                ]
            ];

            return  $this->setResponseFormat('json')->respond($response);
            // return json_encode($response);
        }


        $oldImage = $this->request->getVar('oldImage');

        if ($this->request->getvar('featureImage') != '') {



            $imgName = $this->request->getVar('featureImage');

            if (file_exists('public/assets/uploads/blog/' . $oldImage)) {
                unlink('public/assets/uploads/blog/' . $oldImage);
            }
        } else {
            $imgName = $this->sanitize($this->request->getVar('oldImage'));
        }

        $id = $this->sanitize($this->request->getVar('id'));
        $heading = $this->sanitize($this->request->getVar('heading'));
        $category = $this->sanitize($this->request->getVar('category'));
        $slug = $this->sanitize($this->request->getVar('slug'));
        $author = $this->sanitize($this->request->getVar('author'));
        $isActive = $this->sanitize($this->request->getVar('isActive'));





        $updateData['heading'] = $heading;
        $updateData['slug'] = $slug;
        $updateData['category'] = $category;
        $updateData['created_by'] = $author;
        $updateData['is_active'] = $isActive;
        $updateData['feature_image'] = $imgName;

        $isUpdate = $this->Home_model->update_data('blog', $updateData, array(
            'blog_id' => $id
        ));

        if (!$isUpdate) {
            $response = [
                'status' => 'error',
                'code' => 400,
                'message' => 'Form field not valid',
                'data' => [
                    'error' => [
                        'errorWrapper' => 'Something went Wrong Please Try again'
                    ]
                ]

            ];

            return  $this->setResponseFormat('json')->respond($response);
        }


        $category  = $this->Home_model->select_value('blog_category', 'category_name', array(
            'blog_category_id' => $category
        ));

        $response = [
            'status' => 'success',
            'code' => 200,
            'message' => 'Form field not valid',
            'data' => [
                'id' =>  $id,
                'heading' =>  $heading,
                'slug' =>  $slug,
                'category' =>  $category,
                'author' =>  $author,
                'featureImage' =>  $imgName,
            ]

        ];

        return  $this->setResponseFormat('json')->respond($response);
    }


    public function updateFullBlog()
    {

        if (!$this->session->get('ad_is_logged_in')) {
            return redirect()->to('admin/login');
        }

        if (!$this->request->is('post')) {

            $this->session->setFlashdata('message', '<div class="alert alert-info alert-dismissable alert-style-1">
             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
             <i class="zmdi zmdi-info-outline"></i>Method Not Allowed. 
         </div>');


            return  redirect()->back();
        }

        $id = $this->sanitize($this->request->getVar('id'));

        $redirectUrl = $this->Home_model->select_value('blog', 'slug', array(
            'blog_id' => $id
        ));

        $redirectUrl = base_url('admin/edit-blog/' . $redirectUrl);
        $oldImage = $this->sanitize($this->request->getVar('oldImage'));

        $imgName = $oldImage;


        $rules = [
            'heading' => [
                'label' =>  'Heading',
                'rules' => 'trim|required|max_length[210]'
            ],
            'shortDescription' => [
                'label' => 'Short Description',
                'rules' => 'trim|max_length[250]'
            ],
            'category' => [
                'label' =>  'Category',
                'rules' => 'trim|numeric|required'
            ],
            'blogDescription' => [
                'label' => 'Blog Description',
                'rules' => 'trim'
            ],
            'featureImage' => [
                'label' => 'Feature Image',
                'rules' => 'uploaded[featureImage]'
            ]

        ];

        if (!$this->validate($rules)) {


            $this->session->setFlashdata('message', '<div class="alert alert-info alert-dismissable alert-style-1">
             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
             <i class="zmdi zmdi-info-outline"></i>' . $this->validator->listErrors() . '. 
         </div>');

            return redirect()->to($redirectUrl)->withInput();
        }

        if ($this->request->getFile('featureImage') != '') {

            $rules = [
                'featureImage' => [
                    'label' => 'feature Image',
                    'rules' => 'trim|uploaded[featureImage]|max_size[featureImage, 6000]|ext_in[featureImage,png,jpg,webp,jpeg]|is_image[featureImage]',
                    'errors' => [
                        'ext_in' => 'Image only allowed is (png,jpg,jpeg,webp)',
                        'max_size' => 'Max Size of image uploaded is 500Kb'
                    ]
                ]
            ];


            if (!$this->validate($rules)) {

                $this->session->setFlashdata('message', '<div class="alert alert-info alert-dismissable alert-style-1">
                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                 <i class="zmdi zmdi-info-outline"></i>' . $this->validator->listErrors() . '. 
             </div>');

                return redirect()->to($redirectUrl)->withInput();
            }

            $img = $this->request->getFile('featureImage');
            if (!$img->hasMoved()) {
                // $imgName = $img->getRandomName();

                $location = 'public/assets/uploads/blog/';

                $imgName =  $this->sanitize($img->getClientName());
                $img->move(ROOTPATH . $location, $imgName);

                if (!empty($oldImage) && $oldImage != '') {
                    if (file_exists($location . $oldImage)) {
                        unlink($location . $oldImage);
                    }
                }
            } else {

                $this->session->setFlashdata('message', '<div class="alert alert-info alert-dismissable alert-style-1">
                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                 <i class="zmdi zmdi-info-outline"></i> Image not Uploded try again 
             </div>');

                return redirect()->to($redirectUrl)->withInput();
            }
        }





        $heading = $this->sanitize($this->request->getVar('heading'));
        $shortDescription = $this->sanitize($this->request->getVar('shortDescription'));
        $category = $this->sanitize($this->request->getVar('category'));
        $blogDescription = $this->request->getVar('blogDescription');
        $slug = $this->sanitize($this->createSlug($heading));


        $updateData['heading'] = $heading;
        $updateData['short_description'] = $shortDescription;
        $updateData['description'] = $blogDescription;
        $updateData['category'] = $category;
        $updateData['feature_image'] = $imgName;
        $updateData['slug'] = $slug;





        $isUpdate = $this->Home_model->update_data('blog', $updateData, array(
            'blog_id' => $id
        ));

        if (!$isUpdate) {
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissable alert-style-1">
                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                 <i class="zmdi zmdi-info-outline"></i>Something Went Wrong. Blog Not updated. Please Try again. 
             </div>');

            return redirect()->to(base_url('admin/edit-product/' . $slug))->withInput();
        }

        $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissable alert-style-1">
             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
             <i class="zmdi zmdi-check"></i><strong>Successfull!</strong> Blog is updated. 
         </div>');

        return redirect()->to(base_url('admin/edit-blog/' . $slug))->withInput();
    }


    public function deleteBlog($id)
    {
        if (!$this->session->get('ad_is_logged_in')) {
            return redirect()->to('admin/login');
        }

        if (!$this->request->is('delete')) {

            $response = [
                'status' => 'error',
                'code' => 500,
                'message' => 'Method is not Allowed',
                'data' => [
                    'errorWrapper' => "Method Not Allowed"
                ]

            ];

            return  $this->setResponseFormat('json')->respond($response);
        }





        if (!is_numeric($id)) {

            $response = [
                'status' => 'error',
                'code' => 400,
                'message' => 'Form field not valid',
                'data' => [
                    'error' => 'Product Id Not correct'
                ]

            ];

            return  $this->setResponseFormat('json')->respond($response);
            // return json_encode($response);

        }

        $id = $this->sanitize($id);


        $isDeleted = $this->Home_model->delete_data('blog', array(
            'blog_id' => $id
        ));

        if (!$isDeleted) {
            $response = [
                'status' => 'error',
                'code' => 400,
                'message' => 'Something Went Worng. Please Try again',
                'data' => [
                    'error' => [
                        'errorWrapper' => 'Something went Wrong Please Try again'
                    ]
                ]
            ];

            return  $this->setResponseFormat('json')->respond($response);
        }
        $response = [
            'status' => 'success',
            'code' => 200,
            'message' => 'Blog is deleted',
            'data' => [
                'id' => $id
            ]
        ];

        return  $this->setResponseFormat('json')->respond($response);
    }

    public function deleteBulkBlog()
    {
        if (!$this->session->get('ad_is_logged_in')) {
            return redirect()->to('admin/login');
        }

        if (!$this->request->is('post')) {

            $response = [
                'status' => 'error',
                'code' => 500,
                'message' => 'Method is not Allowed',
                'data' => [
                    'errorWrapper' => "Method Not Allowed"
                ]

            ];

            return  $this->setResponseFormat('json')->respond($response);
        }
        $ids = implode(",", $this->request->getVar('ids'));
        $isDeleted = $this->Admin_model->delete_data_batch('blog', 'blog_id', $ids);
        if (!$isDeleted) {
            $response = [
                'status' => 'error',
                'code' => 400,
                'message' => 'Something Went Worng. Please Try again',
                'data' => [
                    'error' => [
                        'errorWrapper' => 'Something went Wrong Please Try again'
                    ]
                ]

            ];

            return  $this->setResponseFormat('json')->respond($response);
        }
        $response = [
            'status' => 'success',
            'code' => 200,
            'message' => 'Blog is  is deleted',
            'data' => [
                'ids' => explode(",", $ids)
            ]


        ];

        return  $this->setResponseFormat('json')->respond($response);
    }


    // =============== Blog Cateogries ============= //



    public function getBlogCategories()
    {


        if (!$this->session->get('ad_is_logged_in')) {
            return redirect()->to('admin/login');
        }

        $page = 'blog-categories';
        if (!is_file(APPPATH . 'Views/backend/' . $page . '.php')) {
            // Whoops, we don't have a page for that!
            throw new PageNotFoundException($page);
        }


        $header = [
            'page' => $page,
            'title' => 'Blog Category show',
            'metaTitle' => 'Shop hair systems for men | Non-surgical hair replacement systems | Lordhair',
            'metaDescription' => 'Shop online for hair systems for men with the best discounts. Non-surgical hair replacement systems 
                                with 100% real human hair and undetectable hairlines for a truly realistic look. All with a 30-day money-back
                                guarantee.',
            'metaKeywords' => 'hair, replacement, systems, hair replacement system, non surgical 
                              hair replacement, hair replacement systems, system, surgical'


        ];
        $data['backendAllPages'] =  $this->backendAllPages();


        $page    = (int) ($this->request->getGet('page') ?? 1);
        $perPage = 20;
        $total   = $this->Home_model->select_value("blog_category", "count(blog_category_id)", '');

        $data['pager_links'] = '';
        $data['perPage'] = $perPage;
        $data['total'] = $total;
        $data['searchTerm'] = '';

        // Call makeLinks() to make pagination links.



        $next = ($page - 1) * $perPage;

        $searchTerm = $this->sanitize($this->request->getVar('search'));

        $data['searchTerm'] = $searchTerm;

        if($searchTerm != '' && !empty($searchTerm)){

            $data['categories'] = $this->Home_model->select_data_like('blog_category', '*', 'category_name', $searchTerm);
        }else{

            $data['categories'] = $this->Home_model->select_data('blog_category', '*', '');
        }



        if ($total > $perPage) {
            $data['pager_links'] =    $this->pager->makeLinks($page, $perPage, $total);
        }



        return view('backend/tpl/header', $header + $data)
            . view('backend/blog-categories')
            . view('backend/tpl/footer');
    }


    public function addBlogCategory()
    {

        if (!$this->session->get('ad_is_logged_in')) {
            return redirect()->to('admin/login');
        }

        if (!$this->request->is('post')) {

            $response = [
                'status' => 'error',
                'code' => 500,
                'message' => 'Method is not Allowed',

            ];

            return  $this->setResponseFormat('json')->respond($response);
        }

        $rules = [
            'categoryName' => [
                'label' => 'Category Name',
                'rules' => 'trim|required|max_length[200]'
            ]
        ];


        if (!$this->validate($rules)) {

            $response = [
                'status' => 'error',
                'code' => 400,
                'message' => 'Form field not valid',
                'data' => [
                    'error' => validation_errors()
                ]

            ];

            return  $this->setResponseFormat('json')->respond($response);
        
        }
        $categoryName = $this->request->getVar('categoryName');
        $slug =  $this->createSlug($categoryName);

        $insertData['category_name'] = $categoryName;
        $insertData['slug'] = $slug;
        $isSave = $this->Home_model->save_data('blog_category', $insertData);

        if (!$isSave) {
            $response = [
                'status' => 'error',
                'code' => 400,
                'message' => 'Form field not valid',
                'data' => [
                    'error' => [
                        'errorWrapper' => 'Something went Wrong Please Try again'
                    ]
                ]
            ];

            return  $this->setResponseFormat('json')->respond($response);
        }


        $data = $this->Home_model->select_data('blog_category', '*', array(
            'category_name' => $categoryName
        ), '', '', '', $limit = "1");

        $response = [
            'status' => 'success',
            'code' => 200,
            'message' => 'Category is Added',
            'data' => [
                'id' => $data[0]->blog_category_id,
                'categoryName' => $categoryName,
                'slug' => $slug,
                'active'=> 'Active'

            ]

        ];

        return  $this->setResponseFormat('json')->respond($response);
    }
    public function getBlogSingleCategory($id)
    {
        if (!$this->session->get('ad_is_logged_in')) {
            return redirect()->to('admin/login');
        }

        if (!$this->request->is('get')) {

            $response = [
                'status' => 'error',
                'code' => 500,
                'message' => 'Method is not Allowed',

            ];

            return  $this->setResponseFormat('json')->respond($response);
        }
        $id = $this->sanitize($id);
        if (!is_numeric($id)) {
            $response = [
                'status' => 'error',
                'code' => 500,
                'message' => 'Something went wrong. Please try again ',

            ];
            return  $this->setResponseFormat('json')->respond($response);
        }
        $data = $this->Home_model->select_data('blog_category', '*', array(
                'blog_category_id'=> $id
        ));


        if (!$data) {
            $response = [
                'status' => 'error',
                'code' => 200,
                'message' => 'Something Went wrong.'
            ];
            return  $this->setResponseFormat('json')->respond($response);
        }
        $response = [
            'status' => 'success',
            'code' => 200,
            'message' => 'Category Detail ',
            'data' => $data

        ];

        return  $this->setResponseFormat('json')->respond($response);
    }

    public function updateBlogCategory()
    {
        if (!$this->session->get('ad_is_logged_in')) {
            return redirect()->to('admin/login');
        }

        if (!$this->request->is('post')) {

            $response = [
                'status' => 'error',
                'code' => 500,
                'message' => 'Method is not Allowed',
                'data' => [
                    'errorWrapper' => "Method Not Allowed"
                ]

            ];

            return  $this->setResponseFormat('json')->respond($response);
        }


        $rules = [
            'id' => [
                'label' =>  'Category Id',
                'rules' => 'trim|required|numeric'
            ],
            'categoryName' => [
                'label' =>  'Category Name',
                'rules' => 'trim|required|max_length[210]'
            ],
            'active' => [
                'label' =>  'Active',
                'rules' => 'trim|required|in_list[1,0]'
            ],


        ];

        if (!$this->validate($rules)) {

            $response = [
                'status' => 'error',
                'code' => 400,
                'message' => 'Form field not valid',
                'data' => [
                    'error' => validation_errors()
                ]

            ];

            return  $this->setResponseFormat('json')->respond($response);
            // return json_encode($response);

        }

        $id = $this->sanitize($this->request->getVar('id'));
        $categoryName = $this->request->getVar('categoryName');
        $slug = $this->createSlug($categoryName);
        $active = $this->sanitize($this->request->getVar('active'));

        $updateData['category_name'] = $categoryName;
        $updateData['slug'] = $slug;
        $updateData['is_active'] = $active;

        $isUpdate = $this->Home_model->update_data('blog_category', $updateData, array(
            'blog_category_id' => $id
        ));

        if (!$isUpdate) {
            $response = [
                'status' => 'error',
                'code' => 400,
                'message' => 'Form field not valid',
                'data' => [
                    'error' => [
                        'errorWrapper' => 'Something went Wrong Please Try again'
                    ]
                ]

            ];

            return  $this->setResponseFormat('json')->respond($response);
        }
        $response = [
            'status' => 'success',
            'code' => 200,
            'message' => 'Successfully Updated',
            'data' => [
                'categoryName' =>  $categoryName,
                'slug' =>  $slug,
                'active'=> $active  ==  1 ?  "Active" : 'In active' 
            ]

        ];

        return  $this->setResponseFormat('json')->respond($response);
    }

    public function deleteBlogCategory($id)
    {
        if (!$this->session->get('ad_is_logged_in')) {
            return redirect()->to('admin/login');
        }

        if (!$this->request->is('delete')) {

            $response = [
                'status' => 'error',
                'code' => 500,
                'message' => 'Method is not Allowed',
                'data' => [
                    'errorWrapper' => "Method Not Allowed"
                ]

            ];

            return  $this->setResponseFormat('json')->respond($response);
        }

        if (!is_numeric($id)) {

            $response = [
                'status' => 'error',
                'code' => 400,
                'message' => 'Form field not valid',
                'data' => [
                    'error' => 'Product Id Not correct'
                ]

            ];

            return  $this->setResponseFormat('json')->respond($response);
            // return json_encode($response);

        }

        $id = $this->sanitize($id);


        $isDeleted = $this->Home_model->delete_data('blog_category', array(
            'blog_category_id' => $id
        ));

        if (!$isDeleted) {


            $response = [
                'status' => 'error',
                'code' => 400,
                'message' => 'Something Went Worng. Please Try again',
                'data' => [
                    'error' => [
                        'errorWrapper' => 'Something went Wrong Please Try again'
                    ]
                ]

            ];

            return  $this->setResponseFormat('json')->respond($response);
        }
        $response = [
            'status' => 'success',
            'code' => 200,
            'message' => 'Category is deleted',
            'data' => [
                'id' => $id
            ]
        ];

        return  $this->setResponseFormat('json')->respond($response);
    }

    public function deleteBulkBlogCategory()
    {
        if (!$this->session->get('ad_is_logged_in')) {
            return redirect()->to('admin/login');
        }

        if (!$this->request->is('post')) {

            $response = [
                'status' => 'error',
                'code' => 500,
                'message' => 'Method is not Allowed',
                'data' => [
                    'errorWrapper' => "Method Not Allowed"
                ]

            ];

            return  $this->setResponseFormat('json')->respond($response);
        }





        $ids = implode(",", $this->request->getVar('ids'));





        $isDeleted = $this->Admin_model->delete_data_batch('blog_category', 'blog_category_id', $ids);


        if (!$isDeleted) {


            $response = [
                'status' => 'error',
                'code' => 400,
                'message' => 'Something Went Worng. Please Try again',
                'data' => [
                    'error' => [
                        'errorWrapper' => 'Something went Wrong Please Try again'
                    ]
                ]

            ];

            return  $this->setResponseFormat('json')->respond($response);
        }



        $response = [
            'status' => 'success',
            'code' => 200,
            'message' => 'Category is  is deleted',
            'data' => [
                'ids' => explode(",", $ids)
            ]


        ];

        return  $this->setResponseFormat('json')->respond($response);
    }
}
