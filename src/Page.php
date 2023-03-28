<?php

namespace MediaWiki\Extension\CurrencyExchangeRatesSB;

use MediaWiki\MediaWikiServices;
use MediaWiki\Revision\SlotRecord;

class Page {

    public static function create( string $name ): bool {

        $pageTitle = \Title::newFromText( $name );

		if ( $pageTitle->exists() ) {
			return false;
		}

		if ( method_exists( MediaWikiServices::class, 'getWikiPageFactory' ) ) {
			// MW 1.36+
			$page = MediaWikiServices::getInstance()->getWikiPageFactory()->newFromTitle( $pageTitle );
		} else {
			$page = new WikiPage( $pageTitle );
		}

		$updater = $page->newPageUpdater( \RequestContext::getMain()->getUser() );
		
		$pageContent = \ContentHandler::makeContent( self::putContent(), $pageTitle );
		
		$updater->setContent( SlotRecord::MAIN, $pageContent );
		
		$edit_summary = \CommentStoreComment::newUnsavedComment( 'create page' );
		
		$updater->saveRevision( $edit_summary, EDIT_NEW );

        return true;
    }

    public static function putContent () {

        return \Xml::element(
            'div',
            [ 'id' => 'currencyexchangeratessb-timer' ],
        ) . \Xml::closeElement( 'div' ) .
            \Xml::element(
            'div',
            [ 'id' => 'currencyexchangeratessb-container' ],
            \RequestContext::getMain()->msg( 'currencyexchangeratessb-conten-for-new-page' )
        );
        
    }
}
