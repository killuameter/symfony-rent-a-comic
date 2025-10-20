<?php

namespace App\DataFixtures\ORM;

use App\Entity\PickupSpot;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LoadDropSpotData extends Fixture
{
    // use ContainerAwareTrait;
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $dropspots = $this->getDropSpots();
        //loop over the array
        foreach ($dropspots as $dropspot) {
            //creates a Pickup_spot instance
            $pickup_spot = new PickupSpot();
            //hydrates it
            $pickup_spot->setStoreName($dropspot[0]);
            $pickup_spot->setAddress($dropspot[1]);
            $pickup_spot->setpostalCode($dropspot[2]);
            $pickup_spot->setCity("Paris");
                        
            //(gets the coordinates, optionnal)
            //https://developers.google.com/maps/documentation/geocoding/
            //api key AIza---NOPE------kDb6s
            $go = 1;
            if ($go==0) {
                $tmpTab = explode(" ", $pickup_spot->getStoreName());
                $nom = implode("+", $tmpTab);
                $tmpTab = explode(" ", $pickup_spot->getAddress());
                $ad = implode("+", $tmpTab);
                $tmpTab = explode(" ", $pickup_spot->getpostalCode());
                $cp = implode("+", $tmpTab);
                $tmpTab = explode(" ", $pickup_spot->getCity());
                $ville = implode("+", $tmpTab);

                $adressFull = $nom.','.$ad.',+'.$cp.',+'.$ville.',+France';
                $mapsUrl = "https://maps.googleapis.com/maps/api/geocode/json?address=";

                $googleApiUrl = $mapsUrl.$adressFull."&key=AIza---NOPE------kDb6s";

                $file = file_get_contents($googleApiUrl);
                $tab = array();
                $tab = json_decode($file, true);

                $pickup_spot->setLatitude($tab['results'][0]['geometry']['location']['lat']);
                $pickup_spot->setLongitude($tab['results'][0]['geometry']['location']['lng']);
            } else {
                $pickup_spot->setLatitude(48.8685692);
                $pickup_spot->setLongitude(2.3356084);
            }
            //persists it
            $manager->persist($pickup_spot);
        }
        //flush
        // $em->flush();
        $manager->flush();
    }
    private function getDropSpots()
    {
        $dropspots = array(
            array("Libria", "82 Passage Choiseul", "75002"),
            array("Telecom Star", "15 Bd de Bonne Nouvelle", "75002"),
            array("Hypso Reprographie", "53 rue de Montmorency", "75003"),
            array("BM Pressing", "4 Bis Bd Morland", "75004"),
            array("Game Cash / CG Paris 5", "21 rue Monge", "75005"),
            array("Chez Florence", "11 rue Dauphine", "75006"),
            array("Aux Fleurs du Bac", "69 rue du Bac", "75007"),
            array("Cordonnerie Serrurerie Grenell", "165 rue de Grenelle", "75007"),
            array("Clean Pressing", "15 rue Manuel", "75009"),
            array("Luffy", "35 rue de Clichy", "75009"),
            array("Les Coteaux de Saumur", "10 rue Bichat", "75010"),
            array("Magenta Art Deco", "34 Ter rue du Dunkerque", "75010"),
            array("Baticlean 75", "191 rue de Charonne", "75011"),
            array("Cala Thé A", "133 rue de Montreuil", "75011"),
            array("A Livr' Ouvert", "171 Bis Bd Voltaire", "75011"),
            array("Pressing Boulle", "13 rue Boulle", "75011"),
            array("B.C.B.G / SARL Fleuve Bleu", "18 rue Jules Valles", "75011"),
            array("L'Atelier du Trèfles Cadeaux", "13 Bis Avenue Philippe Auguste", "75011"),
            array("Lio Optic", "44 Bd Diderot", "75012"),
            array("A.M Presse Bizot", "116 Av Général Michel Bizot", "75012"),
            array("Alanpark", "105 rue de Charenton", "75013"),
            array("Okbi Presse", "91 rue de Barrault", "75013"),
            array("Encherexpert", "51 rue de Clisson", "75013"),
            array("Maison de la Presse", "137 Bd Auguste Blanqui", "75013"),
            array("Ideal Optic", "101 Av de France", "75013"),
            array("Chryzalys", "206 Bd Raspail", "75014"),
            array("Agip Papeterie Côté Sud", "133 Av du Maine", "75014"),
            array("Animalerie Little Zoo", "40 Bd Brune", "75014"),
            array("Cordonnerie B.V.F", "22 rue des Volontaires", "75015"),
            array("Moveux", "14 rue Dupleix", "75015"),
            array("Saveurs du Sud", "14 Av Félix Faure", "75015"),
            array("Anwa", "105 Bis rue des Entrepreneurs", "75015"),
            array("Mercerie Poncet", "15 rue Daumier", "75016"),
            array("Vu du XII", "96 Av de Mozart", "75016"),
            array("Centre Literie", "2 Bd Bessières", "75017"),
            array("Salon Marylène", "45 rue Brochant", "75017"),
            array("Allo Micro", "117 rue Legendre", "75017"),
            array("Encherexpert", "61 rue Guy Moquet", "75017"),
            array("Au Rocher de Joie", "12 rue Lamarck", "75018"),
            array("Consoplus Informatique", "8 Bd Ney", "75018"),
            array("Unity Génération", "17 rue Simart", "75018"),
            array("Isabelle Cherchevsky Atelier", "15 rue Lagouat", "75018"),
            array("Labelencre", "10 Av de La porte Brunet", "75019"),
            array("Prim Plus", "9 rue du Cher", "75020"),
            array("Cadeaux Chics", "27 rue Saint Fargeau", "75020"),
            array("Optic 62", "62 rue de Belleville", "75020"),
            array("Pressing 113", "113 Bd Davout", "75020"),
            array("Copy Conforme", "25 rue Gatinée", "75020"),
        );
        return $dropspots;
    }
}
