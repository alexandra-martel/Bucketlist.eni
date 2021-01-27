<?php

namespace App\Controller;

use App\Entity\Wish;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

Class WishController extends AbstractController
{
    /**
     * @Route("/wish", name="wish_list")
     */

    public function list(): Response
    {
        return $this->render('wish/list.html.twig', []);
    }

    /**
     * @Route("/wish/detail/{id}", name="wish_detail", requirements={"id":"\d+"})
     */

    public function detail(int $id): Response
    {
        return $this->render('wish/detail.html.twig', ["wish_id" => $id]);

    }


    /**
     * @Route("/wish/test", name="wish_test")
     */

    public function test(EntityManagerInterface $entityManager)
    {
        $wish = new Wish();

        $wish->setTitle('Voir les aurores boréales');
        $wish->setDescription('En Islande ou en Norvège');
        $wish->setAuthor('Alexandra');
        $wish->setIsPublished('non');
        $wish->getDateCreated(new \DateTime());

        $entityManager->persist($wish);

        $wish2 = new Wish();

        $wish2->setTitle('Habiter une maison écologique autonome');
        $wish2->setDescription('En pleine campagne');
        $wish2->setAuthor('Alexandra');
        $wish2->setIsPublished('non');
        $wish2->getDateCreated(new \DateTime());

        $entityManager->persist($wish2);

        $wish3 = new Wish();

        $wish3->setTitle('Être heureuse tout le temps');
        $wish3->setDescription('Savourer chaque instant !');
        $wish3->setAuthor('Alexandra');
        $wish3->setIsPublished('non');
        $wish3->getDateCreated(new \DateTime());

        $entityManager->persist($wish3);

        $wish4 = new Wish();

        $wish4->setTitle('Faire le tour du monde en camping car');
        $wish4->setDescription('Explorer, voyager, rencontrer, être libre !!');
        $wish4->setAuthor('Alexandra');
        $wish4->setIsPublished('non');
        $wish4->getDateCreated(new \DateTime());

        $entityManager->persist($wish4);
        $entityManager->flush();

        return new \http\Env\Response('ok !');
    }


}