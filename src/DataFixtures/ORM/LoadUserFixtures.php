<?php
namespace App\DataFixtures\ORM;

use Faker\Factory;
use App\Entity\Book;
use App\Entity\Cart;
use App\Entity\Fine;
use App\Entity\User;
use App\Entity\PickupSpot;
use App\Entity\Transaction;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class LoadUserFixtures extends Fixture
{
    // use ContainerAwareTrait;
    private $em;
    private $faker;
    private UserPasswordHasherInterface $hasher;
    private SluggerInterface $slugger;
    private ManagerRegistry $doctrine;

    public function __construct(
        UserPasswordHasherInterface $hasher,
        SluggerInterface $slugger,
        ManagerRegistry $doctrine
    ) {
        $this->hasher = $hasher;
        $this->slugger = $slugger;
        $this->doctrine = $doctrine;
    }

    public function load(ObjectManager $manager)
    {
        $this->em = $manager;
        $faker = Factory::create('fr_FR');

        //en boucle, créer quelques User
        for ($i=0; $i < 10; $i++) {
            $user = new User();
            $user->setFirstName($faker->firstName());
            $user->setLastName($faker->lastName());
            $user->setPassword('123');
            $user->setEmail($faker->email());
            $user->setNickname($faker->userName());
            $user->setAddress($faker->address());
            $user->setCity('Paris');
            $user->setTel($faker->phoneNumber());
            $user->setRoles(array("ROLE_ADMIN"));
            $user->setSubscriber($faker->boolean($chanceOfGettingTrue = 85));
            $user->setMyMoney($faker->randomFloat($nbMaxDecimals = 1, $min = 650, $max = 1550));
            $user->setLatitude($faker->randomFloat($nbMaxDecimals = 6, $min = 48.834540, $max = 48.883781));
            $user->setLongitude($faker->randomFloat($nbMaxDecimals = 6, $min = 2.296678, $max = 2.389375));
            $user->setCb('4485187294407276');
            $postalCodeArray = array();
            for ($l=75001; $l < 75021; $l++) {
                array_push($postalCodeArray, $l);
            }
            shuffle($postalCodeArray);
            $user->setPostalCode($postalCodeArray[0]);
            
            $password = $this->hasher->hashPassword($user, $user->getPassword());
            $user->setPassword($password);

            $slug = $this->slugger->slug(strtolower($user->getFirstName().'-'.$user->getLastName().uniqid()));
            $user->setSlug($slug);

            $manager->persist($user);
        }

        $user = new User();
        $user->setFirstName('Jacques');
        $user->setLastName('Chirac');
        $user->setPassword('123');
        $user->setEmail($faker->email());
        $user->setNickname('J.Chirac');
        $user->setAddress('3 Quai Voltaire');
        $user->setCity('Paris');
        $user->setTel($faker->phoneNumber());
        $user->setRoles(array("ROLE_ADMIN"));
        $user->setSubscriber(1);
        $user->setMyMoney($faker->randomFloat($nbMaxDecimals = 1, $min = 850, $max = 1399));
        $user->setLatitude($faker->randomFloat($nbMaxDecimals = 6, $min = 48.834540, $max = 48.883781));
        $user->setLongitude($faker->randomFloat($nbMaxDecimals = 6, $min = 2.296678, $max = 2.389375));
        $user->setCb('4485187294407276');
        $user->setPostalCode('75007');
        $password = $this->hasher->hashPassword($user, $user->getPassword());
        $user->setPassword($password);

        $slug = $this->slugger->slug(strtolower($user->getFirstName().'-'.$user->getLastName().uniqid()));
        $user->setSlug($slug);
            
        $manager->persist($user);
            
        $user = new User();
        $user->setFirstName('Aymane');
        $user->setLastName('Khouaji');
        $user->setPassword('12345');
        $user->setEmail($faker->email());
        $user->setNickname('Odint');
        $user->setAddress('3 rue Foch');
        $user->setCity('Paris');
        $user->setTel($faker->phoneNumber());
        $user->setRoles(array("ROLE_ADMIN"));
        $user->setSubscriber(1);
        $user->setMyMoney($faker->randomFloat($nbMaxDecimals = 1, $min = 850, $max = 1399));
        $user->setLatitude($faker->randomFloat($nbMaxDecimals = 6, $min = 48.834540, $max = 48.883781));
        $user->setLongitude($faker->randomFloat($nbMaxDecimals = 6, $min = 2.296678, $max = 2.389375));
        $user->setCb('4485187294407276');
        $user->setPostalCode('75016');
        $password = $this->hasher->hashPassword($user, $user->getPassword());
        $user->setPassword($password);
        $slug = $this->slugger->slug(strtolower($user->getFirstName().'-'.$user->getLastName().uniqid()));
        $user->setSlug($slug);
            
        $manager->persist($user);
            
        $user = new User();
        $user->setFirstName('Julien');
        $user->setLastName('Ouali');
        $user->setPassword('123');
        $user->setEmail($faker->email());
        $user->setNickname('test');
        $user->setAddress('33 rue Cambon');
        $user->setCity('Paris');
        $user->setTel($faker->phoneNumber());
        $user->setRoles(array("ROLE_ADMIN"));
        $user->setSubscriber(1);
        $user->setMyMoney($faker->randomFloat($nbMaxDecimals = 1, $min = 850, $max = 1399));
        $user->setLatitude($faker->randomFloat($nbMaxDecimals = 6, $min = 48.834540, $max = 48.883781));
        $user->setLongitude($faker->randomFloat($nbMaxDecimals = 6, $min = 2.296678, $max = 2.389375));
        $user->setCb('4485187294407276');
        $user->setPostalCode('75001');
        $password = $this->hasher->hashPassword($user, $user->getPassword());
        $user->setPassword($password);
        $slug = $this->slugger->slug(strtolower($user->getFirstName().'-'.$user->getLastName().uniqid()));
        $user->setSlug($slug);
            
        $manager->persist($user);
            
        $user = new User();
        $user->setFirstName('Lionel');
        $user->setLastName('Jospin');
        $user->setPassword('123');
        $user->setEmail($faker->email());
        $user->setNickname('L.Jospin');
        $user->setAddress('3 rue foch');
        $user->setCity('Paris');
        $user->setTel($faker->phoneNumber());
        $user->setRoles(array("ROLE_ADMIN"));
        $user->setSubscriber(1);
        $user->setMyMoney($faker->randomFloat($nbMaxDecimals = 1, $min = 850, $max = 1399));
        $user->setLatitude($faker->randomFloat($nbMaxDecimals = 6, $min = 48.834540, $max = 48.883781));
        $user->setLongitude($faker->randomFloat($nbMaxDecimals = 6, $min = 2.296678, $max = 2.389375));
        $user->setCb('4485187294407276');
        $user->setPostalCode('75016');
        $password = $this->hasher->hashPassword($user, $user->getPassword());
        $user->setPassword($password);
        $slug = $this->slugger->slug(strtolower($user->getFirstName().'-'.$user->getLastName().uniqid()));
        $user->setSlug($slug);
            
        $manager->persist($user);
            
        $cart = new cart();
            
        $cart->setUser($user);
        $cart->setDateCreated($faker->dateTimeBetween(" - 3 years "));
        $cart->setDateToBeReturn($faker->dateTimeThisMonth($max = 'now'));
        $cart->setDateReallyReturned($faker->dateTimeBetween($cart->getDateToBeReturn()));
        $cart->setDateModified($faker->dateTimeBetween($cart->getDateReallyReturned()));
        $cart->setTotalAmont(25);
        $cart->setStatus('Retourné');
            
        $books = $this->doctrine->getRepository(Book::class)->findAll();
        shuffle($books);
        $tab = array();
        array_push($tab, $books[1]);
        $cart->setBooks($tab);
            
        $pickupRepo = $this->doctrine->getRepository(PickupSpot::class);
        $pickups = $pickupRepo->findAll();
        shuffle($pickups);
        $cart->setPickup($pickups[1]);

        $manager->persist($cart);

        $user = new User();
        $user->setFirstName('Raymond');
        $user->setLastName('Barre');
        $user->setPassword('123');
        $user->setEmail($faker->email());
        $user->setNickname('R.Barre');
        $user->setAddress('3 rue foch');
        $user->setCity('Paris');
        $user->setTel($faker->phoneNumber());
        $user->setRoles(array("ROLE_ADMIN"));
        $user->setSubscriber(1);
        $user->setMyMoney($faker->randomFloat($nbMaxDecimals = 1, $min = 850, $max = 1399));
        $user->setLatitude($faker->randomFloat($nbMaxDecimals = 6, $min = 48.834540, $max = 48.883781));
        $user->setLongitude($faker->randomFloat($nbMaxDecimals = 6, $min = 2.296678, $max = 2.389375));
        $user->setCb('4485187294407276');
        $user->setPostalCode('75016');
        $password = $this->hasher->hashPassword($user, $user->getPassword());
        $user->setPassword($password);
        $slug = $this->slugger->slug(strtolower($user->getFirstName().'-'.$user->getLastName().uniqid()));
        $user->setSlug($slug);
            
        $manager->persist($user);
            
        $cart = new cart();
            
        $cart->setUser($user);
        $cart->setDateCreated($faker->dateTimeBetween(" - 3 years "));
        $cart->setDateToBeReturn($faker->dateTimeThisMonth($max = 'now'));
        $cart->setDateReallyReturned($faker->dateTimeBetween($cart->getDateToBeReturn()));
        $cart->setDateModified($faker->dateTimeBetween($cart->getDateReallyReturned()));
        $cart->setTotalAmont(25);
        $cart->setStatus('Retourné');
            
        $bookRepo = $this->doctrine->getRepository(Book::class);
        $books = $bookRepo->findAll();
        shuffle($books);
        $tab = array();
        array_push($tab, $books[1]);
        array_push($tab, $books[2]);
        $cart->setBooks($tab);
            
        // $pickupRepo = $this->doctrine->getRepository("App:Pickupspot");
        $pickupRepo = $this->doctrine->getRepository(PickupSpot::class);
        $pickups = $pickupRepo->findAll();
        shuffle($pickups);
        $cart->setPickup($pickups[1]);

        $manager->persist($cart);
        
        $user = new User();
        $user->setFirstName('Arlette');
        $user->setLastName('Laguiller');
        $user->setPassword('123');
        $user->setEmail($faker->email());
        $user->setNickname('A.Laguil');
        $user->setAddress('3 rue foch');
        $user->setCity('Paris');
        $user->setTel($faker->phoneNumber());
        $user->setRoles(array("ROLE_ADMIN"));
        $user->setSubscriber(1);
        $user->setMyMoney($faker->randomFloat($nbMaxDecimals = 1, $min = 850, $max = 1399));
        $user->setLatitude($faker->randomFloat($nbMaxDecimals = 6, $min = 48.834540, $max = 48.883781));
        $user->setLongitude($faker->randomFloat($nbMaxDecimals = 6, $min = 2.296678, $max = 2.389375));
        $user->setCb('4485187294407276');
        $user->setPostalCode('75016');
        $password = $this->hasher->hashPassword($user, $user->getPassword());
        $user->setPassword($password);
        $slug = $this->slugger->slug(strtolower($user->getFirstName().'-'.$user->getLastName().uniqid()));
        $user->setSlug($slug);
            
        $manager->persist($user);
            
        $cart = new cart();
            
        $cart->setUser($user);
        $cart->setDateCreated($faker->dateTimeBetween(" - 3 years "));
        $cart->setDateToBeReturn($faker->dateTimeThisMonth($max = 'now'));
        $cart->setDateReallyReturned($faker->dateTimeBetween($cart->getDateToBeReturn()));
        $cart->setDateModified($faker->dateTimeBetween($cart->getDateReallyReturned()));
        $cart->setTotalAmont(25);
        $cart->setStatus('Retourné');
            
        $bookRepo = $this->doctrine->getRepository(Book::class);
        $books = $bookRepo->findAll();
        shuffle($books);
        $tab = array();
        array_push($tab, $books[1]);
        array_push($tab, $books[2]);
        $cart->setBooks($tab);

        $pickupRepo = $this->doctrine->getRepository(PickupSpot::class);
        $pickups = $pickupRepo->findAll();
        shuffle($pickups);
        $cart->setPickup($pickups[1]);

        $manager->persist($cart);
            
        $cart = new cart();
            
        $cart->setUser($user);
        $cart->setDateCreated($faker->dateTimeBetween(" - 3 years "));
        $cart->setDateToBeReturn($faker->dateTimeThisMonth($max = 'now'));
        $cart->setDateReallyReturned($faker->dateTimeBetween($cart->getDateToBeReturn()));
        $cart->setDateModified($faker->dateTimeBetween($cart->getDateReallyReturned()));
        $cart->setTotalAmont(25);
        $cart->setStatus('Retourné');
            
        $bookRepo = $this->doctrine->getRepository(Book::class);
        $books = $bookRepo->findAll();
        shuffle($books);
        $tab = array();
        array_push($tab, $books[1]);
        array_push($tab, $books[2]);
        array_push($tab, $books[3]);
        $cart->setBooks($tab);

        $pickupRepo = $this->doctrine->getRepository(PickupSpot::class);
        $pickups = $pickupRepo->findAll();
        shuffle($pickups);
        $cart->setPickup($pickups[1]);

        $manager->persist($cart);

        $user = new User();
        $user->setFirstName('Jack');
        $user->setLastName('Lang');
        $user->setPassword('123');
        $user->setEmail($faker->email());
        $user->setNickname('J.Lang');
        $user->setAddress('3 rue foch');
        $user->setCity('Paris');
        $user->setTel($faker->phoneNumber());
        $user->setRoles(array("ROLE_ADMIN"));
        $user->setSubscriber(1);
        $user->setMyMoney($faker->randomFloat($nbMaxDecimals = 1, $min = 850, $max = 1399));
        $user->setLatitude($faker->randomFloat($nbMaxDecimals = 6, $min = 48.834540, $max = 48.883781));
        $user->setLongitude($faker->randomFloat($nbMaxDecimals = 6, $min = 2.296678, $max = 2.389375));
        $user->setCb('4485187294407276');
        $user->setPostalCode('75016');
        $password = $this->hasher->hashPassword($user, $user->getPassword());
        $user->setPassword($password);

        $slug = $this->slugger->slug(strtolower($user->getFirstName().'-'.$user->getLastName().uniqid()));
        $user->setSlug($slug);
            
        $manager->persist($user);
            
        $cart = new cart();
            
        $cart->setUser($user);
        $cart->setDateCreated($faker->dateTimeBetween(" - 3 years "));
        $cart->setDateToBeReturn($faker->dateTimeThisMonth($max = 'now'));
        $cart->setDateReallyReturned($faker->dateTimeBetween($cart->getDateToBeReturn()));
        $cart->setDateModified($faker->dateTimeBetween($cart->getDateReallyReturned()));
        $cart->setTotalAmont(25);
        $cart->setStatus('Retourné');
            
        $bookRepo = $this->doctrine->getRepository(Book::class);
        $books = $bookRepo->findAll();
        shuffle($books);
        $tab = array();
        array_push($tab, $books[1]);
        array_push($tab, $books[2]);
        $cart->setBooks($tab);
            
        $pickupRepo = $this->doctrine->getRepository(PickupSpot::class);
        $pickups = $pickupRepo->findAll();
        shuffle($pickups);
        $cart->setPickup($pickups[1]);

        $manager->persist($cart);
            
        $cart = new cart();
            
        $cart->setUser($user);
        $cart->setDateCreated($faker->dateTimeBetween(" - 3 years "));
        $cart->setDateToBeReturn($faker->dateTimeThisMonth($max = 'now'));
        $cart->setDateReallyReturned($faker->dateTimeBetween($cart->getDateToBeReturn()));
        $cart->setDateModified($faker->dateTimeBetween($cart->getDateReallyReturned()));
        $cart->setTotalAmont(25);
        $cart->setStatus('Retourné');
            
        $bookRepo = $this->doctrine->getRepository(Book::class);
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
        array_push($tab, $books[9]);
        array_push($tab, $books[10]);
        $cart->setBooks($tab);
            
        $pickupRepo = $this->doctrine->getRepository(PickupSpot::class);
        $pickups = $pickupRepo->findAll();
        shuffle($pickups);
        $cart->setPickup($pickups[1]);

        $manager->persist($cart);
            
        $cart = new cart();
            
        $cart->setUser($user);
        $cart->setDateCreated($faker->dateTimeBetween(" - 3 years "));
        $cart->setDateToBeReturn($faker->dateTimeThisMonth($max = 'now'));
        $cart->setDateReallyReturned($faker->dateTimeBetween($cart->getDateToBeReturn()));
        $cart->setDateModified($faker->dateTimeBetween($cart->getDateReallyReturned()));
        $cart->setTotalAmont(25);
        $cart->setStatus('Retourné');
            
        $bookRepo = $this->doctrine->getRepository(Book::class);
        $books = $bookRepo->findAll();
        shuffle($books);
        $tab = array();
        array_push($tab, $books[1]);
        $cart->setBooks($tab);
            
        $pickupRepo = $this->doctrine->getRepository(PickupSpot::class);
        $pickups = $pickupRepo->findAll();
        shuffle($pickups);
        $cart->setPickup($pickups[1]);
        $manager->persist($cart);
            
        $fine = new fine();
        $fine->setCart($cart);
        $fine->setDateCreated($faker->dateTimeBetween($cart->getDateReallyReturned()));
        $fine->setDateModified($faker->dateTimeBetween($fine->getDateCreated()));
        $fine->setDateLimit($faker->dateTimeBetween($fine->getDateModified()));
        $fine->setAmount($faker->randomFloat($nbMaxDecimals = 2, $min = 7, $max = 28));
        $fine->setMotif('Endommagé');
        $fine->setStatus('Payée');
        $manager->persist($fine);
            
        $transaction = new transaction();
        $transaction->setFine($fine);
        $transaction->setDateCreated($faker->dateTimeBetween($fine->getDateModified()));
        $transaction->setDateValidationBq($transaction->getDateCreated());
        $transaction->setStatus('payment_ok');
        $transaction->setMessage('Payment created');
        $transaction->setAmount($fine->getAmount());
        $transaction->setTransactionId('55506fad526f3');
        $manager->persist($transaction);
            
        $fine = new fine();
        $fine->setCart($cart);
        $fine->setDateCreated($faker->dateTimeBetween($cart->getDateReallyReturned()));
        $fine->setDateModified($faker->dateTimeBetween($fine->getDateCreated()));
        $fine->setDateLimit($faker->dateTimeBetween($fine->getDateModified()));
        $fine->setAmount($faker->randomFloat($nbMaxDecimals = 2, $min = 7, $max = 28));
        $fine->setMotif('Retard');
        $fine->setStatus('Non payée');
        $manager->persist($fine);

        $cart = new cart();
            
        $cart->setUser($user);
        $cart->setDateCreated($faker->dateTimeBetween(" - 3 years "));
        $cart->setDateToBeReturn($faker->dateTimeThisMonth($max = 'now'));
        $cart->setDateReallyReturned($faker->dateTimeBetween($cart->getDateToBeReturn()));
        $cart->setDateModified($faker->dateTimeBetween($cart->getDateReallyReturned()));
        $cart->setTotalAmont(25);
        $cart->setStatus('Retourné');
            
        $bookRepo = $this->doctrine->getRepository(Book::class);
        $books = $bookRepo->findAll();
        shuffle($books);
        $tab = array();
        array_push($tab, $books[1]);
        $cart->setBooks($tab);
            
        $pickupRepo = $this->doctrine->getRepository(PickupSpot::class);
        $pickups = $pickupRepo->findAll();
        shuffle($pickups);
        $cart->setPickup($pickups[1]);
        $manager->persist($cart);
            
        $fine = new fine();
        $fine->setCart($cart);
        $fine->setDateCreated($faker->dateTimeBetween($cart->getDateReallyReturned()));
        $fine->setDateModified($faker->dateTimeBetween($fine->getDateCreated()));
        $fine->setDateLimit($faker->dateTimeBetween($fine->getDateModified()));
        $fine->setAmount($faker->randomFloat($nbMaxDecimals = 2, $min = 7, $max = 28));
        $fine->setMotif('Endommagé');
        $fine->setStatus('Non payée');
        $manager->persist($fine);
            
        $fine = new fine();
        $fine->setCart($cart);
        $fine->setDateCreated($faker->dateTimeBetween($cart->getDateReallyReturned()));
        $fine->setDateModified($faker->dateTimeBetween($fine->getDateCreated()));
        $fine->setDateLimit($faker->dateTimeBetween($fine->getDateModified()));
        $fine->setAmount($faker->randomFloat($nbMaxDecimals = 2, $min = 7, $max = 28));
        $fine->setMotif('Retard');
        $fine->setStatus('Payée');
        $manager->persist($fine);
            
        $transaction = new transaction();
        $transaction->setFine($fine);
        $transaction->setDateCreated($faker->dateTimeBetween($fine->getDateModified()));
        $transaction->setDateValidationBq($transaction->getDateCreated());
        $transaction->setStatus('payment_ok');
        $transaction->setMessage('Payment created');
        $transaction->setAmount($fine->getAmount());
        $transaction->setTransactionId('55506fad526f4');
        $manager->persist($transaction);
                    
        $user = new User();
        $user->setFirstName('Roselyne');
        $user->setLastName('Bachelot');
        $user->setPassword('123');
        $user->setEmail($faker->email());
        $user->setNickname('R.Bachel');
        $user->setAddress('3 rue foch');
        $user->setCity('Paris');
        $user->setTel($faker->phoneNumber());
        $user->setRoles(array("ROLE_ADMIN"));
        $user->setSubscriber(1);
        $user->setMyMoney($faker->randomFloat($nbMaxDecimals = 1, $min = 650, $max = 1550));
        $user->setLatitude($faker->randomFloat($nbMaxDecimals = 6, $min = 48.834540, $max = 48.883781));
        $user->setLongitude($faker->randomFloat($nbMaxDecimals = 6, $min = 2.296678, $max = 2.389375));
        $user->setCb('4485187294407276');
        $user->setPostalCode('75016');
        $password = $this->hasher->hashPassword($user, $user->getPassword());
        $user->setPassword($password);
        $slug = $this->slugger->slug(strtolower($user->getFirstName().'-'.$user->getLastName().uniqid()));
        $user->setSlug($slug);
            
        $manager->persist($user);
            
        $cart = new cart();
            
        $cart->setUser($user);
        $cart->setDateCreated($faker->dateTimeBetween(" - 3 years "));
        $cart->setDateToBeReturn($faker->dateTimeThisMonth($max = 'now'));
        $cart->setDateReallyReturned($faker->dateTimeBetween($cart->getDateToBeReturn()));
        $cart->setDateModified($faker->dateTimeBetween($cart->getDateReallyReturned()));
        $cart->setTotalAmont(25);
        $cart->setStatus('Retourné');
            
        $bookRepo = $this->doctrine->getRepository(Book::class);
        $books = $bookRepo->findAll();
        shuffle($books);
        $tab = array();
        array_push($tab, $books[1]);
        array_push($tab, $books[2]);
        $cart->setBooks($tab);
            
        $pickupRepo = $this->doctrine->getRepository(PickupSpot::class);
        $pickups = $pickupRepo->findAll();
        shuffle($pickups);
        $cart->setPickup($pickups[1]);

        $manager->persist($cart);
            
        $cart = new cart();
            
        $cart->setUser($user);
        $cart->setDateCreated($faker->dateTimeBetween(" - 3 years "));
        $cart->setDateToBeReturn($faker->dateTimeThisMonth($max = 'now'));
        $cart->setDateReallyReturned($faker->dateTimeBetween($cart->getDateToBeReturn()));
        $cart->setDateModified($faker->dateTimeBetween($cart->getDateReallyReturned()));
        $cart->setTotalAmont(25);
        $cart->setStatus('Retourné');
            
        $bookRepo = $this->doctrine->getRepository(Book::class);
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
            
        $pickupRepo = $this->doctrine->getRepository(PickupSpot::class);
        $pickups = $pickupRepo->findAll();
        shuffle($pickups);
        $cart->setPickup($pickups[1]);

        $manager->persist($cart);
            
        $cart = new cart();
            
        $cart->setUser($user);
        $cart->setDateCreated($faker->dateTimeBetween(" - 3 years "));
        $cart->setDateToBeReturn($faker->dateTimeThisMonth($max = 'now'));
        $cart->setDateReallyReturned($faker->dateTimeBetween($cart->getDateToBeReturn()));
        $cart->setDateModified($faker->dateTimeBetween($cart->getDateReallyReturned()));
        $cart->setTotalAmont(25);
        $cart->setStatus('Retourné');
            
        $bookRepo = $this->doctrine->getRepository(Book::class);
        $books = $bookRepo->findAll();
        shuffle($books);
        $tab = array();
        array_push($tab, $books[1]);
        $cart->setBooks($tab);
            
        $pickupRepo = $this->doctrine->getRepository(PickupSpot::class);
        $pickups = $pickupRepo->findAll();
        shuffle($pickups);
        $cart->setPickup($pickups[1]);
        $manager->persist($cart);
            
        $fine = new fine();
        $fine->setCart($cart);
        $fine->setDateCreated($faker->dateTimeBetween($cart->getDateReallyReturned()));
        $fine->setDateModified($faker->dateTimeBetween($fine->getDateCreated()));
        $fine->setDateLimit($faker->dateTimeBetween($fine->getDateModified()));
        $fine->setAmount($faker->randomFloat($nbMaxDecimals = 2, $min = 7, $max = 28));
        $fine->setMotif('Endommagé');
        $fine->setStatus('Payée');
        $manager->persist($fine);
            
        $transaction = new transaction();
        $transaction->setFine($fine);
        $transaction->setDateCreated($faker->dateTimeBetween($fine->getDateModified()));
        $transaction->setDateValidationBq($transaction->getDateCreated());
        $transaction->setStatus('payment_ok');
        $transaction->setMessage('Payment created');
        $transaction->setAmount($fine->getAmount());
        $transaction->setTransactionId('55506fad526f3');
        $manager->persist($transaction);
            
        $fine = new fine();
        $fine->setCart($cart);
        $fine->setDateCreated($faker->dateTimeBetween($cart->getDateReallyReturned()));
        $fine->setDateModified($faker->dateTimeBetween($fine->getDateCreated()));
        $fine->setDateLimit($faker->dateTimeBetween($fine->getDateModified()));
        $fine->setAmount($faker->randomFloat($nbMaxDecimals = 2, $min = 7, $max = 28));
        $fine->setMotif('Retard');
        $fine->setStatus('Non payée');
        $manager->persist($fine);

        $cart = new cart();
            
        $cart->setUser($user);
        $cart->setDateCreated($faker->dateTimeBetween(" - 3 years "));
        $cart->setDateToBeReturn($faker->dateTimeThisMonth($max = 'now'));
        $cart->setDateReallyReturned($faker->dateTimeBetween($cart->getDateToBeReturn()));
        $cart->setDateModified($faker->dateTimeBetween($cart->getDateReallyReturned()));
        $cart->setTotalAmont(25);
        $cart->setStatus('Retourné');
            
        $bookRepo = $this->doctrine->getRepository(Book::class);
        $books = $bookRepo->findAll();
        shuffle($books);
        $tab = array();
        array_push($tab, $books[1]);
        $cart->setBooks($tab);
            
        $pickupRepo = $this->doctrine->getRepository(PickupSpot::class);
        $pickups = $pickupRepo->findAll();
        shuffle($pickups);
        $cart->setPickup($pickups[1]);
        $manager->persist($cart);
            
        $fine = new fine();
        $fine->setCart($cart);
        $fine->setDateCreated($faker->dateTimeBetween($cart->getDateReallyReturned()));
        $fine->setDateModified($faker->dateTimeBetween($fine->getDateCreated()));
        $fine->setDateLimit($faker->dateTimeBetween($fine->getDateModified()));
        $fine->setAmount($faker->randomFloat($nbMaxDecimals = 2, $min = 7, $max = 28));
        $fine->setMotif('Endommagé');
        $fine->setStatus('Non payée');
        $manager->persist($fine);
            
        $fine = new fine();
        $fine->setCart($cart);
        $fine->setDateCreated($faker->dateTimeBetween($cart->getDateReallyReturned()));
        $fine->setDateModified($faker->dateTimeBetween($fine->getDateCreated()));
        $fine->setDateLimit($faker->dateTimeBetween($fine->getDateModified()));
        $fine->setAmount($faker->randomFloat($nbMaxDecimals = 2, $min = 7, $max = 28));
        $fine->setMotif('Retard');
        $fine->setStatus('Payée');
        $manager->persist($fine);
            
        $transaction = new transaction();
        $transaction->setFine($fine);
        $transaction->setDateCreated($faker->dateTimeBetween($fine->getDateModified()));
        $transaction->setDateValidationBq($transaction->getDateCreated());
        $transaction->setStatus('payment_ok');
        $transaction->setMessage('Payment created');
        $transaction->setAmount($fine->getAmount());
        $transaction->setTransactionId('55506fad526f4');
        $manager->persist($transaction);

        $cart = new cart();
            
        $cart->setUser($user);
        $cart->setDateCreated($faker->dateTimeBetween(" - 3 years "));
        $cart->setDateToBeReturn($faker->dateTimeThisMonth($max = 'now'));
        $cart->setDateReallyReturned($faker->dateTimeBetween($cart->getDateToBeReturn()));
        $cart->setDateModified($faker->dateTimeBetween($cart->getDateReallyReturned()));
        $cart->setTotalAmont(25);
        $cart->setStatus('Retourné');
            
        $bookRepo = $this->doctrine->getRepository(Book::class);
        $books = $bookRepo->findAll();
        shuffle($books);
        $tab = array();
        array_push($tab, $books[1]);
        $cart->setBooks($tab);
            
        $pickupRepo = $this->doctrine->getRepository(PickupSpot::class);
        $pickups = $pickupRepo->findAll();
        shuffle($pickups);
        $cart->setPickup($pickups[1]);
        $manager->persist($cart);
            
        $fine = new fine();
        $fine->setCart($cart);
        $fine->setDateCreated($faker->dateTimeBetween($cart->getDateReallyReturned()));
        $fine->setDateModified($faker->dateTimeBetween($fine->getDateCreated()));
        $fine->setDateLimit($faker->dateTimeBetween($fine->getDateModified()));
        $fine->setAmount($faker->randomFloat($nbMaxDecimals = 2, $min = 7, $max = 28));
        $fine->setMotif('Endommagé');
        $fine->setStatus('Non payée');
        $manager->persist($fine);
            
        $fine = new fine();
        $fine->setCart($cart);
        $fine->setDateCreated($faker->dateTimeBetween($cart->getDateReallyReturned()));
        $fine->setDateModified($faker->dateTimeBetween($fine->getDateCreated()));
        $fine->setDateLimit($faker->dateTimeBetween($fine->getDateModified()));
        $fine->setAmount($faker->randomFloat($nbMaxDecimals = 2, $min = 7, $max = 28));
        $fine->setMotif('Retard');
        $fine->setStatus('Payée');
        $manager->persist($fine);
            
        $transaction = new transaction();
        $transaction->setFine($fine);
        $transaction->setDateCreated($faker->dateTimeBetween($fine->getDateModified()));
        $transaction->setDateValidationBq($transaction->getDateCreated());
        $transaction->setStatus('payment_ok');
        $transaction->setMessage('Payment created');
        $transaction->setAmount($fine->getAmount());
        $transaction->setTransactionId('55506fad526f4');
        $manager->persist($transaction);

        $cart = new cart();
            
        $cart->setUser($user);
        $cart->setDateCreated($faker->dateTimeBetween(" - 3 years "));
        $cart->setDateToBeReturn($faker->dateTimeThisMonth($max = 'now'));
        $cart->setDateReallyReturned($faker->dateTimeBetween($cart->getDateToBeReturn()));
        $cart->setDateModified($faker->dateTimeBetween($cart->getDateReallyReturned()));
        $cart->setTotalAmont(25);
        $cart->setStatus('Retourné');
            
        $bookRepo = $this->doctrine->getRepository(Book::class);
        $books = $bookRepo->findAll();
        shuffle($books);
        $tab = array();
        array_push($tab, $books[1]);
        $cart->setBooks($tab);
            
        $pickupRepo = $this->doctrine->getRepository(PickupSpot::class);
        $pickups = $pickupRepo->findAll();
        shuffle($pickups);
        $cart->setPickup($pickups[1]);
        $manager->persist($cart);
            
        $fine = new fine();
        $fine->setCart($cart);
        $fine->setDateCreated($faker->dateTimeBetween($cart->getDateReallyReturned()));
        $fine->setDateModified($faker->dateTimeBetween($fine->getDateCreated()));
        $fine->setDateLimit($faker->dateTimeBetween($fine->getDateModified()));
        $fine->setAmount($faker->randomFloat($nbMaxDecimals = 2, $min = 7, $max = 28));
        $fine->setMotif('Endommagé');
        $fine->setStatus('Non payée');
        $manager->persist($fine);
            
        $fine = new fine();
        $fine->setCart($cart);
        $fine->setDateCreated($faker->dateTimeBetween($cart->getDateReallyReturned()));
        $fine->setDateModified($faker->dateTimeBetween($fine->getDateCreated()));
        $fine->setDateLimit($faker->dateTimeBetween($fine->getDateModified()));
        $fine->setAmount($faker->randomFloat($nbMaxDecimals = 2, $min = 7, $max = 28));
        $fine->setMotif('Retard');
        $fine->setStatus('Payée');
        $manager->persist($fine);
            
        $transaction = new transaction();
        $transaction->setFine($fine);
        $transaction->setDateCreated($faker->dateTimeBetween($fine->getDateModified()));
        $transaction->setDateValidationBq($transaction->getDateCreated());
        $transaction->setStatus('payment_ok');
        $transaction->setMessage('Payment created');
        $transaction->setAmount($fine->getAmount());
        $transaction->setTransactionId('55506fad526f4');
        $manager->persist($transaction);

        $user = new User();
        $user->setFirstName('Raymond');
        $user->setLastName('Domenech');
        $user->setPassword('123');
        $user->setEmail('test@test.com');
        $user->setNickname('R.Domene');
        $user->setAddress('3 rue foch');
        $user->setCity('Paris');
        $user->setTel($faker->phoneNumber());
        $user->setRoles(array("ROLE_ADMIN"));
        $user->setSubscriber(1);
        $user->setMyMoney($faker->randomFloat($nbMaxDecimals = 1, $min = 650, $max = 1550));
        $user->setLatitude($faker->randomFloat($nbMaxDecimals = 6, $min = 48.834540, $max = 48.883781));
        $user->setLongitude($faker->randomFloat($nbMaxDecimals = 6, $min = 2.296678, $max = 2.389375));
        $user->setCb('4485187294407276');
        $user->setPostalCode('75016');
        $password = $this->hasher->hashPassword($user, $user->getPassword());
        $user->setPassword($password);
        $slug = $this->slugger->slug(strtolower($user->getFirstName().'-'.$user->getLastName().uniqid()));
        $user->setSlug($slug);
            
        $manager->persist($user);
            
        $cart = new cart();
            
        $cart->setUser($user);
        $cart->setDateCreated($faker->dateTimeBetween(" - 3 years "));
        $cart->setDateToBeReturn($faker->dateTimeThisMonth($max = 'now'));
        $cart->setDateReallyReturned($faker->dateTimeBetween($cart->getDateToBeReturn()));
        $cart->setDateModified($faker->dateTimeBetween($cart->getDateReallyReturned()));
        $cart->setTotalAmont(25);
        $cart->setStatus('Retourné');
            
        $bookRepo = $this->doctrine->getRepository(Book::class);
        $books = $bookRepo->findAll();
        shuffle($books);
        $tab = array();
        array_push($tab, $books[1]);
        array_push($tab, $books[2]);
        $cart->setBooks($tab);
            
        $pickupRepo = $this->doctrine->getRepository(PickupSpot::class);
        $pickups = $pickupRepo->findAll();
        shuffle($pickups);
        $cart->setPickup($pickups[1]);

        $manager->persist($cart);
            
        $cart = new cart();
            
        $cart->setUser($user);
        $cart->setDateCreated($faker->dateTimeBetween(" - 3 years "));
        $cart->setDateToBeReturn($faker->dateTimeThisMonth($max = 'now'));
        $cart->setDateReallyReturned($faker->dateTimeBetween($cart->getDateToBeReturn()));
        $cart->setDateModified($faker->dateTimeBetween($cart->getDateReallyReturned()));
        $cart->setTotalAmont(25);
        $cart->setStatus('Retourné');
            
        $bookRepo = $this->doctrine->getRepository(Book::class);
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
            
        $pickupRepo = $this->doctrine->getRepository(PickupSpot::class);
        $pickups = $pickupRepo->findAll();
        shuffle($pickups);
        $cart->setPickup($pickups[1]);

        $manager->persist($cart);
            
        $cart = new cart();
            
        $cart->setUser($user);
        $cart->setDateCreated($faker->dateTimeBetween(" - 3 years "));
        $cart->setDateToBeReturn($faker->dateTimeThisMonth($max = 'now'));
        $cart->setDateReallyReturned($faker->dateTimeBetween($cart->getDateToBeReturn()));
        $cart->setDateModified($faker->dateTimeBetween($cart->getDateReallyReturned()));
        $cart->setTotalAmont(25);
        $cart->setStatus('Retourné');
            
        $bookRepo = $this->doctrine->getRepository(Book::class);
        $books = $bookRepo->findAll();
        shuffle($books);
        $tab = array();
        array_push($tab, $books[1]);
        $cart->setBooks($tab);
            
        $pickupRepo = $this->doctrine->getRepository(PickupSpot::class);
        $pickups = $pickupRepo->findAll();
        shuffle($pickups);
        $cart->setPickup($pickups[1]);
        $manager->persist($cart);
            
        $fine = new fine();
        $fine->setCart($cart);
        $fine->setDateCreated($faker->dateTimeBetween($cart->getDateReallyReturned()));
        $fine->setDateModified($faker->dateTimeBetween($fine->getDateCreated()));
        $fine->setDateLimit($faker->dateTimeBetween($fine->getDateModified()));
        $fine->setAmount($faker->randomFloat($nbMaxDecimals = 2, $min = 7, $max = 28));
        $fine->setMotif('Endommagé');
        $fine->setStatus('Payée');
        $manager->persist($fine);
            
        $transaction = new transaction();
        $transaction->setFine($fine);
        $transaction->setDateCreated($faker->dateTimeBetween($fine->getDateModified()));
        $transaction->setDateValidationBq($transaction->getDateCreated());
        $transaction->setStatus('payment_ok');
        $transaction->setMessage('Payment created');
        $transaction->setAmount($fine->getAmount());
        $transaction->setTransactionId('55506fad526f3');
        $manager->persist($transaction);
            
        $fine = new fine();
        $fine->setCart($cart);
        $fine->setDateCreated($faker->dateTimeBetween($cart->getDateReallyReturned()));
        $fine->setDateModified($faker->dateTimeBetween($fine->getDateCreated()));
        $fine->setDateLimit($faker->dateTimeBetween($fine->getDateModified()));
        $fine->setAmount($faker->randomFloat($nbMaxDecimals = 2, $min = 7, $max = 28));
        $fine->setMotif('Retard');
        $fine->setStatus('Non payée');
        $manager->persist($fine);

        $cart = new cart();
            
        $cart->setUser($user);
        $cart->setDateCreated($faker->dateTimeBetween(" - 3 years "));
        $cart->setDateToBeReturn($faker->dateTimeThisMonth($max = 'now'));
        $cart->setDateReallyReturned($faker->dateTimeBetween($cart->getDateToBeReturn()));
        $cart->setDateModified($faker->dateTimeBetween($cart->getDateReallyReturned()));
        $cart->setTotalAmont(25);
        $cart->setStatus('Retourné');
            
        $bookRepo = $this->doctrine->getRepository(Book::class);
        $books = $bookRepo->findAll();
        shuffle($books);
        $tab = array();
        array_push($tab, $books[1]);
        $cart->setBooks($tab);
            
        $pickupRepo = $this->doctrine->getRepository(PickupSpot::class);
        $pickups = $pickupRepo->findAll();
        shuffle($pickups);
        $cart->setPickup($pickups[1]);
        $manager->persist($cart);
            
        $fine = new fine();
        $fine->setCart($cart);
        $fine->setDateCreated($faker->dateTimeBetween($cart->getDateReallyReturned()));
        $fine->setDateModified($faker->dateTimeBetween($fine->getDateCreated()));
        $fine->setDateLimit($faker->dateTimeBetween($fine->getDateModified()));
        $fine->setAmount($faker->randomFloat($nbMaxDecimals = 2, $min = 7, $max = 28));
        $fine->setMotif('Endommagé');
        $fine->setStatus('Non payée');
        $manager->persist($fine);
            
        $fine = new fine();
        $fine->setCart($cart);
        $fine->setDateCreated($faker->dateTimeBetween($cart->getDateReallyReturned()));
        $fine->setDateModified($faker->dateTimeBetween($fine->getDateCreated()));
        $fine->setDateLimit($faker->dateTimeBetween($fine->getDateModified()));
        $fine->setAmount($faker->randomFloat($nbMaxDecimals = 2, $min = 7, $max = 28));
        $fine->setMotif('Retard');
        $fine->setStatus('Payée');
        $manager->persist($fine);
            
        $transaction = new transaction();
        $transaction->setFine($fine);
        $transaction->setDateCreated($faker->dateTimeBetween($fine->getDateModified()));
        $transaction->setDateValidationBq($transaction->getDateCreated());
        $transaction->setStatus('payment_ok');
        $transaction->setMessage('Payment created');
        $transaction->setAmount($fine->getAmount());
        $transaction->setTransactionId('55506fad526f4');
        $manager->persist($transaction);

        $cart = new cart();
            
        $cart->setUser($user);
        $cart->setDateCreated($faker->dateTimeBetween(" - 3 years "));
        $cart->setDateToBeReturn($faker->dateTimeThisMonth($max = 'now'));
        $cart->setDateReallyReturned($faker->dateTimeBetween($cart->getDateToBeReturn()));
        $cart->setDateModified($faker->dateTimeBetween($cart->getDateReallyReturned()));
        $cart->setTotalAmont(25);
        $cart->setStatus('Retourné');
            
        $bookRepo = $this->doctrine->getRepository(Book::class);
        $books = $bookRepo->findAll();
        shuffle($books);
        $tab = array();
        array_push($tab, $books[1]);
        $cart->setBooks($tab);
            
        $pickupRepo = $this->doctrine->getRepository(PickupSpot::class);
        $pickups = $pickupRepo->findAll();
        shuffle($pickups);
        $cart->setPickup($pickups[1]);
        $manager->persist($cart);
            
        $fine = new fine();
        $fine->setCart($cart);
        $fine->setDateCreated($faker->dateTimeBetween($cart->getDateReallyReturned()));
        $fine->setDateModified($faker->dateTimeBetween($fine->getDateCreated()));
        $fine->setDateLimit($faker->dateTimeBetween($fine->getDateModified()));
        $fine->setAmount($faker->randomFloat($nbMaxDecimals = 2, $min = 7, $max = 28));
        $fine->setMotif('Endommagé');
        $fine->setStatus('Non payée');
        $manager->persist($fine);
            
        $fine = new fine();
        $fine->setCart($cart);
        $fine->setDateCreated($faker->dateTimeBetween($cart->getDateReallyReturned()));
        $fine->setDateModified($faker->dateTimeBetween($fine->getDateCreated()));
        $fine->setDateLimit($faker->dateTimeBetween($fine->getDateModified()));
        $fine->setAmount($faker->randomFloat($nbMaxDecimals = 2, $min = 7, $max = 28));
        $fine->setMotif('Retard');
        $fine->setStatus('Payée');
        $manager->persist($fine);
            
        $transaction = new transaction();
        $transaction->setFine($fine);
        $transaction->setDateCreated($faker->dateTimeBetween($fine->getDateModified()));
        $transaction->setDateValidationBq($transaction->getDateCreated());
        $transaction->setStatus('payment_ok');
        $transaction->setMessage('Payment created');
        $transaction->setAmount($fine->getAmount());
        $transaction->setTransactionId('55506fad526f4');
        $manager->persist($transaction);

        $cart = new cart();
            
        $cart->setUser($user);
        $cart->setDateCreated($faker->dateTimeBetween(" - 3 years "));
        $cart->setDateToBeReturn($faker->dateTimeThisMonth($max = 'now'));
        $cart->setDateReallyReturned($faker->dateTimeBetween($cart->getDateToBeReturn()));
        $cart->setDateModified($faker->dateTimeBetween($cart->getDateReallyReturned()));
        $cart->setTotalAmont(25);
        $cart->setStatus('Retourné');
            
        $bookRepo = $this->doctrine->getRepository(Book::class);
        $books = $bookRepo->findAll();
        shuffle($books);
        $tab = array();
        array_push($tab, $books[1]);
        $cart->setBooks($tab);
            
        $pickupRepo = $this->doctrine->getRepository(PickupSpot::class);
        $pickups = $pickupRepo->findAll();
        shuffle($pickups);
        $cart->setPickup($pickups[1]);
        $manager->persist($cart);
            
        $fine = new fine();
        $fine->setCart($cart);
        $fine->setDateCreated($faker->dateTimeBetween($cart->getDateReallyReturned()));
        $fine->setDateModified($faker->dateTimeBetween($fine->getDateCreated()));
        $fine->setDateLimit($faker->dateTimeBetween($fine->getDateModified()));
        $fine->setAmount($faker->randomFloat($nbMaxDecimals = 2, $min = 7, $max = 28));
        $fine->setMotif('Endommagé');
        $fine->setStatus('Non payée');
        $manager->persist($fine);
            
        $fine = new fine();
        $fine->setCart($cart);
        $fine->setDateCreated($faker->dateTimeBetween($cart->getDateReallyReturned()));
        $fine->setDateModified($faker->dateTimeBetween($fine->getDateCreated()));
        $fine->setDateLimit($faker->dateTimeBetween($fine->getDateModified()));
        $fine->setAmount($faker->randomFloat($nbMaxDecimals = 2, $min = 7, $max = 28));
        $fine->setMotif('Retard');
        $fine->setStatus('Payée');
        $manager->persist($fine);
            
        $transaction = new transaction();
        $transaction->setFine($fine);
        $transaction->setDateCreated($faker->dateTimeBetween($fine->getDateModified()));
        $transaction->setDateValidationBq($transaction->getDateCreated());
        $transaction->setStatus('payment_ok');
        $transaction->setMessage('Payment created');
        $transaction->setAmount($fine->getAmount());
        $transaction->setTransactionId('55506fad526f4');
        $manager->persist($transaction);
            
        $manager->flush();
    }
}
