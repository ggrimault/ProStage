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
        // $product = new Product();
        // $manager->persist($product);

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
    }
}
