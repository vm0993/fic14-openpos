@extends('template.setup')

@section('title')
Data Usaha & Buat User ::
@parent
@stop


@section('content')
<p>Ini adalah informasi akun yang akan Anda gunakan untuk mengakses situs untuk pertama kalinya.</p>
<form action="{{ route('setup.user.save') }}" method="POST" onkeydown="return event.key != 'Enter';" >
    @csrf
    <div class="col-lg-12" style="padding-top: 4px;">
        <div class="row">
            <div class="col-md-6">
                <div>
                    <div class="text-sm text-danger">Nama Usaha</div>
                    <input type="text" id="nama_perusahaan" name="nama_perusahaan" class="form-control" placeholder="Nama Perusahaan">
                    {!! $errors->first('company_name', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                </div>
            </div>
            <div class="col-md-6">
                <div>
                    <div class="text-sm text-danger">Alamat</div>
                    <input type="text" id="alamat" name="alamat" class="form-control" placeholder="Alamat">
                    {!! $errors->first('address', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div>
                    <div class="text-sm">No Telepon</div>
                    <input type="text" id="no_telepon" name="no_telepon" class="form-control" placeholder="No Telepon">
                </div>
            </div>
            <div class="col-md-6">
                <div>
                    <div class="text-sm">Website Perusahaan</div>
                    <input type="text" id="website" name="website" class="form-control" placeholder="Website ex: https://mykedai.id">
                    {!! $errors->first('website', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                </div>
            </div>
        </div>
        <div class="row">
            <h6 class="card-title mt-1">Data Outlet</h4>
            <div class="col-md-6">
                <div>
                    <div class="text-sm text-danger">Kode Outlet</div>
                    <input type="text" maxlength="6" id="code" name="code" class="form-control" placeholder="Kode Outlet">
                    {!! $errors->first('code', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                </div>
            </div>
            <div class="col-md-6">
                <div>
                    <div class="text-sm text-danger">Nama Outlet</div>
                    <input type="text" id="nama_outlet" name="nama_outlet" class="form-control" placeholder="Nama Outlet">
                    {!! $errors->first('nama_outlet', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div>
                    <div class="text-sm text-danger">Email Outlet</div>
                    <input type="email" id="email_outlet" name="email_outlet" class="form-control" placeholder="Email Outlet">
                    {!! $errors->first('email_outlet', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                </div>
            </div>
            <div class="col-md-6">
                <div>
                    <div class="text-sm">No Telepon Outlet</div>
                    <input type="text" id="telpon_outlet" name="telpon_outlet" class="form-control" placeholder="No.Telepon Outlet">
                </div>
            </div>
        </div>
        <div class="row">
            <h6 class="card-title mt-1">Akses Pengguna</h4>
            <div class="col-md-6">
                <div>
                    <div class="text-sm text-danger">Email Owner</div>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Email Login">
                    {!! $errors->first('email', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                </div>
            </div>
            <div class="col-md-6">
                <div>
                    <div class="text-sm text-danger">Nama Owner</div>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Nama User">
                    {!! $errors->first('name', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div>
                    <div class="text-sm text-danger">Password</div>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Password Login">
                    {!! $errors->first('password', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                </div>
            </div>
            <div class="col-md-6">
                <div>
                    <div class="text-sm text-danger">Konfirmasi Password</div>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Konfirmasi Password">
                    {!! $errors->first('password_confirmation', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                </div>
            </div>
        </div>
    </div>
@stop

@section('button')
    <button type="submit" class="btn btn-info mt-2">Next: Simpan Data</button>
</form>
@parent
@stop
