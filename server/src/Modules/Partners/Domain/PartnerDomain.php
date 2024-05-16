<?php
namespace App\Modules\Partners\Domain;

use App\Modules\Partners\Dto\CreateDto;
use App\Shared\Core\Result;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints as Assert;

class PartnerDomain {
    public static function isValidDTO(CreateDto $dto): Result {
        $validator = Validation::createValidator();
        $constraints = new Assert\Collection([
            'name' => [
                new Assert\NotBlank()
            ],
            'document' => [
                new Assert\NotBlank()
            ]
        ]);
        
        $violations = $validator->validate(['name' => $dto->name, 'document' => $dto->document], $constraints);
        return (count($violations) == 0) ? Result::ok() : Result::fail($violations);
    }
}