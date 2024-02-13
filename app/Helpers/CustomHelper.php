<?php

use App\Models\Master\Ingradiant;
use App\Models\Master\Item;
use Illuminate\Support\Facades\DB;

function getSetting()
{
    return \App\Models\Sistem\Company::first();
}

function getOutlets()
{
    $results = \App\Models\Master\Outlet::where('status','AKTIF')->get();
    return $results;
}

function getPermission(){
    $results = \App\Models\PermissionGroup::where('status','AKTIF')->get();
    return $results;
}

function getCategorys(){
    $results = \App\Models\Master\Categori::where('status','AKTIF')->get();
    return $results;
}

function getUnits(){
    $results = \App\Models\Master\Unit::where('status','AKTIF')->get();
    return $results;
}

function getRawMaterialItems()
{
    $results = \App\Models\Master\Item::select(DB::raw("id,code,name,sale_amount"))
        ->where('item_sale',0)->get();
    return $results;
}

function getEmployee()
{
    $results = \App\Models\Master\Employee::select(DB::raw("id,code,name"))
        ->where('status','AKTIF')->get();
    return $results;
}

function getPromoType()
{
    $arrayData = [
        'TERBATAS' => 'Terbatas',
        'PERIODE'  => 'Periode',
    ];
    return $arrayData;
}

function getProductType()
{
    $arrayData = [
        'TUNGGAL' => 'SINGLE PRODUCT',
        'KOMPOSISI'  => 'NEED INGRADIANT',
    ];
    return $arrayData;
}

function getUserTypes()
{
    $arrayData = [
        'superuser' => 'Super User',
        'admin'  => 'Admin',
    ];
    return $arrayData;
}

/* Accounting Setup */
function getAccountTypes()
{
    $jenisAkun = array(
        1  => 'Kas/Bank',
        2  => 'Piutang Usaha',
        3  => 'Piutang Non Usaha',
        4  => 'Persediaan',
        5  => 'Aktiva Lancar Lainnya',
        6  => 'Aktiva Tetap',
        7  => 'Akumulasi Depresiasi',
        8  => 'Hutang Usaha',
        9  => 'Hutang Non Usaha',
        10 => 'Hutang Lancar Lainnya',
        11 => 'Hutang Jangka Panjang',
        12 => 'Modal',
        13 => 'Pendapatan',
        14 => 'Harga Pokok Penjualan',
        15 => 'Biaya',
        16 => 'Pendapatan Lain-Lain',
        17 => 'Biaya Lain-Lain',
    );

    return $jenisAkun;
}

/* Inventory */
function getAllPurchaseItems(){
    return Item::select(DB::raw("id,code,name"))->where([
        ['status','AKTIF'],
        ['item_purchase',1]
    ])->get();
}

function getProductNeedRawMaterial(){
    return Item::select(DB::raw("id,code,name"))->where([
        ['status','AKTIF'],
        ['item_sale',1],
        ['item_type','KOMPOSISI'],
    ])->get();
}

function getIngradiants(){
    return Ingradiant::select(DB::raw("id,description,code"))->where([
        ['status','AKTIF'],
    ])->get();
}
/* End Inventory */

/* Global Usage */
function penyebut($nilai)
{
    $nilai = abs($nilai);
    $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    $temp = "";
    if ($nilai < 12) {
        $temp = " " . $huruf[$nilai];
    } else if ($nilai < 20) {
        $temp = penyebut($nilai - 10) . " belas";
    } else if ($nilai < 100) {
        $temp = penyebut($nilai / 10) . " puluh" . penyebut($nilai % 10);
    } else if ($nilai < 200) {
        $temp = " seratus" . penyebut($nilai - 100);
    } else if ($nilai < 1000) {
        $temp = penyebut($nilai / 100) . " ratus" . penyebut($nilai % 100);
    } else if ($nilai < 2000) {
        $temp = " seribu" . penyebut($nilai - 1000);
    } else if ($nilai < 1000000) {
        $temp = penyebut($nilai / 1000) . " ribu" . penyebut($nilai % 1000);
    } else if ($nilai < 1000000000) {
        $temp = penyebut($nilai / 1000000) . " juta" . penyebut($nilai % 1000000);
    } else if ($nilai < 1000000000000) {
        $temp = penyebut($nilai / 1000000000) . " milyar" . penyebut(fmod($nilai, 1000000000));
    } else if ($nilai < 1000000000000000) {
        $temp = penyebut($nilai / 1000000000000) . " trilyun" . penyebut(fmod($nilai, 1000000000000));
    }
    return $temp;
}

function terbilang($nilai)
{
    if ($nilai < 0) {
        $hasil = "minus " . trim(penyebut($nilai));
    } else {
        $hasil = trim(penyebut($nilai));
    }
    return $hasil;
}
