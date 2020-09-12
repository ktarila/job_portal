<?php

namespace App\Security;

use App\Entity\AppUser;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Http\Authentication\AuthenticationFailureHandler;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Http\Authentication\AuthenticationSuccessHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\SecurityEvents;
use Symfony\Component\Security\Http\Session\SessionAuthenticationStrategyInterface;

class AppJsonAuthenticator extends AbstractGuardAuthenticator
{
    private $entityManager;
    private $router;
    private $csrfTokenManager;
    private $passwordEncoder;
    private $successHandler;
    private $failureHandler;
    private $sessionStrategy;
    private $logger;
    private $eventDispatcher;
    private $tokenStorage;

    public const LOGIN_ROUTE = 'login';

    public function __construct(
        TokenStorageInterface $tokenStorage,
        EntityManagerInterface $entityManager,
        RouterInterface $router,
        UserPasswordEncoderInterface $passwordEncoder,
        AuthenticationSuccessHandler $successHandler = null,
        AuthenticationFailureHandler $failureHandler = null,
        LoggerInterface $logger = null,
        EventDispatcherInterface $eventDispatcher = null
    ) {
        $this->entityManager = $entityManager;
        $this->router = $router;
        $this->passwordEncoder = $passwordEncoder;

        $this->successHandler = $successHandler;
        $this->failureHandler = $failureHandler;
        $this->logger = $logger;
        $this->eventDispatcher = $eventDispatcher;
        $this->tokenStorage = $tokenStorage;
    }

    public function supports(Request $request)
    {
        // dump("in support");
        return 'api_login' === $request->attributes->get('_route')
            && $request->isMethod('POST');
    }

    public function getCredentials(Request $request)
    {
        // todo
        $credentials = [];
        if ($content = $request->getContent()) {
            $credentials = json_decode($content, true);
        }
        return $credentials;
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        // todo
        $user = $this->entityManager->getRepository(AppUser::class)->loadUserByUsername($credentials['email']);


        if (!$user) {
            // fail authentication with a custom error
            throw new CustomUserMessageAuthenticationException('Email or password is not correct.');
        }

        if ($user->isActive() === false) {
            // fail authentication with a custom error
            throw new CustomUserMessageAuthenticationException('Your account has been deactivated. Contact Admin');
        }

        return $user;
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        // todo
        return $this->passwordEncoder->isPasswordValid($user, $credentials['password']);
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        // todo
        if (null !== $this->logger) {
            $this->logger->info('Authentication request failed.', ['exception' => $exception]);
        }

        $token = $this->tokenStorage->getToken();
        if ($token instanceof UsernamePasswordToken && $this->providerKey === $token->getProviderKey()) {
            $this->tokenStorage->setToken(null);
        }

        return new JsonResponse(['error' => $exception->getMessageKey()], 401);

        
        /* if (!$response instanceof Response) { */
        /*     throw new \RuntimeException('Authentication Failure Handler did not return a Response.'); */
        /* } */

        /* dump($response); */

        /* return $response; */
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        // todo
        if (null !== $this->logger) {
            $this->logger->info('User has been authenticated successfully.', ['username' => $token->getUsername()]);
        }
        $this->tokenStorage->setToken($token);

        if (null !== $this->eventDispatcher) {
            $loginEvent = new InteractiveLoginEvent($request, $token);
            $this->eventDispatcher->dispatch(SecurityEvents::INTERACTIVE_LOGIN, $loginEvent);
        }

        if (!$this->successHandler) {
            return; // let the original request succeeds
        }

        $response = $this->successHandler->onAuthenticationSuccess($request, $token);

        if (!$response instanceof Response) {
            throw new \RuntimeException('Authentication Success Handler did not return a Response.');
        }

        return $response;
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        // todo
        $data = [
            // you might translate this message
            'message' => 'Authentication Required',
        ];

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }

    public function supportsRememberMe()
    {
        // todo
        return false;
    }

    /**
     * Call this method if your authentication token is stored to a session.
     *
     * @final
     */
    public function setSessionAuthenticationStrategy(SessionAuthenticationStrategyInterface $sessionStrategy)
    {
        $this->sessionStrategy = $sessionStrategy;
    }

    private function migrateSession(Request $request, TokenInterface $token)
    {
        if (!$this->sessionStrategy || !$request->hasSession() || !$request->hasPreviousSession()) {
            return;
        }

        $this->sessionStrategy->onAuthentication($request, $token);
    }
}
