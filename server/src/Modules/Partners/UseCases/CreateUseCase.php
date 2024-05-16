<?php

namespace App\Modules\Partners\UseCases;

use App\Modules\Partners\Domain\PartnerDomain;
use App\Modules\Partners\Dto\CreateDto;
use App\Modules\Partners\Exceptions\PartnerAlreadyExistException;
use App\Modules\Partners\Exceptions\InvalidDTOException;
use App\Modules\Partners\Repository\PartnerRepository;
use App\Shared\Core\Either;
use App\Shared\Core\Right;
use App\Shared\Core\Result;
use App\Shared\Core\Left;

class CreateUseCase {
    private PartnerRepository $repository;
    
    public function __construct(PartnerRepository $PartnerRepository) {
        $this->repository = $PartnerRepository;
    }
    
    function Execute(CreateDto $dto): Either {
        try {
            if (PartnerDomain::isValidDTO($dto)->isFailure())
                return new Left(Result::fail(new InvalidDTOException()));
    
            if ($this->repository->FindByDocument($dto->document) != null)
                return new Left(Result::fail(new PartnerAlreadyExistException()));
    
            $data = $this->repository->Create($dto->name, $dto->document);
            return new Right(Result::ok($data->toArr()));
        } catch (\Throwable $th) {
            return new Left(Result::fail($th));
        }
    }
}