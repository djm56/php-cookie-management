<?php


if ( ! class_exists( 'Manage_Cookies' ) ) {
	/**
	 * Manage_Cookies class is used to get, set and clear cookies
	 *
	 * The class uses public static functions and can be called from anywhere in the theme.
	 * To set, get and clear.
	 *
	 * Example Usage:
	 * Manage_Cookies::set_cookie( '_bgs_cc', $country_code, true );
	 * Manage_Cookies::get_cookie( '_bgs_rs' );
	 * Manage_Cookies::clear_cookie( '_bgs_rs' );
	 */
	class Manage_Cookies {

		/**
		 * Expiration 31 days in seconds in seconds used in cookie creation process.
		 *
		 * @var int
		 */
		private static $expiration = 2678400;

		/**
		 * Get the cookie value from the key supplied.
		 * This is a static function and can be directly used.
		 *
		 * @param string $key The name of the cookie key.
		 * @return string The cookie string.
		 */
		public static function get_cookie( $key ) {
			if ( ! $key ) {
				return false;
			}

			$value = isset( $_COOKIE[ $key ] ) ? sanitize_text_field( stripslashes( $_COOKIE[ $key ] ) ) : false;

			return $value;
		}

		/**
		 * Set the cookie key and encrypt the string if instructed.
		 * This is a static function and can be directly used.
		 *
		 * @param string $key The name of the Cookie key to be set.
		 * @param string $value the string to be encrypted.
		 * @param int    $expiration the expirary of the key.
		 * @return boolean
		 */
		public static function set_cookie( $key, $value = false, $expiration = false ) {
			if ( ! $key ) {
				return false;
			}

			if ( $value && ! is_admin() && is_page() ) {

				if ( true === $expiration ) {
					$expiration_cookie = time() + self::$expiration;
				} elseif ( false === $expiration ) {
					$expiration_cookie = false;
				} elseif ( is_int( $expiration ) ) {
					$expiration_cookie = $expiration;
				} else {
					$expiration_cookie = false;
				}

				return setcookie( $key, $value, $expiration_cookie, COOKIEPATH, COOKIE_DOMAIN );
			}
		}

		/**
		 * Clear a Cookie by passing empty string to the cookie key.
		 * Then unset the Cookie.
		 *
		 * @param string $key The cookie key.
		 * @return boolean
		 */
		public static function clear_cookie( $key ) {
			if ( ! $key ) {
				return false;
			}

			$expiration_cookie = time() - self::$expiration;
			setcookie( $key, '', $expiration_cookie, COOKIEPATH, COOKIE_DOMAIN );
			unset( $_COOKIE[ $key ] );
			return true;
		}
	}

	class_alias( 'Manage_Cookies', 'MC' );

}
