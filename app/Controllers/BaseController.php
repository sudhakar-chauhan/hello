<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
    }




/* ======================================================= 
custom Function User in Controller 


    # Encript Password
    # Sanitize 
    # Create Slug 
    # Send Email
    # backend all page data 
=============================================================  */ 
    function __encrip_password($password)
    {
        return $hashInput =  password_hash($password, PASSWORD_BCRYPT);
    }
    public function sanitize($data)
    {
        $data = trim($data);
        $data  =  strip_tags($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    public function createSlug($str, $delimiter = '-')
    {
        $slug = strtolower(trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z0-9-]+/', $delimiter, preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $str))))), $delimiter));
        return $slug;
    }
   public function sendEmail($receiver_email, $subject, $message)
   {

       $email = \Config\Services::email();
       $email->setTo($receiver_email);
       $email->setFrom(ADMIN_EMAIL, ADMIN_NAME);
       $email->setSubject($subject);
       $email->setMessage($message);
       if ($email->send()) {
                       return true;
       } else {

           return false;
       }
   } 

   function backendAllPages(){
    $data ['notification'] = $this->Admin_model->select_orders_notfication();
    $data['headerLinks'] = $this->Home_model->select_data('header','*',array(
        'location'=> 'link'
    ));
    return $data;
}

}





