<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Wallet;

class TronController extends Controller
{
    /**
     * @OA\Post(
     *      path="/create-wallet",
     *      operationId="createWallet",
     *      summary="Create new wallet",
     *      description="Create new wallet and save in database",
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *       )
     *
     *     )
     */
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

    /**
     * @OA\Get(
     *      path="/get-wallet-balance/{address}",
     *      operationId="getWalletBalance",
     *      summary="Get balance of wallet",
     *      description="Returns balance of wallet for the address provided",
     *     @OA\Parameter(
     *         name="address",
     *         in="path",
     *         description="The address of wallet",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       )
     *
     *     )
     */
    public function getWalletBalance($address)
    {
        $fullNode = new \IEXBase\TronAPI\Provider\HttpProvider('https://api.trongrid.io');
        $solidityNode = new \IEXBase\TronAPI\Provider\HttpProvider('https://api.trongrid.io');
        $eventServer = new \IEXBase\TronAPI\Provider\HttpProvider('https://api.trongrid.io');

        try {
          $tron = new \IEXBase\TronAPI\Tron($fullNode, $solidityNode, $eventServer);
        } catch (\IEXBase\TronAPI\Exception\TronException $e) {
          exit($e->getMessage());
        }

        $tron = $tron->getBalance($address, true);

        return response()->json($tron, 200);
    }
}
