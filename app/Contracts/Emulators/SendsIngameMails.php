<?php

namespace App\Contracts\Emulators;

interface SendsIngameMails
{
    /**
     * Send the items to the recipient character by ingame mail(s).
     *
     * @param string $recipientCharacterGuid
     * @param array $items
     * @param integer $perMail
     *
     * @return void
     */
    public function sendItems($recipientCharacterGuid, $items, $perMail = 8);
}
