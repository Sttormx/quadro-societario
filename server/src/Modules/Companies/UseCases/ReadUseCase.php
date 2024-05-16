<?php

namespace App\Modules\Companies\UseCases;

use App\Modules\Companies\Exceptions\CompanyNotFoundException;
use App\Modules\Companies\Exceptions\InvalidDTOException;
use App\Modules\Companies\Repository\CompanyRepository;
use App\Modules\CompaniesPartners\Entity\CompaniesPartners;
use App\Modules\CompaniesPartners\Repository\CompanyPartnersRepository;
use App\Shared\Core\Either;
use App\Shared\Core\Right;
use App\Shared\Core\Result;
use App\Shared\Core\Left;

class ReadUseCase {
    private CompanyRepository $repository;
    private CompanyPartnersRepository $cpr;
    
    public function __construct(CompanyRepository $companyRepository, CompanyPartnersRepository $cpr) {
        $this->repository = $companyRepository;
        $this->cpr = $cpr;
    }
    
    function Execute(string $id): Either {
        try {
            if ($id == '')
                return new Left(Result::fail(new InvalidDTOException()));

            $data = $this->repository->FindByUuid($id);
            if ($data == null)
                return new Left(Result::fail(new CompanyNotFoundException()));

            $dataArr = $data->toArr();
            $dataArr['partners'] = [];

            $cps = CompaniesPartners::formatAll($this->cpr->FindAllActiveByCompany($data->getId()));
            foreach ($cps as $value) {
                $dataArr['partners'][$value['partner']['id']] = $value['partner'];
            }

            return new Right(Result::ok($dataArr));
        } catch (\Throwable $th) {
            dd($th);
            return new Left(Result::fail($th));
        }
    }
}