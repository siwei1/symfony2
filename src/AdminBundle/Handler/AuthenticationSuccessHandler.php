<?php

namespace AdminBundle\Handler;

use Doctrine\Bundle\DoctrineBundle\Registry as Doctrine;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

class AuthenticationSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    protected $em;
    public function __construct( Doctrine $doctrine )
    {
        $this->em = $doctrine->getManager();

    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        $user = $token->getUser();
        $user->setLastLoginTime(new \DateTime('now'));
        $this->em->persist($user);
        $this->em->flush();
        return new RedirectResponse('/admin/index');
    }
}