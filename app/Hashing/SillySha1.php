<?php

namespace App\Hashing;


use Illuminate\Contracts\Hashing\Hasher;

/**
 * Class SillySha1
 *
 * Encrypting a password like this, is just silly.
 * But! it is what the underlying game server uses, so until we get around to swap it out.. cheerio matey.
 *
 * @package App\Hashing
 */
class SillySha1 implements Hasher
{
    /**
     * Get information about the given hashed value.
     *
     * @param  string $hashedValue
     * @return array
     */
    public function info($hashedValue)
    {
        return [
            'algo' => 0,
            'algoName' => 'sha1',
            'options' => []
        ];
    }

    /**
     * Check the given plain value against a hash.
     *
     * @param  string $value
     * @param  string $hashedValue
     * @param  array $options
     * @return bool
     */
    public function check($value, $hashedValue, array $options = [])
    {
        if (strlen($hashedValue) === 0) {
            return false;
        }

        return $this->make($value, $options) === $hashedValue;
    }

    /**
     * Hash the given value.
     *
     * @param  string $value
     * @param  array $options
     * @return string
     */
    public function make($value, array $options = [])
    {
        $accountName = $options['user'] ?? $options['account'];

        $encrypted = sha1(strtoupper($accountName) . ":" . strtoupper($value));

        return strtoupper($encrypted);
    }

    /**
     * Check if the given hash has been hashed using the given options.
     *
     * @param  string $hashedValue
     * @param  array $options
     * @return bool
     */
    public function needsRehash($hashedValue, array $options = [])
    {
        return false;
    }
}
