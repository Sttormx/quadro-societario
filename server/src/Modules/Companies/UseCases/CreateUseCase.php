<?php

namespace App\Modules\Companies\UseCases;

use App\Modules\Companies\Domain\CompanyDomain;
use App\Modules\Companies\Dto\CreateDto;
use App\Modules\Companies\Exceptions\CompanyAlreadyExistException;
use App\Modules\Companies\Exceptions\InvalidDTOException;
use App\Modules\Companies\Repository\CompanyRepository;
use App\Shared\Core\Either;
use App\Shared\Core\Right;
use App\Shared\Core\Result;
use App\Shared\Core\Left;

class CreateUseCase {
    private CompanyRepository $repository;
    
    public function __construct(CompanyRepository $companyRepository) {
        $this->repository = $companyRepository;
    }
    
    function Execute(CreateDto $dto): Either {
        try {
            if (CompanyDomain::isValidDTO($dto)->isFailure())
                return new Left(Result::fail(new InvalidDTOException()));
    
            if ($this->repository->FindByDocument($dto->document) != null)
                return new Left(Result::fail(new CompanyAlreadyExistException()));
    
            $data = $this->repository->Create($dto->name, $dto->document);
            return new Right(Result::ok($data->toArr()));
        } catch (\Throwable $th) {
            return new Left(Result::fail($th));
        }
    }
}