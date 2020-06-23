<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Wallet;

use App\Services\Tron;

class TronController extends Controller
{

    private $tron;

    public function __construct(Tron $tron)
    {
        $this->tron = $tron;
    }

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
        $tron = $this->tron->createTron()->createAccount();

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
        $tron = $this->tron->createTron()->getBalance($address, true);

        return response()->json($tron, 200);
    }
}
