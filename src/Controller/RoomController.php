<?php
// src/Controller/RoomController.php

namespace App\Controller;

use App\Entity\Room;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RoomController extends AbstractController
{
    #[Route('/room', name: 'room_index')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        // Récupérer toutes les chambres depuis la base de données
        $rooms = $entityManager->getRepository(Room::class)->findAll();

        // Passer les chambres au template
        return $this->render('room/index.html.twig', [
            'rooms' => $rooms,
        ]);
    }
}
