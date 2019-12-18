<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Entreprise;
use App\Entity\Formation;
use App\Entity\Stage;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

//CREATION BASIQUE
        /* 

        $Entreprise = new Entreprise();
        $Entreprise->setNom("Entreprise 1");
        $Entreprise->setActivite("Creation de caniche pour chien.");
        $Entreprise->setAdresse("16 impasse des chie, 6469 chien");
        $Entreprise->setLienSite("dog.com");
        $manager->persist($Entreprise);

        $Formation = new Formation();
        $Formation->setNom("DUT informatique et science du numérique");
        $Formation->setAcronyme("DUT Inf");
        $manager->persist($Formation);

        $Formation2 = new Formation();
        $Formation2->setNom("DUT des zanimo");
        $Formation2->setAcronyme("DUT GIM");
        $manager->persist($Formation2);

        $Stage = new Stage();
        $Stage->setTitre("stage n°1");
        $Stage->setDescMission("il sagi dun stage pr sokuper des chiens wouaf");
        $Stage->setMail("chien&chat@gmail.com");
        $Stage->addFormation($Formation);
        $Stage->addFormation($Formation2);
        $Stage->setEntreprise($Entreprise);
        $manager->persist($Stage);

        $manager->flush();
        */

//CREATION AVEC FAKER

    $faker = \Faker\Factory::create('fr_FR');

    //GENERATION DES FORMATIONS

        $Formation1 = new Formation();
        $Formation1->setNom("DUT informatique");
        $Formation1->setAcronyme("DUT Info");

        $Formation2 = new Formation();
        $Formation2->setNom("Licence Professionnelle Multimédia");
        $Formation2->setAcronyme("LP multimédia");

        $Formation3 = new Formation();
        $Formation3->setNom("Diplôme Universitaire en Technologies de l'Information et de la Communication");
        $Formation3->setAcronyme("DU TIC");

        $listeFormation = array($Formation1, $Formation2, $Formation3);
        foreach($listeFormation as $formation)
        {
            $manager->persist($formation);
        }

    //GENERATION DES ENTREPRISE

        $nbEntreprise = $faker->numberBetween($min = 5, $max = 7);
        $listeEntreprise = array();

        for ($i = 0; $i <= $nbEntreprise; $i++)
        {
            $uneEntreprise = new Entreprise();
            $uneEntreprise->setNom( $faker->company );
            $uneEntreprise->setActivite( $faker->catchPhrase );
            $uneEntreprise->setAdresse( $faker->address );
            $uneEntreprise->setLienSite( $faker->domainName );

            $listeEntreprise[] = $uneEntreprise;
        }

        foreach($listeEntreprise as $entreprise)
        {
            $manager->persist($entreprise);
        }

    //GENERATION DES STAGES

        $nbStage = $faker->numberBetween($min = 15, $max = 20);
        $listeStage = array();

        for ($i = 0; $i <= $nbStage; $i++)
        {
            $unStage = new Stage();
            $unStage->setTitre( $faker->jobTitle );
            $unStage->setDescMission( $faker->text($maxNbChars = $faker->numberBetween($min = 200, $max = 800)) );
            $unStage->setMail( $faker->email );

            //CHOISIR LE NB ET LE,S FORMATION,S QUI VONT CORRESPONDRE

                for( $j = 1; $j <= $faker->numberBetween($min = 1, $max = 3); $j++ )
                {
                    $numeroFormation = $faker->numberBetween($min = 0, $max = 2);
                    $unStage->addFormation( $listeFormation[ $numeroFormation ] );
                }

            //CHOISIR L'ENTREPRISE QUI SERA PROPRIETAIRE DU STAGE

                $numeroEntreprise = $faker->numberBetween($min = 0, $max = ($nbEntreprise - 1));
                $unStage->setEntreprise( $listeEntreprise[ $numeroEntreprise ]);
        

            $listeStage[] = $unStage;
        }

        foreach($listeStage as $stage)
        {
            $manager->persist($stage);
        }

    //FIN DE LA CREATION DES DONNES ALEATOIRE

        $manager->flush();

    }
}