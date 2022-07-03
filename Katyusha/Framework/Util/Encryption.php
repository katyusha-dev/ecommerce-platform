<?php

namespace Katyusha\Framework\Utils;

use Exception;

/**
 * Crypt PHP.
 *
 * Provides cryptography functionality, including hashing and symmetric-key encryption
 *
 * @license    http://www.opensource.org/licenses/bsd-license.php BSD License
 *
 * @version    Version @package_version@
 *
 * @since      Class available since Version 1.0.0
 *
 * @link       http://github.com/osmanungur/crypt-php
 */

class Encryption
{
    public const HMAC_ALGORITHM = 'sha1';
    public const DELIMITER = '#';
    public const MCRYPT_MODULE = 'rijndael-192';
    public const MCRYPT_MOD = 'cfb';
    public const PREFIX = 'Crypt';
    public const MINIMUM_KEY_LENGTH = 8;
    private $data;
    private $key;
    private $module;
    private $complexTypes = false;

    public function __construct()
    {
        $this->checkEnvironment();
        $this->setModule(mcrypt_module_open(self::MCRYPT_MODULE, '', self::MCRYPT_MOD, ''));
    }

    public function __destruct()
    {
        @mcrypt_generic_deinit($this->getModule());
        mcrypt_module_close($this->getModule());
    }

    /**
     * Sets the data for encryption or decryption.
     */
    public function setData($data): self
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Sets the secret key for encryption or decryption, at least 8 character long.
     */
    public function setKey(string $key): self
    {
        if (mb_strlen($key) < self::MINIMUM_KEY_LENGTH) {
            $message = sprintf('The secret key must be a minimum %s character long', self::MINIMUM_KEY_LENGTH);

            throw new Exception($message, 1);
        }
        $this->key = $key;

        return $this;
    }

    /**
     * Sets using complex data types like arrays and objects for serialization.
     */
    public function setComplexTypes(bool $complexTypes): self
    {
        $this->complexTypes = $complexTypes;

        return $this;
    }

    /**
     * Encrypts the given data using symmetric-key encryption.
     */
    public function encrypt(): string
    {
        mt_srand();
        $init_vector = mcrypt_create_iv(mcrypt_enc_get_iv_size($this->getModule()), MCRYPT_RAND);
        $key = mb_substr(sha1($this->getKey()), 0, mcrypt_enc_get_key_size($this->getModule()));
        mcrypt_generic_init($this->getModule(), $key, $init_vector);

        if ($this->getComplexTypes()) {
            $this->setData(serialize($this->getData()));
        }
        $cipher = mcrypt_generic($this->getModule(), $this->getData());
        $hmac = hash_hmac(self::HMAC_ALGORITHM, $init_vector.self::DELIMITER.$cipher, $this->getKey());
        $encoded_init_vector = base64_encode($init_vector);
        $encoded_cipher = base64_encode($cipher);

        return self::PREFIX.self::DELIMITER.$encoded_init_vector.self::DELIMITER.$encoded_cipher.self::DELIMITER.$hmac;
    }

    /**
     * Decrypts encrypted cipher using symmetric-key encryption.
     */
    public function decrypt()
    {
        $elements = explode(self::DELIMITER, $this->getData());

        if (count($elements) !== 4 || $elements[0] !== self::PREFIX) {
            $message = sprintf('The given data does not appear to be encrypted with %s', self::class);

            throw new Exception($message, 1);
        }
        $init_vector = base64_decode($elements[1]);
        $cipher = base64_decode($elements[2]);
        $given_hmac = $elements[3];
        $hmac = hash_hmac(self::HMAC_ALGORITHM, $init_vector.self::DELIMITER.$cipher, $this->getKey());

        if ($given_hmac !== $hmac) {
            throw new Exception('The given data appears tampered or corrupted', 1);
        }
        $key = mb_substr(sha1($this->getKey()), 0, mcrypt_enc_get_key_size($this->getModule()));
        mcrypt_generic_init($this->getModule(), $key, $init_vector);
        $result = mdecrypt_generic($this->getModule(), $cipher);

        if ($this->getComplexTypes()) {
            return unserialize($result);
        }

        return $result;
    }

    /**
     * Checks the environment for mcrypt and mcrypt module.
     */
    private function checkEnvironment(): void
    {
    }

    /**
     * Sets the mcrypt module.
     *
     * @param resource $module
     */
    private function setModule($module): self
    {
        $this->module = $module;

        return $this;
    }

    /**
     * Returns the encrypted or decrypted data.
     */
    private function getData()
    {
        return $this->data;
    }

    /**
     * Returns the secret key for encryption.
     */
    private function getKey(): string
    {
        return $this->key;
    }

    /**
     * Returns the mcrypt module resource.
     *
     * @return resource
     */
    private function getModule()
    {
        return $this->module;
    }

    /**
     * Returns true if using complex data types like arrays and objects declared.
     */
    private function getComplexTypes(): bool
    {
        return $this->complexTypes;
    }
}
