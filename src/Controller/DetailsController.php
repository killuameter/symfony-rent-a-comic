<?php

namespace App\Controller;

use App\Entity\Book;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class DetailsController extends AbstractController
{
    /**
     * @Route("/details/{slug}", name="details")
     */
    public function detailsAction(Request $request, ManagerRegistry $doctrine, $slug)
    {
        $bookRepo = $doctrine->getRepository(Book::class);
        $book = $bookRepo->findOneBySlug($slug);

        if (!$book) {
            throw $this->createNotFoundException("Oups ! Désolé gamin...");
        }
        
        $params = array(
            "bd" => $book
        );
        
        return $this->render('details/details.html.twig', $params);
    }
}
