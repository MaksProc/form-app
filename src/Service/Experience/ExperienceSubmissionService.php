<?php


namespace App\Service\Experience;

use App\Entity\Experience;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ExperienceSubmissionService
{
    public function __construct(private ValidatorInterface $validator) {}
    public function createExperienceFromPayload(array $data)
    {
        $experiences = [];
        foreach ($data as $expData) {
            $newExp = new Experience();
            $newExp -> setCompanyName($expData['company']);
            $newExp -> setJobTitle($expData['jobtitle']);
            $newExp -> setStartDate(new \DateTime($expData['start']));
            $newExp -> setEndDate(new \DateTime($expData['end']));
            
            $error = $this -> validator -> validate($newExp);
            if (count($error) > 0) {
                throw new \Exception($error);
            }

            $experiences[] = $newExp;
        }

        return $experiences;
    }
}