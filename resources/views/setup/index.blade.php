@extends('template.setup')

@section('title')
Cek Persyaratan myKedai ::
@parent
@stop

@section('content')
<p>Halaman ini akan melakukan pemeriksaan sistem untuk memastikan konfigurasi Anda sudah benar. Kami akan menambahkan pengguna pertama Anda di halaman berikutnya.</p>
<table class="table">
    <thead>
        <tr>
            <th class="col-lg-2">Setting</th>
            <th class="col-lg-1">Valid</th>
            <th class="col-lg-9">Catatan</th>
        </tr>
    </thead>
    <tbody>
        <tr {!! ($start_settings['php_version_min']) ? ' class="success"' : ' class="danger"' !!}>
            <td>PHP</td>
            <td style="text-align: center;">
            @if ($start_settings['php_version_min'])
                    <i class="fas fa-check preflight-success"></i>
                @else
                    <i class="fas fa-times preflight-error"></i>
                @endif
            </td>
            <td>
                @if ($start_settings['php_version_min'])
                    Yay!
                @else
                    Oh no!
                @endif
                    Anda menjalankan versi PHP {{ PHP_VERSION }}. ({{ config('app.min_php') }} atau lebih besar diperlukan.)
            </td>
        </tr>
        <tr {!! ($start_settings['url_valid']) ? ' class="success"' : ' class="danger"' !!}>
            <td>URL</td>
            <td style="text-align: center;">
                @if ($start_settings['url_valid'])
                <i class="fas fa-check preflight-success"></i>
                @else
                <i class="fas fa-times preflight-error"></i>
                @endif
            </td>
            <td>
                @if ($start_settings['url_valid'])
                    URL itu sepertinya benar! Kerja bagus!
                @else
                    Uh oh! myKedai mengira URL Anda adalah {{ $start_settings['url_config'] }}, tapi URL asli Anda adalah {{ $start_settings['real_url'] }}
                    Harap perbarui <code>APP_URL</code> pengaturan file anda di <code>.env</code>
                @endif
            </td>
        </tr>
        <tr {!! ($start_settings['db_conn']===true) ? ' class="success"' : ' class="danger"' !!}>
            <td>Database</td>
            <td style="text-align: center;">
                @if ($start_settings['db_conn']===true)
                <i class="fas fa-check preflight-success"></i>
                @else
                <i class="fas fa-times preflight-error"></i>
                @endif
            </td>
            <td>
                @if ($start_settings['db_conn']===true)
                    Kerja bagus! Terhubung dengan <code>{{ $start_settings['db_name'] }}</code>
                @else
                    Ya ampun! Sepertinya kami tidak dapat terhubung ke database Anda. Harap perbarui pengaturan basis data Anda di file <code>.env</code>. Data anda adalah <code>{{ $start_settings['db_error'] }}</code>
                @endif
            </td>
        </tr>
        <tr {!! (!$start_settings['env_exposed']) ? ' class="success"' : ' class="danger"' !!}>
            <td>Config File</td>
            <td style="text-align: center;">
                @if (!$start_settings['env_exposed'])
                <i class="fas fa-check preflight-success"></i>
                @else
                <i class="fas fa-times preflight-error"></i>
                @endif
            </td>
            <td>
                @if (!$start_settings['env_exposed'])
                    Tidak! Ini tidak terlihat seperti milikmu file <code>.env</code> tidak sesuai. (Anda harus memeriksa ulang ini di browser. Anda tidak ingin ada orang yang dapat melihat file itu. Selamanya.) <a href="../../.env">Klik disini untuk mengecek</a> (Ini akan mengembalikan file tidak ditemukan atau kesalahan terlarang.)
                @else
                    Kami tidak dapat menentukan apakah file konfigurasi Anda terekspos ke dunia luar, jadi Anda harus memverifikasinya secara manual. Anda tidak ingin ada orang yang dapat melihat file itu. Pernah. Selamanya. Terkena file <code>.env</code> dapat mengungkapkan data sensitif tentang sistem dan database Anda.
                @endif
            </td>
        </tr>
        <tr {!! ($start_settings['prod']) ? ' class="success"' : ' class="warning"' !!}>
            <td>Environment</td>
            <td style="text-align: center;">
                @if ($start_settings['prod'])
                <i class="fas fa-check preflight-success"></i>
                @else
                <i class="fas fa-times preflight-error"></i>
                @endif
            </td>
            <td>
                @if ($start_settings['prod'])
                    Aplikasi sudah disetel ke mode produksi. Bersiaplah!
                @else
                Aplikasi anda sudah siap <code>{{ $start_settings['env'] }}</code> alihkan ke mode <code>production</code>. Jika Anda tidak berencana mengembangkan myKedai, harap perbarui pengaturan <code>APP_ENV</code> anda di file <code>.env</code> ke <code>production</code>.
                @endif
            </td>
        </tr>
        <tr {!! (!$start_settings['owner_is_admin']) ? ' class="success"' : ' class="danger"' !!}>
            <td>File Owner</td>
            <td style="text-align: center;">
                @if (!$start_settings['owner_is_admin'])
                <i class="fas fa-check preflight-success"></i>
                @else
                <i class="fas fa-times preflight-error"></i>
                @endif
            </td>
            <td>
                @if (!$start_settings['owner_is_admin'])
                    File aplikasi Anda dimiliki oleh <code>{{ $start_settings['owner'] }}</code>. Itu tidak terlihat seperti akun root/admin default. Bagus!
                @else
                    Sepertinya file Anda dimiliki oleh <code>{{ $start_settings['owner'] }}</code>, yang mungkin merupakan akun root/admin. Menjalankan situs web dengan hak istimewa yang lebih tinggi bukanlah ide yang baik.
                @endif
            </td>
        </tr>
        <tr {!! (!$start_settings['writable']) ? ' class="danger"' : ' class="success"' !!}>
            <td>Permissions</td>
            <td style="text-align: center;">
                @if ($start_settings['writable'])
                <i class="fas fa-check preflight-success"></i>
                @else
                <i class="fas fa-times preflight-error"></i>
                @endif
            </td>
            <td>
                @if ($start_settings['writable'])
                    Hura! Direktori penyimpanan aplikasi Anda tampaknya dapat ditulisi.
                @else
                    Oh Tidak. Milikmu <code>{{ storage_path() }}</code> direktori (atau subdirektori di dalamnya) tidak dapat ditulis oleh server web. Direktori tersebut harus dapat ditulis oleh server web agar aplikasi dapat berfungsi.
                @endif
            </td>
        </tr>
        <tr {!! ($start_settings['debug_exposed']) ? ' class="danger"' : ' class="success"' !!}>
            <td>Debug</td>
            <td style="text-align: center;">
                @if (!$start_settings['debug_exposed'])
                <i class="fas fa-check preflight-success"></i>
                @else
                <i class="fas fa-times preflight-error"></i>
                @endif
            </td>
            <td>
                @if (!$start_settings['debug_exposed'])
                    Luar biasa. Debug dinonaktifkan, atau Anda menjalankannya di lingkungan non-produksi. (Jangan lupa mematikannya saat Anda siap untuk mode production.)
                @else
                    Astaga! Anda harus mematikan mode debug kecuali Anda mengalami masalah apa pun. Harap perbarui pengaturan <code>APP_DEBUG</code> Anda di file <code>.env</code> Anda.
                @endif
            </td>
        </tr>
        <tr {!! ($start_settings['gd']) ? ' class="success"' : ' class="warning"' !!}>
            <td>Image Library</td>
            <td style="text-align: center;">
                @if ($start_settings['gd'])
                <i class="fas fa-check preflight-success"></i>
                @else
                <i class="fas fa-times preflight-warning"></i>
                @endif
            </td>
            <td>
                @if ($start_settings['gd'])
                    GD sudah terpasang. Silahkan di lanjutkan!
                @else
                    Library GD tidak diinstal. Meskipun hal ini tidak akan menghalangi sistem untuk bekerja, Anda tidak akan dapat membuat label atau mengunggah gambar.
                @endif
            </td>
        </tr>
        <tr id="mailtestrow" class="warning">
            <td>Email</td>
            <td>
                <a class="btn btn-default btn-sm pull-left" id="mailtest" style="margin-right: 10px;">
                    Send Test
                </a>
            </td>
            <td>
                <span id="mailtesticon"></span>
                <span id="mailtestresult"></span>
                <span id="mailteststatus"></span>
                <div class="col-md-12">
                    <div id="mailteststatus-error" class="text-danger"></div>
                </div>
                <div class="col-md-12">
                    <p class="help-block">
                        Ini akan mencoba mengirim email percobaan ke {{ config('mail.from.address') }}.
                    </p>
                </div>
            </td>
        </tr>
    </tbody>
</table>

@section('button')
    <form action="{{ route('setup.migrate') }}" method="GET">
        <button class="btn btn-primary right">Next: Buat Table Database</button>
    </form>
@parent
@stop

@endsection
@section('footer')
    @push('scripts')
    @endpush
@stop
