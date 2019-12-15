<?php

/*
 * eduVPN - End-user friendly VPN.
 *
 * Copyright: 2016-2019, The Commons Conservancy eduVPN Programme
 * SPDX-License-Identifier: AGPL-3.0+
 */

namespace LC\Common\Http;

use LC\Common\TplInterface;

class FormAuthenticationHook implements BeforeHookInterface
{
    /** @var SessionInterface */
    private $session;

    /** @var \LC\Common\TplInterface */
    private $tpl;

    public function __construct(SessionInterface $session, TplInterface $tpl)
    {
        $this->session = $session;
        $this->tpl = $tpl;
    }

    /**
     * @return mixed
     */
    public function executeBefore(Request $request, array $hookData)
    {
        if (Service::isWhitelisted($request, ['POST' => ['/_form/auth/verify']])) {
            return;
        }

        if ($this->session->has('_form_auth_user')) {
            $permissionList = $this->session->has('_form_auth_permission_list') ? $this->session->getStringArray('_form_auth_permission_list') : [];

            return new UserInfo(
                $this->session->getString('_form_auth_user'),
                $permissionList
            );
        }

        // any other URL, enforce authentication
        $response = new Response(200, 'text/html');
        $response->setBody(
            $this->tpl->render(
                'formAuthentication',
                [
                    '_form_auth_invalid_credentials' => false,
                    '_form_auth_redirect_to' => $request->getUri(),
                    '_form_auth_login_page' => true,
                ]
            )
        );

        return $response;
    }
}
