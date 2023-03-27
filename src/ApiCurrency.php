<?php

namespace MediaWiki\Extension\CurrencyExchangeRatesSB;

use MediaWiki\MediaWikiServices;

class ApiCurrency extends \ApiBase {

    public function execute() {

		$dataCurrency = self::getDataCurrency();

		$this->getResult()->addValue( null, "result", $dataCurrency );
	}

	private static function getDataCurrency() {

		$config = MediaWikiServices::getInstance()->getConfigFactory()->makeConfig( 'main' );
		$apiKey = $config->get( 'FreeCurrencyApiKey' );
		$currencyPairs = $config->get( 'CurrencyExchangeRatesSBPairs' );

		$serviceUrl = "https://api.freecurrencyapi.com/v1/latest";

		$headers = array(
			"apikey: {$apiKey}",
		);
		

		$params = [];

		foreach ( $currencyPairs as $base => $arrayCurrencies ) {
			$params['base_currency'] = $base;
			$params['currencies'] = implode( ',', $arrayCurrencies );
			
			$url = $serviceUrl . '?' . http_build_query( $params );

			$ch = curl_init();
			curl_setopt( $ch, CURLOPT_URL, $url) ;
			curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
			$response = json_decode( curl_exec( $ch ), true );

			curl_close( $ch );

			if ( array_key_exists( 'message', $response ) ) {
				return $response;
			}

			// Just to save the number of requests to the server
			foreach ( $response['data'] as $currency => $price ) {
				$result[$base][$currency] = round( 1 / $price, 2 );
			}

		}

		return $result;
	}
}
