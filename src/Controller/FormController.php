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

use App\Service\User\UserSubmissionService;
use App\Service\Experience\ExperienceSubmissionService;
use App\Service\Contact\ContactSubmissionService;
use App\Service\FormFeedbackService;

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
    public function submit(Request $request, ValidatorInterface $validator, EntityManagerInterface $em,
        UserSubmissionService $userService,
        ExperienceSubmissionService $experienceService,
        ContactSubmissionService $contactService,
        FormFeedbackService $formFeedbackService
    ): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        try {
            $formFeedbackService->applicationFormJsonShapeCheck($data);
        }
        catch (\Exception $e) {
            return $this->json($e, 400);
        }

        try {
            $user = $userService->createUserFromPayload($data['user']);
            $contact = $contactService->createContactFromPayload($data['contact']);
            $experiences = $experienceService->createExperienceFromPayload($data['experience']);

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
        catch (\Exception $e) {
            return $this->json(['error' => (string) $e], 400);
        }



    }
}
