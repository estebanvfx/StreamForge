<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\SSHService;
use Illuminate\Http\Request;

class ProxyManagementController extends Controller
{
    public function index(){
        $download_script = 'https://www.dropbox.com/scl/fi/pk3mexbp2iv199fr69bgj/squid-install.sh?rlkey=b61rdcindaxkqy7mc84cjq29k&st=97lk8mws&dl=1&pv=1';

        $download_command = 'wget -O squid-install.sh "'.$download_script.'" && chmod +x squid-install.sh && ./squid-install.sh 190.128.10.147 > /dev/null 2>&1';

        $sshService = new SSHService('209.250.230.203', 'root', 'K6h].WkT(j3Xjnrp');
        $output = $sshService->executeCommandos($download_command);

        return response()->json($output);
    }

}
