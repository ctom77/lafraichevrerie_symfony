<?php

namespace App\Controller;

use App\Entity\Cheese;
use App\Entity\Category;
use App\Repository\CheeseRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class CheeseController extends AbstractController
{

    /**
     * Permet d'afficher une seule annonce
     * @Route("/fromages/{slug}", name = "cheeses_show")
     * 
     */
    public function show( Cheese $cheese){
        // Je récupère l'annonce qui correspond au slug
        //$ad = $repo->findOneBySlug($slug);
        
        return $this->render('cheese/show.html.twig',
        [
            'cheese' => $cheese
        ]);

    }


    /**
     * @Route("/fromages", name="cheeses")
     * Lister tout les fromages
     */
    public function index(CheeseRepository $repo)
    {

        $cheeses = $repo->findAll();
        
        return $this->render('cheese/index.html.twig', [
            'cheeses' => $cheeses,
        ]);
    }

    /**
     * @Route("/{slug}", name="cheese_category" )
     * Lister tout les fromages par catégories

     */
    public function cheeseByCategory($slug, CheeseRepository $repoCheese, CategoryRepository $repoCategory){
        // Je viens chercher la catégorie lié au slug présent dans l'url
        $category = $repoCategory->findBy([
            'slug' => $slug
        ]);

        //Si la catégorie n'éxiste pas, je renvoi vers une 404
        if(empty($category[0])){

            return $this->render('404.html.twig');

        // Sinon, ...
        }else{
        
        // Je viens chercher tout les fromages en lien avec le slug
        $cheeses = $repoCheese->findBy([
            'category' => $category[0]
        ]);

        //Je retourne tout les fromages ainsi que la catégorie dans laquelle je me situe à ma vu afin d'y avoir accès
        return $this->render('cheese/index.html.twig', [
            'category' =>$category,
            'cheeses' => $cheeses
            
        ]);
        }   

    }

    // Permet l'affichage de mon header et renvoi les variable que j'ai besoin d'avoir en global
    public function getCategories(CategoryRepository $repo){

        $categories = $repo->findAll();
        $maGlobale = $categories;

        return $this->render('partials/header.html.twig', [
            'categories' => $categories,
            
        ]);
    }



     
    

    




    

    
}
