<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Movement extends Model
{
    public $incrementing = false;
    public $primaryKey = 'timestamp';
    public $timestamps = false;
    protected $fillable = ['timestamp', 'receiver_account_id', 'maker_account_id', 'ip', 'privilege_id'];

    public function receiver_account() {
    	return $this->belongsTo(Account::class, 'receiver_account_id', 'account_id');
    }

    public function maker_account() {
    	return $this->belongsTo(Account::class, 'maker_account_id', 'account_id');
    }

    public function privilege() {
    	return $this->belongsTo(Privilege::class, 'privilege_id');
    }

    public function buildByAccounts($maker, $receiver, $privilege) {
        $this->maker_account_id = $maker->account_id;
        $this->receiver_account_id = $receiver->account_id;
        $this->privilege_id = $privilege->privilege_id;
        return $this;
    }

    public static function register($maker_account, $receiver_account, $action_name) {
        $privilege_id = config('constants.' . $action_name);
        return Movement::create(['maker_account_id' => $maker_account->account_id, 
                                 'receiver_account_id' => ($receiver_account !== null ? $receiver_account->account_id : null), 
                                 'ip' => request()->ip(), 'privilege_id' => $privilege_id, 
                                 'timestamp' => new Carbon()]);
    }
}
