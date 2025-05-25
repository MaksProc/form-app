<?php

namespace App\Service\Contact;

use App\Entity\Contact;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ContactSubmissionService
{
    public function __construct(private ValidatorInterface $validator) {}
    public function createContactFromPayload(array $data)
    {
        $contact = new Contact();
        $contact -> setPhone($data['phone']);
        $contact ->setEmail($data['email']);

        $errors = $this -> validator -> validate($contact);
        if (count($errors) > 0) {
            throw new \Exception($errors);
        }

        return $contact;
    }
}