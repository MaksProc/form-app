<?php

namespace App\Service;

class FormFeedbackService
{
    public function __construct() {}

    public function applicationFormJsonShapeCheck(array $data) 
    {
        if (
            !isset($data['user']['name']) ||
            !isset($data['user']['surname']) ||
            !isset($data['user']['birthday']) ||
            !isset($data['contact']['phone']) ||
            !isset($data['contact']['email']) ||
            !is_array($data['experience'])
        ) {
            throw new \Exception('Invalid data structure');
        }

        foreach ($data['experience'] as $entry) {
            if (
                empty($entry['company']) ||
                empty($entry['jobtitle']) ||
                empty($entry['start']) ||
                empty($entry['end'])
            ) {
                throw new \Exception('Invalid experience entry');
            }
        }
    }
}