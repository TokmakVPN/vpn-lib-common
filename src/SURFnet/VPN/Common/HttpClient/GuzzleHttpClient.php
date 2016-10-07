<?php
/**
 *  Copyright (C) 2016 SURFnet.
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU Affero General Public License as
 *  published by the Free Software Foundation, either version 3 of the
 *  License, or (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU Affero General Public License for more details.
 *
 *  You should have received a copy of the GNU Affero General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
namespace SURFnet\VPN\Common\HttpClient;

use GuzzleHttp\Client;
use SURFnet\VPN\Common\HttpClient\Exception\HttpClientException;
use GuzzleHttp\Exception\BadResponseException;

class GuzzleHttpClient implements HttpClientInterface
{
    /** @var \GuzzleHttp\Client */
    private $httpClient;

    public function __construct($authUser, $authPass)
    {
        $this->httpClient = new Client(
            [
                'defaults' => [
                    'auth' => [$authUser, $authPass],
                ],
            ]
        );
    }

    public function get($requestUri)
    {
        return $this->httpClient->get(sprintf($requestUri))->json();
    }

    public function post($requestUri, array $postData)
    {
        try {
            return $this->httpClient->post(
                $requestUri,
                [
                    'body' => [
                        $postData,
                    ],
                ]
            )->json();
        } catch (BadResponseException $e) {
            $responseData = $e->getResponse()->json();

            throw new HttpClientException($responseData['error']);
        }
    }
}
