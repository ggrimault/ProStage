<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Entreprise;
use App\Entity\Formation;
use App\Entity\Stage;
use App\Entity\User;


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
        $nbStage = $faker->numberBetween($min = 50, $max = 60);
        $listeStage = array();

        for ($i = 0; $i <= $nbStage; $i++)
        {
            $unStage = new Stage();
            $unStage->setTitre( $faker->jobTitle );
            $unStage->setDescMission( $faker->realText($maxNbChars = $faker->numberBetween($min = 1000, $max = 800)) );
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

        $unUser = new User();
        $unUser->setEmail("guillaume.grimault64@orange.fr");
        $unUser->setRoles(["ROLE_ADMIN"]);
        $unUser->setPassword('$2y$10$heMA3Lg2f7H9G9d2FFvnSeq2HBN4EHmgnYe9BQW.C30Z1MqsqnO8e');
        $manager->persist($unUser);

        $deuxUser = new User();
        $deuxUser->setEmail("tanguy.grimault64@orange.fr");
        $deuxUser->setRoles(["ROLE_USER"]);
        $deuxUser->setPassword('$2y$10$heMA3Lg2f7H9G9d2FFvnSeq2HBN4EHmgnYe9BQW.C30Z1MqsqnO8e');
        $manager->persist($deuxUser);
        //FIN DE LA CREATION DES DONNES ALEATOIRE

        $manager->flush();
    }
}