<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Experience;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

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
    public function submit(Request $request): JsonResponse
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
        $user = new User();
        $user -> setName($data['user']['name']);
        $user -> setSurname($data['user']['surname']);
        $user -> setBirthday($data['user']['birthday']);

        // new User validation checks. Name and surname not null, Birthday in YYYY-MM-DD format and not today years old

        $experiences = [];
        foreach ($data['experience'] as $expData) {
            $newExp = new Experience();
            $newExp -> setCompanyName($expData['company']);
            $newExp -> setJobTitle($expData['jobtitle']);
            $newExp -> setStartDate($expData['start']);
            $newExp -> setEndDate($expData['end']);
            
            // newExp validation checks. End not sooner than start, dates in correct format, company and jobtitle not null

            $experiences[] = $newExp;
        }

        $contact = new Contact();
        $contact -> setPhone($data['contact']['phone']);
        $contact ->setEmail($data['contact']['email']);

        // new Contact validation checks. Both fields not null and unique


        // Bind and save the entities if all checks passed
        $user -> setContact($contact);
        foreach ($experiences as $exp) {
            $user -> addExperience($exp);
        }



        return $this->json([
            'message' => 'Data received successfully',
            'data' => $data
        ], 200);
    }
}
