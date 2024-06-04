<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\SSHService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use function Webmozart\Assert\Tests\StaticAnalysis\length;

class ProxyManagementController extends Controller
{
    public function createProxy(){
        $download_script = 'https://www.dropbox.com/scl/fi/pk3mexbp2iv199fr69bgj/squid-install.sh?rlkey=b61rdcindaxkqy7mc84cjq29k&st=97lk8mws&dl=1&pv=1';

        $download_command = 'wget -O squid-install.sh "'.$download_script.'" && chmod +x squid-install.sh && ./squid-install.sh 190.128.10.147 > /dev/null 2>&1';

        $sshService = new SSHService('149.248.53.228', 'root', 'Df+9a+tg.?uUC=e?');
        $output = $sshService->executeCommandos($download_command);

        return response()->json($output);
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
        $rand = rand(1,sizeof($regions));

        $region_id = $regions[$rand];


        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$API_KEY,
        ])->get('https://api.vultr.com/v2/instances');

        $data = $response->json();
        dd($data);
        //return response()->json($regions[$rand]);


        $response = Http::post()
    }
}
