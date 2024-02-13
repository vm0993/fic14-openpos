<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Watson\Validating\ValidatingTrait;

class User extends Authenticatable
{
    use ValidatingTrait;
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'activated',
        'permission_group_id',
        'pegawai_id',
        'company_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected $rules = [
        'name'     => 'required|string|min:1|max:191',
        'email'    => 'email|nullable|max:191',
        'password' => 'required|min:8',
    ];

    public function permissionGroup()
    {
        return $this->belongsToMany(PermissionGroup::class, 'permission_group_id');
    }

    public function hasPermission(array $permissions) : bool
    {
        // check if the permission is available in any role
        foreach ($this->permissionGroup as $role) {
            if($role->hasPermission($permissions)) {
                return true;
            }
        }
        return false;
    }

    protected function checkPermissionSection($section)
    {
        $groups = PermissionGroup::find(auth()->user()->permission_group_id);
        $is_user_section_permissions_set = ($groups['permission'] != '') && array_key_exists($section, $groups['permission']);
        //If the user is explicitly granted, return true
        if ($is_user_section_permissions_set && ($groups['permission'][$section] == '1')) {
            return true;
        }
        // If the user is explicitly denied, return false
        if ($is_user_section_permissions_set && ($groups['permission'][$section] == '-1')) {
            return false;
        }

        return false;
    }

    public function hasAccess($section)
    {
        if ($this->isSuperUser()) {
            return true;
        }

        return $this->checkPermissionSection($section);
    }

    public function isSuperUser()
    {
        return $this->checkPermissionSection('superuser');
    }

    public function isActivated()
    {
        return $this->activated == 1;
    }

    public function decodePermissions()
    {
        return json_decode($this->permission, true);
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }
}
