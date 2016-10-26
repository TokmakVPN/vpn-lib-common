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
namespace SURFnet\VPN\Common\Http\Test;

use SURFnet\VPN\Common\HttpClient\HttpClientInterface;
use RuntimeException;

class TestHttpClient implements HttpClientInterface
{
    public function addRequestHeader($key, $value)
    {
        // NOP
    }

    public function get($requestUri)
    {
        switch ($requestUri) {
            case 'serverClient/has_otp_secret?user_id=foo':
                return self::wrap('has_otp_secret', true);
            case 'serverClient/has_otp_secret?user_id=bar':
                return self::wrap('has_otp_secret', false);
            default:
                throw new RuntimeException(sprintf('unexpected requestUri "%s"', $requestUri));
        }
    }

    public function post($requestUri, array $postData)
    {
        switch ($requestUri) {
            case 'serverClient/verify_otp_key':
                if ('foo' === $postData['user_id']) {
                    return self::wrap('verify_otp_key', true);
                }

                return self::wrap('verify_otp_key', false);
            default:
                throw new RuntimeException(sprintf('unexpected requestUri "%s"', $requestUri));
        }
    }

    private static function wrap($key, $response)
    {
        return [
            'data' => [
                $key => $response,
            ],
        ];
    }
}
