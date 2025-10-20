<?php

namespace App\Controller;

use \App\Entity\Cart;
use App\Entity\Book;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function indexAction()
    {
        return $this->render('default/index.html.twig');
    }
    
    /**
     * @Route("catalogue/{page}", requirements={"catalogue/page":"\d+"}, defaults={"page":1}, name="catalogue")
     */
    public function catalogueAction(Request $request, ManagerRegistry $doctrine, $page)
    {
        $catRepo = $doctrine->getRepository(Book::class);
        
        $paginationResults = $catRepo->findPaginated($page);

        $param = array(
                "paginationResults" => $paginationResults,
                );
        
        return $this->render('catalogue/catalogue.html.twig', $param);
    }
    
    /**
     * @Route("panier",name="panier")
     * @return type
     */
    public function panierAction(ManagerRegistry $doctrine)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $cartRepo = $doctrine->getRepository(Cart::class);
        $cart = $cartRepo->findCartEnCourByUser($this->getUser());
        if (!$cart) {
            $cart = new Cart();
        } else {
            $cart = $cart[0];
        }
        $param = array('cart'=> $cart);
        return $this->render('panier/panier.html.twig', $param);
    }
}
