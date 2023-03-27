<?php

namespace MediaWiki\Extension\CurrencyExchangeRatesSB;

class Module extends \ResourceLoaderFileModule {
	/** @inheritDoc */
	public function getScript( \ResourceLoaderContext $context ) {
		$conf = $this->getConfig();
		return \Xml::encodeJsCall( 'mw.config.set', [ [
			'wgCurrencyExchangeRatesSBNamePage' => $conf->get( 'CurrencyExchangeRatesSBNamePage' ),
			'wgCurrencyExchangeRatesSBPairs' => $conf->get( 'CurrencyExchangeRatesSBPairs' ),
			'wgCurrencyExchangeRatesSBTimeReload' => $conf->get( 'CurrencyExchangeRatesSBTimeReload' ),
			] ] )
			. parent::getScript( $context );
	}

	/** @return bool */
	public function enableModuleContentVersion() {
		return true;
	}

	/** @return bool */
	public function supportsURLLoading() {
		return false;
	}
}
