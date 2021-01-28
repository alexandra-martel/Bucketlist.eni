<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Form\WishFormType;
use App\Repository\WishRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

Class WishController extends AbstractController
{
    /**
     * @Route("/wish", name="wish_list")
     */

    public function list(WishRepository $wishRepository)
    {
        $wishes = $wishRepository->findBy(["isPublished"=>true],["dateCreated"=>"DESC"]);
        return $this->render("wish/list.html.twig", ["wishes"=> $wishes]);
    }

    /**
     * @Route("/wish/detail/{id}", name="wish_detail", requirements={"id":"\d+"})
     */

    public function detail(int $id, WishRepository $wishRepository): Response
    {
        $wish = $wishRepository->find($id);

        return $this->render('wish/detail.html.twig', ["wish_id" => $id, "wish" => $wish]);

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
        $wish->setDateCreated (new \DateTime());

        $entityManager->persist($wish);

        $wish2 = new Wish();

        $wish2->setTitle('Habiter une maison écologique autonome');
        $wish2->setDescription('En pleine campagne');
        $wish2->setAuthor('Alexandra');
        $wish2->setIsPublished('non');
        $wish2->setDateCreated(new \DateTime());

        $entityManager->persist($wish2);

        $wish3 = new Wish();

        $wish3->setTitle('Être heureuse tout le temps');
        $wish3->setDescription('Savourer chaque instant !');
        $wish3->setAuthor('Alexandra');
        $wish3->setIsPublished('non');
        $wish3->setDateCreated(new \DateTime());

        $entityManager->persist($wish3);

        $wish4 = new Wish();



        $wish4->setTitle('Faire le tour du monde en camping car');
        $wish4->setDescription('Explorer, voyager, rencontrer, être libre !!');
        $wish4->setAuthor('Alexandra');
        $wish4->setIsPublished('non');
        $wish4->setDateCreated(new \DateTime());

        $entityManager->persist($wish4);
        $entityManager->flush();

        return $this->render('main/home.html.twig', []);
    }

    /**
     * @Route("/wish/new", name="wish_new")
     */

    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $wishForm = $this->createForm(WishFormType::class);
        $wish = new Wish();
        $wishForm = $this->createForm(WishFormType::class, $wishForm);
        $wishForm->handleRequest($request);
        if($wishForm->isSubmitted() && $wishForm->isValid()){

            $entityManager->persist($wish);
            $entityManager->flush();

        $this ->addFlash('succès','Le message a bien été crée');
        return $this->redirectToRoute('wish_detail', ['id'=> $wish->getId()]);

        }
        return $this->render('wish/new.html.twig',
            ["wishForm" => $wishForm->createView()]);

    }

}