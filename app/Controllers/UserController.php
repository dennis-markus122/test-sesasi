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


abstract class UserController extends Controller
{

    protected $request;
    protected $userModel;
    protected $authModel;
    protected $helpers = [];

    protected $user;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
        $this->request = $request; 
        $this->authModel = new LogAuthModel();
        $this->userModel = new UserModel();


        $authorizationHeader = $this->request->getHeaderLine('Authorization');
        if (!empty($authorizationHeader)) {
            if (strpos($authorizationHeader, 'Bearer ') === 0) {
                $token = substr($authorizationHeader, 7);
                $data = $this->authModel->getIdUserByAuthorization($token);

                if($data==null){
                    $this->unautorize();
                }else{
                    if($data["status"]){
                        $this->user = $this->userModel->getUserById($data["id_user"]);
                    }else{
                        $this->unautorize();
                    }
                }
            }else{
                $this->unautorize();
            }
        }else{
            $this->unautorize();
        }
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

    function checkRole($role=["USER"]){
        $isValidUser = false;
        foreach ($role as $value) {
            if($this->user["role"] === $value){
                $isValidUser = true;
            }
        }

        if(!$isValidUser){
            $this->unautorize();
        }
    }

    private function unautorize() {
        $response = $this->response->setContentType('application/json')
        ->setStatusCode(401)
        ->setJSON([
            "status" => false,
            "message" => "Unautorize",
            "data" => []
        ]);

        $this->response->send($response);
        exit();
    }
}
