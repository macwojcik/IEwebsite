<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Mail;

class MainPageController extends Controller
{
    public function indexAction()
    {


        return $this->render('AppBundle:MainPage:index.html.twig', array(
            // ...
        ));
    }

    public function contactAction()
    {


        return $this->render('AppBundle:MainPage:contact.html.twig', array(
            //...
        ));
    }

    public function advertAction()
    {
        $em = $this->getDoctrine()->getManager();

        $advertisement = $em->getRepository('AppBundle:Advertisement')->findAll();
        $user = $em->getRepository('AppBundle:User')->findAll();
        $category = $em->getRepository('AppBundle:Category')->findAll();


        return $this->render('@App/MainPage/advert.html.twig', array(
            'adds' => $advertisement,
            'user' => $user,
            'category' =>$category,
        ));
    }

    public function sortAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $advertisement = $em->getRepository('AppBundle:Advertisement')->findAll();
        $user = $em->getRepository('AppBundle:User')->findAll();
        $category = $em->getRepository('AppBundle:Category')->findAll();


        return $this->render('AppBundle:MainPage:sort.html.twig', array(
            'adds' => $advertisement,
            'user' => $user,
            'category' => $category,
            'sortid' => $id,
        ));
    }

    public function addinfoAction($n)
    {
        $em = $this->getDoctrine()->getManager();
        $advertisement = $em->getRepository('AppBundle:Advertisement')->findAll();
        $user = $em->getRepository('AppBundle:User')->findAll();
        $category = $em->getRepository('AppBundle:Category')->findAll();

        $request = $this->container->get('request_stack')->getCurrentRequest();

        $mail = new Mail();

        $form = $this->createFormBuilder($mail)
            ->add('subject', 'text')
            ->add('email', 'text')
            ->add('text', 'text')
            ->add('Wyślij', 'submit')
            ->getForm();



        $form->handleRequest($request);



        if ($form->isValid()) {



            $message = \Swift_Message::newInstance()
                ->setSubject($mail->getSubject())
                ->setFrom('support@dreamjob.com')
                ->setTo($mail->getEmail())
                ->setBody($mail->getText());

            $this->get('mailer')->send($message);

            return $this->redirect($this->generateUrl('advert'));
        }

        return $this->render('AppBundle:MainPage:addinfo.html.twig', array(
            'n' => $n,
            'adds' => $advertisement,
            'user' => $user,
            'category' => $category,
            'form' => $form->createView(),
        ));
    }

}
