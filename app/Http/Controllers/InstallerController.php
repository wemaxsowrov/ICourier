<?php

namespace App\Http\Controllers;

use App\Http\Requests\Installer\InstallRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use GeoSot\EnvEditor\Facades\EnvEditor;
class InstallerController extends Controller
{
    public function index(){
        return view('installer.index');
    }

    public function installing(InstallRequest $request){
       ini_set('max_execution_time', 900); //900 seconds
       $host           = $request->host;
       $dbuser         = $request->dbuser;
       $dbpassword     = $request->dbpassword;
       $dbname         = $request->dbname;
       $first_name     = $request->first_name;
       $last_name      = $request->last_name;
       $user_name      = $first_name.' '.$last_name;
       $email          = $request->email;
       $login_password = $request->password ? $request->password : "";


        //purchase code verification
        $purchaseVerify = $this->PurchaseVerification($request->purchase_code);  
        if($purchaseVerify != 200):
            return redirect()->back()->withErrors(['purchase_code'=> $purchaseVerify])->withInput($request->all());
        endif; 
        // end purchase code verification 

         // check for valid database connection
        try {
             $mysqli = @new \mysqli($host, $dbuser, $dbpassword, $dbname);
        } catch (\Throwable $th) {
            try {
                    //  set database details
                    $this->envWrite('DB_HOST', $host);
                    $this->envWrite('DB_DATABASE', $dbname);
                    $this->envWrite('DB_USERNAME', $dbuser);
                    $this->envWrite('DB_PASSWORD', $dbpassword);
                    $this->envWrite('APP_INSTALLED', ''); 
                    Artisan::call('config:clear');
                    DB::connection()->getPdo();
            } catch (\Throwable $th) {   
                return redirect()->back()->withErrors(['invalid_db'=>'The database information is Invalid.']);
            }
        }
        if (isset($mysqli) && mysqli_connect_errno()) {
           return redirect()->back()->with('error', 'Please input valid database information.')->withInput($request->all());
        }
        if(isset($mysqli)):
            $mysqli->close();
        endif;

        //check for valid email
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
           return redirect()->back()->with('error', 'Please input a valid email.')->withInput($request->all());
        }
        //  set database details
        $this->envWrite('DB_HOST', $host);
        $this->envWrite('DB_DATABASE', $dbname);
        $this->envWrite('DB_USERNAME', $dbuser);
        $this->envWrite('DB_PASSWORD', $dbpassword);
        $this->envWrite('APP_INSTALLED', '');
        Artisan::call('key:generate');
        Artisan::call('config:clear');
        
        $data = [
            'user_name'     => $user_name,
            'email'         => $email,
            'login_password'=> $login_password
        ];
        return redirect()->route('final',$data);
   }
   public function finish(Request $request){
            DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
                foreach(DB::select('SHOW TABLES') as $table) {
                    $table_array = get_object_vars($table);
                    Schema::drop($table_array[key($table_array)]);
            }
            Artisan::call('migrate:refresh');
            Artisan::call('db:seed'); 
            $user                = User::find(1);
            $user->name          = $request->user_name;
            $user->email         = $request->email;
            $user->password      = bcrypt($request->login_password);
            $user->save();
            $this->envWrite('APP_INSTALLED', 'yes');
            Artisan::call('config:clear');
        
            return redirect('/');
        }
        //env write
        private function envWrite($key,$value)
        {
            if (EnvEditor::keyExists($key)) {
                EnvEditor::editKey($key, '"' . trim($value) . '"');
            } else {
                EnvEditor::addKey($key, '"' . trim($value) . '"');
            }
        }
 
    //purchase code validation
    public function PurchaseVerification($code) { 
        
        try { 
                $personalToken = "V5yV9o9ZkDkdFBIuesLEXqZNANZblTtu";  
                // Surrounding whitespace can cause a 404 error, so trim it first
                $code = trim($code); 
                // Make sure the code looks valid before sending it to Envato
                // This step is important - requests with incorrect formats can be blocked!
                if (!preg_match("/^([a-f0-9]{8})-(([a-f0-9]{4})-){3}([a-f0-9]{12})$/i", $code)) {
                    return "Invalid purchase code";
                }
            
                $ch = curl_init();
                curl_setopt_array($ch, array( 
                    CURLOPT_URL => "https://api.envato.com/v3/market/author/sale?code={$code}", 
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_TIMEOUT => 20,
                    CURLOPT_HTTPHEADER => array(
                        "Authorization: Bearer {$personalToken}",
                        "User-Agent: Purchase code verification script"
                    )
                )); 
                $response     = @curl_exec($ch);
                $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);  
                if (curl_errno($ch) > 0) {
                    return  "Failed to connect: " . curl_error($ch); 
                }  
                switch ($responseCode) {
                    case 404: return "Invalid purchase code";
                    case 403: return "The wemaxdevs token is missing the required permission for this script. Please contact to wemaxdevs.";
                    case 401: return "The wemaxdevs token is missing the required permission for this script. Please contact to wemaxdevs.";
                } 
                if ($responseCode !== 200) {
                   return "Got status {$responseCode}, try again shortly";
                } 
                $body = @json_decode($response); 
                if ($body === false && json_last_error() !== JSON_ERROR_NONE) {
                   return "Error parsing response, try again";
                } 
                if( !empty($response) ):
                    $result = json_decode($response,true);  
                    if(isset($result['buyer']) && isset($result['item']['id'])): 
                        if($result['item']['id'] == '42712610'):
                            return $responseCode;
                        else:
                            return 'Invalid purchase code';
                        endif;
                    endif;
                endif;
                return false;

        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    } 

        
}
