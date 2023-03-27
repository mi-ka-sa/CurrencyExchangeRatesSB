<?php

namespace MediaWiki\Extension\CurrencyExchangeRatesSB;

class SpecialCurrencyExchangeRatesSB extends \SpecialPage {

	public function __construct() {

		parent::__construct( 'CurrencyExchangeRatesSB' );
		
	}

	public function execute( $sub ) {

		$config = \RequestContext::getMain()->getConfig();
		$namePage = $config->get( 'CurrencyExchangeRatesSBNamePage' );

		$out = $this->getOutput();

		$out->setPageTitle( $this->msg( 'currencyexchangeratessb-title' ) );
		$out->addWikiMsg( $this->msg( 'currencyexchangeratessb-content' ) );
		$out->addHTML( $this->createLinkHtml( $namePage ) );

	}

	protected function getGroupName() {
		return 'other';
	}

	private function createLinkHtml( string $string ) {
		return '<a href="/index.php/' . $string . '" title="' . $string .'">' . $string .'</a>';
	}
}
