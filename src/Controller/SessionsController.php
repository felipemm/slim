<?php
namespace App\Controller;
use \App\Model\Session;
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
        $pkey = $crypto->decrypt($user->user_pwd_encrypted_pkey, $request->getHeader('PHP_AUTH_PW')[0]);
        
        
        //print_r($pkey);
        // print_r($request->getHeader('PHP_AUTH_PW')[0]);
        // print_r($user->user_sealed_encryption_key);
        
        if ($user != null){
            $encryption_key = $crypto->getCryptoKey($user->user_sealed_encryption_key, $user->user_env_key, $pkey);
            echo $encryption_key;
            // $session = new Session(array(
                // 'session_id' => session_id(),
                // 'user_id' => $user->id,
                // 'auth_hash' => $crypto->encrypt($encryption_key, $key)
            // ));
            
            // $session->save();
            // $token = array(
                // $user->toArray(),
            // );
            // $jwt = JWT::encode($token, $key);
            
            // return $response->withJson(["auth-jwt" => $jwt, "user" => $user, "session_id" => $session->session_id], 200)
                            // ->withHeader('Content-type', 'application/json');         
        }
    }
}