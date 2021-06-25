<?php

namespace App\Model\User;

use Illuminate\Database\Eloquent\Model;

class UserEarning extends Model
{
    protected $fillable = ['user_id','current_transaction','current_amount','previous_amount','last_transaction'];
}
