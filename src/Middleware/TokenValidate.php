<?php

namespace App\Middleware;
use Firebase\JWT\JWT;
use \App\Model\User;
use \App\Model\Session;

class TokenValidate
{
    private $container;

    public function __construct($container) {
        $this->container = $container;
    }
    
    public function __invoke($request, $response, $next)
    {
        $resourceUri = $request->getUri()->getPath();
        //print_r(strtolower(trim(str_replace("/","",$resourceUri))));
        //print_R($this->container->get('settings')['authRoute']);
        
        $requestUri = strtolower(trim(str_replace("/","",$resourceUri)));
        $authUri = strtolower(trim(str_replace("/","",$this->container->get('settings')['authRoute'])));
        
        //print_r($requestUri);
        //print_r($authUri);
        
        if(strpos($requestUri, $authUri) === false && $requestUri != ""){
            $result = $this->validate($request);
            if ($result == false) {
                $message = [
                    'success' => false,
                    'message' => 'Not allowed '//.$resourceUri
                ];
                $response = $response->withHeader('Content-type', 'application/json');
                $response = $response->withStatus(403);
                $body = $response->getBody();
                $body->write(json_encode($message));

                return $response;
            }            
        }
        
        // Allowed, continue with the execution
        $response = $next($request->withAttribute("user_id",$this->getUserId($request)), $response);
        // $response = $next($request, $response);
        return $response;
    }
    
    
    public function getUserId($request){
        if ($request->hasHeader('X-Token')) {
            $xToken = $request->getHeader('X-Token')[0];
                
            $app = $this->container["secretkey"];
            $decoded = JWT::decode($xToken, $this->container["secretkey"], array('HS256'));
            
            echo $tokenUser->user;
            
            $tokenUser = $decoded[0];
            $user = User::where("user", $tokenUser->user)->first();
            if ($user->count() == 1){
                return $user->id;
            }
        }
        return false;
    }
    
    public function validate($request)
    {
        //if ($request->hasHeader('Authorization')) return true;
        //echo $request->getHeader('X-Token')[0];
        if ($request->hasHeader('X-Token')) {
            // Get the headers
            $xToken = $request->getHeader('X-Token')[0];
            
            $app = $this->container["secretkey"];
            $decoded = JWT::decode($xToken, $this->container["secretkey"], array('HS256'));
            
            $tokenUser = $decoded[0];
            $user = User::where("user", $tokenUser->user)->first();
            if ($user->count() == 1){
                $body = (string)$request->getBody()->getContents();
                //print_r($body);
                
                if ($request->hasHeader('X-Token-Hash')){
                    $session = Session::where("user_id", $user->id)->orderBy('created_at', 'desc')->first();
                    //print_r($session);
                    $xTokenHash = $request->getHeader('X-Token-Hash')[0];
                    $time = gmdate('ymdHi');
                    $messageHash = hash_hmac('SHA512', $body, $session->session_id . $time);
                    
                    // echo $user->session_id;
                    // echo "\n";
                    // echo $time;
                    // echo "\n";
                    // echo $body;
                    // echo "\n";
                    // echo $xTokenHash;
                    // echo "\n";
                    // echo $messageHash;
                    // echo "\n";
                    // echo "\n";
                    
                    if ($messageHash === $xTokenHash) {
                        return true;
                    }                
                }
            }
        }
        return false;
    }
}
?>