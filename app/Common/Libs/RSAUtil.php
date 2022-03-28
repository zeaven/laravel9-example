<?php

namespace App\Common\Libs;

class RSAUtil
{
    /**
     * RSA公钥加密
     * @param string $public_key 公钥
     * @param string $data 要加密的字符串
     * @return string $encrypted 返回加密后的字符串
     */
    public static function rsaPublicEncrypt($data)
    {
        $encrypted = '';
        $pu_key = openssl_pkey_get_public(file_get_contents(resource_path('key/platform_rsa_public_key.pem')));
        $plainData = str_split($data, 128);

        foreach ($plainData as $chunk) {
            $partialEncrypted = '';
            //公钥加密
            $encryptionOk = openssl_public_encrypt($chunk, $partialEncrypted, $pu_key);

            if ($encryptionOk === false) {
                return false;
            }

            $encrypted .= $partialEncrypted;
        }

        $encrypted = base64_encode($encrypted);

        return $encrypted;
    }

    /**
     * RSA私钥解密
     * @param string $private_key 私钥
     * @param string $data 公钥加密后的字符串
     * @return string $decrypted 返回解密后的字符串
     */
    public static function rsaPrivateDecrypt($data)
    {
        $decrypted = '';
        $pi_key = openssl_pkey_get_private(file_get_contents(resource_path('key/merchant_rsa_private_key.pem')));
        $plainData = str_split(base64_decode($data), 184);
        foreach ($plainData as $chunk) {
            $str = '';
            //私钥解密
            $decryptionOk = openssl_private_decrypt($chunk, $str, $pi_key);
            if ($decryptionOk === false) {
                return false;
            }
            $decrypted .= $str;
        }

        return $decrypted;
    }
}
