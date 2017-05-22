<?php
/**
 * Created by PhpStorm.
 * User: danya
 * Date: 22.05.17
 * Time: 22:09
 */

namespace BaseBundle\EventListener;

use BaseBundle\Controller\TokenAuthenticatedController;
use BaseBundle\Models\ErrorMessages;
use BaseBundle\Services\UserTokenHandler;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class AuthenticationSubscriber implements EventSubscriberInterface
{
    /** @var  UserTokenHandler */
    private $tokenHandler;
    /** @var  TokenStorage */
    private $tokenStorage;
    private $firewallName;

    public function __construct(UserTokenHandler $tokenHandler, TokenStorage $tokenStorage, $firewallName)
    {
        $this->tokenHandler = $tokenHandler;
        $this->tokenStorage = $tokenStorage;
        $this->firewallName = $firewallName;
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2')))
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => 'authenticate',
        ];
    }

    public function authenticate(FilterControllerEvent $event)
    {
        if ($event->getController()[0] instanceof TokenAuthenticatedController) {
            $token = $event->getRequest()->get('token');
            if (is_null($token)) {
                throw new UnauthorizedHttpException(ErrorMessages::TOKEN_MISSING);
            }

            $userResult = $this->tokenHandler->getUserByToken($token);
            if ($userResult->getIsSuccess()) {
                $user = $userResult->getData();
                $userToken = new UsernamePasswordToken($user, null, $this->firewallName, $user->getRoles());
                $this->tokenStorage->setToken($userToken);
            } else {
                $errorMessage = join(', ', $userResult->getErrors());
                throw new UnauthorizedHttpException($errorMessage);
            }
        }
    }
}