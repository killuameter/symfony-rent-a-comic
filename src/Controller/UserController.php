<?php

namespace App\Controller;

use \Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use App\Entity\Cart;
use App\Entity\Fine;
use App\Entity\Transaction;
use App\Entity\Book;
use App\Entity\PickupSpot;
use App\Form\UserType;
use Cocur\Slugify\Slugify;
use Doctrine\Persistence\ManagerRegistry;
use Faker\Factory;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

class UserController extends AbstractController
{
    /**
     * @var AuthenticationManagerInterface
     */
    private $authenticationManager;
    /**
     * @Route("/profil/{slug}", requirements={"slug":"[a-z0-9-]+"}, name="user_details")
     */
    public function userDetailsAction(
        \Symfony\Component\HttpFoundation\Request $request,
        ManagerRegistry $doctrine,
        $slug
    ) {
        $userRepo = $doctrine->getRepository(User::class);
        $user = $userRepo->findOneBySlug($slug);
        //pour page 404
        if (!$user) {
            throw $this->createNotFoundException("Hey merde!");
        }
        $params = array(
            "user" => $user
        );

        return $this->render('user/user_details.html.twig', $params);
    }
    /**
     * @Route("inscription" , name="inscription")
     */
    public function inscription(
        Request $request,
        ManagerRegistry $doctrine,
        UserPasswordHasherInterface $passwordHasher,
        TokenStorageInterface $tokenStorage
    ) {
        $user = new User();
        $createUserForm = $this->createForm(UserType::class, $user);
        $createUserForm->handleRequest($request);
        
        if ($createUserForm->isSubmitted() && $createUserForm->isValid()) {
            $user->setSubscriber(true);
            if ($user->getPostalCode()[0].$user->getPostalCode()[1] == '75') {
                $user->setCity('Paris');
            } else {
                $FormError =  new \Symfony\Component\Form\FormError('IL FAUT ETRE PARISIENS POUR ACCEDER A CE SERVICE');
                $FormError->setOrigin($createUserForm);
                $createUserForm->addError($FormError);
                $param = array(
                        "createUserForm" =>$createUserForm->createView(),
                );
                return $this->render('user/inscription.html.twig', $param);
            }
            $slugify = new Slugify();
            $slug = $slugify->slugify($user->getFirstName().'-'.$user->getLastName());
            $user->setSlug($slug.uniqid());

            // JP : pour l'instant aleatoire
            $faker = Factory::create('fr_FR');

            // $faker = \Faker\Factory::create();
            $user->setMyMoney($faker->randomFloat($nbMaxDecimals = 1, $min = 7, $max = 5035));
            $user->setLatitude($faker->randomFloat($nbMaxDecimals = 6, $min = 48.834540, $max = 48.883781));
            $user->setLongitude($faker->randomFloat($nbMaxDecimals = 6, $min = 2.296678, $max = 2.389375));
            $user->setCb('4485187294407276');
            $user->setRoles(array("ROLE_ADMIN"));
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $user->getPassword()
            );
            $user->setPassword($hashedPassword);
            
            $em = $doctrine->getManager();
            $em->persist($user);

            $cart = new cart();

            $cart->setUser($user);
            $cart->setDateCreated($faker->dateTimeBetween(" - 3 years "));
            $cart->setDateToBeReturn($faker->dateTimeThisMonth($max = 'now'));
            $cart->setDateReallyReturned($faker->dateTimeBetween($cart->getDateToBeReturn()));
            $cart->setDateModified($faker->dateTimeBetween($cart->getDateReallyReturned()));
            $cart->setTotalAmont(25);
            $cart->setStatus('Retourné');

            $bookRepo = $doctrine->getRepository(Book::class);
            $books = $bookRepo->findAll();
            shuffle($books);
            $tab = array();
            array_push($tab, $books[1]);
            array_push($tab, $books[2]);
            $cart->setBooks($tab);

            $pickupRepo = $doctrine->getRepository(PickupSpot::class);
            $pickups = $pickupRepo->findAll();
            shuffle($pickups);
            $cart->setPickup($pickups[1]);

            $em->persist($cart);

            $cart = new cart();

            $cart->setUser($user);
            $cart->setDateCreated($faker->dateTimeBetween(" - 3 years "));
            $cart->setDateToBeReturn($faker->dateTimeThisMonth($max = 'now'));
            $cart->setDateReallyReturned($faker->dateTimeBetween($cart->getDateToBeReturn()));
            $cart->setDateModified($faker->dateTimeBetween($cart->getDateReallyReturned()));
            $cart->setTotalAmont(25);
            $cart->setStatus('Retourné');

            $bookRepo = $doctrine->getRepository(Book::class);
            $books = $bookRepo->findAll();
            shuffle($books);
            $tab = array();
            array_push($tab, $books[1]);
            array_push($tab, $books[2]);
            array_push($tab, $books[3]);
            array_push($tab, $books[4]);
            array_push($tab, $books[5]);
            array_push($tab, $books[6]);
            array_push($tab, $books[7]);
            array_push($tab, $books[8]);
            $cart->setBooks($tab);

            $pickupRepo = $doctrine->getRepository(PickupSpot::class);
            $pickups = $pickupRepo->findAll();
            shuffle($pickups);
            $cart->setPickup($pickups[1]);

            $em->persist($cart);

            $cart = new cart();

            $cart->setUser($user);
            $cart->setDateCreated($faker->dateTimeBetween(" - 3 years "));
            $cart->setDateToBeReturn($faker->dateTimeThisMonth($max = 'now'));
            $cart->setDateReallyReturned($faker->dateTimeBetween($cart->getDateToBeReturn()));
            $cart->setDateModified($faker->dateTimeBetween($cart->getDateReallyReturned()));
            $cart->setTotalAmont(25);
            $cart->setStatus('Retourné');

            $bookRepo = $doctrine->getRepository(Book::class);
            $books = $bookRepo->findAll();
            shuffle($books);
            $tab = array();
            array_push($tab, $books[1]);
            $cart->setBooks($tab);

            $pickupRepo = $doctrine->getRepository(PickupSpot::class);
            $pickups = $pickupRepo->findAll();
            shuffle($pickups);
            $cart->setPickup($pickups[1]);
            $em->persist($cart);

            $fine = new fine();
            $fine->setCart($cart);
            $fine->setDateCreated($faker->dateTimeBetween($cart->getDateReallyReturned()));
            $fine->setDateModified($faker->dateTimeBetween($fine->getDateCreated()));
            $fine->setDateLimit($faker->dateTimeBetween($fine->getDateModified()));
            $fine->setAmount($faker->randomFloat($nbMaxDecimals = 2, $min = 7, $max = 28));
            $fine->setMotif('Endommagé');
            $fine->setStatus('Payée');
            $em->persist($fine);

            $transaction = new transaction();
            $transaction->setFine($fine);
            $transaction->setDateCreated($faker->dateTimeBetween($fine->getDateModified()));
            $transaction->setDateValidationBq($transaction->getDateCreated());
            $transaction->setStatus('payment_ok');
            $transaction->setMessage('Payment created');
            $transaction->setAmount($fine->getAmount());
            $transaction->setTransactionId('55506fad526f3');
            $em->persist($transaction);

            $fine = new fine();
            $fine->setCart($cart);
            $fine->setDateCreated($faker->dateTimeBetween($cart->getDateReallyReturned()));
            $fine->setDateModified($faker->dateTimeBetween($fine->getDateCreated()));
            $fine->setDateLimit($faker->dateTimeBetween($fine->getDateModified()));
            $fine->setAmount($faker->randomFloat($nbMaxDecimals = 2, $min = 7, $max = 28));
            $fine->setMotif('Retard');
            $fine->setStatus('Non payée');
            //$manager->persist($fine);
            $em->persist($fine);

            $cart = new cart();

            $cart->setUser($user);
            $cart->setDateCreated($faker->dateTimeBetween(" - 3 years "));
            $cart->setDateToBeReturn($faker->dateTimeThisMonth($max = 'now'));
            $cart->setDateReallyReturned($faker->dateTimeBetween($cart->getDateToBeReturn()));
            $cart->setDateModified($faker->dateTimeBetween($cart->getDateReallyReturned()));
            $cart->setTotalAmont(25);
            $cart->setStatus('Retourné');

            $bookRepo = $doctrine->getRepository(Book::class);
            $books = $bookRepo->findAll();
            shuffle($books);
            $tab = array();
            array_push($tab, $books[1]);
            $cart->setBooks($tab);

            $pickupRepo = $doctrine->getRepository(PickupSpot::class);
            $pickups = $pickupRepo->findAll();
            shuffle($pickups);
            $cart->setPickup($pickups[1]);
            $em->persist($cart);

            $fine = new fine();
            $fine->setCart($cart);
            $fine->setDateCreated($faker->dateTimeBetween($cart->getDateReallyReturned()));
            $fine->setDateModified($faker->dateTimeBetween($fine->getDateCreated()));
            $fine->setDateLimit($faker->dateTimeBetween($fine->getDateModified()));
            $fine->setAmount($faker->randomFloat($nbMaxDecimals = 2, $min = 7, $max = 28));
            $fine->setMotif('Endommagé');
            $fine->setStatus('Non payée');
            $em->persist($fine);

            $fine = new fine();
            $fine->setCart($cart);
            $fine->setDateCreated($faker->dateTimeBetween($cart->getDateReallyReturned()));
            $fine->setDateModified($faker->dateTimeBetween($fine->getDateCreated()));
            $fine->setDateLimit($faker->dateTimeBetween($fine->getDateModified()));
            $fine->setAmount($faker->randomFloat($nbMaxDecimals = 2, $min = 7, $max = 28));
            $fine->setMotif('Retard');
            $fine->setStatus('Payée');
            $em->persist($fine);

            $transaction = new transaction();
            $transaction->setFine($fine);
            $transaction->setDateCreated($faker->dateTimeBetween($fine->getDateModified()));
            $transaction->setDateValidationBq($transaction->getDateCreated());
            $transaction->setStatus('payment_ok');
            $transaction->setMessage('Payment created');
            $transaction->setAmount($fine->getAmount());
            $transaction->setTransactionId('55506fad526f4');
            $em->persist($transaction);

            $cart = new cart();

            $cart->setUser($user);
            $cart->setDateCreated($faker->dateTimeBetween(" - 3 years "));
            $cart->setDateToBeReturn($faker->dateTimeThisMonth($max = 'now'));
            $cart->setDateReallyReturned($faker->dateTimeBetween($cart->getDateToBeReturn()));
            $cart->setDateModified($faker->dateTimeBetween($cart->getDateReallyReturned()));
            $cart->setTotalAmont(25);
            $cart->setStatus('Retourné');

            $bookRepo = $doctrine->getRepository(Book::class);
            $books = $bookRepo->findAll();
            shuffle($books);
            $tab = array();
            array_push($tab, $books[1]);
            $cart->setBooks($tab);

            $pickupRepo = $doctrine->getRepository(PickupSpot::class);
            $pickups = $pickupRepo->findAll();
            shuffle($pickups);
            $cart->setPickup($pickups[1]);
            $em->persist($cart);

            $fine = new fine();
            $fine->setCart($cart);
            $fine->setDateCreated($faker->dateTimeBetween($cart->getDateReallyReturned()));
            $fine->setDateModified($faker->dateTimeBetween($fine->getDateCreated()));
            $fine->setDateLimit($faker->dateTimeBetween($fine->getDateModified()));
            $fine->setAmount($faker->randomFloat($nbMaxDecimals = 2, $min = 7, $max = 28));
            $fine->setMotif('Endommagé');
            $fine->setStatus('Non payée');
            $em->persist($fine);

            $fine = new fine();
            $fine->setCart($cart);
            $fine->setDateCreated($faker->dateTimeBetween($cart->getDateReallyReturned()));
            $fine->setDateModified($faker->dateTimeBetween($fine->getDateCreated()));
            $fine->setDateLimit($faker->dateTimeBetween($fine->getDateModified()));
            $fine->setAmount($faker->randomFloat($nbMaxDecimals = 2, $min = 7, $max = 28));
            $fine->setMotif('Retard');
            $fine->setStatus('Payée');
            $em->persist($fine);

            $transaction = new transaction();
            $transaction->setFine($fine);
            $transaction->setDateCreated($faker->dateTimeBetween($fine->getDateModified()));
            $transaction->setDateValidationBq($transaction->getDateCreated());
            $transaction->setStatus('payment_ok');
            $transaction->setMessage('Payment created');
            $transaction->setAmount($fine->getAmount());
            $transaction->setTransactionId('55506fad526f4');
            $em->persist($transaction);

            $cart = new cart();

            $cart->setUser($user);
            $cart->setDateCreated($faker->dateTimeBetween(" - 3 years "));
            $cart->setDateToBeReturn($faker->dateTimeThisMonth($max = 'now'));
            $cart->setDateReallyReturned($faker->dateTimeBetween($cart->getDateToBeReturn()));
            $cart->setDateModified($faker->dateTimeBetween($cart->getDateReallyReturned()));
            $cart->setTotalAmont(25);
            $cart->setStatus('Retourné');

            $doctrine->getRepository(Book::class);
            $books = $bookRepo->findAll();
            shuffle($books);
            $tab = array();
            array_push($tab, $books[1]);
            $cart->setBooks($tab);

            $pickupRepo = $doctrine->getRepository(PickupSpot::class);
            $pickups = $pickupRepo->findAll();
            shuffle($pickups);
            $cart->setPickup($pickups[1]);
            $em->persist($cart);

            $fine = new fine();
            $fine->setCart($cart);
            $fine->setDateCreated($faker->dateTimeBetween($cart->getDateReallyReturned()));
            $fine->setDateModified($faker->dateTimeBetween($fine->getDateCreated()));
            $fine->setDateLimit($faker->dateTimeBetween($fine->getDateModified()));
            $fine->setAmount($faker->randomFloat($nbMaxDecimals = 2, $min = 7, $max = 28));
            $fine->setMotif('Endommagé');
            $fine->setStatus('Non payée');
            $em->persist($fine);

            $fine = new fine();
            $fine->setCart($cart);
            $fine->setDateCreated($faker->dateTimeBetween($cart->getDateReallyReturned()));
            $fine->setDateModified($faker->dateTimeBetween($fine->getDateCreated()));
            $fine->setDateLimit($faker->dateTimeBetween($fine->getDateModified()));
            $fine->setAmount($faker->randomFloat($nbMaxDecimals = 2, $min = 7, $max = 28));
            $fine->setMotif('Retard');
            $fine->setStatus('Payée');
            $em->persist($fine);

            $transaction = new transaction();
            $transaction->setFine($fine);
            $transaction->setDateCreated($faker->dateTimeBetween($fine->getDateModified()));
            $transaction->setDateValidationBq($transaction->getDateCreated());
            $transaction->setStatus('payment_ok');
            $transaction->setMessage('Payment created');
            $transaction->setAmount($fine->getAmount());
            $transaction->setTransactionId('55506fad526f4');
            $em->persist($transaction);
            $em->flush();
        
            //log user
            $token = new UsernamePasswordToken($user, "main", $user->getRoles());

            $tokenStorage->setToken($token);

            //now dispatch the login event
            $event = new InteractiveLoginEvent($request, $token);
            $dispatcher = new EventDispatcher();
            $dispatcher->dispatch($event, "security.interactive_login");

            //redirige sur accueil
                
            return $this->redirectToRoute("catalogue");
        }
        
        $param = array(
            "createUserForm" =>$createUserForm->createView(),
            "FormError" => $createUserForm->getErrors()
        );

        return $this->render('user/inscription.html.twig', $param);
    }
    
     /**
     * @Route("/login",
     * name = "app_login")
     */
    public function loginFormAction(AuthenticationUtils $authenticationUtils)
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login_user.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

     /**
     * @Route ("/login_check",
     * name = "login_check")
     */
    public function loginCheckAction()
    {
    }
    
    /**
     * @Route ("/logout",
     * name = "logout")
     */
    public function logoutAction()
    {
    }

    private $slugifyThat;
}
