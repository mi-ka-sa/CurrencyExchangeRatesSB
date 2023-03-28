<?php

namespace MediaWiki\Extension\CurrencyExchangeRatesSB;

class Hooks implements 
	\MediaWiki\Hook\BeforeInitializeHook, 
	\MediaWiki\Hook\BeforePageDisplayHook
{

	public function onBeforeInitialize( $title, $unused, $output, $user, $request, $mediaWiki ) {
		
		$config = $output->getConfig();
		$userNamePage = $config->get( 'CurrencyExchangeRatesSBNamePage' );

		// Сheck for the existence of the page is done internally
		Page::create( $userNamePage );

	}

	public function onBeforePageDisplay( $out, $skin ): void {
		
		$title = $out->getTitle()->getText();
		$ourPage = $out->getConfig()->get( 'CurrencyExchangeRatesSBNamePage');
		
		if (strtolower( $title ) == strtolower( $ourPage ) ) {
			$out->addModules( 'ext.CurrencyExchangeRatesSB' );
		}
		
	}
}