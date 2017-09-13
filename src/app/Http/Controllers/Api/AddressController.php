<?php

namespace AraneaDev\Electrum\App\Http\Controllers\Api;

use AraneaDev\Electrum\Electrum;
use App\Http\Controllers\Controller;

/**
 * Class AddressController
 * @package AraneaDev\Electrum\App\Http\Controllers\Api
 */
class AddressController extends Controller
{
    /** @var Electrum */
    protected $electrum;

    /**
     * AddressController constructor.
     *
     * @param Electrum $electrum
     */
    public function __construct(Electrum $electrum)
    {
        $this->electrum = $electrum;
    }

    /**
     * Get available addresses.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json($this->electrum->getAddresses());
    }

    /**
     * Check if address is in wallet.
     *
     * @param $address
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function is_mine($address)
    {
        return response()->json($this->electrum->isAddressMine($address));
    }

    /**
     * Get an unused address.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function unused()
    {
        return response()->json($this->electrum->getUnusedAddress());
    }

    /**
     * Validate the given address.
     *
     * @param $address
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function check($address)
    {
        return response()->json($this->electrum->validateAddress($address));
    }
}
