<?php

namespace App\Services;

use phpseclib3\Net\SSH2;
class SSHService{
    protected  $ssh;

    public function __construct($host, $username, $password){
        $this->ssh = new SSH2($host);
        if(!$this->ssh->login($username, $password)){
            throw new \Exception('Error while logging in');
        }
    }

    public function executeCommands(array $commands){
        $output = '';

        foreach($commands as $command){
            $output .= $this->ssh->exec($command). "\n";
        }
        return $output;
    }

    public function executeCommandos($command){
        return $this->ssh->exec($command);
    }
}
