<?php
namespace App\Controller;
use \App\Model\User;
use \App\Classes\CryptoManager;
use \App\Controller\BaseController;
use Firebase\JWT\JWT;

class UsersController extends BaseController
{
    public function index($request, $response, $args)
    {
        $users = User::all();
        return $this->view->render($response, 'users.twig.html', [
            'users' => $users
        ]);
        //return $users->toJson();
    }
    
    public function get($request, $response, $args)
    {
        $users = User::find($args['id']);
        return $users->toJson();
    }

    public function getByName($request, $response, $args)
    {
        $users = User::where('user', $args['username'])->first();
        return $users->toJson();
    }
    
    public function getAll($request, $response, $args)
    {
        $users = User::all();
        return $users->toJson();
    }
    
    public function add($request, $response, $args)
    {
        $params = (object) $request->getParams();
        $users = new User(array(
            'user' => $params->user,
        ));
        $logger = $this->logger;
        $logger->info('User Created!', $users->toArray());
        $users->save();
        echo $users->toJson();
    }    
    
    public function change($request, $response, $args)
    {
        $params = (object) $request->getParams();
        $users = User::find($args['id']);

        if(isset($params->user)) $users->user = $params->user;

        $users->save();
        echo $users->toJson();        
    }    
    
    public function remove($request, $response, $args)
    {
        $users = User::find($args['id']);
        if ($users != null){
            $users->destroy($args['id']);
            echo $users->toJson();                    
        }
    }  
    
    public function killSession($request, $response, $args)
    {
        $user = User::where('user', $args['username'])->first();
        $user->session_id = "";
        $user->save();
        echo $user->toJson();        
    }   
    
    public function authenticate($request, $response, $args)
    {
        $key = $this->secretkey;
        $user = User::where("user", $request->getHeader('PHP_AUTH_USER'))->first();
        //print_r($request->getHeader('PHP_AUTH_PW'));
        
        $user->session_id = session_id();
        $user->save();
        
        $token = array(
            $user->toArray(),
        );
        $jwt = JWT::encode($token, $key);
        
        return $response->withJson(["auth-jwt" => $jwt, "user" => $user, "session_id" => $user->session_id], 200)
                        ->withHeader('Content-type', 'application/json');         
    }
    
    
    public function genKeys($request, $response, $args){
        $params = (object) $request->getParams();
        //print_r($request->getAttribute('user_id'));
        
        $crypto = new CryptoManager();
        $keys = $crypto->generateUserKeys($params->password);
        return json_encode($keys);
    }
    
    
    public function updateUserPassword($request, $response, $args){
        $params = (object) $request->getParams();
        //print_r($request->getAttribute('user_id'));
        
        $user = User::find($request->getAttribute('user_id'));
        if ($user != null){
            $keys = json_decode($this->genKeys($request, $response, $args));
            if(isset($params->password)) $user->hash = password_hash($params->password, PASSWORD_DEFAULT);
            
            if(isset($keys->sealed_encryption_key)) $user->user_sealed_encryption_key = $keys->sealed_encryption_key;
            if(isset($keys->pwd_encrypted_pkey)) $user->user_pwd_encrypted_pkey = $keys->pwd_encrypted_pkey;
            if(isset($keys->env_key)) $user->user_env_key = $keys->env_key;

            $user->save();
            return $user->toJson();        
        }
        //return "felipe";
    }
    
    
    public function decrypt($request, $response, $args){
        $user = User::find($request->getAttribute('user_id'));
        if ($user != null){
            
        }
    }
    
}