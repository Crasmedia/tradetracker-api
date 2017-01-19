<?php namespace Crasmedia\TradeTracker;

use SoapClient;

class TradeTrackerApi {

	const API_ENDPOINT = 'http://ws.tradetracker.com/soap/affiliate?wsdl';

	/**
	 * @var array
	 */
	private $config = [];

	/**
	 * @var \SoapClient|object
	 */
	protected $tradetracker;

	public function __construct(array $config)
	{
		$this->config = $config;

		$this->tradetracker = new SoapClient(self::API_ENDPOINT, [
			'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP
		]);

		$this->tradetracker->authenticate(
			array_get($this->config, 'key'),
			array_get($this->config, 'secret'),
			array_get($this->config, 'sandbox', true),
			array_get($this->config, 'locale'),
			array_get($this->config, 'demo', true)
		);
	}

	/**
	 * Proxy any non-existent method calls to the SoapClient instance
	 *
	 * @param string $name
	 * @param array $arguments
	 * @return mixed
	 */
	public function __call($name, $arguments = [])
	{
		return call_user_func_array([$this->tradetracker, $name], $arguments);
	}
}