(function() {
    var flagTimer;

    $( "#currencyexchangeratessb-container" ).html( mw.msg( 'currencyexchangeratessb-preload-data' ) );
    $( "#currencyexchangeratessb-container" ).css( 'color', 'black' );
    sendAjax();
    setInterval( sendAjax, mw.config.get( "wgCurrencyExchangeRatesSBTimeReload" ) * 1000 );

    function sendAjax() {
        $.ajax({
            type: "GET",
            // Get API endpoint
            url: mw.util.wikiScript( 'api' ),
            data: {
                action: 'askcurrencyexchangeratessb',
                format: 'json',
            },
            dataType: 'json',
            success: function( response ) {

                if ( 'message' in response.result ) {
                    $( "#currencyexchangeratessb-container" ).html( response.result.message );
                    return;
                }

                let out = '';
                let baseCurrencies = Object.keys( response.result) ;
                for ( let baseCurrency of baseCurrencies ) {
                    out += '<h2>' + mw.msg( 'currencyexchangeratessb-head-table', baseCurrency ) + '</h2>';
                    out += '<table class="wikitable plainlinks"><tr><th></th><th>' + baseCurrency + '</th>';

                    for ( let [ key, value ] of Object.entries( response.result[ baseCurrency ] ) ) {
                        out += '<tr><td>' + key + '</td><td>' + value + '</td></tr>';
                    }
                    out += '</table>';
                }

                $( "#currencyexchangeratessb-container" ).html( out );
                clearInterval( flagTimer );
                $( "#currencyexchangeratessb-timer" ).html( '<span style="color: green">' + mw.msg( 'currencyexchangeratessb-done-to-timer' ) + '</span>' );
                startTimer( mw.config.get("wgCurrencyExchangeRatesSBTimeReload" ) - 1, $( "#currencyexchangeratessb-timer" ) );
            }
        });
    }

    function startTimer( duration, display ) {
        let timer = duration,
            minutes,
            seconds;
        flagTimer = setInterval( function() {
            minutes = parseInt( timer / 60, 10 );
            seconds = parseInt( timer % 60, 10 );

            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            display.html( mw.msg( 'currencyexchangeratessb-timer', minutes, seconds ) );

            if (--timer < 0) {
                clearInterval( flagTimer );
            }
        }, 1000 );
    }
}());