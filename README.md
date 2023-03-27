# CurrencyExchangeRatesSB

Installing the extension
<pre>
wfLoadExtension( 'CurrencyExchangeRatesSB' );
</pre>


The page link is overridden by this global variable, by default: <code>CurrencyExchangeRatesSB</code>
<pre>
$wgCurrencyExchangeRatesSBNamePage = "test100500";
</pre>

 Data refresh rate in seconds, by default: <strong>60 </strong>
<pre>$wgCurrencyExchangeRatesSBTimeReload = 10;
</pre>

You can also add additional currency pairs, by default: USD/CZK, EUR/CZK and GBP/CZK
<pre>
$wgCurrencyExchangeRatesSBPairs = [
     "PLN" => [
      "USD",
      "EUR",
      "GBP",
      "AUD"
      ]
   ];
</pre>
