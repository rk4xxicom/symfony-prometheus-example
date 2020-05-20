<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="create_user", methods={"POST"})
     */
    public function index(Request $request, EntityManagerInterface $entityManager, LoggerInterface $logger)
    {
        $user = new User();
        $user->setEnabled(true);
        $user->setName($request->request->get('name'));

        $entityManager->persist($user);
        $entityManager->flush();

        $logger->info('Saved user', ['id' => $user->getId()]);

        return new JsonResponse(['id' => $user->getId()], Response::HTTP_CREATED);
    }
}
