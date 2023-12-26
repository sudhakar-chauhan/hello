<?php

namespace App\Controllers\Api\V1;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use Config\Services;
use App\Models\Home_model;
use UnexpectedValueException;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use CodeIgniter\I18n\Time;


 require_once APPPATH . 'ThirdParty/vendor/autoload.php';

class Home extends BaseController
{
    use ResponseTrait;
    public function __construct()
    {
        helper(['form', 'text', 'url', 'filesystem', 'inflector']);
        $this->Home_model = new Home_model();
        $this->uri = current_url(true);
        $this->pager = \Config\Services::pager();
        $this->validation = \Config\Services::validation();
        // $this->image = \Config\Services::image();
    }


     // ========= User Login ============= //

     public function login()
     {
       
 
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
                 'rules' => 'trim|required',
                 
             ]
         ];  // rules that are requirest when user Register.
 
 
 
         if (!$this->validate($rules)) {
 
             $response = [
                 'status' => 'error',
                 'code' => 400,
                 'message' => $this->validator->listErrors('my_list'),
 
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
                     'message' => 'Login Failed: Email is not register.',
 
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
                         'message' => 'Your Account is locked. Forget password to unlock the account',
 
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
                         'message' => 'Login Failed: Your account is locked. Forget password to unlock account',
 
                     ];
                     return $this->setResponseFormat('json')->respond($response, 200);
                 } else {
 
                     $updateData['login_failed_count'] = $failed_login_count + 1;
                     $this->Home_model->update_data("user", $updateData, array(
 
                         'email' => $email
 
                     ));
                     if ($failed_login_count < 9) {
 
                         $response = [
                             'status' => 'error',
                             'code' => 401,
                             'message' => 'Login Failed: Your email Or password do not match. Please try again.',
 
                         ];
                         return $this->setResponseFormat('json')->respond($response, 200);
                     } else {
                         $response = [
                             'status' => 'error',
                             'code' => 401,
                             'message' => 'Login Failed: Your email Or password do not match. Last attempt before account is locked. .',
 
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
                         'message' => 'Email is not verified. Please verify your email or forget password to receive an email for verification.',
 
                     ];
                     return $this->setResponseFormat('json')->respond($response, 200);
                 }
                 if ($userData[0]->is_active === "3") {
                     $response = [
                         'status' => 'error',
                         'code' => 401,
                         'message' => 'Your account is blocked. To Unblock it Contact Service Center',
 
                     ];
                     return $this->setResponseFormat('json')->respond($response, 200);
                 }
 
                 if ($userData[0]->account_is_locked !== "0") {
 
                     $response = [
                         'status' => 'error',
                         'code' => 401,
                         'message' => 'Your Account is locked. Forget password to unlock the account',
 
                     ];
                     return $this->setResponseFormat('json')->respond($response, 200);
                 }
 
 
 
 
                 $updateData['log_date'] =  date("Y-m-d H:i:s");
                 $updateData['login_failed_count'] = 0;
                 $updateData['account_is_locked'] = 0;
                 $updateData['rp_token'] = '';
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
                 $data['first_name'] = $userData[0]->first_name;
                 
                $jwtToken =  $this->createjwtToken($id, $email);
                
 
                 $response = [
                     'status' => 'success',
                     'code' => 200,
                     'message' => 'Login Successfully.',
                     'data' => $data,
                     'isLogged' => true,
                     'token' => $jwtToken
 
                 ];
                 return $this->setResponseFormat('json')->respond($response, 200);
             }
         }
     }

    // ==============  Create domestic ========== //

    public function createDomestic()
    {
        if (!$this->request->is('post')) {
            $response = [
                'status' => 'error',
                'code' => 405,
                'message' => 'Method Not Allowed',

            ];
            return $this->setResponseFormat('json')->respond($response, 200);
        }
    

            $rules = [
                'name' => [
                    'label' => 'Name',
                    'rules' => 'trim|required|min_length[1]|max_length[32]|alpha_space'

                ],
                'email' => [
                    'label' => 'Email',
                    'rules' => 'trim|required|valid_email',
                ],
                'phone' => [
                    'label' => 'Phone',
                    'rules' => 'trim|required|min_length[10]|max_length[10]|regex_match[/^(\+\d{1,2}\s?)?\(?\d{3}\)?[\s.-]?\d{3}[\s.-]?\d{4}$/]',
                    'errors' => [
                        'min_length' => 'Please enter a valid 10-digit phone number.',
                        'max_length' => 'Please enter a valid 10-digit phone number.',
                        'regex_match' => 'Please enter a valid 10-digit phone number.',
                    ]
                ],
                'dob' => [
                    'label' => 'Date of Birth',
                    'rules' => 'trim|required|valid_date[Y-m-d]'
                ],
                'address' => [
                    'label' => 'Address',
                    'rules' => 'trim|required'
                ],
                'property_constructed' => [
                    'label' => 'property constructed',
                    'rules' => 'trim|required|valid_date[Y]'
                ],
                'construction_details' => [
                    'label' => 'Construction details',
                    'rules' => 'trim|required'
                ],
                'wall_construction' => [
                    'label' => 'wall construction',
                    'rules' => 'trim|required'
                ],
                'hs_details' => [
                    'label' => 'house security details',
                    'rules' => 'trim|required'
                ],
                'additional_cover' => [
                    'label' => 'additional cover',
                    'rules' => 'trim|required'
                ],
                'weekly_rent' => [
                    'label' => 'weekly rent',
                    'rules' => 'trim|required'
                ],
                'property_occupancy' => [
                    'label' => 'property occupancy',
                    'rules' => 'trim|required'
                ],
                'mortgage_building' => [
                    'label' => 'mortgage building',
                    'rules' => 'trim|required'
                ],
                'ci_provider' => [
                    'label' => 'current insurance provider',
                    'rules' => 'trim|required'
                ],
                'any_claim' => [
                    'label' => 'any claim',
                    'rules' => 'trim|required'
                ],
                
                
            ];  // rules that are requirest when user Register.

            if (!$this->validate($rules)) {
                
                $response = [
                    'status' => 'error',
                    'code' => 400,
                    'message' => $this->validator->listErrors('my_list'),

                ];

                return $this->setResponseFormat('json')->respond($response, 200);
            } else {
                 
                $name = $this->sanitize($this->request->getVar('name'));
                $email = $this->sanitize($this->request->getVar('email'));
                $phone = $this->sanitize($this->request->getVar('phone'));
                $dob = $this->sanitize($this->request->getVar('dob'));
                $joint_insured_name = $this->sanitize($this->request->getVar('joint_insured_name'));
                $joint_insured_dob = $this->sanitize($this->request->getVar('joint_insured_dob'));
                $address = $this->sanitize($this->request->getVar('address'));
                $property_constructed = $this->sanitize($this->request->getVar('property_constructed'));
                $bsi_amount = $this->sanitize($this->request->getVar('bsi_amount'));
                $csi_amount = $this->sanitize($this->request->getVar('csi_amount'));
                $building_excess = $this->sanitize($this->request->getVar('building_excess'));
                $content_excess = $this->sanitize($this->request->getVar('content_excess'));
                $construction_details = $this->sanitize($this->request->getVar('construction_details'));
                $wall_construction = $this->sanitize($this->request->getVar('wall_construction'));
                $hs_details = $this->sanitize($this->request->getVar('hs_details'));
                $additional_cover = $this->sanitize($this->request->getVar('additional_cover'));
                $weekly_rent = $this->sanitize($this->request->getVar('weekly_rent'));
                $property_occupancy = $this->sanitize($this->request->getVar('property_occupancy'));
                $mortgage_building = $this->sanitize($this->request->getVar('mortgage_building'));
                $ci_provider = $this->sanitize($this->request->getVar('ci_provider'));
                $renewal_date = $this->sanitize($this->request->getVar('renewal_date'));
                $any_claim = $this->sanitize($this->request->getVar('any_claim'));
                $claim_mention = $this->sanitize($this->request->getVar('claim_mention'));
                $comments = $this->sanitize($this->request->getVar('comments'));

                $insertData['name'] = $name;
                $insertData['email'] = $email;
                $insertData['phone'] = $phone;
                $insertData['dob'] = $dob;
                $insertData['claim_no'] = 'CL'.mt_rand(11111, 99999);
                $insertData['claim_for'] = 3;
                $insertData['is_readed'] = 0;

                 $isClaim = $this->Home_model->save_data('claim', $insertData);

                 if (!$isClaim) {

                    $response = [
                        'status' => 'error',
                        'code' => 500,
                        'message' => 'Something went wrong. We’re sorry for the inconvenience. Please try again later. ',
                    ];
                    return $this->setResponseFormat('json')->respond($response, 200);
                }
        
                // $isDomestic = $this->Admin_model->last_insert($name,$email);
                 $isDomestic = $this->Home_model->select_data('claim','id', array('name' => $name,'email' => $email), 'id', 'DESC', '1');
    
                $claimId = $isDomestic[0]->id;
                
                $insertData1['claim_id'] =  $claimId;
                $insertData1['joint_insured_name'] = $joint_insured_name;
                $insertData1['joint_insured_dob'] = $joint_insured_dob;
                $insertData1['address'] = $address;
                $insertData1['property_constructed'] = $property_constructed;
                $insertData1['bsi_amount'] = $bsi_amount;
                $insertData1['csi_amount'] = $csi_amount;
                $insertData1['building_excess'] = $building_excess;
                $insertData1['content_excess'] = $content_excess;
                $insertData1['construction_details'] = $construction_details;
                $insertData1['wall_construction'] = $wall_construction;
                $insertData1['hs_details'] = $hs_details;
                $insertData1['additional_cover'] = $additional_cover;
                $insertData1['weekly_rent'] = $weekly_rent;
                $insertData1['property_occupancy'] = $property_occupancy;
                $insertData1['mortgage_building'] = $mortgage_building;
                $insertData1['ci_provider'] = $ci_provider;
                $insertData1['renewal_date'] = $renewal_date;
                $insertData1['any_claim'] = $any_claim;
                $insertData1['claim_mention'] = $claim_mention;
                $insertData1['comments'] = $comments;

                $isDomestic = $this->Home_model->save_data('domestic_landlords', $insertData1);
                
                if (!$isDomestic) {
        
                    $response = [
                        'status' => 'error',
                        'code' => 400,
                        'message' => 'Something went wrong.',
        
                    ];
                    return $this->setResponseFormat('json')->respond($response, 200);
                }
        
                $response = [
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'successfully submitted',
        
                ];
                return $this->setResponseFormat('json')->respond($response, 200);


            }
           
        } // Create A user  



        public function createHome()
        {
            if (!$this->request->is('post')) {
                $response = [
                    'status' => 'error',
                    'code' => 405,
                    'message' => 'Method Not Allowed',
    
                ];
                return $this->setResponseFormat('json')->respond($response, 200);
            }
        
    
                $rules = [
                    'name' => [
                        'label' => 'Name',
                        'rules' => 'trim|required|min_length[1]|max_length[32]|alpha_space'
    
                    ],
                    'email' => [
                        'label' => 'Email',
                        'rules' => 'trim|required|valid_email',
                    ],
                    'phone' => [
                        'label' => 'Phone',
                        'rules' => 'trim|required|min_length[10]|max_length[10]|regex_match[/^(\+\d{1,2}\s?)?\(?\d{3}\)?[\s.-]?\d{3}[\s.-]?\d{4}$/]',
                        'errors' => [
                            'min_length' => 'Please enter a valid 10-digit phone number.',
                            'max_length' => 'Please enter a valid 10-digit phone number.',
                            'regex_match' => 'Please enter a valid 10-digit phone number.',
                        ]
                    ],
                    'dob' => [
                        'label' => 'Date of Birth',
                        'rules' => 'trim|required|valid_date[Y-m-d]'
                    ],
                    'address' => [
                        'label' => 'Address',
                        'rules' => 'trim|required'
                    ],
                    'old_property' => [
                        'label' => 'old property',
                        'rules' => 'trim|required'
                    ],
                   
                    
                ];  // rules that are requirest when user Register.
    
                if (!$this->validate($rules)) {
                    
                    $response = [
                        'status' => 'error',
                        'code' => 400,
                        'message' => $this->validator->listErrors('my_list'),
    
                    ];
    
                    return $this->setResponseFormat('json')->respond($response, 200);
                }  else {
                 
                    $name = $this->sanitize($this->request->getVar('name'));
                    $email = $this->sanitize($this->request->getVar('email'));
                    $phone = $this->sanitize($this->request->getVar('phone'));
                    $dob = $this->sanitize($this->request->getVar('dob'));
                    $joint_insured_name = $this->sanitize($this->request->getVar('joint_insured_name'));
                    $address = $this->sanitize($this->request->getVar('address'));
                    $bsi_amount = $this->sanitize($this->request->getVar('bsi_amount'));
                    $csi_amount = $this->sanitize($this->request->getVar('csi_amount'));
                    $building_excess = $this->sanitize($this->request->getVar('building_excess'));
                    $content_excess = $this->sanitize($this->request->getVar('content_excess'));
                    $old_property = $this->sanitize($this->request->getVar('old_property'));
                    $construction_details = $this->sanitize($this->request->getVar('construction_details'));
                    $wall_construction = $this->sanitize($this->request->getVar('wall_construction'));
                    $hs_details = $this->sanitize($this->request->getVar('hs_details'));
                    $ct_water= $this->sanitize($this->request->getVar('ct_water'));
                    $bf_home = $this->sanitize($this->request->getVar('bf_home'));
                    $mortgage_building = $this->sanitize($this->request->getVar('mortgage_building'));
                    $ci_provider = $this->sanitize($this->request->getVar('ci_provider'));
                    $renewal_date = $this->sanitize($this->request->getVar('renewal_date'));
                    $any_claim = $this->sanitize($this->request->getVar('any_claim'));
                    $comments = $this->sanitize($this->request->getVar('comments'));
    
                    $insertData['name'] = $name;
                    $insertData['email'] = $email;
                    $insertData['phone'] = $phone;
                    $insertData['dob'] = $dob;
                    $insertData['claim_no'] = 'CL'.mt_rand(11111, 99999);
                    $insertData['claim_for'] = 2;
                    $insertData['is_readed'] = 0;
    
                     $isClaim = $this->Home_model->save_data('claim', $insertData);
    
                     if (!$isClaim) {
    
                        $response = [
                            'status' => 'error',
                            'code' => 500,
                            'message' => 'Something went wrong. We’re sorry for the inconvenience. Please try again later. ',
                        ];
                        return $this->setResponseFormat('json')->respond($response, 200);
                    }
            
                    // $isDomestic = $this->Admin_model->last_insert($name,$email);
                     $isDomestic = $this->Home_model->select_data('claim','id', array('name' => $name,'email' => $email), 'id', 'DESC', '1');
        
                    $claimId = $isDomestic[0]->id;
                    
                    $insertData1['claim_id'] =  $claimId;
                    $insertData1['joint_insured_name'] = $joint_insured_name;
                    $insertData1['address'] = $address;
                    $insertData1['bsi_amount'] = $bsi_amount;
                    $insertData1['csi_amount'] = $csi_amount;
                    $insertData1['building_excess'] = $building_excess;
                    $insertData1['content_excess'] = $content_excess;
                    $insertData1['old_property'] = $old_property;
                    $insertData1['construction_details'] = $construction_details;
                    $insertData1['wall_construction'] = $wall_construction;
                    $insertData1['hs_details'] = $hs_details;
                    $insertData1['ct_water'] = $ct_water;
                    $insertData1['bf_home'] = $bf_home;
                    $insertData1['mortgage_building'] = $mortgage_building;
                    $insertData1['ci_provider'] = $ci_provider;
                    $insertData1['renewal_date'] = $renewal_date;
                    $insertData1['any_claim'] = $any_claim;
                    $insertData1['comments'] = $comments;
    
                    $isDomestic = $this->Home_model->save_data('home_content', $insertData1);
                    
                    if (!$isDomestic) {
            
                        $response = [
                            'status' => 'error',
                            'code' => 400,
                            'message' => 'Something went wrong.',
            
                        ];
                        return $this->setResponseFormat('json')->respond($response, 200);
                    }
            
                    $response = [
                        'status' => 'success',
                        'code' => 200,
                        'message' => 'successfully submitted',
            
                    ];
                    return $this->setResponseFormat('json')->respond($response, 200);
    
    
                }
               
            } // Create A user  

            public function createMotorvehicle()
        {
            if (!$this->request->is('post')) {
                $response = [
                    'status' => 'error',
                    'code' => 405,
                    'message' => 'Method Not Allowed',
    
                ];
                return $this->setResponseFormat('json')->respond($response, 200);
            }
        
    
                $rules = [
                    'name' => [
                        'label' => 'Name',
                        'rules' => 'trim|required|min_length[1]|max_length[32]|alpha_space'
    
                    ],
                    'email' => [
                        'label' => 'Email',
                        'rules' => 'trim|required|valid_email',
                    ],
                    'phone' => [
                        'label' => 'Phone',
                        'rules' => 'trim|required|min_length[10]|max_length[10]|regex_match[/^(\+\d{1,2}\s?)?\(?\d{3}\)?[\s.-]?\d{3}[\s.-]?\d{4}$/]',
                        'errors' => [
                            'min_length' => 'Please enter a valid 10-digit phone number.',
                            'max_length' => 'Please enter a valid 10-digit phone number.',
                            'regex_match' => 'Please enter a valid 10-digit phone number.',
                        ]
                    ],
                    'dob' => [
                        'label' => 'Date of Birth',
                        'rules' => 'trim|required|valid_date[Y-m-d]'
                    ],
                    'parking_address' => [
                        'label' => 'parking address',
                        'rules' => 'trim|required'
                    ],
                    'registration_no' => [
                        'label' => 'registration number',
                        'rules' => 'trim|required'
                    ],
                    'si_type' => [
                        'label' => 'Sum insured type',
                        'rules' => 'trim|required'
                    ],
                    'excess_amount' => [
                        'label' => 'Excess amount',
                        'rules' => 'trim|required'
                    ],
                    'insured_cover' => [
                        'label' => 'insured cover',
                        'rules' => 'trim|required'
                    ],
                    'vehicle_hail_damage' => [
                        'label' => 'vehicle hail damage',
                        'rules' => 'trim|required'
                    ],
                    'ci_provider_name' => [
                        'label' => 'ci provider name',
                        'rules' => 'trim|required'
                    ],
                    'any_claim' => [
                        'label' => 'any claim',
                        'rules' => 'trim|required'
                    ],
                   
                ];  // rules that are requirest when user Register.
    
                if (!$this->validate($rules)) {
                    
                    $response = [
                        'status' => 'error',
                        'code' => 400,
                        'message' => $this->validator->listErrors('my_list'),
    
                    ];
    
                    return $this->setResponseFormat('json')->respond($response, 200);
                }  else {
                 
                    $name = $this->sanitize($this->request->getVar('name'));
                    $email = $this->sanitize($this->request->getVar('email'));
                    $phone = $this->sanitize($this->request->getVar('phone'));
                    $dob = $this->sanitize($this->request->getVar('dob'));
                    $driver_name = $this->sanitize($this->request->getVar('driver_name'));
                    $parking_address = $this->sanitize($this->request->getVar('parking_address'));
                    $registration_no = $this->sanitize($this->request->getVar('registration_no'));
                    $si_type = $this->sanitize($this->request->getVar('si_type'));
                    $vehicle_usage = $this->sanitize($this->request->getVar('vehicle_usage'));
                    $excess_amount = $this->sanitize($this->request->getVar('excess_amount'));
                    $insured_cover = $this->sanitize($this->request->getVar('insured_cover'));
                    $vehicle_hail_damage = $this->sanitize($this->request->getVar('vehicle_hail_damage'));
                    $ci_provider_name = $this->sanitize($this->request->getVar('ci_provider_name'));
                    $any_claim = $this->sanitize($this->request->getVar('any_claim'));
                    $claim_mention= $this->sanitize($this->request->getVar('claim_mention'));
                    $accessory_type = $this->sanitize($this->request->getVar('accessory_type'));
                    $comments = $this->sanitize($this->request->getVar('comments'));
    
                    $insertData['name'] = $name;
                    $insertData['email'] = $email;
                    $insertData['phone'] = $phone;
                    $insertData['dob'] = $dob;
                    $insertData['claim_no'] = 'CL'.mt_rand(11111, 99999);
                    $insertData['claim_for'] = 1;
                    $insertData['is_readed'] = 0;
    
                     $isClaim = $this->Home_model->save_data('claim', $insertData);
    
                     if (!$isClaim) {
    
                        $response = [
                            'status' => 'error',
                            'code' => 500,
                            'message' => 'Something went wrong. We’re sorry for the inconvenience. Please try again later. ',
                        ];
                        return $this->setResponseFormat('json')->respond($response, 200);
                    }
            
                    // $isDomestic = $this->Admin_model->last_insert($name,$email);
                     $isDomestic = $this->Home_model->select_data('claim','id', array('name' => $name,'email' => $email), 'id', 'DESC', '1');
        
                    $claimId = $isDomestic[0]->id;
                    
                    $insertData1['claim_id'] =  $claimId;
                    $insertData1['driver_name'] =  $driver_name;
                    $insertData1['parking_address'] =  $parking_address;
                    $insertData1['registration_no'] = $registration_no;
                    $insertData1['si_type'] = $si_type;
                    $insertData1['vehicle_usage'] = $vehicle_usage;
                    $insertData1['excess_amount'] = $excess_amount;
                    $insertData1['insured_cover'] =   $insured_cover;
                    $insertData1['vehicle_hail_damage'] =  $vehicle_hail_damage;
                    $insertData1['ci_provider_name'] = $ci_provider_name;
                    $insertData1['any_claim'] = $any_claim;
                    $insertData1['claim_mention'] =  $claim_mention;
                    $insertData1['accessory_type'] = $accessory_type;
                    $insertData1['comments'] = $comments;
    
                    $isDomestic = $this->Home_model->save_data('motor_vehicle', $insertData1);
                    
                    if (!$isDomestic) {
            
                        $response = [
                            'status' => 'error',
                            'code' => 400,
                            'message' => 'Something went wrong.',
            
                        ];
                        return $this->setResponseFormat('json')->respond($response, 200);
                    }
            
                    $response = [
                        'status' => 'success',
                        'code' => 200,
                        'message' => 'successfully submitted',
            
                    ];
                    return $this->setResponseFormat('json')->respond($response, 200);
    
    
                }
               
            } // Create A user  

            public function getClaim()
            {
                if (!$this->request->is('get')) {
                    $response = [
                        'status' => 'error',
                        'code' => 405,
                        'message' => 'Method Not Allowed',
        
                    ];
                    return $this->setResponseFormat('json')->respond($response, 200);
                }
        
                if ($this->checkJWT()) {
                    return $this->checkJWT();
                }
        
                $getJwtToken = $this->request->header('token')->getValue();
        
                $jwtToken = $this->decodejwtToken($getJwtToken);
              
               $userId = $jwtToken['decodeToken']->data->id;

                $page    = (int) ($this->request->getGet('page') ?? 1);
                $perPage = 4;
                $next = ($page - 1) * $perPage;
                $category = $this->request->getGet('category');

                if(!empty($category))
                {
                    $isData = $this->Home_model->select_data('claim', '*', array(
                        'user_id' => $userId,'claim_for' => $category
                    ),'id','DESC','',$perPage,$next);
                  
                }else{

                    $isData = $this->Home_model->select_data('claim', '*', array(
                        'user_id' => $userId
                    ),'id','DESC','',$perPage,$next);

                }
               
                if (!$isData) {
        
                    $response = [
                        'status' => 'error',
                        'code' => 404,
                        'message' => 'No Data found',
        
                    ];
                    return $this->setResponseFormat('json')->respond($response, 200);
                }
        
        
                $response = [
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'All Data',
                    'data' => $isData
        
                ];
                return $this->setResponseFormat('json')->respond($response, 200);
            }

            public function getclaimDetails($id)
            {
                if (!$this->request->is('get')) {
                    $response = [
                        'status' => 'error',
                        'code' => 405,
                        'message' => 'Method Not Allowed',
        
                    ];
                    return $this->setResponseFormat('json')->respond($response, 200);
                }
        
                if ($this->checkJWT()) {
                    return $this->checkJWT();
                }
        
                $getJwtToken = $this->request->header('token')->getValue();
        
                $jwtToken = $this->decodejwtToken($getJwtToken);
              
                $userId = $jwtToken['decodeToken']->data->id;


                $claimData = $this->Home_model->select_value('claim', 'claim_for', array(
                    'id' => $id,'user_id' =>$userId
                ));

                
                if (!$claimData) {
        
                    $response = [
                        'status' => 'error',
                        'code' => 404,
                        'message' => 'No Data found',
        
                    ];
                    return $this->setResponseFormat('json')->respond($response, 200);
                }
             
                   
                  $claim_data = "claim.id as claim_index,claim.user_id,claim.name,claim.email,claim.phone,claim.dob,
                  claim.claim_no,claim.claim_for,claim.is_readed";

                    if($claimData == 1)
                    {
                        $join_col = "claim.id=motor_vehicle.claim_id";
                        $isData=$this->Home_model->select_data_join("claim", "$claim_data, motor_vehicle.*", array("claim.id"=>$id), "motor_vehicle", 
                        "$join_col");
                      
                    } 
                   
                    elseif($claimData == 2)
                    { 
                        $join_col = "claim.id=home_content.claim_id";
                        $isData=$this->Home_model->select_data_join("claim", "$claim_data, home_content.*", array("claim.id"=>$id), "home_content", 
                        "$join_col");
                          
                    }
                    elseif($claimData == 3)
                    {
                        $join_col = "claim.id=domestic_landlords.claim_id";
                        $isData=$this->Home_model->select_data_join("claim", "$claim_data, domestic_landlords.*", array("claim.id"=>$id), "domestic_landlords", 
                        "$join_col");
                      
                    }
        
        
                $response = [
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Not Available',
                    'data' => $isData
        
                ];
                return $this->setResponseFormat('json')->respond($response, 200);
            }

            public function getTradehelp()
            {
                if (!$this->request->is('get')) {
                    $response = [
                        'status' => 'error',
                        'code' => 405,
                        'message' => 'Method Not Allowed',
        
                    ];
                    return $this->setResponseFormat('json')->respond($response, 200);
                }
        
                if ($this->checkJWT()) {
                    return $this->checkJWT();
                }
        
                $getJwtToken = $this->request->header('token')->getValue();
        
                $jwtToken = $this->decodejwtToken($getJwtToken);
              
                $userId = $jwtToken['decodeToken']->data->id;

                $page    = (int) ($this->request->getGet('page') ?? 1);
                $perPage = 4;
                $next = ($page - 1) * $perPage;
                $category = $this->request->getGet('category');

                if(!empty($category))
                {
                    $isData = $this->Home_model->select_data('trade_help', '*', array(
                        'category' => $category
                    ),'id','DESC','',$perPage,$next);
                  
                }else{

                    $isData = $this->Home_model->select_data('trade_help', '*', '','id','DESC','',$perPage,$next);

                }
               
                if (!$isData) {
        
                    $response = [
                        'status' => 'error',
                        'code' => 404,
                        'message' => 'No Data found',
        
                    ];
                    return $this->setResponseFormat('json')->respond($response, 200);
                }
        
        
                $response = [
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'All Data',
                    'data' => $isData
        
                ];
                return $this->setResponseFormat('json')->respond($response, 200);
            }

            public function getTradeDetails($id)
            {
                if (!$this->request->is('get')) {
                    $response = [
                        'status' => 'error',
                        'code' => 405,
                        'message' => 'Method Not Allowed',
        
                    ];
                    return $this->setResponseFormat('json')->respond($response, 200);
                }
        
                if ($this->checkJWT()) {
                    return $this->checkJWT();
                }
        
                $getJwtToken = $this->request->header('token')->getValue();
        
                $jwtToken = $this->decodejwtToken($getJwtToken);
              
                $userId = $jwtToken['decodeToken']->data->id;
            
                $isData = $this->Home_model->select_data('trade_help', '*', array(
                    'id' => $id
                ));

                
                if (!$isData) {
        
                    $response = [
                        'status' => 'error',
                        'code' => 404,
                        'message' => 'No Data found',
        
                    ];
                    return $this->setResponseFormat('json')->respond($response, 200);
                }
        
                $response = [
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Not Available',
                    'data' => $isData
        
                ];
                return $this->setResponseFormat('json')->respond($response, 200);
            }

        public function Support()
         
        {
          
          if (!$this->request->is('post')) {
              $response = [
                  'status' => 'error',
                  'code' => 405,
                  'message' => 'Method Not Allowed',

              ];
              return $this->setResponseFormat('json')->respond($response, 200);
          }

          if ($this->checkJWT()) {
            return $this->checkJWT();
        }


          $getJwtToken = $this->request->header('token')->getValue();
          $jwtToken = $this->decodejwtToken($getJwtToken);
          $userId = $jwtToken['decodeToken']->data->id;

          $rules = [
              'subject' => [
                  'label' => 'Subject',
                  'rules' => 'trim|required|min_length[1]|max_length[255]'

              ],
              'message' => [
                  'label' => 'Message',
                  'rules' => 'trim|required|min_length[1]|max_length[500]'

              ]

          ];

          if (!$this->validate($rules)) {

              $response = [
                  'status' => 'error',
                  'code' => 400,
                  'message' => $this->validator->listErrors('my_list'),

              ];
              return $this->setResponseFormat('json')->respond($response, 200);
          } else {
          

              $subject = $this->sanitize($this->request->getVar('subject'));
              $message = $this->sanitize($this->request->getVar('message'));
          
              $insertData['subject'] = $subject;
              $insertData['message'] = $message;
              $insertData['user_id'] = $userId;
              $insertData['subject_id'] = 'IS'.mt_rand(1111, 9999);
          

              $isValid = $this->Home_model->save_data('support_ticket', $insertData);
          
              if ($isValid) {


                  $response = [
                      'status' => 'success',
                      'code' => 201,
                      'message' => 'Your message is succefully send',


                  ];
                  return $this->setResponseFormat('json')->respond($response, 201);
              } else {

                  $response = [
                      'status' => 'error',
                      'code' => 500,
                      'message' => 'Something went wrong. We’re sorry for the inconvenience. Please try again later. ',


                  ];
                  return $this->setResponseFormat('json')->respond($response, 200);
              }
          }
      }

      public function getSupport()
      {
          
          if (!$this->request->is('get')) {
              $response = [
                  'status' => 'error',
                  'code' => 405,
                  'message' => 'Method Not Allowed',

              ];
              return $this->setResponseFormat('json')->respond($response, 200);
          }

          if ($this->checkJWT()) {
              return $this->checkJWT();
          }

          $getJwtToken = $this->request->header('token')->getValue();


          $jwtToken = $this->decodejwtToken($getJwtToken);
          $userId = $jwtToken['decodeToken']->data->id;
      

         
          $page    = (int) ($this->request->getGet('page') ?? 1);
          $perPage = 12;
          $next = ($page - 1) * $perPage;
  
          $isData = $this->Home_model->select_data('support_ticket', 'support_id,subject_id,subject,DATE_FORMAT(created_at, "%d-%M-%y %H:%i") AS created_at',
          array("parent_id" => 0,"user_id" =>  $userId),'support_id','DESC','',$perPage,$next);
      

          if (!$isData) {

              $response = [
                  'status' => 'error',
                  'code' => 404,
                  'message' => 'N0 Data found',

              ];
              return $this->setResponseFormat('json')->respond($response, 200);
          }


          $response = [
              'status' => 'success',
              'code' => 200,
              'message' => 'Data',
              'data' => $isData

          ];
          return $this->setResponseFormat('json')->respond($response, 200);
      }

      public function getSupportChat($subject_id)
      {
           
          if (!$this->request->is('get')) {
              $response = [
                  'status' => 'error',
                  'code' => 405,
                  'message' => 'Method Not Allowed',
  
              ];
              return $this->setResponseFormat('json')->respond($response, 200);
          }
  
          if ($this->checkJWT()) {
              return $this->checkJWT();
          }
  
          $getJwtToken = $this->request->header('token')->getValue();
  
  
          $jwtToken = $this->decodejwtToken($getJwtToken);
          $userId = $jwtToken['decodeToken']->data->id;
        //   $subject_id = $this->request->getVar('subject_id');
  
          $page    = (int) ($this->request->getGet('page') ?? 1);
          $perPage = 20;
          $next = ($page - 1) * $perPage;

          $isData = $this->Home_model->select_data('support_ticket', 'support_id,subject_id,message,image,DATE_FORMAT(created_at, "%d-%M-%y %H:%i") AS created_at',
          array("subject_id" => $subject_id,"user_id" =>  $userId),'support_id','ASC','',$perPage,$next);
  
          if (!$isData) {
  
              $response = [
                  'status' => 'error',
                  'code' => 404,
                  'message' => 'N0 Data found',
  
              ];
              return $this->setResponseFormat('json')->respond($response, 200);
          }
  
  
          $response = [
              'status' => 'success',
              'code' => 200,
              'message' => 'Data',
              'data' => $isData
  
          ];
          return $this->setResponseFormat('json')->respond($response, 200);
   }
  
              public function setSupportChat($subject_id)
              {
              
                  if (!$this->request->is('post')) {
                      $response = [
                          'status' => 'error',
                          'code' => 405,
                          'message' => 'Method Not Allowed',
  
                      ];
                      return $this->setResponseFormat('json')->respond($response, 200);
                  }
  
                  if ($this->checkJWT()) {
                      return $this->checkJWT();
                  }
  
                  $getJwtToken = $this->request->header('token')->getValue();
  
  
                  $jwtToken = $this->decodejwtToken($getJwtToken);
                  $userId = $jwtToken['decodeToken']->data->id;
  
                  $image = $this->request->getFile('image');
                 
                  
                 
                  $message = $this->request->getVar('message');
                //   $support_id = $this->request->uri->getVar('subject_id');
  
                  $rules = [
                      'message' => [
                          'label' => 'Message',
                          'rules' => 'trim|required|min_length[1]|max_length[500]',
                          
          
                      ]
          
                  ];
          
                  if (!$this->validate($rules)) {
          
                      $response = [
                          'status' => 'error',
                          'code' => 400,
                          'message' => $this->validator->listErrors('my_list'),
                      ];
                      return $this->setResponseFormat('json')->respond($response, 200);
                  }
                     
                      if($image){
                        $rules = [
                            'image' => [
                                'label' => 'Image',
                                'rules' => 'trim|uploaded[image]|max_size[image, 1000]|ext_in[image,png,jpg,webp,jpeg]|is_image[image]',
                              'errors' => [
                                    'ext_in' => 'Image only allowed is (png,jpg,jpeg,webp)',
                                      'max_size' => 'Max Size of image uploaded is 1MB'
                                  ] 
                            ]
                        ];
                
                        if (!$this->validate($rules)) {
                
                            $response = [
                                'status' => 'error',
                                'code' => 400,
                                'message' => $this->validator->listErrors('my_list'),
                            ];
                            return $this->setResponseFormat('json')->respond($response, 200);
                        }
                           
                        
                          if ($image->isValid() && !$image->hasMoved()) {
                              $newName = $image->getRandomName();
                              $image->move(ROOTPATH . 'public/backend/uploads/users', $newName);
                             
                              $data = [
                                  'file_path' =>  $newName
                              ];
                          } 
                          $insertData['image'] = $data;
                             
                      }
                     
                  
                  $insertData['message'] =  $message;
                  $insertData['parent_id'] =  1;
                  $insertData['subject_id'] =  $subject_id;
                  $insertData['user_id'] =  $userId;
                  $isData = $this->Home_model->save_data('support_ticket', $insertData);
                  if ($isData) {
                      $response = [
                          'status' => 'success',
                          'code' => 201,
                          'message' => 'Your message is succefully send',
      
      
                      ];
                      return $this->setResponseFormat('json')->respond($response, 201);
                  } else {
      
                      $response = [
                          'status' => 'error',
                          'code' => 500,
                          'message' => 'Something went wrong. Please try again later. ',
                      ];
                      return $this->setResponseFormat('json')->respond($response, 200);
                  }
              }
}


