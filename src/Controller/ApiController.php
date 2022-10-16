<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Persistence\ManagerRegistry;

class ApiController extends AbstractController
{

    private $entityManager;
    private $userRepository;
    public function __construct(UserRepository $userRepository, ManagerRegistry $doctrine)
    {
        $this->entityManager = $doctrine->getManager();
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/api/add_user", name="app_api",methods={"POST"})
     */
    public function add_user(Request $request,UserPasswordHasherInterface $passwordHasher)
    {
        $donnees = json_decode($request->getContent());
        $user = new User();
        $user->setUsername($donnees->name);
        $hashedPassword = $passwordHasher->hashPassword(
            $user,
            $donnees->password
        );
        $user->setPassword($hashedPassword);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        return new Response("User add");
    }
}
