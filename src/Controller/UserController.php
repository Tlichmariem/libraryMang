<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user/profile', name: 'user_profile')]
    public function profile(): Response
    {
        // Optionnel : Vous pouvez ajouter des informations supplémentaires ici, comme les données de l'utilisateur.
        return $this->render('user/profile.html.twig');
    }
}
