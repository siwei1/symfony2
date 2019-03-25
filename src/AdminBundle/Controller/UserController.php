<?php
namespace AdminBundle\Controller;
use AdminBundle\Entity\AdminUser;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


/**
 * @Route("/user")
 */
class UserController extends BaseController
{

    /**
     * @Route("/index",name="admin.user.index")
     */
    public function indexAction()
    {
        $users =$this->getAdminUserRepository()->findAll();
        return $this->render('admin/user/index.html.twig',compact('users'));
    }

    /**
     * @Route("/create",name="admin.user.create")
     */
    public function createAction(Request $request)
    {
        if($request->isMethod('post'))
        {
            $admin_user = new AdminUser();
            $admin_user->setUserName($request->get('user_name'));
            $admin_user->setPassword($request->get('password'));

            $encoder = $this->container->get('security.password_encoder');
            $password = $encoder->encodePassword($admin_user, $admin_user->getPassword());
            $admin_user->setPassword($password);


            $validator  = $this->get('validator');
            $errors = $validator->validate($admin_user);

            if(count($errors)>0)
            {
                return $this->render('admin/user/create.html.twig',compact('errors'));
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($admin_user);
            $em->flush();

            $this->addFlash('positive','创建用户'.$admin_user->getUserName().'成功');
            return $this->redirectToRoute('admin.user.index');
        }
        return $this->render('admin/user/create.html.twig');
    }

    /**
     * @Route("/update/{id}",name="admin.user.update",requirements={"id":"\d+"})
     */
    public function updateAction(Request $request,$id)
    {
        $admin_user = $this->getAdminUserRepository()->findOneBy(compact('id'));

        if(empty($admin_user))
        {
            $this->addFlash('negative','用户未找到');
            return $this->redirect($this->generateUrl('admin.user.index'));
        }

        if($request->isMethod('post'))
        {
            $admin_user->setUserName($request->get('user_name')) ;
            if(!empty($password = $request->get('password')))
            {
                $admin_user->setPassword($password);
                $encoder = $this->container->get('security.password_encoder');
                $password = $encoder->encodePassword($admin_user, $admin_user->getPassword());
                $admin_user->setPassword($password);
            }

            $validator = $this->get('validator');
            $errors = $validator->validate($admin_user);

            if(count($errors)>0)
            {
                return $this->render('AdminBundle::user/update.html.twig',compact('errors'));
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($admin_user);
            $em->flush();
            $this->addFlash('positive','用户ID'.$admin_user->getId().'修改成功');
            return $this->redirect($this->generateUrl('admin.user.index'));
        }

        return $this->render('AdminBundle::user/update.html.twig',compact('admin_user'));
    }

    /**
     * @Route("/del/{id}",name="admin.user.del",requirements={"id":"\d+"})
     */
    public function delAction($id)
    {
        $admin_user = $this->getAdminUserRepository()->findOneBy(compact('id'));
        if(empty($admin_user))
        {
            return new JsonResponse(['state'=>'1','msg'=>'用户未找到,请刷新重试']);
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($admin_user);
        $em->flush();
        return new JsonResponse(['state'=>'0','msg'=>'用户删除成功']);

    }
}