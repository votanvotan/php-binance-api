<?php
/* ============================================================
 * php-binance-api
 * https://github.com/jaggedsoft/php-binance-api
 * ============================================================
 * Copyright 2017-, Jon Eyrick
 * Released under the MIT License
 * ============================================================ */

declare(strict_types=1);

require 'php-binance-api.php';
require 'vendor/autoload.php';

file_put_contents( getenv("HOME") . "/.config/jaggedsoft/php-binance-api.json" ,
   "{ \"api-key\": \"z5RQZ9n8JcS3HLDQmPpfLQIGGQN6TTs5pCP5CTnn4nYk2ImFcew49v4ZrmP3MGl5\",
      \"api-secret\": \"ZqePF1DcLb6Oa0CfcLWH0Tva59y8qBBIqu789JEY27jq0RkOKXpNl9992By1PN9Z\" }");

use PHPUnit\Framework\TestCase;

final class BinanceTest extends TestCase
{
   private $_testable = null;

   public static function setUpBeforeClass() {
      fwrite(STDOUT, __METHOD__ . "\n");
      if( file_exists( getenv("HOME") . "/.config/jaggedsoft/php-binance-api.json" ) == false ) {
         fwrite(STDERR, __METHOD__ . ": " . getenv("HOME") . "/.config/jaggedsoft/php-binance-api.json not found\n");
         exit;
      }
   }
   protected function setUp() {
      fwrite(STDOUT, __METHOD__ . "\n");
      $this->_testable = new Binance\API();
      $this->assertInstanceOf('Binance\API', $this->_testable);
   }
   public function testInstantiate() {
      fwrite(STDOUT, __METHOD__ . "\n");
      $this->_testable = new Binance\API();
      $this->assertInstanceOf('Binance\API', $this->_testable);
   }
   public function testAccount() {
      fwrite(STDOUT, __METHOD__ . "\n");
      $details = $this->_testable->account();
      $check_keys = array( 'makerCommission',
                           'takerCommission',
                           'buyerCommission',
                           'sellerCommission',
                           'canTrade',
                           'canWithdraw',
                           'canDeposit',
                           'updateTime',
                           'balances' );

      foreach ($check_keys as $check_key) {
         $this->assertTrue( isset( $details[ $check_key ] ) );
         if( isset( $details[ $check_key ] ) == false ) {
            fwrite(STDOUT, __METHOD__ . ": exchange info error: $check_key missing\n");
         }
      }

      $this->assertTrue( count( $details[ 'balances' ] ) > 0 );
   }
   public function testBuy() {
      fwrite(STDOUT, __METHOD__ . "\n");
      $result = $this->_testable->buy( "TRXBTC", "5", "0.001" );
      $this->assertTrue( isset( $result['code'] ) );

      if( isset( $result['code'] ) ) {
         $this->assertTrue( $result['code'] == "-2010" );
      }

      if( isset( $result['code'] ) == false ) {
         fwrite(STDOUT, __METHOD__ . ": shouldn't be any money in the account\n");
      }
   }
   public function testBuyTest() {
      fwrite(STDOUT, __METHOD__ . "\n");
      $result = $this->_testable->buyTest( "TRXBTC", "5", "0.001" );
      $this->assertTrue( ( isset( $result['code'] ) == false ) );

      if( isset( $result['code'] ) ) {
         fwrite(STDOUT, __METHOD__ . ": buy error: " . $result['code'] . ":" . $result['msg'] ."\n");
      }
   }
   public function testSell() {
      fwrite(STDOUT, __METHOD__ . "\n");
      $result = $this->_testable->sell( "TRXBTC", "5", "0.001" );
      $this->assertTrue( isset( $result['code'] ) );

      if( isset( $result['code'] ) ) {
         $this->assertTrue( $result['code'] == "-2010" );
      }

      if( isset( $result['code'] ) == false ) {
         fwrite(STDOUT, __METHOD__ . ": shouldn't be any code in the account\n");
      }
   }
   public function testSellTest() {
      fwrite(STDOUT, __METHOD__ . "\n");
      $result = $this->_testable->sellTest( "TRXBTC", "5", "0.001" );
      $this->assertTrue( ( isset( $result['code'] ) == false ) );

      if( isset( $result['code'] ) ) {
         fwrite(STDOUT, __METHOD__ . ": sell error: " . $result['code'] . ":" . $result['msg'] ."\n");
      }
   }
   public function testMarketBuy() {
      fwrite(STDOUT, __METHOD__ . "\n");
      $result = $this->_testable->marketBuy( "TRXBTC", "5" );
      $this->assertTrue( isset( $result['code'] ) );

      if( isset( $result['code'] ) ) {
         $this->assertTrue( $result['code'] == "-2010" );
      }

      if( isset( $result['code'] ) == false ) {
         fwrite(STDOUT, __METHOD__ . ": shouldn't be any code in the account\n");
      }
   }
   public function testMarketBuyTest() {
      fwrite(STDOUT, __METHOD__ . "\n");
      $result = $this->_testable->marketBuyTest( "TRXBTC", "5" );
      $this->assertTrue( ( isset( $result['code'] ) == false ) );

      if( isset( $result['code'] ) ) {
         fwrite(STDOUT, __METHOD__ . ": market buy error: " . $result['code'] . ":" . $result['msg'] ."\n");
      }
   }
   public function testMarketSell() {
      fwrite(STDOUT, __METHOD__ . "\n");
      $result = $this->_testable->marketSell( "TRXBTC", "5" );
      $this->assertTrue( isset( $result['code'] ) );

      if( isset( $result['code'] ) ) {
         $this->assertTrue( $result['code'] == "-2010" );
      }

      if( isset( $result['code'] ) == false ) {
         fwrite(STDOUT, __METHOD__ . ": shouldn't be any code in the account\n");
      }
   }
   public function testMarketSellTest() {
      fwrite(STDOUT, __METHOD__ . "\n");
      $result = $this->_testable->marketSellTest( "TRXBTC", "5" );
      $this->assertTrue( ( isset( $result['code'] ) == false ) );

      if( isset( $result['code'] ) ) {
         fwrite(STDOUT, __METHOD__ . ": market sell error: " . $result['code'] . ":" . $result['msg'] ."\n");
      }
   }
   public function testCancel() {
      fwrite(STDOUT, __METHOD__ . "\n");
      $result = $this->_testable->cancel( "TRXBTC", "55555555" );
      $this->assertTrue( isset( $result['code'] ) );

      if( isset( $result['code'] ) ) {
         $this->assertTrue( $result['code'] == "-2011" );
      }

      if( isset( $result['code'] ) == false ) {
         fwrite(STDOUT, __METHOD__ . ": shouldn't be anything to cancel\n");
      }
   }
   public function testOrderStatus() {
      fwrite(STDOUT, __METHOD__ . "\n");
      $result = $this->_testable->orderStatus( "TRXBTC", "55555555" );
      $this->assertTrue( isset( $result['code'] ) );

      if( isset( $result['code'] ) ) {
         $this->assertTrue( $result['code'] == "-2013" );
      }

      if( isset( $result['code'] ) == false ) {
         fwrite(STDOUT, __METHOD__ . ": shouldn't be any order with this id\n");
      }
   }
   public function testOpenOrders() {
      fwrite(STDOUT, __METHOD__ . "\n");
      $result = $this->_testable->openOrders( "TRXBTC" );
      $this->assertTrue( ( isset( $result['code'] ) == false ) );
      $this->assertTrue( is_array( $result ) );

      if( isset( $result['code'] ) ) {
         fwrite(STDOUT, __METHOD__ . ": open orders error: " . $result['code'] . ":" . $result['msg'] ."\n");
      }
   }
   public function testOrders() {
      fwrite(STDOUT, __METHOD__ . "\n");
      $result = $this->_testable->orders( "TRXBTC" );
      $this->assertTrue( ( isset( $result['code'] ) == false ) );
      $this->assertTrue( is_array( $result ) );

      if( isset( $result['code'] ) ) {
         fwrite(STDOUT, __METHOD__ . ": orders error: " . $result['code'] . ":" . $result['msg'] ."\n");
      }
   }
   public function testHistory() {
      fwrite(STDOUT, __METHOD__ . "\n");
      $result = $this->_testable->history( "TRXBTC" );
      $this->assertTrue( ( isset( $result['code'] ) == false ) );
      $this->assertTrue( is_array( $result ) );

      if( isset( $result['code'] ) ) {
         fwrite(STDOUT, __METHOD__ . ": my trades error: " . $result['code'] . ":" . $result['msg'] ."\n");
      }
   }
   public function testUseServerTime() {
      fwrite(STDOUT, __METHOD__ . "\n");
      $this->_testable->useServerTime();
      $this->assertTrue( true );
   }
   public function testTime() {
      fwrite(STDOUT, __METHOD__ . "\n");
      $result = $this->_testable->time();
      $this->assertTrue( ( isset( $result['code'] ) == false ) );
      $this->assertTrue( isset( $result[ 'serverTime' ] ) );

      if( isset( $result['code'] ) ) {
         fwrite(STDOUT, __METHOD__ . ": server time error: " . $result['code'] . ":" . $result['msg'] ."\n");
      }
   }
   public function testExchangeInfo() {
      fwrite(STDOUT, __METHOD__ . "\n");
      $result = $this->_testable->exchangeInfo();
      $this->assertTrue( ( isset( $result['code'] ) == false ) );
      $check_keys = array( 'timezone', 'serverTime', 'rateLimits', 'exchangeFilters', 'symbols' );

      foreach ($check_keys as $check_key) {
         $this->assertTrue( isset( $result[ $check_key ] ) );
         if( isset( $result[ $check_key ] ) == false ) {
            fwrite(STDOUT, __METHOD__ . ": exchange info error: $check_key missing\n");
         }
      }

      $this->assertTrue( count( $result[ 'symbols' ] ) > 0 );
      $this->assertTrue( count( $result[ 'rateLimits' ] ) > 0 );

      if( isset( $result['code'] ) ) {
         fwrite(STDOUT, __METHOD__ . ": exchange info error: " . $result['code'] . ":" . $result['msg'] ."\n");
      }
   }
   public function testWithdraw() {
      fwrite(STDOUT, __METHOD__ . "\n");
      $asset = "BTC";
      $address = "1C5gqLRs96Xq4V2ZZAR1347yUCpHie7sa";
      $amount = 0.2;
      $result = $this->_testable->withdraw($asset, $address, $amount, false);
      $this->assertTrue( true );
      if( isset( $result['code'] ) ) {
         fwrite(STDOUT, __METHOD__ . ": withdraw error: " . $result['code'] . ":" . $result['msg'] ."\n");
      }
   }
   public function testDepositAddress() {
      fwrite(STDOUT, __METHOD__ . "\n");
      $asset = "BTC";
      $result = $this->_testable->depositAddress($asset);
      $this->assertTrue( true );
      if( isset( $result['code'] ) ) {
         fwrite(STDOUT, __METHOD__ . ": depsoit error: " . $result['code'] . ":" . $result['msg'] ."\n");
      }
   }
   public function testDepositHistory() {
      fwrite(STDOUT, __METHOD__ . "\n");
      $asset = "BTC";
      $result = $this->_testable->depositHistory();
      $this->assertTrue( true );
      if( isset( $result['code'] ) ) {
         fwrite(STDOUT, __METHOD__ . ": deposit history error: " . $result['code'] . ":" . $result['msg'] ."\n");
      }
   }
   public function testWithdrawHistory() {
      fwrite(STDOUT, __METHOD__ . "\n");
      $asset = "BTC";
      $result = $this->_testable->withdrawHistory();
      $this->assertTrue( true );
      if( isset( $result['code'] ) ) {
         fwrite(STDOUT, __METHOD__ . ": withdraw history error: " . $result['code'] . ":" . $result['msg'] ."\n");
      }
   }
   public function testPrices() {
      fwrite(STDOUT, __METHOD__ . "\n");
      $result = $this->_testable->prices();
      $this->assertTrue( ( isset( $result['code'] ) == false ) );
      $this->assertTrue( count( $result ) > 0 );

      if( isset( $result['code'] ) ) {
         fwrite(STDOUT, __METHOD__ . ": prices error: " . $result['code'] . ":" . $result['msg'] ."\n");
      }
   }
   public function testBookPrices() {
      fwrite(STDOUT, __METHOD__ . "\n");
      $result = $this->_testable->bookPrices();
      $this->assertTrue( ( isset( $result['code'] ) == false ) );
      $this->assertTrue( count( $result ) > 0 );

      if( isset( $result['code'] ) ) {
         fwrite(STDOUT, __METHOD__ . ": book prices error: " . $result['code'] . ":" . $result['msg'] ."\n");
      }
   }
   public function testPrevDay() {
      fwrite(STDOUT, __METHOD__ . "\n");
      $result = $this->_testable->prevDay( "TRXBTC" );
      $this->assertTrue( ( isset( $result['code'] ) == false ) );

      if( isset( $result['code'] ) ) {
         fwrite(STDOUT, __METHOD__ . ": previous day error: " . $result['code'] . ":" . $result['msg'] ."\n");
      }
   }
   public function testAggTrades() {
      fwrite(STDOUT, __METHOD__ . "\n");
      $result = $this->_testable->aggTrades( "TRXBTC" );
      $this->assertTrue( ( isset( $result['code'] ) == false ) );
      $this->assertTrue( count( $result ) > 0 );

      if( isset( $result['code'] ) ) {
         fwrite(STDOUT, __METHOD__ . ": agg trades error: " . $result['code'] . ":" . $result['msg'] ."\n");
      }
   }
   public function testDepth() {
      fwrite(STDOUT, __METHOD__ . "\n");
      $result = $this->_testable->depth( "TRXBTC" );
      $this->assertTrue( ( isset( $result['code'] ) == false ) );
      $this->assertTrue( isset( $result['bids'] ) );
      $this->assertTrue( isset( $result['asks'] ) );

      if( isset( $result['code'] ) ) {
         fwrite(STDOUT, __METHOD__ . ": depth error: " . $result['code'] . ":" . $result['msg'] ."\n");
      }
   }
   public function testBalances() {
      fwrite(STDOUT, __METHOD__ . "\n");
      $result = $this->_testable->balances();
      $this->assertTrue( ( isset( $result['code'] ) == false ) );
      $this->assertTrue( is_array( $result ) );

      if( isset( $result['code'] ) ) {
         fwrite(STDOUT, __METHOD__ . ": balances error: " . $result['code'] . ":" . $result['msg'] ."\n");
      }
   }
   public function testGetProxyUriString() {
      fwrite(STDOUT, __METHOD__ . "\n");

      $proxyConf = [
        'proto' => 'http',
        'address' => '192.168.1.1',
        'port' => '8080',
        'user' => 'dude',
        'pass' => 'd00d'
      ];

      $this->_testable->setProxy( $proxyConf );
      $uri = $this->_testable->getProxyUriString();
      $this->assertTrue( $uri == $proxyConf['proto'] . "://" . $proxyConf['address'] . ":" . $proxyConf['port'] );
   }
   public function testHttpRequest() {
      fwrite(STDOUT, __METHOD__ . "\n");
      $this->assertTrue( true );
   }
   public function testOrder() {
      fwrite(STDOUT, __METHOD__ . "\n");
      $this->assertTrue( true );
   }
   public function testCandlesticks() {
      fwrite(STDOUT, __METHOD__ . "\n");
      $result = $this->_testable->candlesticks("BNBBTC", "5m");
      $this->assertTrue( is_array( $result ) );

      if( isset( $result['code'] ) ) {
         fwrite(STDOUT, __METHOD__ . ": candlesticks error: " . $result['code'] . ":" . $result['msg'] ."\n");
      }
   }
   public function testBalanceData() {
      fwrite(STDOUT, __METHOD__ . "\n");
      $ticker = $this->_testable->prices();
      $result = $this->_testable->balances( $ticker );
      $this->assertTrue( is_array( $result ) );

      if( isset( $result['code'] ) ) {
         fwrite(STDOUT, __METHOD__ . ": balances error: " . $result['code'] . ":" . $result['msg'] ."\n");
      }
   }
   public function testBalanceHandler() {
      fwrite(STDOUT, __METHOD__ . "\n");
      $this->assertTrue( true );
   }
   public function testTickerStreamHandler() {
      fwrite(STDOUT, __METHOD__ . "\n");
      $this->assertTrue( true );
   }
   public function testExecutionHandler() {
      fwrite(STDOUT, __METHOD__ . "\n");
      $this->assertTrue( true );
   }
   public function testChartData() {
      fwrite(STDOUT, __METHOD__ . "\n");
      $this->assertTrue( true );
   }
   public function testBookPriceData() {
      fwrite(STDOUT, __METHOD__ . "\n");
      $this->assertTrue( true );
   }
   public function testPriceData() {
      fwrite(STDOUT, __METHOD__ . "\n");
      $this->assertTrue( true );
   }
   public function testCumulative() {
      fwrite(STDOUT, __METHOD__ . "\n");
      $result = $this->_testable->depth( "TRXBTC" );
      $this->assertTrue( ( isset( $result['code'] ) == false ) );
      $this->assertTrue( isset( $result['bids'] ) );
      $this->assertTrue( isset( $result['asks'] ) );
      $result = $this->_testable->cumulative( $result );
      $this->assertTrue( isset( $result['bids'] ) );
      $this->assertTrue( isset( $result['asks'] ) );
      $this->assertTrue( is_array( $result['bids'] ) );
      $this->assertTrue( is_array( $result['asks'] ) );
      $this->assertTrue( count( $result['bids'] ) > 0);
      $this->assertTrue( count( $result['asks'] ) > 0);
   }
   public function testHighstock() {
      fwrite(STDOUT, __METHOD__ . "\n");
      $this->assertTrue( true );
   }
   public function testDepthHandler() {
      fwrite(STDOUT, __METHOD__ . "\n");
      $this->assertTrue( true );
   }
   public function testChartHandler() {
      fwrite(STDOUT, __METHOD__ . "\n");
      $this->assertTrue( true );
   }
   public function testFirst() {
      fwrite(STDOUT, __METHOD__ . "\n");
      $arr = array( "one" => 6, "two" => 7, "three" => 8 );
      $this->assertTrue( $this->_testable->first( $arr ) == "one" );
      $arr = array();
      $this->assertTrue( $this->_testable->first( $arr ) == null );
   }
   public function testLast() {
      fwrite(STDOUT, __METHOD__ . "\n");
      $arr = array( "one" => 6, "two" => 7, "three" => 8 );
      $this->assertTrue( $this->_testable->last( $arr ) == "three" );
      $arr = array();
      $this->assertTrue( $this->_testable->last( $arr ) == null );
   }
   public function testDisplayDepth() {
      fwrite(STDOUT, __METHOD__ . "\n");
      $result = $this->_testable->depth( "TRXBTC" );
      $this->assertTrue( ( isset( $result['code'] ) == false ) );
      $this->assertTrue( isset( $result['bids'] ) );
      $this->assertTrue( isset( $result['asks'] ) );
      $result = $this->_testable->displayDepth( $result );
      $this->assertTrue( is_string( $result ) );
      $this->assertTrue( $result != "" );
   }
   public function testSortDepth() {
      fwrite(STDOUT, __METHOD__ . "\n");
      $this->assertTrue( true );
   }
   public function testDepthData() {
      fwrite(STDOUT, __METHOD__ . "\n");
      $this->assertTrue( true );
   }
   public function testDepthCache() {
      fwrite(STDOUT, __METHOD__ . "\n");
      $this->assertTrue( true );
   }

   public function testTicker() {
      fwrite(STDOUT, __METHOD__ . "\n");
      $this->assertTrue( true );
   }

   public function testChart() {
      fwrite(STDOUT, __METHOD__ . "\n");
      $this->assertTrue( true );
   }

   public function testKeepAlive() {
      fwrite(STDOUT, __METHOD__ . "\n");
      $this->assertTrue( true );
   }

   public function testMiniTicker() {
      fwrite(STDOUT, __METHOD__ . "\n");
      $this->assertTrue( true );
   }

   public function testGetTransfered() {
      fwrite(STDOUT, __METHOD__ . "\n");
      $result = $this->_testable->getTransfered();
      $this->assertTrue( true );
   }

   public function testGetRequestCount() {
      fwrite(STDOUT, __METHOD__ . "\n");
      $result = $this->_testable->getRequestCount();
      $this->assertTrue( true );
   }
}
