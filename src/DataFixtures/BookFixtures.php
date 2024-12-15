<?php
// src/DataFixtures/BookFixtures.php
namespace App\DataFixtures;

use App\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BookFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Créer un livre
        $book1 = new Book();
        $book1->setTitle('The Great Gatsby');
        $book1->setAuthor('F. Scott Fitzgerald');
        $book1->setPublicationDate(new \DateTime('1925-04-10'));
        $book1->setAvailability(true);

        // Créer un autre livre
        $book2 = new Book();
        $book2->setTitle('1984');
        $book2->setAuthor('George Orwell');
        $book2->setPublicationDate(new \DateTime('1949-06-08'));
        $book2->setAvailability(true);

        // Ajouter à la base de données
        $manager->persist($book1);
        $manager->persist($book2);

        // Sauvegarder dans la base de données
        $manager->flush();
    }
}
