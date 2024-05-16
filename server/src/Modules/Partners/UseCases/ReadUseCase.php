<?php

namespace App\Modules\Partners\UseCases;

use App\Modules\Partners\Exceptions\PartnerNotFoundException;
use App\Modules\Partners\Exceptions\InvalidDTOException;
use App\Modules\Partners\Repository\PartnerRepository;
use App\Shared\Core\Either;
use App\Shared\Core\Right;
use App\Shared\Core\Result;
use App\Shared\Core\Left;

class ReadUseCase {
    private PartnerRepository $repository;
    
    public function __construct(PartnerRepository $PartnerRepository) {
        $this->repository = $PartnerRepository;
    }
    
    function Execute(string $document): Either {
        try {
            if ($document == '')
                return new Left(Result::fail(new InvalidDTOException()));

            $data = $this->repository->FindByDocument($document);
            if ($data == null)
                return new Left(Result::fail(new PartnerNotFoundException()));

            return new Right(Result::ok($data->toArr()));
        } catch (\Throwable $th) {
            return new Left(Result::fail($th));
        }
    }
}