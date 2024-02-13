<?php

namespace App\Models\Sistem;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Watson\Validating\ValidatingTrait;

class Company extends Model
{
    use HasFactory;
    use ValidatingTrait;
    protected $guarded = array();

    protected $rules = [
        'company_name' => 'required|string|min:1|max:191',
        'address'      => 'required|nullable|max:191',
        'website'      => 'required|min:4',
    ];

    public static ?self $_cache = null;
    public const SETUP_CHECK_KEY = 'app_setup_check';

    public static function getSettings(): ?self
    {
        if (!self::$_cache) {
            try {
                self::$_cache = self::first();
            } catch (\Throwable $th) {
                return null;
            }
        }
        return self::$_cache;
    }

    public static function setupCompleted(): bool
    {
        try {
            $usercount = User::count();
            $settingsCount = self::count();

            return $usercount > 0 && $settingsCount > 0;
        } catch (\Throwable $th) {
            Log::debug('User table and settings table DO NOT exist or DO NOT have records');
            return false;
        }
    }
}
