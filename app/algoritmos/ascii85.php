<?php
/**
 * ASCII85: encode/decode binary data with text characters.
 *
 * About:
 * - Generates a text 25% larger from de original (approximately);
 * - Suport to Adobe version of algorithm;
 * - Suport to btoa version of algorithm;
 *
 * @author Rubens Takiguti Ribeiro
 * @date 2008-11-26
 * @version 1.0 2008-11-27
 * @see http://en.wikipedia.org/wiki/Ascii85
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPLv3 (LICENSE.TXT)
 * @copyright Copyright (C) 2008  Rubens Takiguti Ribeiro
 */
final class ascii85 {

/// # CONSTANTS

    /**
     * Algorithm variations.
     */
    const BASIC   = 0; // Default implementation
    const ADOBE   = 1; // Adobe version
    const BTOA    = 2; // BTOA version

    /**
     * Exception codes
     */
    const THROW_ADOBE_DELIMITER = 1;
    const THROW_BTOA_CHECKS     = 2;
    const THROW_BTOA_VALUE      = 3;
    const THROW_TUPLE_CHAR      = 4;
    const THROW_TUPLE_SIZE      = 5;


/// # METHODS


    /**
     * This class is not instantiable.
     * Use static methods only.
     *
     * @return void
     */
    private function __construct() {}


    /**
     * Encode to ASCII85 format.
     *
     * @see CONSTANTS section
     * @param string $value String to be encoded.
     * @param int $variation Constant code of algorithm variation.
     * @param bool || int $split_pos Position to split returned string.
     * @return string Encoded string in ASCII85 format or false on failure.
     */
    public static function encode($value, $variation = self::BASIC, $split_pos = false) {

        switch ($variation) {
        case self::ADOBE:
            $y_exception = false;
            $z_exception = true;
            break;
        case self::BTOA:
            $y_exception = true;
            $z_exception = true;
            break;
        case self::BASIC:
            $y_exception = false;
            $z_exception = false;
            break;
        }

        // Returned value
        $return = '';

        // Get string tuples of 4 bytes
        $tuples = str_split($value, 4);

        // Foreach tuple
        foreach ($tuples as $tuple) {

            // Convert tuple (string value) to binary (integer value)
            $bin_tuple = 0;
            $len = strlen($tuple);
            for ($i = 0; $i < $len; $i++) {
                $bin_tuple |= (ord($tuple[$i]) << ((3 - $i) * 8));
            }

            // Get unsigned value as string
            $bin_tuple = sprintf('%u', $bin_tuple);

            // Zero-tuple is represented as "z"
            if ($z_exception && $bin_tuple == 0) {
                $return .= 'z';

            // Space-tuple is represented as "y"
            } elseif ($y_exception && $bin_tuple == 0x20202020) {
                $return .= 'y';

            // Tuple
            } else {

                // Create a tuple 85 (string value)
                $i = 5;
                $tuple85 = '';
                while ($i--) {
                    $c = bcmod($bin_tuple, '85');
                    $tuple85 = chr(bcadd($c, '33')).$tuple85;
                    $bin_tuple = bcdiv($bin_tuple, '85', 0);
                }
                $tuple85 = substr($tuple85, 0, $len + 1);

                // Append to return value
                $return .= $tuple85;
            }
        }

        switch ($variation) {
        case self::BASIC:
            self::split($return, $split_pos);
            break;
        case self::ADOBE:
            $return = '<~'.$return.'~>';
            self::split($return, $split_pos);
            break;
        case self::BTOA:
            self::btoa_create_checks($value, $size_dec, $size_hex, $check_xor, $check_sum, $check_rot);
            self::split($return, $split_pos);
            $return = sprintf(
                          "xbtoa Begin\n%s\nxbtoa End N %s %s E %s S %s R %s\n",
                          $return, $size_dec, $size_hex, $check_xor, $check_sum, $check_rot
                      );
            break;
        }
        return $return;
    }


