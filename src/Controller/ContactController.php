<?php 

namespace App\Controller;

use Pimcore\Controller\FrontendController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use App\Form\ContactFormType;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\FormBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Pimcore\Mail;



class ContactController extends FrontendController
{
    /**
     * @param Request $request
     * @param MailerInterface $mailer
     * @return Response
     */

     public function indexAction(Request $request, MailerInterface $mailer): Response
     {

        //Commenting the form for email!
        $form = $this->createForm(ContactFormType::class);
        
        $form->handleRequest($request);  

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $formData = $form->getData();

                try {
                    $mail = new \Pimcore\Mail();
                    $mail->from('example@email.com');
                    $mail->to('example@email.com');
                    $mail->setDocument('/emails/contact-us');
                    $mail->setParams($formData);
                    $mail->send();
                } catch (\Throwable $e) {
                    dd($e);
                    return $this->redirect('/contact');
                }

                return $this->redirect('/contact'); 
            }
        }

        return $this->render('contact/index.html.twig', 
            [
                'form' => $form->createView()
            ]
        );
     }

     /**
      * @param Request $request
      * @return Response
      */

      public function contactMailAction(Request $request)
      {
        $attributes = $request->attributes->all();

        return $this->render('emails/contact.html.twig', $attributes);
      }
}