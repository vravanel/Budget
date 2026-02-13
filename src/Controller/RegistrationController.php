<?php

namespace App\Controller;

use App\DTO\RegistrationDTO;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/api/register', methods: ['POST'])]
    public function register(
        Request $request,
        SerializerInterface $serializer,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $passwordHasher,
        ValidatorInterface $validator,
        JWTTokenManagerInterface $jwtManager,
    ): JsonResponse {
        if ('json' !== $request->getContentTypeFormat()) {
            throw new BadRequestException('Unsupported content format');
        }

        $jsonData = $request->getContent();
        $registrationDTO = $serializer->deserialize($jsonData, RegistrationDTO::class, 'json');

        $errors = $validator->validate($registrationDTO);

        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[$error->getPropertyPath()] = $error->getMessage();
            }
            return $this->json(['errors' => $errorMessages], 422);
        }

        $existingUser = $em->getRepository(User::class)->findOneBy([
            'email' => $registrationDTO->email
        ]);

        if ($existingUser) {
            return $this->json([
                'errors' => ['email' => 'Cet email est déjà utilisé']
            ], 422);
        }

        $user = new User();
        $user->setEmail($registrationDTO->email);
        $user->setFirstName($registrationDTO->firstName);
        $user->setLastName($registrationDTO->lastName);
        $user->setRoles(['ROLE_USER']);

        $hashedPassword = $passwordHasher->hashPassword($user, $registrationDTO->password);
        $user->setPassword($hashedPassword);

        $em->persist($user);
        $em->flush();

        $token = $jwtManager->create($user);

        return $this->json(['token' => $token], 201);
    }
}
