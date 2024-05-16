<?php
namespace App\Modules\Partners\Http;

use App\Modules\Partners\Dto\CreateDto;
use App\Modules\Partners\Exceptions\PartnerAlreadyExistException;
use App\Modules\Partners\Exceptions\PartnerNotFoundException;
use App\Modules\Partners\Exceptions\InvalidDTOException;
use App\Modules\Partners\Repository\PartnerRepository;
use App\Modules\Partners\UseCases\CreateUseCase;
use App\Modules\Partners\UseCases\DeleteUseCase;
use App\Modules\Partners\UseCases\ReadAllUseCase;
use App\Modules\Partners\UseCases\ReadUseCase;
use App\Modules\Partners\UseCases\UpdateUseCase;
use App\Shared\Http\BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class Controller extends BaseController
{
    public function Create(Request $request, PartnerRepository $repository): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true);
            if (is_null($data))
                return $this->BadRequest();
            
            $uc = new CreateUseCase($repository);
            $result = $uc->Execute(CreateDto::FromRequest($data));
            
            if ($result->isLeft()) {
                switch (get_class($result->value->getErrorValue())) {
                    case PartnerAlreadyExistException::class:
                        return $this->BadRequest('Partner already exist.');
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

    public function Read(Request $request, PartnerRepository $repository): JsonResponse
    {
        try {
            $param = $request->query->get('document');
            if (is_null($param))
                return $this->BadRequest();
            
            $uc = new ReadUseCase($repository);
            $result = $uc->Execute($param);
            
            if ($result->isLeft()) {
                switch (get_class($result->value->getErrorValue())) {
                    case PartnerNotFoundException::class:
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

    public function ReadAll(PartnerRepository $repository): JsonResponse
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
    
    public function Delete(string $id, PartnerRepository $repository): JsonResponse
    {
        try {
            if (is_null($id))
                return $this->BadRequest();
            
            $uc = new DeleteUseCase($repository);
            $result = $uc->Execute($id);
            
            if ($result->isLeft()) {
                switch (get_class($result->value->getErrorValue())) {
                    case PartnerNotFoundException::class:
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

    public function Update(Request $request, string $id, PartnerRepository $repository): JsonResponse
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
                    case PartnerNotFoundException::class:
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
