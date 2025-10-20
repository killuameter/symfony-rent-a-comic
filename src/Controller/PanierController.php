<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\Book;
use App\Entity\PickupSpot;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PanierController extends AbstractController
{
    /**
     * @Route("/AjoutPanier/{slug}",name="ajoutPa")
     */
    public function ajoutP(ManagerRegistry $doctrine, $slug)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $bookRepo = $doctrine->getRepository(Book::class);
        $cartRepo = $doctrine->getRepository(Cart::class);
                
        $cart = $cartRepo->findCartEnCourByUser($this->getUser());
        if (!$cart) {
            $cart = new Cart();
            $cart->setUser($this->getUser());
            $cart->setDateCreated(new \DateTime());
            $cart->setDateModified(new \DateTime());
                    
            $date2WeekLater = new \DateTime();
            $date2WeekLater = $date2WeekLater->add(new \DateInterval('P14D'));
            $cart->setDateToBeReturn($date2WeekLater);
            $cart->setStatus('En Cours de Commande');
        } else {
            $cart = $cartRepo->findCartEnCourByUser($this->getUser())[0];
        }
                
        $commandBook = $bookRepo->findOneBySlug($slug);
        $cart->addBook($commandBook);
        $em = $doctrine->getManager();
        $em->persist($cart);
        $em->flush();
                
        $bookRepo->decrementQte($commandBook);
                
        return $this->redirect($this->generateUrl('panier'));
    }
    
    /**
     * @Route("/supprimer",name="supprimer", methods={"POST","HEAD"})
     */
    public function supprimerP(Request $request, ManagerRegistry $doctrine)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $cartId = $request->request->get('cartId');
        $bookId = $request->request->get('bookId');
            
        if ($request->isXmlHttpRequest()) {
            $bookRepo = $doctrine->getRepository(Book::class);
            $cartRepo = $doctrine->getRepository(Cart::class);
                
            $cart = $cartRepo->findOneById($cartId);
            $book = $bookRepo->findOneById($bookId);
            $bookQte = count($cart->getBooks());
            $cart->removeBook($book);

            $em = $doctrine->getManager();
            $em->persist($cart);
            $em->flush();

            if ($bookQte==1) {
                $em->remove($cart);
                $em->flush();
            }
            $bookRepo->incrementQte($book);

            return new Response();
        }
    }

    /**
     * @Route("/confirmPanier/{cartId}",name="confirmP")
     * @param Cart $carts
     */
    public function confirmP(Request $request, ManagerRegistry $doctrine, $cartId)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $pickUpSpotRepo = $doctrine->getRepository(PickupSpot::class);
        $lesPickupSpots = $pickUpSpotRepo->findAll();
        $param = array("pickSpots"=>$lesPickupSpots);
            
        return $this->render('panier/confirmP.html.twig', $param);
    }
}
