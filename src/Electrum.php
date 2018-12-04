<?php

namespace AraneaDev\Electrum;

use Exception;
use GuzzleHttp\Client;

/**
 * Class Electrum.
 */
class Electrum
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * Electrum constructor.
     */
    public function __construct()
    {
        $host = config('electrum.host', 'http://127.0.0.1');
        $port = config('electrum.port', 7777);

        $this->client = new Client([
            'base_uri' => $host.':'.$port,
        ]);
    }

    /**
     * Get the Electrum version.
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->sendRequest('version');
    }

    /**
     * Get the synchronized status.
     *
     * @return object
     */
    public function isSynchronized()
    {
        return $this->sendRequest('is_synchronized');
    }

    /**
     * Get the total balance.
     *
     * @return object
     */
    public function getBalance()
    {
        return $this->sendRequest('getbalance');
    }

    /**
     * Get balance for address.
     *
     * @param  $address
     * @return object
     */
    public function getAddressBalance($address)
    {
        return $this->sendRequest('getaddressbalance', ['address' => $address]);
    }

    /**
     * Get history for address.
     *
     * @param  $address
     * @return object
     */
    public function getAddressHistory($address)
    {
        return $this->sendRequest('getaddresshistory', ['address' => $address]);
    }

    /**
     * Get unspent for address.
     *
     * @param  $address
     * @return object
     */
    public function getAddressUnspent($address)
    {
        return $this->sendRequest('getaddressunspent', ['address' => $address]);
    }

    /**
     * Check whether address is in wallet.
     *
     * @param  $address
     * @return object
     */
    public function isAddressMine($address)
    {
        return $this->sendRequest('ismine', ['address' => $address]);
    }

    /**
     * Get history of wallet.
     *
     * @return object
     */
    public function getHistory()
    {
        return $this->sendRequest('history');
    }

    /**
     * Create a new payment request.
     *
     * @param  float    $amount
     * @param  string   $memo
     * @param  int      $expiration
     * @return object
     */
    public function createRequest($amount = 0.00, $memo = '', $expiration = 3600)
    {
        return $this->sendRequest('addrequest', [
            'amount'     => $amount,
            'memo'       => $memo,
            'expiration' => $expiration,
        ]);
    }

    /**
     * Get all payment requests.
     *
     * @return object
     */
    public function getRequests()
    {
        return $this->sendRequest('listrequests');
    }

    /**
     * Get a payment request by address.
     *
     * @param  $address
     * @return object
     */
    public function getRequest($address)
    {
        return $this->sendRequest('getrequest', ['key' => $address]);
    }

    /**
     * Clear a payment request by address.
     *
     * @param  $address
     * @return object
     */
    public function clearRequest($address)
    {
        return $this->sendRequest('rmrequest', ['address' => $address]);
    }

    /**
     * Clear all payment requests.
     *
     * @return object
     */
    public function clearRequests()
    {
        return $this->sendRequest('clearrequests');
    }

    /**
     * Validate address.
     *
     * @param  $address
     * @return object
     */
    public function validateAddress($address)
    {
        return $this->sendRequest('validateaddress', ['address' => $address]);
    }

    /**
     * Get all addresses associated with the wallet.
     *
     * @return object
     */
    public function getAddresses()
    {
        return $this->sendRequest('listaddresses');
    }

    /**
     * Get an unused address.
     *
     * @return object
     */
    public function getUnusedAddress()
    {
        return $this->sendRequest('getunusedaddress');
    }

    /**
     * Get transaction details.
     *
     * @param  $txid
     * @return object
     */
    public function getTransaction($txid)
    {
        return $this->sendRequest('gettransaction', ['txid' => $txid]);
    }

    /**
     * Sign a address.
     *
     * @param  $address
     * @return object
     */
    public function signRequest($address)
    {
        return $this->sendRequest('signrequest', ['address' => $address]);
    }

    /**
     * Broadcast a transaction.
     *
     * @param  $tx
     * @return object
     */
    public function broadcast($tx)
    {
        return $this->sendRequest('broadcast', ['tx' => $tx]);
    }

    /**
     * Serialize JSON tx.
     *
     * @param  $json
     * @return object
     */
    public function serialize($json)
    {
        return $this->sendRequest('serialize', ['jsontx' => $json]);
    }

    /**
     * Deserialize JSON tx.
     *
     * @param  $tx
     * @return object
     */
    public function deserialize($tx)
    {
        return $this->sendRequest('deserialize', ['tx' => $tx]);
    }

    /**
     * Encrypt a message.
     *
     * @param  $public_key
     * @param  $message
     * @return object
     */
    public function encrypt($public_key, $message)
    {
        return $this->sendRequest('encrypt', [
            'pubkey'  => $public_key,
            'message' => $message,
        ]);
    }

    /**
     * Decrypt a message.
     *
     * @param  $public_key
     * @param  $encrypted
     * @return object
     */
    public function decrypt($public_key, $encrypted)
    {
        return $this->sendRequest('decrypt', [
            'pubkey'    => $public_key,
            'encrypted' => $encrypted,
        ]);
    }

    /**
     * Check a seed.
     *
     * @param  $seed
     * @return object
     */
    public function checkSeed($seed)
    {
        return $this->sendRequest('check_seed', ['seed' => $seed]);
    }

    /**
     * Create seed.
     *
     * @return object
     */
    public function createSeed()
    {
        return $this->sendRequest('make_seed');
    }

    /**
     * Get seed.
     *
     * @return object
     */
    public function getSeed()
    {
        return $this->sendRequest('getseed');
    }

    /**
     * Freeze an address.
     *
     * @param  $address
     * @return object
     */
    public function freeze($address)
    {
        return $this->sendRequest('freeze', ['address' => $address]);
    }

    /**
     * Get Electrum config value.
     *
     * @param  $key
     * @return object
     */
    public function getConfig($key)
    {
        return $this->SendRequest('getconfig', ['key' => $key]);
    }

    /**
     * Set Electrum config value.
     *
     * @param  $key
     * @param  $value
     * @return object
     */
    public function setConfig($key, $value)
    {
        return $this->sendRequest('setconfig', [
            'key'   => $key,
            'value' => $value,
        ]);
    }

    /**
     * Create a new payment.
     *
     * @param  string   $destination
     * @param  float    $amount
     * @param  string   password
     * @return object
     */
    public function createPayment($destination = '', $amount = 0.00, $password = '')
    {
        return $this->sendRequest('payto', [
            'destination' => $destination,
            'amount'      => $amount,
            'password'    => $password,
        ]);
    }

    /**
     * Sign a transaction.
     *
     * @param  string   $tx
     * @param  string   $password
     * @return object
     */
    public function sign($tx = '', $password = '')
    {
        return $this->sendRequest('signtransaction', [
            'tx'       => $tx,
            'password' => $password,
        ]);
    }

    /**
     * Get the maximumm amount that can be sent.
     *
     * @param  string   $destination
     * @param  string   $password
     * @return object
     */
    public function getmax($destination = '', $password = '')
    {
        return $this->sendRequest('getmax', [
            'destination' => $destination,
            'password'    => $password,
        ]);
    }

    /**
     * Create a wallet.
     *
     * @param  string   $seed
     * @param  string   $password
     * @return object
     */
    public function createWallet($seed = '', $password = '')
    {
        if ('' == $seed) {
            return $this->sendRequest('create_new', [
                'password' => $password,
            ]);
        } else {
            return $this->sendRequest('create_from_seed', [
                'seed'     => $seed,
                'password' => $password,
            ]);
        }
    }

    /**
     * Load a wallet.
     *
     * @param  string   $password
     * @return object
     */
    public function loadWallet($password = '')
    {
        $config = [
            'subcommand' => 'load_wallet',
            'testnet'    => 'True',
            'password'   => $password,
        ];
        return $this->sendRequest('daemon', [
            'config_options' => $config,
        ]);
    }

    /**
     * Create a seed and a key for a multisig wallet
     *
     * @param  string   $seed
     * @return object
     */
    public function createMultisigKey($seed = '')
    {
        if ('' == $seed) {
            return $this->sendRequest('create_new_multisig_key', []);
        } else {
            return $this->sendRequest('create_multisig_key', [
                'seed' => $seed,
            ]);
        }
    }

    /**
     * Create a multisig wallet
     *
     * @param  string   $seed
     * @param  string   $cosignerkey
     * @param  string   $password
     * @return object
     */
    public function createMultisigWallet($seed = '', $cosignerkey = '', $password = '')
    {
        return $this->sendRequest('create_multisig_wallet', [
            'seed'        => $seed,
            'cosignerkey' => $cosignerkey,
            'password'    => $password,
        ]);
    }

    /**
     * Send a request to the Electrum JSON RPC API.
     *
     * @param  $method
     * @param  array       $params
     * @throws Exception
     * @return object
     */
    public function sendRequest($method, $params = [])
    {
        $request = $this->client->request('POST', '/', [
            'json' => [
                'id'     => 'curltext',
                'method' => $method,
                'params' => $params,
            ],
        ]);

        $response = json_decode($request->getBody()->getContents());

        if (isset($response->error)) {
            throw new Exception($response->error->message);
        } else {
            return $response->result;
        }
    }
}
