<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Entreprise;
use App\Entity\Formation;
use App\Entity\Stage;

class ProStageController extends AbstractController
{
    public function accueil()
    {
    //Traitement métier/controlleur
        $repositoryFormation = $this->getDoctrine()->getRepository(Formation::class);
        $listeFormations = $repositoryFormation->findAll();

        $repositoryStage = $this->getDoctrine()->getRepository(Stage::class);
        $listeStages = $repositoryStage->findAll();

        $repositoryFormation = $this->getDoctrine()->getRepository(Formation::class);
        $listeFormations = $repositoryFormation->findAll();

    //méthode Response
        /*
        return new Response("<html><body><h1>Bienvenue sur la page d'accueil de Prostages</h1></body></html>");
        */

    //méthode Templates
        return $this->render('pro_stage/accueil.html.twig', [
            'controller_name' => 'ProStageController_accueil',
            'name' => 'accueil',
            'listeStages' => $listeStages,
        ]);
    }

    public function entreprises()
    {
    //Traitement métier/controlleur
        $repositoryEntreprise = $this->getDoctrine()->getRepository(Entreprise::class);
        $listeEntreprises = $repositoryEntreprise->findAll();


    //méthode Response
        /*
        return new Response("<html><body><h1>Cette page affichera la liste des entreprises proposant un stage</h1></body></html>");
        */

    //méthode Templates
        return $this->render('pro_stage/entreprises.html.twig', [
            'controller_name' => 'ProStageController_entreprises',
            'name' => 'entreprises',
            'listeEntreprises' => $listeEntreprises,
        ]);
    }

    public function formations()
    {
    //Traitement métier/controlleur

        $repositoryFormation = $this->getDoctrine()->getRepository(Formation::class);
        $listeFormations = $repositoryFormation->findAll();


    //Envoie à la Vue

        //méthode Response
            /*
            return new Response("<html><body><h1>Cette page affichera la liste des formations de l'IUT</h1></body></html>");
            */

        //méthode Templates
            return $this->render('pro_stage/formations.html.twig', [
                'controller_name' => 'ProStageController_formations',
                'name' => 'formations',
                'listeFormations' => $listeFormations,
            ]);
    }

    public function stages($id)
    {
    //Traitement métier/controlleur

        $repositoryStage = $this->getDoctrine()->getRepository(Stage::class);
        $stage = $repositoryStage->findBy(['id'=>$id]);

    //Envoie à la Vue

        //méthode Response
            /*
            return new Response("<html><body><h1>Cette page affichera le descriptif du stage ayant pour identifiant". $id."</h1></body></html>");
            */

        //méthode Templates
            return $this->render('pro_stage/stages.html.twig', [
                'controller_name' => 'ProStageController_stages',
                'identifiant' => $id,
                'name' => 'stages',
                'stage' => $stage,
            ]);
    }
    
    public function parEntreprise($id)
    {
    //Traitement métier/controlleur

        $repositoryStage = $this->getDoctrine()->getRepository(Stage::class);
        $repositoryEntreprise = $this->getDoctrine()->getRepository(Entreprise::class);

        $entreprise = $repositoryEntreprise->find($id);
        $stages = $repositoryStage->findBy(["entreprise"=>$id]);


    
    //Envoie à la vue
        return $this->render('pro_stage/parEntreprise.html.twig', [
            'controller_name' => 'ProStageController_parEntreprise',
            'name' => 'parEntreprise',
            'infoEntreprise' => $entreprise,
            'listeStages' => $stages,
        ]);
    }

    public function parFormation($id)
    {
    //Traitement métier/controlleur

        $repositoryStage = $this->getDoctrine()->getRepository(Stage::class);
        $repositoryFormation = $this->getDoctrine()->getRepository(Formation::class);

        $formation = $repositoryFormation->find($id);
        $stages = $repositoryStage->findBy(["formations"=>$id]); //Ca marche? Plusieurs formation



    //Envoie à la vue
        return $this->render('pro_stage/parFormation.html.twig', [
            'controller_name' => 'ProStageController_parFormation',
            'name' => 'parFormation',
        ]);
    }
}
