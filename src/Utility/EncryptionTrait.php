<?php
/**
 * Encryption Trait
 * This trait provides methods to encrypt and decrypt data.
 *
 * @author Lucas Fonseca Martins
 */

namespace App\Utility;

trait EncryptionTrait {

    /**
     * Encrypts data using AES-256-CBC
     * @param $data
     * @param $key
     * @return string
     */
    protected function encrypt($data, $key): string {
        // Check data sanity
        if (empty($data)) {
            $data = 'null';
        }

        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $encrypted = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);
        return base64_encode($iv . ':√' . $encrypted);
    }


    /**
     * Decrypts data using AES-256-CBC
     * @param $data
     * @param $key
     * @return false|string
     * @throws \Exception
     */
    protected function decrypt($data, $key) {

        $parts = explode(':√', base64_decode($data));

        //die(base64_decode($data));

        // Check data sanity
        if (count($parts) !== 2) {
            throw new \Exception("Decryption failed due to malformed input." . PHP_EOL . "Data: " . base64_decode($data));
        }

        list($iv, $encrypted_data) = $parts;
        $iv = str_pad($iv, 16, "\0");

        return openssl_decrypt($encrypted_data, 'aes-256-cbc', $key, 0, $iv);
    }

}
