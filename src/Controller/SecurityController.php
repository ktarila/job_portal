<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Utils\RandomToken;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\NamedAddress;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class SecurityController extends AbstractController
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @Route("/api/login_check", name="api_login", methods={"POST"})
     * @return JsonResponse
     */
    public function loginAction(Request $request)
    {
    }

    /**
     * @Route("/api/security/change-password", name="change_password", methods={"POST"})
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @return JsonResponse
     */
    public function changePasswordAction(Request $request, UserInterface $user = null, UserPasswordEncoderInterface $encoder): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // dump($data);

        $response = new JsonResponse();
        $response->headers->set('Content-Type', 'application/json');

        //check if old password is same as current logged in password
        if (!$encoder->isPasswordValid($user, $data['old_password'])) {
            //passwords not the same
            $response->setStatusCode(400, 'validation error');
            $response->setData(['error' => 'Incorrect Old Password']);
            //dump($response);
            return $response;
        }
        // change password
        $encodedPassword = $encoder->encodePassword($user, $data['password']);
        $user->setPassword($encodedPassword);

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        $response->setStatusCode(200, 'Success');
        $response->setData(['success' => 'Password Changed Successfully']);
        //dump($response);
        return $response;
    }

    /**
     * @Route("/api/security/forgot-password", name="forgot_password", methods={"POST"})
     * @return JsonResponse
     */
    public function forgotPasswordAction(Request $request, RandomToken $randomToken, UserRepository $userRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $response = new JsonResponse();
        $response->headers->set('Content-Type', 'application/json');

        //get user that owns email
        $user = $userRepository->findByEmail($data['email']);

        // dump($user);

        //if user does not exist then return no such user
        if (!$user instanceof User) {
            $error = $data['email'] . " is not registered in database";
            $response->setStatusCode(400, 'validation error');
            $response->setData(['error' => $error]);
            return $response;
        }

        //if here then user exists --- generate reset password token
        $token = $randomToken->generateToken();
        $user->setResetPasswordToken($token);

        //expiry time is now + 1hr
        $date = new \DateTime("Africa/Lagos");
        $date->add(new \DateInterval('PT1H'));
        $expiryTime = $date;
        $user->setResetPasswordTokenExpiryTime($expiryTime);

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        $resetLink = $this->getParameter('app_origin') . "/reset-password/" . $token;
        $logoPath = $this->getParameter('kernel.project_dir') . "/public/images/logo.png";

        /* dump($resetLink); */

        // send email to user
        $email = (new TemplatedEmail())
            ->from('Patrick.Kenekayoro@outlook.com')
            ->to(new NamedAddress($data['email'], $user->getFullname()))
            ->subject('Reset Password')

            // path of the Twig template to render
            ->htmlTemplate('security/generateresetpasswordlink.html.twig')
            ->textTemplate('security/generateresetpasswordlink.txt.twig')
            // get the image contents from an existing file
            ->embedFromPath($logoPath, 'logo')

            // pass variables (name => value) to the template
            ->context([
                'name' => $user->getFullname(),
                'token' => $token,
                'resetLink' => $resetLink,
            ])
        ;

        $this->mailer->send($email);

        $success = "Link to change password sent to " . $data['email'];
        $response->setStatusCode(200, 'Success');
        $response->setData(['success' => $success]);
        //dump($response);
        return $response;
    }

    /**
     * @Route("/api/security/reset-password", name="reset_password", methods={"POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function changePasswordWithTokenAction(Request $request, UserPasswordEncoderInterface $encoder, UserRepository $userRepository)
    {
        $data = json_decode($request->getContent(), true);

        dump($data);

        $response = new JsonResponse();
        $response->headers->set('Content-Type', 'application/json');

        //check of token is valid again before changing the password
        $resetToken = $data['change_token'];
        //get user that owns token
        $user = $userRepository->findByResetPasswordToken($resetToken);

        //if no matching token -- return
        if (!$user instanceof User) {
            $response->setStatusCode(400, 'validation error');
            $response->setData(['error' => 'Invalid Change Password URL']);
            //dump($response);
            return $response;
        }
        //if got here token is valid -- check if token expired
        $currentTime = new \DateTime("Africa/Lagos");
        if ($currentTime > $user->getResetPasswordTokenExpiryTime()) {
            $response->setStatusCode(400, 'validation error');
            $response->setData(['error' => 'Change password URL has expired']);
            //dump($response);
            return $response;
        }

        //Token is valid and not expired so password can be safely changed
        $password_plain = $data['password'];
        $encodedPassword = $encoder->encodePassword($user, $password_plain);
        $user->setPassword($encodedPassword);
        $user->setResetPasswordToken(null);
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        $success = "Password has been reset. Login with new password";
        $response->setStatusCode(200, 'Success');
        $response->setData(['success' => $success]);
        //dump($response);
        return $response;
    }
}
