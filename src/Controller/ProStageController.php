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
use App\Form\EntrepriseType;
use App\Form\StageType;

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
    //creation d'un objet Entreprise vide
    $entreprise = new Entreprise();

    //creation du formulaire ( a partir du formulaire externalisé )
    $formulaireEntreprise = $this -> createForm(EntrepriseType::class, $entreprise);    


    //enregistrement des données apres soumission du formulaire dans l'objet entreprise
    $formulaireEntreprise->handleRequest($requeteHttp);

    if ( $formulaireEntreprise->isSubmitted() && $formulaireEntreprise->isValid())
    {
        //sauvegarder l'entreprise en bd
        $manager->persist($entreprise);
        $manager->flush();

        //rediriger vers l'accueil
        return $this->redirectToRoute('ProStageController_accueil');
    }

    //affichage du formulaire
    $vueFormulaireEntreprise = $formulaireEntreprise->createView();

    //Envoie à la vue
        return $this->render('pro_stage/ajouterEntreprise.html.twig', [
            'controller_name' => 'ProStageController_creerEntreprise',
            'name' => 'Ajouter Entreprise',
            'vueFormulaireEntreprise' => $vueFormulaireEntreprise,
        ]);
    }



    public function modifierEntreprise(Request $requeteHttp, ObjectManager $manager, Entreprise $entreprise)
    {
    //CREATION FORMULAIRE
    $formulaireEntreprise = $this -> createForm(EntrepriseType::class, $entreprise);

    //recuperation du formulaire
    $formulaireEntreprise->handleRequest($requeteHttp);

    if ( $formulaireEntreprise->isSubmitted() && $formulaireEntreprise->isValid())
    {
        //sauvegarder l'entreprise
        $manager->persist($entreprise);
        $manager->flush();

        //rediriger vers l'accueil
        return $this->redirectToRoute('ProStageController_accueil');
    }
                            
    $vueFormulaireEntreprise = $formulaireEntreprise->createView();

    //Envoie à la vue
        return $this->render('pro_stage/modifierEntreprise.html.twig', [
            'controller_name' => 'ProStageController_modifierEntreprise',
            'name' => 'Modifier Entreprise',
            'vueFormulaireEntreprise' => $vueFormulaireEntreprise,
        ]);
    }

    public function ajouterStage(Request $requeteHttp, ObjectManager $manager)
    {
    //creation d'un objet Stage vide
    $stage = new Stage();

    //creation du formulaire ( a partir du formulaire externalisé )
    $formulaireStage = $this -> createForm(StageType::class, $stage);    


    //enregistrement des données apres soumission du formulaire dans l'objet entreprise
    $formulaireStage->handleRequest($requeteHttp);

    if ( $formulaireStage->isSubmitted() && $formulaireStage->isValid())
    {
        //sauvegarder l'entreprise en bd
        $manager->persist($stage);
        $manager->flush();

        //rediriger vers l'accueil
        return $this->redirectToRoute('ProStageController_accueil');
    }

    //affichage du formulaire
    $vueFormulaireStage = $formulaireStage->createView();

    //Envoie à la vue
        return $this->render('pro_stage/ajouterStage.html.twig', [
            'controller_name' => 'ProStageController_creerStage',
            'name' => 'Ajouter un Stage',
            'vueFormulaireStage' => $vueFormulaireStage,
        ]);
    }
}