    /**
     * Decode from ASCII85.
     *
     * @exception THROW_BTOA_VALUE if encoded value has invalid format.
     * @exception THROW_BTOA_CHECKS If generated value did not match with checks.
     * @exception THROW_ADOBE_DELIMITER If there are not Adobe delimiter.
     * @exception THROW_TUPLE_CHAR If any tuple has invalid characters.
     * @exception THROW_TUPLE_SIZE If any tuple is greater than 2^32.
     * @param string $value Encoded text to be decoded.
     * @param int $variation Constant code of algorithm variation.
     * @return string Decoded string or false on failure.
     */
    public static function decode($value, $variation = self::BASIC) {

        // Get BTOA checks
        if ($variation == self::BTOA) {
            try {
                self::btoa_get_checks($value, $size_dec, $size_hex, $check_xor, $check_sum, $check_rot);
            } catch (Exception $e) {
                throw $e;
            }
        }

        // Clean value
        try {
            self::clean($value, $variation);
        } catch (Exception $e) {
            throw $e;
        }

        // Returned value
        $return = '';

        // Const values
        $max_tuple = pow(2, 32);

        $base85 = array();
        $base85[0] = 1;                // 85^0
        $base85[1] = $base85[0] * 85;  // 85^1
        $base85[2] = $base85[1] * 85;  // 85^2
        $base85[3] = $base85[2] * 85;  // 85^3
        $base85[4] = $base85[3] * 85;  // 85^4

        // Get ASCII85 tuples
        $value = str_split($value, 5);

        // Foreach tuple 85 of 5 bytes
        foreach ($value as $tuple85) {

            // If zero-tuple was found
            if ($tuple85 === 'zzzzz') {
                $return .= str_repeat(chr(0), 4);
                continue;

            // If space-tupe was found
            } elseif ($tuple85 === 'yyyyy') {
                $return .= str_repeat(' ', 4);
                continue;
            }

            // If the tuple has invalid chars
            if (!preg_match('/^[\x21-\x75]{1,5}$/', $tuple85)) {
                throw new Exception('Tuple has invalid characters ('.$tuple85.')', self::THROW_TUPLE_CHAR);
            }

            // Convert tuple 85 (text) to binary tuple (number)
            $bin_tuple = '0';
            $len = strlen($tuple85);

            // Append "u" to missing positions to avoid rounding-down effect
            $tuple85 .= str_repeat('u', 5 - $len);

            for ($i = 0; $i < 5; $i++) {
                $bin_char = strval(ord($tuple85[$i]) - 33);
                $bin_tuple += bcmul($bin_char, $base85[4 - $i]);
            }

            // If binary value is greater than 2^32
            if ($bin_tuple > $max_tuple) {
                throw new Exception('Tuple is greater than '.$max_tuple, self::THROW_TUPLE_SIZE);
            }
            $bin_tuple = bindec(sprintf('%032b', $bin_tuple));

            // Create a tuple (string value)
            $i = 4;
            $tuple = '';
            $len -= 1;
            while ($len--) {
                $c = ($bin_tuple >> (--$i * 8)) & 0xFF;
                $tuple .= chr($c);
            }

            // Append to return value
            $return .= $tuple;
        }

        // Get BTOA checks
        if ($variation == self::BTOA) {
            $v = self::btoa_validate_checks($return, $size_dec, $size_hex, $check_xor, $check_sum, $check_rot);
            if (!$v) {
                throw new Exception('Generated text did not pass by validation of BTOA checks', self::THROW_BTOA_CHECKS);
            }
        }

        return $return;
    }


    /**
     * Split a string on a specific position.
     *
     * @param string $value Value to be splited
     * @param int || bool $pos Position to split value.
     * @return void
     */
    private static function split(&$value, $pos) {
        if (is_numeric($pos) && $pos > 0) {
            $value = chunk_split($value, $pos, "\n");
            $value = rtrim($value);
        }
    }


