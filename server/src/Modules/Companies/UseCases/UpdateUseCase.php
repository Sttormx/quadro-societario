<?php

namespace App\Modules\Companies\UseCases;

use App\Modules\Companies\Dto\CreateDto;
use App\Modules\Companies\Exceptions\CompanyNotFoundException;
use App\Modules\Companies\Exceptions\InvalidDTOException;
use App\Modules\Companies\Repository\CompanyRepository;
use App\Shared\Core\Either;
use App\Shared\Core\Right;
use App\Shared\Core\Result;
use App\Shared\Core\Left;
use Symfony\Component\Uid\Uuid;

class UpdateUseCase {
    private CompanyRepository $repository;
    
    public function __construct(CompanyRepository $companyRepository) {
        $this->repository = $companyRepository;
    }
    
    function Execute(string $id, CreateDto $dto): Either {
        try {
            if ($id == '' || !Uuid::isValid($id))
                return new Left(Result::fail(new InvalidDTOException()));

            $company = $this->repository->FindByUuid($id);
            if ($company == null)
                return new Left(Result::fail(new CompanyNotFoundException()));
    
            $this->repository->Update($company, $dto->toArr());
            return new Right(Result::ok());
        } catch (\Throwable $th) {
            dd($th);
            return new Left(Result::fail($th));
        }
    }
}