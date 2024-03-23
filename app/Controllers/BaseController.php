<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

// model
use App\Models\UserModel;
use App\Models\LogAuthModel;


abstract class BaseController extends Controller
{

    protected $request;
    protected $userModel;
    protected $authModel;
    protected $helpers = [];

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
        $this->request = $request; 
        $this->authModel = new LogAuthModel();
        $this->userModel = new UserModel();
    }

    function printJson($status = false, $message = "", $data = []){

        return $this->response->setContentType('application/json')
                                ->setStatusCode(200)
                                ->setJSON([
                                    "status"=>$status,
                                    "message"=>$message,
                                    "data"=> $data
                                ]);
    }


}
