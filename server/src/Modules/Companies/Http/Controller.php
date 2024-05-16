<?php
namespace App\Modules\Companies\Http;

use App\Modules\Companies\Dto\CreateDto;
use App\Modules\Companies\Exceptions\CompanyAlreadyExistException;
use App\Modules\Companies\Exceptions\CompanyNotFoundException;
use App\Modules\Companies\Exceptions\InvalidDTOException;
use App\Modules\Companies\Repository\CompanyRepository;
use App\Modules\Companies\UseCases\CreateUseCase;
use App\Modules\Companies\UseCases\DeleteUseCase;
use App\Modules\Companies\UseCases\ReadAllUseCase;
use App\Modules\Companies\UseCases\ReadUseCase;
use App\Modules\Companies\UseCases\UpdateUseCase;
use App\Modules\CompaniesPartners\Repository\CompanyPartnersRepository;
use App\Shared\Http\BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class Controller extends BaseController
{
    public function Create(Request $request, CompanyRepository $repository): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true);
            if (is_null($data))
                return $this->BadRequest();
            
            $uc = new CreateUseCase($repository);
            $result = $uc->Execute(CreateDto::FromRequest($data));
            
            if ($result->isLeft()) {
                switch (get_class($result->value->getErrorValue())) {
                    case CompanyAlreadyExistException::class:
                        return $this->BadRequest('Company already exist.');
                    case InvalidDTOException::class:
                        return $this->UE(['message' => 'Invalid request.']);

                    default:
                        return $this->InternalError();
                }
            }

            return $this->Ok([
                'message' => 'Success.',
                'data' => $result->value->getValue()
            ]);
        } catch (\Throwable $th) {
            return $this->InternalError();
        }
    }

    public function Read(CompanyRepository $repository, CompanyPartnersRepository $cpr, string $id): JsonResponse
    {
        try {
            if (is_null($id) || $id == '')
                return $this->BadRequest();
            
            $uc = new ReadUseCase($repository, $cpr);
            $result = $uc->Execute($id);
            
            if ($result->isLeft()) {
                switch (get_class($result->value->getErrorValue())) {
                    case CompanyNotFoundException::class:
                        return $this->NotFound();
                    case InvalidDTOException::class:
                        return $this->BadRequest();

                    default:
                        return $this->InternalError();
                }
            }

            return $this->Ok([
                'message' => 'Success.',
                'data' => $result->value->getValue()
            ]);
        } catch (\Throwable $th) {
            dd($th);
            return $this->InternalError();
        }
    }

    public function ReadAll(CompanyRepository $repository): JsonResponse
    {
        try {
            $uc = new ReadAllUseCase($repository);
            $result = $uc->Execute();
            
            if ($result->isLeft())
                return $this->InternalError();

            return $this->Ok([
                'message' => 'Success.',
                'data' => $result->value->getValue()
            ]);
        } catch (\Throwable $th) {
            return $this->InternalError();
        }
    }
    
    public function Delete(string $id, CompanyRepository $repository): JsonResponse
    {
        try {
            if (is_null($id))
                return $this->BadRequest();
            
            $uc = new DeleteUseCase($repository);
            $result = $uc->Execute($id);
            
            if ($result->isLeft()) {
                switch (get_class($result->value->getErrorValue())) {
                    case CompanyNotFoundException::class:
                        return $this->NotFound();
                    case InvalidDTOException::class:
                        return $this->BadRequest();

                    default:
                        return $this->InternalError();
                }
            }

            return $this->Ok([
                'message' => 'Success.',
            ]);
        } catch (\Throwable $th) {
            dd($th);
            return $this->InternalError();
        }
    }

    public function Update(Request $request, string $id, CompanyRepository $repository): JsonResponse
    {
        try {
            if (is_null($id))
                return $this->BadRequest();
            
            $data = json_decode($request->getContent(), true);
            if (is_null($data))
                return $this->BadRequest();

            $uc = new UpdateUseCase($repository);
            $result = $uc->Execute($id, CreateDto::FromRequest($data));
            
            if ($result->isLeft()) {
                switch (get_class($result->value->getErrorValue())) {
                    case CompanyNotFoundException::class:
                        return $this->NotFound();
                    case InvalidDTOException::class:
                        return $this->BadRequest();

                    default:
                        return $this->InternalError();
                }
            }

            return $this->Ok([
                'message' => 'Success.',
            ]);
        } catch (\Throwable $th) {
            dd($th);
            return $this->InternalError();
        }
    }
}
