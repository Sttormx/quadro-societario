<?php

namespace App\Modules\Partners\UseCases;

use App\Modules\Partners\Entity\Partner;
use App\Modules\Partners\Repository\PartnerRepository;
use App\Shared\Core\Either;
use App\Shared\Core\Right;
use App\Shared\Core\Result;
use App\Shared\Core\Left;

class ReadAllUseCase {
    private PartnerRepository $repository;
    
    public function __construct(PartnerRepository $PartnerRepository) {
        $this->repository = $PartnerRepository;
    }
    
    function Execute(): Either {
        try {
            $data = $this->repository->FindAllActive();
            return new Right(Result::ok(Partner::formatAll($data)));
        } catch (\Throwable $th) {
            return new Left(Result::fail($th));
        }
    }
}