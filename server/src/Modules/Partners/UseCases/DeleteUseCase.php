<?php

namespace App\Modules\Partners\UseCases;

use App\Modules\Partners\Exceptions\PartnerNotFoundException;
use App\Modules\Partners\Exceptions\InvalidDTOException;
use App\Modules\Partners\Repository\PartnerRepository;
use App\Shared\Core\Either;
use App\Shared\Core\Right;
use App\Shared\Core\Result;
use App\Shared\Core\Left;
use Symfony\Component\Uid\Uuid;

class DeleteUseCase {
    private PartnerRepository $repository;
    
    public function __construct(PartnerRepository $PartnerRepository) {
        $this->repository = $PartnerRepository;
    }
    
    function Execute(string $id): Either {
        try {
            if ($id == '' || !Uuid::isValid($id))
                return new Left(Result::fail(new InvalidDTOException()));

            $Partner = $this->repository->FindByUuid($id);
            if ($Partner == null)
                return new Left(Result::fail(new PartnerNotFoundException()));
    
            $this->repository->SoftDelete($Partner);
            return new Right(Result::ok());
        } catch (\Throwable $th) {
            dd($th);
            return new Left(Result::fail($th));
        }
    }
}