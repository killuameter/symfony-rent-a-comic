<?php
namespace App\DataFixtures\ORM;

use App\Entity\Book;
use App\Entity\Serie;
use App\Entity\Author;
use App\Entity\Category;
use App\Entity\RelBookAuthor;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;

class LoadData extends Fixture
{
    // use ContainerAwareTrait;

    private $pathToData;
    private $authorRepo;
    private $serieRepo;
    private $catRepo;
    private $authors = array();
    private $series = array();
    private SluggerInterface $slugger;
    private ManagerRegistry $doctrine;
    
    public function __construct(ManagerRegistry $doctrine, SluggerInterface $slugger)
    {
        $this->pathToData = __DIR__ . "/data/";
        $this->doctrine = $doctrine;
        $this->slugger = $slugger;
    }
    
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $this->authorRepo = $this->doctrine->getRepository(Author::class);
        $this->serieRepo = $this->doctrine->getRepository(Serie::class);
        $this->catRepo = $this->doctrine->getRepository(Category::class);
        
        $this->loadCategories($manager);
        $this->loadSeries($manager);
        $this->loadAuthors($manager);
        $this->loadBooks($manager);
    }

    private function loadCategories(ObjectManager $manager)
    {
        $categorie = array( "Science-fiction",
        "Aventure",
        "Polar/Thriller",
        "Historique",
        "Jeunesse",
        "Humour",
        "Manga",
        "Biographie",
        "Indépendant",
        "Érotique",
        "Comics",
        "Divers");
              
        foreach ($categorie as $key => $value) {
            $cat = new Category();
            $cat->setCategoryName($value);
            $manager->persist($cat);
        }
              
        $manager->flush();
    }
    
    private function loadBooks(ObjectManager $manager)
    {
        $fh = fopen($this->pathToData."albums.csv", "r");
        $num = 1;
        while ($row = fgetcsv($fh, 0, ';')) {
            //skip first row
            if ($num <= 1) {
                $num++;
                continue;
            }
            /*
                [0] => IdAlbum
                [1] => Num
                [2] => Titre
                [3] => IdSerie
                [4] => IdDessinateur
                [5] => IdColoriste
                [6] => IdScenariste
                [7] => Editeur
                [8] => Reference
                [9] => Couverture
                [10] =>
                [11] => Exlibris
                [12] => NbPages
                [13] => Planche
                [14] => IdBEL
                [15] => Exemplaires
            */
            $row = $this->replaceNull($row);
            $book = new Book();
            $book->setSeriePosition($row[1]);
            if (empty($row[2])) {
                $book->setTitle('Undifined title'.uniqid());
            } else {
                $book->setTitle(utf8_encode($row[2]));
            }
            //get authors
            
            $relBookAuthor = new RelBookAuthor();
            
            $illustrator = $this->getAuthor($row[4]);
            if ($illustrator) {
                $relBookAuthor->setAuthorType('Illu');
                $relBookAuthor->setAuthors($illustrator);
                $relBookAuthor->setBooks($book);
                $manager->persist($relBookAuthor);
                $relBookAuthor = new RelBookAuthor();
            }
            
            $colorist = $this->getAuthor($row[5]);
            if ($colorist) {
                $relBookAuthor->setAuthorType('colo');
                $relBookAuthor->setAuthors($colorist);
                $relBookAuthor->setBooks($book);
                $manager->persist($relBookAuthor);
                $relBookAuthor = new RelBookAuthor();
            }
            
            $scenarist = $this->getAuthor($row[6]);
            if ($scenarist) {
                $relBookAuthor->setAuthorType('scen');
                $relBookAuthor->setAuthors($scenarist);
                $relBookAuthor->setBooks($book);
                $manager->persist($relBookAuthor);
            }

            $serie = $this->getSerie($row[3]);
            if ($serie) {
                $book->setSerie($serie);
            }
            if (empty($row[7])) {
                $book->setEditor('Aucun');
            } else {
                $book->setEditor(utf8_encode($row[7]));
            }
            $book->setReference($row[8]);
            $book->setCover($row[9]);
            $book->setNbPage($row[12]);
            $book->setStock($row[15]);
            $slug = $this->slugger->slug(utf8_encode($book->getTitle()));
            $book->setSlug($slug);
            $book->setDateCreated(new \DateTime());
            $book->setDateModified(new \DateTime());
            $book->setId($row[0]);
            $serie->addBook($book);
            $manager->persist($book, $serie, $relBookAuthor);
        }
        //allow to SET the id, else it will be autogenerated
        $metadata = $manager->getClassMetaData(get_class($book));
        $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
        $manager->flush();
    }
    
    private function loadAuthors(ObjectManager $manager)
    {
        $fh = fopen($this->pathToData."auteurs.csv", "r");
        $num = 1;
        while ($row = fgetcsv($fh, 0, ';')) {
            //skip first 2 rows
            if ($num <= 2) {
                $num++;
                continue;
            }
            /*
                [0] => IdAuteur
                [1] => Nom
                [2] => Prenom
                [3] => Surnom //in fact picture
                [4] => DateNaissance
                [5] => DateDeces
                [6] => Pays
                [7] => Pseudo //real aka
                [8] => IdBEL
            */
            $row = $this->replaceNull($row);
            $author = new Author();
            if (empty($row[1])) {
                $author->setLastName('Aucun');
            } else {
                $author->setLastName(utf8_encode($row[1]));
            }

            if (empty($row[2])) {
                $author->setFirstName('Aucun');
            } else {
                $author->setFirstName(utf8_encode($row[2]));
            }
            
            if ($row[4] != null) {
                $author->setBirthDate($this->getDateTime($row[4]));
            }
            if ($row[5] != null) {
                $author->setDeathDate($this->getDateTime($row[5]));
            }
            if (empty($row[6])) {
                $author->setCountry('Aucun');
            } else {
                $author->setCountry(ucfirst(mb_strtolower($row[6], 'UTF-8')));
            }
            
            if (empty($row[7])) {
                $author->setNickname('Aucun');
            } else {
                $author->setNickname(utf8_encode($row[7]));
            }
            if ($author->getFirstname() == null) {
                $slug = $author->getLastname();
            } else {
                $slug = $this->slugger->slug(utf8_encode($author->getFirstname().$author->getLastname()));
            }
            $author->setSlug($slug);
            $author->setId($row[0]);
            $manager->persist($author);
        }
        //allow to SET the id, else it will be autogenerated
        $metadata = $manager->getClassMetaData(get_class($author));
        $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
        
        $manager->flush();
    }
    
    private function loadSeries(ObjectManager $manager)
    {
        $fh = fopen($this->pathToData."series.csv", "r");
        $num = 1;
        while ($row = fgetcsv($fh, 0, ';')) {
            //skip first row
            if ($num <= 1) {
                $num++;
                continue;
            }
            /*
            [0] => IdSerie
            [1] => Titre
            [2] => Style
            [3] => Commentaire
            [4] => NoteGlobale
            [5] => Planche
            [6] => IdBEL
            [7] => Langue
            */
            $row = $this->replaceNull($row);
            $serie = new Serie();

            if (empty($row[1])) {
                $serie->setTitle('Aucun');
            } else {
                $serie->setTitle(utf8_encode($row[1]));
            }

            $cat = $this->catRepo->findOneBycategoryName($this->getSimpleStyle($row[2]));
            $serie->addCategory($cat);

            if (empty($row[3])) {
                $serie->setDescription(' ');
            } else {
                $serie->setDescription(utf8_encode($row[3]));
            }

            $slug = $this->slugger->slug(utf8_encode($serie->getTitle()));
            $serie->setSlug($slug);
            //lang
            $serie->setLanguage($this->getLanguageCode($row[7]));
            $serie->setId($row[0]);
            $cat->addSeries($serie);
            $manager->persist($serie, $cat);
        }
        //allow to SET the id, else it will be autogenerated
        $metadata = $manager->getClassMetaData(get_class($serie));
        $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
        
        $manager->flush();
    }
    //replace textual NULL values by real null
    private function replaceNull($row)
    {
        for ($i=0; $i<count($row); $i++) {
            if ($row[$i] == "NULL") {
                $row[$i] = null;
            }
        }
        return $row;
    }
    //get new author from db, else from local property if already set
    private function getAuthor($authorId)
    {
        if (empty($this->authors[$authorId])) {
            $author = $this->authorRepo->find($authorId);
            $this->authors[ $authorId ] = $author;
        }
        return $this->authors[ $authorId ];
    }
    //get new serie from db, else from local property if already set
    private function getSerie($serieId)
    {
        if (empty($this->series[$serieId])) {
            $serie = $this->serieRepo->find($serieId);
            $this->series[ $serieId ] = $serie;
        }
        return $this->series[ $serieId ];
    }
    
    //return a DateTime object from a shitty date, or false on failure
    private function getDateTime($date)
    {
        $twoDigitDate = explode(' ', explode('/', $date)[2])[0];
        $fourDigitDate = "20" . $twoDigitDate;
        if ($twoDigitDate > date("y")) {
            $fourDigitDate = "19" . $twoDigitDate;
        }
        $date = str_replace($twoDigitDate, $fourDigitDate, $date);
        $dateTime = \DateTime::createFromFormat("d/m/Y H:i", $date);
        return $dateTime;
    }
    
    //return the language code from full name
    private function getLanguageCode($fullName)
    {
        $lang = false;
        switch ($fullName) {
            case "Français":
                $lang = "fr";
                break;
            case "Anglais":
                $lang = "en";
                break;
        }
        return $lang;
    }
    
    private function getSimpleStyle($style)
    {
        $default = "Divers";
        $mappings = array(
                "Science-fiction" => array(
                        "Science-fiction",
                        "Heroic Fantasy",
                        "Sf/fantastique/anticipation",
                        "Science fiction",
                        "Anticipation",
                        "Fantastique"
                ),
                "Aventure" => array(
                        "Aventure",
                        "Aventures",
                        "Aventure fantastique"
                ),
                "Polar/Thriller" => array(
                        "Polar/Thriller",
                        "Polar",
                        "Polar/Thriler",
                        "Policier",
                        "Thriller"
                ),
                "Historique" => array(
                        "Historique",
                        "Histoire",
                        "Histoire - Fiction",
                        "Aventure historique",
                        "Histoire/fiction historique"
                ),
                "Jeunesse" => array(
                        "Jeunesse"
                ),
                "Humour" => array(
                        "Humoristique",
                        "Western humoristique",
                        "Humour"
                ),
                "Manga" => array(
                        "Manga",
                        "Manga - Seinen"
                ),
                "Biographie" => array(
                        "Biographie",
                        "Autobiographie",
                        "Tranche de vie"
                ),
                "Indépendant" => array(
                        "Independant"
                ),
                "Érotique" => array(
                        "Erotique"
                ),
                "Comics" => array(
                        "Super héros",
                        "Comics"
                ),
                "Divers" => array(
                        "Roman graphique",
                        "Animalier",
                        "Adaptation",
                        "Divers",
                        "Chronique urbaine",
                        "Chronique",
                        "Société/quotidien",
                        "Drame",
                        "NULL",
                        null,
                        false
                ),
        );
        //looks for bad name, and returns good one
        foreach ($mappings as $goodName => $badNames) {
            if (in_array($style, $badNames)) {
                return $goodName;
            }
        }
        return $default;
    }
}
