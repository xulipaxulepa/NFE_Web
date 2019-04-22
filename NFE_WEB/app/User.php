<?php

namespace App;

use App\Model\EnterpriseLimit;
use App\Model\Profile;
use App\Model\Role;
use App\Notifications\MyResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'status'
    ];

    public function getProfile()
    {
        return Profile::where('user', $this->id)->first();
    }

//
//    public function rolesSTR()
//    {
//        $role = "";
//        $roles = Role::where('user', $this->id)->get();
//        foreach ($roles as $r) {
//            $role .= $r->level . "; ";
//        }
//        return $role;
//    }

    public function getEnterpriseLimit()
    {
        return EnterpriseLimit::where('user', $this->id)->first();
    }

    public function rolesJumpSTR()
    {
        $role = "";
        $roles = Role::where('user', $this->id)->get();
        foreach ($roles as $r) {
            $role .= $r->level . "\n";
        }
        return $role;
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MyResetPassword($token));
    }

    public function permissionBoolean($roles)
    {
        $role = NULL;
        if (is_array($roles)) {
            $role = Role::whereIn('level', $roles)->where('user', Auth::id())->first();
        } else {
            $role = Role::where('level', $roles)->where('user', Auth::id())->first();
        }
        return !is_null($role);
    }

    public function permission($roles)
    {
        if (is_array($roles)) {
            return $this->checkRoleArray($roles) || abort(401, __("messages.not_permission"));
        }
        return $this->checkRole($roles) || abort(401, __("messages.not_permission"));
    }

    public function checkRoleArray($roles)
    {
        return null !== Role::whereIn('level', $roles)->where('user', Auth::id())->first();
    }

    public function checkRole($role)
    {
        return null !== Role::where('level', $role)->where('user', Auth::id())->first();
    }
}
