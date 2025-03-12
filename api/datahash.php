<?php
class dataHash {
    
    private static $AES_KEY = "abcdefghijklmnop";

    public static function encrypt($data) {
        $cipher = "aes-128-cbc";
        $options = 0;
        $iv = openssl_random_pseudo_bytes(16); // IV length set to 16 bytes
        $encrypted = openssl_encrypt($data, $cipher, self::$AES_KEY, $options, $iv);
        return base64_encode($encrypted . '::' . $iv);
    }

    public static function decrypt($encryptedData) {
        $cipher = "aes-128-cbc";
        $options = 0;
        list($encryptedData, $iv) = explode('::', base64_decode($encryptedData), 2);
        // Ensure $iv is exactly 16 bytes long
        $iv = substr($iv, 0, 16); // Truncate or pad $iv to 16 bytes
        return openssl_decrypt($encryptedData, $cipher, self::$AES_KEY, $options, $iv);
    }
}


?>