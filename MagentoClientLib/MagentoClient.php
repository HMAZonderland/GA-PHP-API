<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 03-05-13
 * Time: 20:07
 * To change this template use File | Settings | File Templates.
 */

class MagentoClient
{

    /**
     * Containing a soapclient
     * @var SoapClient
     */
    private $_client;

    /**
     * Containing the session
     * @var
     */
    private $_session;

    /**
     * Containing api user
     * @var
     */
    private $_apiUser;

    /**
     * Containing api key
     * @var
     */
    private $_apiKey;

    /**
     * Contains the Magento webshop hostname and which API to use
     * @var
     */
    private $_magentoHost;

    /**
     * Sets the vars
     */
    public function __construct($apiUser, $apiKey, $host)
    {

        $this->_apiUser = $apiUser;
        $this->_apiKey = $apiKey;
        $this->_magentoHost = $host;
    }

    /**
     * Connects to the Magento API and sets the session
     */
    public function connect()
    {
        $this->_client = new SoapClient($this->_magentoHost);
        $this->_session = $this->_client->login($this->_apiUser, $this->_apiKey);
    }

    /**
     * Closses the active session
     */
    public function close()
    {
        $this->_client->endSession($this->_session);
    }

    /**
     * Executes a request on the Magento API and gets
     * @param $method
     * @param mixed $arg -> could be an single argument or an array with arguments
     * @return mixed
     */
    private function _call($method, $arg)
    {
        if (isset($arg) && !strlen($arg) > 0) {
            return $this->_client->call($this->_session, $method);
        }
        return $this->_client->call($this->_session, $method, $arg);
    }

    public function getProductInfo($sku){

        return $this->_call('catalog_product.info', $sku);
    }
    public function getProductList(){
        return $this->_call('catalog_product.list', '');
    }
}
