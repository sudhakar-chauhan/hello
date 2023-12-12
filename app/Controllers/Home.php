<?php

namespace App\Controllers;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\API\ResponseTrait;
use Config\Services;
use App\Models\Home_model;
use Attribute;


class Home extends BaseController
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




    public function index(): string
    {
        return view('welcome_message');
    }
}
