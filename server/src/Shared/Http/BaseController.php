<?php
namespace App\Shared\Http;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class BaseController extends AbstractController {
    public function Ok(array $data): JsonResponse {
        return $this->json($data, Response::HTTP_OK);
    }

    public function UE(array $data): JsonResponse {
        return $this->json($data, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function InternalError(): JsonResponse {
        return $this->json([
            'message' => 'Internal server error. Try again later.'
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function BadRequest($message = null): JsonResponse {
        return $this->json([
            'message' => $message == null ? 'Bad Request.' : $message
        ], Response::HTTP_BAD_REQUEST);
    }

    public function NotFound($message = null): JsonResponse {
        return $this->json([
            'message' => $message == null ? 'Resource not found.' : $message
        ], Response::HTTP_NOT_FOUND);
    }
}