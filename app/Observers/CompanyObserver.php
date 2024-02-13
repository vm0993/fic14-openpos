<?php

namespace App\Observers;

use App\Models\Sistem\Company;
use Illuminate\Support\Facades\Cache;

class CompanyObserver
{
    public function saved(Company $setting)
    {
        Cache::forget(Company::SETUP_CHECK_KEY);
    }
}
