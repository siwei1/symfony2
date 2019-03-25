<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BaseController extends Controller
{
    /**
     * @return \AdminBundle\Entity\AdminUserRepository
     */
    public function getAdminUserRepository()
    {
        return $this->getDoctrine()->getRepository('AdminBundle:AdminUser');
    }
}