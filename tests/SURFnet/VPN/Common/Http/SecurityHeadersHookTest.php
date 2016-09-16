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
namespace SURFnet\VPN\Common\Http;

use PHPUnit_Framework_TestCase;

class SecurityHeadersHookTest extends PHPUnit_Framework_TestCase
{
    public function testBasicAuthentication()
    {
        $request = new Request(
            [
                'REQUEST_METHOD' => 'GET',
                'SERVER_NAME' => 'vpn.example',
                'HTTP_ACCEPT' => 'text/html',
            ]
        );

        $response = new Response();
        $securityHeadersHook = new SecurityHeadersHook();
        $hookResponse = $securityHeadersHook->executeAfter($request, $response);

        $this->assertSame("default-src 'self'", $hookResponse->getHeader('Content-Security-Policy'));
    }
}
