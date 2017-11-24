<?php
namespace App\Controller;
use \App\Model\User;
use \App\Classes\CryptoManager;
use \App\Controller\BaseController;
use Firebase\JWT\JWT;

class SessionsController extends BaseController
{
    public function get($request, $response, $args)
    {
        $session = Session::where('user_id', $request->getAttribute('user_id'))->first();
        return $session->toJson();
    }

    public function destroy($request, $response, $args)
    {
        $session = Session::where('session_id', $args['session_id'])->first();
        if ($session != null){
            $session->delete();
            echo $session->toJson();           
        }
    }  
    
    public function authenticate($request, $response, $args)
    {
        $crypto = new CryptoManager();
        $key = $this->secretkey;
        $user = User::where("user", $request->getHeader('PHP_AUTH_USER'))->first();
        
        if ($user != null){
            $encryption_key = $crypto->decrypt($user->user_sealed_encryption_key, $request->getHeader('PHP_AUTH_PW'));
        
            $session = new Session(array(
                'session_id' => session_id(),
                'user_id' => session_id(),
                'auth_hash' => $crypto->encrypt($encryption_key, $key)
            ));
            
            $session->save();
            $token = array(
                $user->toArray(),
            );
            $jwt = JWT::encode($token, $key);
            
            return $response->withJson(["auth-jwt" => $jwt, "user" => $user, "session_id" => $user->session_id], 200)
                            ->withHeader('Content-type', 'application/json');         
        }
    }
}