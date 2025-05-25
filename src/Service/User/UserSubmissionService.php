<?php

namespace App\Service\User;

use App\Entity\User;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserSubmissionService
{
    public function __construct(private ValidatorInterface $validator) {}
    public function createUserFromPayload(array $data)
    {
        $user = new User();
        $user -> setName($data['name']);
        $user -> setSurname($data['surname']);
        $user -> setBirthday(new \DateTime($data['birthday']));

        $errors = $this -> validator->validate($user);
        if (count($errors) > 0) {
            throw new \Exception($errors);
        }

        return $user;
    }
}