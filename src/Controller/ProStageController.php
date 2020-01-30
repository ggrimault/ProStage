<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Entreprise;
use App\Entity\Formation;
use App\Entity\Stage;
use App\Repository\EntrepriseRepository;
use App\Repository\FormationRepository;
use App\Repository\StageRepository;

class ProStageController extends AbstractController
{
    public function accueil(StageRepository $repositoryStage)
    {
    //Traitement métier/controlleur
        $listeStages = $repositoryStage->findAllStages();
   
    //méthode Templates
        return $this->render('pro_stage/accueil.html.twig', [
            'controller_name' => 'ProStageController_accueil',
            'name' => 'accueil',
            'listeStages' => $listeStages,
        ]);
    }

    public function entreprises(EntrepriseRepository $repositoryEntreprise)
    {
    //Traitement métier/controlleur
        $listeEntreprises = $repositoryEntreprise->findAll();

    //méthode Templates
        return $this->render('pro_stage/entreprises.html.twig', [
            'controller_name' => 'ProStageController_entreprises',
            'name' => 'entreprises',
            'listeEntreprises' => $listeEntreprises,
        ]);
    }

    public function formations(FormationRepository $repositoryFormation)
    {
    //Traitement métier/controlleur
        $listeFormations = $repositoryFormation->findAll();


    //Envoie à la Vue
        return $this->render('pro_stage/formations.html.twig', [
            'controller_name' => 'ProStageController_formations',
            'name' => 'formations',
            'listeFormations' => $listeFormations,
        ]);
    }

    public function stages(Stage $stage)
    {
        //méthode Templates
            return $this->render('pro_stage/stages.html.twig', [
                'controller_name' => 'ProStageController_stages',
                'name' => 'stage',
                'stage' => $stage,
            ]);
    }
    
    public function parEntreprise(StageRepository $repositoryStage, Entreprise $entreprise )
    {
    //Traitement métier/controlleur
    $stages = $repositoryStage->findByEntreprise($entreprise);
    //Envoie à la vue
        return $this->render('pro_stage/parEntreprise.html.twig', [
            'controller_name' => 'ProStageController_parEntreprise',
            'name' => 'parEntreprise',
            'infoEntreprise' => $entreprise,
            'stages' => $stages,
        ]);
    }

    public function parFormation(Formation $formation, StageRepository $repositoryStage )
    {
    //Traitement métier/controlleur
    $stages = $repositoryStage->findStagesParFormation($formation);

    //Envoie à la vue
        return $this->render('pro_stage/parFormation.html.twig', [
            'controller_name' => 'ProStageController_parFormation',
            'name' => 'parFormation',
            'infoFormation' => $formation,
            'stages' => $stages,
        ]);
    }
}
