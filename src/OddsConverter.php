<?php
/**
 * PHP Odds converter
 *
 * (c) Alexander Sharapov <alexander@sharapov.biz>
 * http://sharapov.biz/
 *
 */

namespace Sharapov\OddsConverter;

class OddsConverter {

  const ODD_EVENS_KEY_WORD = 'evens';

  protected $oddDecimal;

  /**
   * OddsConverter constructor.
   *
   * @param $odd
   */
  public function __construct( $odd = null ) {
    if ( ! is_null( $odd ) ) {
      $this->setOdd( $odd );
    }
  }

  /**
   * Set input odd. Can be decimal, fractional or moneyline (US format)
   *
   * @param $odd
   */
  public function setOdd( $odd ) {
    if ( strtolower( $odd ) == self::ODD_EVENS_KEY_WORD ) {
      $odd = '1/1';
    }
    // Detect odd type and convert it to decimal
    if ( $this->_isDecimal( $odd ) ) { // Decimal detected
      $this->oddDecimal = $odd;
    } elseif ( stripos( $odd, "/" ) == true ) { // Fractional detected
      $this->oddDecimal = $this->_decimalFromFraction( $odd );
    } else { // If nothing above, assume moneyline (US format)
      $this->oddDecimal = $this->_getDecimalFromMoneyLine( $odd );
    }

    $this->odd = $odd;
  }

  /**
   * Returns odd in fractional format
   *
   * @return string
   */
  public function getFractional() {
    return $this->_getFractionalFromDecimal( $this->oddDecimal );
  }

  /**
   * Returns odd in decimal format
   *
   * @return string
   */
  public function getDecimal() {
    return number_format( $this->oddDecimal, 2 );
  }

  /**
   * Returns odd in moneyline (US) format
   *
   * @return string
   */
  public function getMoneyline() {
    return $this->_getMoneylineFromDecimal( $this->oddDecimal );
  }

  /**
   * Detects if input is decimal
   *
   * @param $val
   *
   * @return bool
   */
  private function _isDecimal( $val ) {
    return is_numeric( $val ) && floor( $val ) != $val;
  }

  /**
   * Get decimal from fractional string
   *
   * @param $fraction
   *
   * @return bool|float|int
   */
  private function _decimalFromFraction( $fraction ) {
    $a = explode( '/', $fraction );
    if ( count( $a ) == 2 && ! empty( $a[0] ) && ! empty( $a[1] ) ) {
      return ( ( $a[0] / $a[1] ) + 1 );
    }

    return false;
  }

  /**
   * Get fractional from decimal
   *
   * @param $decimal
   *
   * @return string
   */
  private function _getFractionalFromDecimal( $decimal ) {
    $decimal = number_format( $decimal, 2 );
    $num     = ( $decimal - 1 ) * 10000;
    $dom     = 10000;

    $num = round( $num );
    $dom = round( $dom );

    $a   = $this->_reduce( $num, $dom );
    $num = $a[0];
    $dom = $a[1];

    return ( $num . '/' . $dom );
  }

  /**
   * Get decimal from moneyline
   *
   * @param $moneyline
   *
   * @return float|int
   */
  private function _getDecimalFromMoneyLine( $moneyline ) {
    if ( $moneyline > 0 ) {
      return ( ( ( $moneyline / 100 ) + 1 ) );
    } else {
      return ( ( ( 100 / $moneyline * - 1 ) + 1 ) );
    }
  }

  /**
   * Get moneyline from decimal
   *
   * @param $decimal
   *
   * @return string
   */
  private function _getMoneylineFromDecimal( $decimal ) {
    $decimal -= 1;
    if ( $decimal < 1 ) {
      return '-' . 100 / $decimal;
    } else {
      return '+' . $decimal * 100;
    }
  }

  /**
   * @param $a
   * @param $b
   *
   * @return array
   */
  private function _reduce( $a, $b ) {
    $n    = [];
    $f    = $this->_gcd( $a, $b );
    $n[0] = $a / $f;
    $n[1] = $b / $f;

    return $n;
  }

  /**
   * @param $a
   * @param $b
   *
   * @return int
   */
  private function _gcd( $a, $b ) {
    return ( $a % $b ) ? $this->_gcd( $b, $a % $b ) : $b;
  }
}