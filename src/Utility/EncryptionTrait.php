<?php

namespace App\Utility;

trait EncryptionTrait {

    protected function encrypt($data, $key): string {
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $encrypted = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);
        return base64_encode($iv . '::' . $encrypted);
    }


    protected function decrypt($data, $key) {
        $parts = explode('::', base64_decode($data));

        if (count($parts) !== 2) {
            throw new \Exception("Decryption failed due to malformed input.");
        }

        list($iv, $encrypted_data) = $parts;

        return openssl_decrypt($encrypted_data, 'aes-256-cbc', $key, 0, $iv);
    }


}
