<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class RegistrationDTO
{
    #[Assert\NotBlank(message: "L'email ne peut pas être vide")]
    #[Assert\Email(message: "L'email {{ value }} n'est pas valide")]
    public string $email;

    #[Assert\NotBlank(message: "Le mot de passe ne peut pas être vide")]
    #[Assert\Length(
        min: 12,
        minMessage: "Le mot de passe doit faire au moins {{ limit }} caractères"
    )]
    public string $password;

    #[Assert\NotBlank(message: "Le prénom ne peut pas être vide")]
    #[Assert\Length(min: 2, max: 100, minMessage: "Le prénom doit contenir au moins 2 caractères", maxMessage: "Le prénom ne peut pas contenir plus de 100 caractères")]
    public string $firstName;

    #[Assert\NotBlank(message: "Le nom ne peut pas être vide")]
    #[Assert\Length(min: 2, max: 100, minMessage: "Le nom doit contenir au moins 2 caractères", maxMessage: "Le nom ne peut pas contenir plus de 100 caractères")]
    public string $lastName;
}
