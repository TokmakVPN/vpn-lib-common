<?php

/*
 * eduVPN - End-user friendly VPN.
 *
 * Copyright: 2016-2019, The Commons Conservancy eduVPN Programme
 * SPDX-License-Identifier: AGPL-3.0+
 */

namespace LetsConnect\Common;

interface RandomInterface
{
    /**
     * Get a randomly generated crypto secure string.
     *
     * @param int $length the length (in bytes) of the random string
     */
    public function get($length);
}