    /**
     * Convert some characters of an encoded text.
     *
     * @exception THROW_ADOBE_DELIMITER If there are not Adobe delimiter.
     * @param string $value Encoded value.
     * @param int $variation Constant code of algorithm variation.
     * @return bool
     */
    private static function clean(&$value, $variation) {
        $value = trim($value);

        switch ($variation) {
        case self::BASIC:

            // Remove spaces
            $tr = array(' ' => '',
                        "\r" => '',
                        "\n" => '',
                        "\t" => '',
                        "\0" => '',
                        "\f" => ''
                    );
            $value = strtr($value, $tr);
            break;

        case self::ADOBE:
            if (substr($value, 0, 2) != '<~' || substr($value, -2, 2) != '~>') {
                throw new Exception('Value does not have Adobe delimiter', self::THROW_ADOBE_DELIMITER);
            }

            // Remove <~ and ~>
            $value = substr($value, 2, strlen($value) - 4);

            // Remove spaces and convert "z" exception to a tuple
            $tr = array(' ' => '',
                        "\r" => '',
                        "\n" => '',
                        "\t" => '',
                        "\0" => '',
                        "\f" => '',
                        'z'  => 'zzzzz'
                    );
            $value = strtr($value, $tr);
            break;
        case self::BTOA:

            // Remove first line
            $first = strpos($value, "\n");
            $value = substr($value, $first + 1);

            // Remove last line
            $last  = strrpos($value, "\n");
            $value = substr($value, 0, $last);

            // Remove spaces and convert "z" and "y" exception to a tuple
            $tr = array(' ' => '',
                        "\r" => '',
                        "\n" => '',
                        "\t" => '',
                        "\0" => '',
                        "\f" => '',
                        'z'  => 'zzzzz',
                        'y'  => 'yyyyy'
                    );
            $value = strtr($value, $tr);
            break;
        }
    }


    /**
     * Gets check values from an encoded ASCII85 BTOA value.
     *
     * @exception THROW_BTOA_VALUE if encoded value has invalid format.
     * @param string $value Original value.
     * @param string $size_dec Decimal size.
     * @param string $size_hex Hexadecinal size.
     * @param string $check_xor Check XOR.
     * @param string $check_sum Check SUM.
     * @param string $check_rot Check ROT.
     * @return void
     */
    public static function btoa_get_checks($value, &$size_dec, &$size_hex, &$check_xor, &$check_sum, &$check_rot) {
        $value = trim($value);
        $exp = '/xbtoa[\040]+End[\040]+'.
               'N[\040]+([\d]+)[\040]+([0-9a-f]+)[\040]+'.
               'E[\040]+([0-9a-f]+)[\040]+'.
               'S[\040]+([0-9a-f]+)[\040]+'.
               'R[\040]+([0-9a-f]+)'.
               '$/i';

        if (!preg_match($exp, $value, $match)) {
            throw new Exception('Invalid ASCII85 BTOA encoded data', self::THROW_BTOA_VALUE);
        }

        $size_dec  = $match[1];
        $size_hex  = $match[2];
        $check_xor = $match[3];
        $check_sum = $match[4];
        $check_rot = $match[5];
    }


    /**
     * Generate BTOA values to validate a received text.
     *
     * @param string $value Original value.
     * @param string $size_dec Decimal size.
     * @param string $size_hex Hexadecinal size.
     * @param string $check_xor Check XOR.
     * @param string $check_sum Check SUM.
     * @param string $check_rot Check ROT.
     * @return void
     */
    public static function btoa_create_checks($value, &$size_dec, &$size_hex, &$check_xor, &$check_sum, &$check_rot) {
        $size = strlen($value);

        // Check xor, sum, rot
        $check_xor = 0;
        $check_sum = 0;
        $check_rot = 0;
        for ($i = 0; $i < $size; $i++) {
            $c = ord($value[$i]);
            $check_xor ^= $c;
            $check_sum += $c + 1;
            $check_rot <<= 1;
            if ($check_rot & 0x80000000) {
                $check_rot += 1;
            }
            $check_rot += $c;
        }

        $size_dec  = sprintf('%0.0f', $size);
        $size_hex  = sprintf('%x', $size);
        $check_xor = sprintf('%x', $check_xor);
        $check_sum = sprintf('%x', $check_sum);
        $check_rot = sprintf('%x', $check_rot);
    }


    /**
     * Validate a decoded ASCII85 BTOA value.
     *
     * @param string $value Decoded value.
     * @param string $size_dec Decimal size.
     * @param string $size_hex Hexadecinal size.
     * @param string $check_xor Check XOR.
     * @param string $check_sum Check SUM.
     * @param string $check_rot Check ROT.
     * @return bool
     */
    public static function btoa_validate_checks($value, $size_dec, $size_hex, $check_xor, $check_sum, $check_rot) {
        self::btoa_create_checks($value, $size_dec2, $size_hex2, $check_xor2, $check_sum2, $check_rot2);
        return $size_dec  === $size_dec2 &&
               $size_hex  === $size_hex2 &&
               $check_xor === $check_xor2 &&
               $check_sum === $check_sum2 &&
               $check_rot === $check_rot2;
    }

}//class
