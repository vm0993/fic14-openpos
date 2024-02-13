<?php

namespace App\Core\Repository\Settings;

use App\Core\Interface\Settings\CompanyInterface;
use App\Models\Sistem\Company;

class CompanyRepository implements CompanyInterface
{
    public function getCompany()
    {
        $result = Company::first();
        return $result;
    }

    public function createCompany($request)
    {
        $rateSC  = preg_replace( '/[^0-9.]/', '', $request->service_charges_rate);
        $ratePB1 = preg_replace( '/[^0-9.]/', '', $request->resto_tax_rate);
        $data =[
            'company_name'               => $request->company_name,
            'address'                    => $request->address,
            'phone_no'                   => $request->phone_no,
            'website'                    => $request->website,
            'register_email'             => $request->register_email,
            'service_charges_rate'       => $rateSC,
            'service_charges_account_id' => $request->service_charges_account_id,
            'resto_tax_rate'             => $ratePB1,
            'resto_tax_account_id'       => $request->resto_tax_account_id,
        ];
        return Company::create($data);
    }

    public function updateCompany($request, $id)
    {
        $result = Company::find($id);
        $rateSC = preg_replace( '/[^0-9.]/', '', $request->service_charges_rate);
        $ratePB1 = preg_replace( '/[^0-9.]/', '', $request->resto_tax_rate);
        $data =[
            'company_name'               => $request->company_name,
            'address'                    => $request->address,
            'phone_no'                   => $request->phone_no,
            'website'                    => $request->website,
            'register_email'             => $request->register_email,
            'service_charges_rate'       => $rateSC,
            'service_charges_account_id' => $request->service_charges_account_id,
            'resto_tax_rate'             => $ratePB1,
            'resto_tax_account_id'       => $request->resto_tax_account_id,
        ];
        $result->update($data);
        return $result;
    }
}
