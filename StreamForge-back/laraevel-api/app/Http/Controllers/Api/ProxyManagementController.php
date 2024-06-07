<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\SSHService;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use function Webmozart\Assert\Tests\StaticAnalysis\length;

class ProxyManagementController extends Controller
{
    public function createProxy($ip, $pass){
        $download_script = 'https://www.dropbox.com/scl/fi/pk3mexbp2iv199fr69bgj/squid-install.sh?rlkey=b61rdcindaxkqy7mc84cjq29k&st=97lk8mws&dl=1&pv=1';

        $download_command = 'wget -O squid-install.sh "'.$download_script.'" && chmod +x squid-install.sh && ./squid-install.sh 190.128.10.147 > /dev/null 2>&1';

        while (true){
            try {
                $sshService = new SSHService($ip, 'root', $pass);
                $output = $sshService->executeCommandos($download_command);
                return response()->json([
                    'success' => true,
                    'message' => 'Successfully logged in and proxy working'
                ], 200);
            }catch (\Exception $exa){
                sleep(5);
            }
        }
        //return response()->json($sshService);
    }

    public function storeVps(){
        $API_KEY = "CLTHSIT76LRQBRFHOQWHK7NJWGMRPCAZBEOQ";
        $regions = [];
        $regions_allowed = ["US", "NL", "FR", "DE", "GB", "ES", "AU", "SE", "CA"];
        $response = Http::get('https://api.vultr.com/v2/regions');
        $data = $response->json();
        foreach ($data['regions'] as $region) {
            if (in_array($region['country'], $regions_allowed)) {
                $regions[] = $region['id'];
            }
        }
        $rand = rand(0,sizeof($regions)-1);

        $region_id = $regions[$rand];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$API_KEY,
        ])->get('https://api.vultr.com/v2/instances');

        $data = $response->json();
        //dd($data);
        //return response()->json($regions[$rand]);

        $payload = [
            "region" => "$region_id",
            "plan" => "vhp-1c-1gb-amd",
            "label" => "test-$rand",
            "os_id" => 1743,
            "user_data" => "QmFzZTY0IEV4YW1wbGUgRGF0YQ==",
            "backups" => "disabled",
            "hostname" => "test-$rand",
            "tags" => []
        ];

        $response = http::withHeaders([
            'Authorization' => 'Bearer '.$API_KEY,
            'Content-Type' => 'application/json',
        ])->post("https://api.vultr.com/v2/instances", $payload);


        if ($response->successful()){
            $data = $response->json();
            $id_instance = $data['instance']['id'];
            $pass_instance = $data['instance']['default_password'];
            do{
                sleep(5);
                $response = http::withHeaders([
                    'Authorization' => 'Bearer '.$API_KEY,
                ])->get("https://api.vultr.com/v2/instances/$id_instance");
                $data = $response->json();
            }while($data['instance']['main_ip'] == "0.0.0.0");
            $ip_instance = $data['instance']['main_ip'];

            $response_create_proxy = $this->createProxy($ip_instance, $pass_instance);

            return response()->json([
                "Instance_id" => $id_instance,
                "Instance_ip" => $data['instance']['main_ip'],
                "Intance_pass" => $pass_instance,
                "Working_proxy" => $response_create_proxy
            ]);
        }else{
            return response()->json([
                'error' => 'Failed to create instances',
                'details' => $response->body()
            ], $response->status());
        }
    }
}
