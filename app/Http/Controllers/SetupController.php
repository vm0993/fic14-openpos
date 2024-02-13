<?php

namespace App\Http\Controllers;

use App\Core\Interface\SetupInterface;
use App\Helpers\Helper;
use App\Http\Requests\SetupUserRequest;
use App\Models\PermissionGroup;
use App\Models\Sistem\Company;
use App\Models\User;
use App\Response\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Input;

class SetupController extends Controller
{
    use Response;
    private SetupInterface $setup;

    public function __construct(SetupInterface $setup)
    {
        $this->middleware('web');
        $this->setup = $setup;
    }

    public function getSetupIndex()
    {
        //dd(Company::setupCompleted());
        $start_settings['php_version_min'] = false;

        if (version_compare(PHP_VERSION, config('app.min_php'), '<')) {
            return response('<center><h1>This software requires PHP version '.config('app.min_php').' or greater. This server is running '.PHP_VERSION.'. </h1><h2>Please upgrade PHP on this server and try again. </h2></center>', 500);
        }

        try {
            $conn = DB::select('select 2 + 2');
            $start_settings['db_conn'] = true;
            $start_settings['db_name'] = DB::connection()->getDatabaseName();
            $start_settings['db_error'] = null;
        } catch (\PDOException $e) {
            $start_settings['db_conn'] = false;
            $start_settings['db_name'] = config('database.connections.mysql.database');
            $start_settings['db_error'] = $e->getMessage();
        }

        if (array_key_exists("HTTP_X_FORWARDED_PROTO", $_SERVER)) {
            $protocol = $_SERVER["HTTP_X_FORWARDED_PROTO"] . "://";
        } elseif (array_key_exists('HTTPS', $_SERVER) && ('on' == $_SERVER['HTTPS'])) {
            $protocol = "https://";
        } else {
            $protocol = "http://";
        }

        if (array_key_exists("HTTP_X_FORWARDED_HOST", $_SERVER)) {
            $host = $_SERVER["HTTP_X_FORWARDED_HOST"];
        } else {
            $host = array_key_exists('SERVER_NAME', $_SERVER) ? $_SERVER['SERVER_NAME'] : null;
            $port = array_key_exists('SERVER_PORT', $_SERVER) ? $_SERVER['SERVER_PORT'] : null;
            if (('http://' === $protocol && '80' != $port) || ('https://' === $protocol && '443' != $port)) {
                $host .= ':'.$port;
            }
        }
        $pageURL = $protocol.$host.$_SERVER['REQUEST_URI'];

        $start_settings['url_config'] = config('app.url').'/setup';
        $start_settings['url_valid'] = ($start_settings['url_config'] === $pageURL);
        $start_settings['real_url'] = $pageURL;
        $start_settings['php_version_min'] = true;

        // Curl the .env file to make sure it's not accessible via a browser
        $ch = curl_init($protocol.$host.'/.env');
        curl_setopt($ch, CURLOPT_HEADER, true);    // we want headers
        curl_setopt($ch, CURLOPT_NOBODY, true);    // we don't need body
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $output = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if (404 == $httpcode || 403 == $httpcode || 0 == $httpcode) {
            $start_settings['env_exposed'] = false;
        } else {
            $start_settings['env_exposed'] = true;
        }

        if (App::Environment('production') && (true == config('app.debug'))) {
            $start_settings['debug_exposed'] = true;
        } else {
            $start_settings['debug_exposed'] = false;
        }

        $environment = app()->environment();
        if ('production' != $environment) {
            $start_settings['env'] = $environment;
            $start_settings['prod'] = false;
        } else {
            $start_settings['env'] = $environment;
            $start_settings['prod'] = true;
        }

        $start_settings['owner'] = '';

        if (function_exists('posix_getpwuid')) { // Probably Linux
            $owner = posix_getpwuid(fileowner($_SERVER['SCRIPT_FILENAME']));
            // This *should* be an array, but we've seen this return a bool in some chrooted environments
            if (is_array($owner)) {
                $start_settings['owner'] = $owner['name'];
            }
        }

        if (($start_settings['owner'] === 'root') || ($start_settings['owner'] === '0')) {
            $start_settings['owner_is_admin'] = true;
        } else {
            $start_settings['owner_is_admin'] = false;
        }

        if ((is_writable(storage_path()))
            && (is_writable(storage_path().'/framework'))
            && (is_writable(storage_path().'/framework/cache'))
            && (is_writable(storage_path().'/framework/sessions'))
            && (is_writable(storage_path().'/framework/views'))
            && (is_writable(storage_path().'/logs'))
        ) {
            $start_settings['writable'] = true;
        } else {
            $start_settings['writable'] = false;
        }

        $start_settings['gd'] = extension_loaded('gd');

        return view('setup/index')
            ->with('step', 1)
            ->with('start_settings', $start_settings)
            ->with('section', 'Cek Konfigurasi');
    }

    public function getSetupMigrate()
    {
        Artisan::call('migrate', ['--force' => true]);

        $output = Artisan::output();
        //start seeder
        $permissions     = config('permission');
        $userPermissions = Helper::selectedPermissionsArray($permissions, []);
        $varArray = [];
        foreach ($userPermissions as $key => $permissionArray) {
            $varArray[]  = [
               $key => $key == 'admin' || $key == 'cashier' || $key == 'waiter' ? 0 : 1,
            ];
        }
        $group = [
            'name'       => 'Owner',
            'permission' => call_user_func_array('array_merge', $varArray),
        ];
        PermissionGroup::create($group);
        //end call seeder
        return view('setup/migrate')
        ->with('output', $output)
        ->with('step', 2)
        ->with('section', 'Buat Table Database');
    }

    private function filterDisplayable($permissions)
    {
        $output = null;
        foreach ($permissions as $key => $permission) {
            $output[$key] = array_filter($permission, function ($p) {
                return $p['display'] === true;
            });
        }

        return $output;
    }

    public function getSetupUser()
    {
        return view('setup/user')
        ->with('step', 3)
        ->with('section', 'Data Usaha & Buat User');
    }

    public function postSaveFirstUser(Request $request)
    {
        $result = $this->setup->prepareProfileUsahaAndUser($request);
        if ((!$result['user']->isValid()) || (!$result['settings']->isValid())) {
            return redirect()->back()->withInput()->withErrors($result['user']->getErrors())->withErrors($result['settings']->getErrors());
        } else {
            $valid = true;
            DB::beginTransaction();
            try {
                $user = $this->setup->storeProfileUsahaAndUser($valid, $request);
                DB::commit();
                Auth::login($user,true);
                return redirect()->route('setup.done');
            } catch (\Throwable $th) {
                DB::rollBack();
                return redirect()->back()->withInput()->withErrors($th->getMessage());
            }
        }
    }

    public function getSetupDone()
    {
        return view('setup/done')
        ->with('step', 4)
        ->with('section', 'Selesai!');
    }
}
