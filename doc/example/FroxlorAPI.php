<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2018 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Froxlor team <team@froxlor.org> (2018-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    API-example
 * @since      0.10.0
 *
 */
class FroxlorAPI
{
    private string $url;
    private string $key;
    private string $secret;
    private ?array $lastError = null;
    private ?string $lastStatusCode = null;

    public function __construct($url, $key, $secret)
    {
        $this->url = $url;
        $this->key = $key;
        $this->secret = $secret;
    }

    public function request($command, array $data = [])
    {
        $payload = [
            'command' => $command,
            'params' => $data
        ];

        $ch = curl_init($this->url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_USERPWD, $this->key . ":" . $this->secret);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);

        $this->lastStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        return json_decode($result ?? curl_error($ch), true);
    }

    public function getLastStatusCode(): ?string
    {
        return $this->lastStatusCode;
    }
}
