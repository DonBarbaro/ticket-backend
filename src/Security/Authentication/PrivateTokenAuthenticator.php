<?php

namespace App\Security\Authentication;

use App\Entity\Project;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

class PrivateTokenAuthenticator extends AbstractAuthenticator
{

    private Project $project;

    public function __construct(private ManagerRegistry $doctrine)
    {
    }


    public function supports(Request $request): ?bool
    {
       return $request->headers->has('X-Private-Access');
    }

    public function authenticate(Request $request): Passport
    {
        $apiToken = $request->headers->get('X-Private-Access');

        if ($apiToken === null){
            throw new CustomUserMessageAuthenticationException('No API token provided');
        }


        $result = $this->doctrine->getRepository(Project::class)->findOneBy(['projectToken' => $apiToken]);

        if(!$result){
            throw new CustomUserMessageAuthenticationException('No project with this token');
        }

        $this->project = $result;

        return new SelfValidatingPassport(new UserBadge($apiToken, function ($apiToken) {
            return $this->getUser($apiToken);
        }), []);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        $data = [
            'message' => 'Wrong'
        ];

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }

    public function getUser(string $apiToken):PrivateProjectUser
    {
        return new PrivateProjectUser($apiToken, $this->project);
    }

//    public function start(Request $request, AuthenticationException $authException = null): Response
//    {
//        /*
//         * If you would like this class to control what happens when an anonymous user accesses a
//         * protected page (e.g. redirect to /login), uncomment this method and make this class
//         * implement Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface.
//         *
//         * For more details, see https://symfony.com/doc/current/security/experimental_authenticators.html#configuring-the-authentication-entry-point
//         */
//    }
}
