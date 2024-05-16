<?php

namespace App\Modules\Companies\UseCases;

use App\Modules\Companies\Entity\Company;
use App\Modules\Companies\Repository\CompanyRepository;
use App\Shared\Core\Either;
use App\Shared\Core\Right;
use App\Shared\Core\Result;
use App\Shared\Core\Left;

class ReadAllUseCase {
    private CompanyRepository $repository;
    
    public function __construct(CompanyRepository $companyRepository) {
        $this->repository = $companyRepository;
    }
    
    function Execute(): Either {
        try {
            $data = $this->repository->FindAllActive();
            return new Right(Result::ok(Company::formatAll($data)));
        } catch (\Throwable $th) {
            return new Left(Result::fail($th));
        }
    }
}