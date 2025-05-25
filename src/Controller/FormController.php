<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Experience;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class FormController extends AbstractController
{
    #[Route('/form', name: 'app_form')]
    public function index(): Response
    {
        return $this->render('form/application_form.html.twig', [
            'controller_name' => 'FormController',
        ]);
    }

    #[Route('/submit-form', name:'submit_form', methods: ['POST'])]
    public function submit(Request $request, ValidatorInterface $validator, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // JSON shape checks
        if (
            !isset($data['user']['name']) ||
            !isset($data['user']['surname']) ||
            !isset($data['user']['birthday']) ||
            !isset($data['contact']['phone']) ||
            !isset($data['contact']['email']) ||
            !is_array($data['experience'])
        ) {
            return $this->json(['error' => 'Invalid data structure'], 400);
        }

        foreach ($data['experience'] as $entry) {
            if (
                empty($entry['company']) ||
                empty($entry['jobtitle']) ||
                empty($entry['start']) ||
                empty($entry['end'])
            ) {
                return $this->json(['error' => 'Invalid experience entry'], 400);
            }
        }

        // Backend validation
        // User checks: name and surname not null, not today years old
        $user = new User();
        $user -> setName($data['user']['name']);
        $user -> setSurname($data['user']['surname']);

        try {
            $user -> setBirthday(new \DateTime($data['user']['birthday']));
        } catch (\Exception $e) {
            return $this->json(['error' => 'Invalid date format or value for birthday'], 400);
        }

        $errors = $validator -> validate($user);
        if (count($errors) > 0) {
            return $this->json(['error'=> (string) $errors], 400);
        }


        // Experience validation
        // Experience checks: end not sooner than start, company and jobtitle not null
        $experiences = [];
        foreach ($data['experience'] as $expData) {
            $newExp = new Experience();
            $newExp -> setCompanyName($expData['company']);
            $newExp -> setJobTitle($expData['jobtitle']);
            
            try {
                $newExp -> setStartDate(new \DateTime($expData['start']));
                $newExp -> setEndDate(new \DateTime($expData['end']));
            } catch (\Exception $e) {
                return $this->json(['error' => 'Invalid date in experience entry'], 400);
            }
            
            $errors = $validator -> validate($newExp);
            if (count($errors) > 0) {
                return $this->json(['error'=> "Invalid date in experience entry"], 400);
            }

            $experiences[] = $newExp;
        }


        // Contact validation
        // Contact checks: both fields not null, valid format
        $contact = new Contact();
        $contact -> setPhone($data['contact']['phone']);
        $contact ->setEmail($data['contact']['email']);

        $errors = $validator -> validate($contact);
        if (count($errors) > 0) {
            return $this ->json(['error'=> (string) $errors], 400);
        }


        // Bind and save the entities if all checks passed
        $user -> setContact($contact);
        foreach ($experiences as $exp) {
            $user -> addExperience($exp);
            $em->persist($exp);
        }
        $em->persist($user);
        $em->persist($contact);

        $em->flush();

        return $this->json([
            'message' => 'Data saved successfully',
            'data' => $data
        ], 200);
    }
}
