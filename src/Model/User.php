<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Capsule\Manager as DB;

class User extends Model
{
    protected $hidden = array('hash','session_id','user_sealed_encryption_key','user_pwd_encrypted_pkey','user_env_key');
}
