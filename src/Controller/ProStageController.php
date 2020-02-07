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

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;

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

    public function ajouterEntreprise(Request $requeteHttp, ObjectManager $manager)
    {
    //CREATION FORMULAIRE
    $entreprise = new Entreprise();

    $formulaireEntreprise = $this -> createFormBuilder($entreprise)
                                  -> add('nom', TextType::class)
                                  -> add('activite', TextareaType::class)
                                  -> add('adresse',TextType::class )
                                  -> add('lienSite', UrlType::class)
                                  -> getForm();
    
    $vueFormulaireEntreprise = $formulaireEntreprise->createView();

    //recuperation du formulaire
    $formulaireEntreprise->handleRequest($requeteHttp);

    if ( $formulaireEntreprise->isSubmitted())
    {
        //sauvegarder l'entreprise
        $manager->persist($entreprise);
        $manager->flush();

        //rediriger vers l'accueil
        return $this->redirectToRoute('ProStageController_accueil');
    }

    //Envoie à la vue
        return $this->render('pro_stage/ajouterEntreprise.html.twig', [
            'controller_name' => 'ProStageController_creerEntreprise',
            'name' => 'Ajouter Entreprise',
            'vueFormulaireEntreprise' => $vueFormulaireEntreprise,
        ]);
    }
}
