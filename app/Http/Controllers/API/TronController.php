<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Wallet;

class TronController extends Controller
{

    public function createWallet()
    {
        $fullNode = new \IEXBase\TronAPI\Provider\HttpProvider('https://api.trongrid.io');
        $solidityNode = new \IEXBase\TronAPI\Provider\HttpProvider('https://api.trongrid.io');
        $eventServer = new \IEXBase\TronAPI\Provider\HttpProvider('https://api.trongrid.io');

        try {
          $tron = new \IEXBase\TronAPI\Tron($fullNode, $solidityNode, $eventServer);
        } catch (\IEXBase\TronAPI\Exception\TronException $e) {
          exit($e->getMessage());
        }

        $tron = $tron->createAccount();

        $wallet = new Wallet();
        $wallet->address = $tron['address'];
        $wallet->secret = $tron['privateKey'];
        $wallet->save();

        return response()->json($wallet, 201);
    }


    public function getWalletBalance($address)
    {

    }
}
