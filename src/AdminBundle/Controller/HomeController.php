<?php

namespace AdminBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class HomeController
 * @package AdminBundle\Controller
 */
class HomeController extends BaseController
{

    /**
     * @Route("/index",name="admin.index")
     */
    public function indexAction()
    {
        return $this->render('admin/index.html.twig');
    }
}