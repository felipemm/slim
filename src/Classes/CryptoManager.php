<?php 
namespace App\Classes;

class CryptoManager {
    
    private $SYMMETRIC_KEY_CIPHER;
    private $SYMMETRIC_KEY_IV_LENGTH;
    private $HMAC_HASH_CIPHER;
    private $PRIVATE_KEYS_CIPHER;
    private $IV_LENGTH;
    
    function __construct($skey_cipher = "AES-128-CBC", $hmac_cipher = "sha256", $pkey_cipher = "AES256", $iv_len = 32){
        $this->SYMMETRIC_KEY_CIPHER = $skey_cipher;
        $this->HMAC_HASH_CIPHER = $hmac_cipher;
        $this->PRIVATE_KEYS_CIPHER = $pkey_cipher;
        $this->IV_LENGTH = $iv_len;
        
        $this->SYMMETRIC_KEY_IV_LENGTH = openssl_cipher_iv_length($this->SYMMETRIC_KEY_CIPHER);
    }
    
    function encrypt($data, $key){
        $iv = openssl_random_pseudo_bytes($this->SYMMETRIC_KEY_IV_LENGTH);
        $ciphertext_raw = openssl_encrypt($data, $this->SYMMETRIC_KEY_CIPHER, $key, OPENSSL_RAW_DATA, $iv);
        $hmac = hash_hmac($this->HMAC_HASH_CIPHER, $ciphertext_raw, $key, true);
        $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );
        return $ciphertext;
    }
    
    function decrypt($data, $key){
        $c = base64_decode($data);
        $iv = substr($c, 0, $this->SYMMETRIC_KEY_IV_LENGTH);
        $hmac = substr($c, $this->SYMMETRIC_KEY_IV_LENGTH, $this->IV_LENGTH);
        $ciphertext_raw = substr($c, $this->SYMMETRIC_KEY_IV_LENGTH + $this->IV_LENGTH);
        $original_plaintext = openssl_decrypt($ciphertext_raw, $this->SYMMETRIC_KEY_CIPHER, $key, OPENSSL_RAW_DATA, $iv);
        $calcmac = hash_hmac($this->HMAC_HASH_CIPHER, $ciphertext_raw, $key, true);
        //print_r($hmac);
        if (hash_equals($hmac, $calcmac)){//PHP 5.6+ timing attack safe comparison
            return $original_plaintext;
        }
        return "";
    }
    
    function generateKey(){
        return base64_encode(openssl_random_pseudo_bytes($this->IV_LENGTH));
    }
    
    function generatePrivateKey(){
        $opk = openssl_pkey_new(array('private_key_bits' => 2048));
        $opk_details = openssl_pkey_get_details($opk);
        $key["public"] = $opk_details['key'];
        openssl_pkey_export($opk, $key["private"]);
        openssl_free_key($opk);
        return $key;
    }
    
    function generateUserKeys($password){
        if($password == ""){
            return false;
        }

        //GENERATE THE SYMMETRIC KEY USED FOR ENCRYPT/DECRYPT THE DATA
        $encryption_key = $this->generateKey();
        
        //GENERATE 2 PRIVATE KEYS: THE FIRST ONE WILL BE ENCRYPTED WITH THE USER PASSWORD AND THE OTHER WILL BE PROVIDED FOR BACKUP IN PLAIN TEXT
        $pk1 = $this->generatePrivateKey();
        $pk2 = $this->generatePrivateKey();

        //SEAL THE ENCRYPTION KEY WITH THE 2 PRIVATE KEYS GENERATED
        openssl_seal($encryption_key, $sealed, $ekeys, array($pk1['public'], $pk2['public']));
        $sealed_key = base64_encode($sealed);

        //ENCRYPT THE PRIVATE KEY 1 USING THE USER PASSWORD
        $encrypted_pkey = $this->encrypt($pk1["private"], $password);

        //VALIDATE THE ENCRYPTED KEY
        if ($pk1['private'] !== $this->decrypt($encrypted_pkey, $password)){
            return false;
        }

        $data = array(
            "encryption_key" => $encryption_key,
            "sealed_encryption_key" => $sealed_key,
            "pwd_encrypted_pkey" => $encrypted_pkey,
            "env_key" => base64_encode($ekeys[0]), //used with private key sealed with password ($encrypted_pkey)
            "backup_key" => array(
                "public_key" => $pk2['public'],
                "private_key" => $pk2['private'],
                "env_key" => base64_encode($ekeys[1]), //used with private key from backup private key ($pk2['private'])
            )
        );
        
        return $data;
    }
    
    function getCryptoKey($sealed_key, $env_key, $private_key){
        //ACCESS THE SEALED ENCRYPTION KEY BY USING EITHER ONE OF THE GENERATED PRIVATE KEYS (PROTECTED BY PASSWORD OR BACKUP PKEY)
        openssl_open(base64_decode($sealed_key), $opened_key, base64_decode($env_key), $private_key);
        return $opened_key;
    }
}