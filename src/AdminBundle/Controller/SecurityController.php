<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class SecurityController  extends  BaseController
{
    /**
     * @Route("/login",name="admin.login")
     */
    public function loginAction(Request $request)
    {

        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('admin/login.html.twig', [
                'last_username' => $lastUsername,
                'error'         => $error
        ]);
    }

    /**
     * @Route("/login/check",name="admin.login.check")
     * @Method("post")
     */
    public function loginCheckAction(Request $request)
    {
    }
}