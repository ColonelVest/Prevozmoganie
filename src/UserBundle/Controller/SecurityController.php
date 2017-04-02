<?php

namespace UserBundle\Controller;

use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;

class SecurityController extends FOSRestController
{
    /**
     * @Rest\View
     * @Post("/authorize")
     * @param Request $request
     * @return array
     */
    public function authorizeAction(Request $request)
    {
        $username = $request->get('login');
        $password = $request->get('password');

        $result = $this->get('user_handler')->getUser($username, $password, true);
        if (!$result->getIsSuccess()) {
            $result = $this->get('token_handler')->encode($username, $password);
        }

        return $this->get('api_response_formatter')->createResponseFromResultObj($result);
    }
}
