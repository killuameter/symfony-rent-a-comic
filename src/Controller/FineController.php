<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\Fine;
use App\Entity\Transaction;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class FineController extends AbstractController
{
    private $mailer;
   
    /**
     * @Route("amendes/{cart}", requirements={"cart":"\d+"}, name="fine_details")
     */
    public function cartAction(Request $request, ManagerRegistry $doctrine, Cart $cart)
    {
        $fineRepo = $doctrine->getRepository(Fine::class);
        
        $fines = $fineRepo->findByCart($cart);
        $param = array(
                "fines" => $fines,
                );
        return $this->render('amendes/amende_details.html.twig', $param);
    }

    /**
     * @Route("transaction/{fine}", requirements={"fine":"\d+"}, name="transac_details")
     */
    public function transactionAction(Request $request, ManagerRegistry $doctrine, Fine $fine)
    {
        $fineRepo = $doctrine->getRepository(Transaction::class);
        
        $transaction = $fineRepo->findOneByFine($fine);
        $param = array(
                "transaction" => $transaction,
                );
        return $this->render('transaction/transac_details.html.twig', $param);
    }
    
    /**
     * @Route("payer/{fine}", requirements={"fine":"\d+"}, name="payment_action")
     */
    public function paymentAction(Request $request, ManagerRegistry $doctrine, Fine $fine, MailerInterface $mailer2)
    {
        $em = $doctrine->getManager();

//        The http://guillaume.zz.mu/bank/ website doesn't work anymore
//        so we have to comment the next part :

//        //$this->em = $manager;
//        $secret = 'gm3sygqerettmeqtwbyma7tye868mpv6zys4x6yk688dekbxkd29ubhgtfmpgmz6vaf8g5vgfesmzbgbfmkbkkuqftz6mdm2zs6dbyar28k4bx7b3sepbvnrm7wuxy74';
//        $mid = '6nmet3c4zthdzb23f9y5z9awrzp7v7un';
//        $ccn = '4485187294407276' ;
//        $amo = '5599';
//        $tim = time();
//        $tim = $tim - 1000;
//        $tmp = $secret . $mid . $ccn . $amo . $tim;
//        $tok = hash("sha256", $tmp);
//        $http = 'http://guillaume.zz.mu/bank/payment/create?ccn='.$ccn.'&cvv=123&exp=122017&amo='.$amo.'&cur=eur&mid='.$mid.'&tim='.$tim.'&tok='.$tok;
//        $file = file_get_contents($http);
//        $tab = array ();
//        $tab = json_decode($file, true);
        ////        $transaction_id = $tab['transaction_id'];

        $transaction_id = "55506fad526f4";

        //$status = $tab['status'];
        $status = "payment_ok";

        //$message = $tab['message'];
        $message = "Payment created";
        $transaction = new transaction();
        $transaction->setFine($fine);
        $transaction->setDateCreated($fine->getDateCreated());
        $transaction->setDateValidationBq(new \DateTime('now'));
        $transaction->setStatus($status);
        $transaction->setMessage($message);
        $transaction->setAmount($fine->getAmount());
        $transaction->setTransactionId($transaction_id);
        
        $fine->setStatus('Payée');
        $em->persist($transaction);
        $em->persist($fine);
        
        $cartObj = $fine->getCart();
        $cartId = $cartObj->getId();
        $userObj = $cartObj->getUser();
        $userObj->setMyMoney($userObj->getMyMoney()-$fine->getAmount());
        $em->persist($userObj);

        $em->flush();
        $this->sendEmail($mailer2, 'Merci', $userObj->getFirstName(), $userObj->getLastName(), $fine->getAmount());
        
        return $this->redirectToRoute(
            "fine_details",
            array(
                    "cart" => $cartId
                )
        );
    }
    public function indexAction($name, $firstName, $lastName, $amount, $cartId, $sendTo, $mailer)
    {
        return $this->redirectToRoute(
            "fine_details",
            array(
                    "cart" => $cartId
                )
        );
    }
    // #[Route('/email')]
    public function sendEmail(MailerInterface $mailer, $name, $firstName, $lastName, $amount)
    {
        $email = (new TemplatedEmail())
            ->from('test@test.com')
            ->to(new Address('test@test.com'))
            ->subject('Rent-a-Comic Thanks for paying!')
        
            // path of the Twig template to render
            ->htmlTemplate('emails/fine.html.twig')
        
            // pass variables (name => value) to the template
            ->context([
                'name' => $name,
                'first' => $firstName,
                'last' => $lastName,
                'amount' => $amount,
                // 'expiration_date' => new \DateTime('+7 days'),
                // 'username' => 'foo',
            ])
        ;

        $mailer->send($email);

        // ...
    }
}
