<?php

namespace App\Support\Http;

use JsonSerializable;
use Illuminate\Http\JsonResponse;
use App\DataTransfer\Http\ResponseDTO;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class ApiResponse
{
    const DEFAULT_SUCCESS_MESSAGE = "Success.";
    const DEFAULT_ERROR_MESSAGE = "Something Went Wrong.";

    public function __construct(
        private readonly JsonResponse $responseHandler
    ) {}

    public function success(JsonSerializable|array|null $data, ?string $message = null, array $meta = []): JsonResponse
    {
        $data = new ResponseDTO(
            $data,
            $message ?? self::DEFAULT_SUCCESS_MESSAGE,
            $meta
        );

        return $this->send($data, Response::HTTP_OK);
    }

    public function error(?string $message = null, int $statusCode = Response::HTTP_BAD_REQUEST): JsonResponse
    {
        $data = new ResponseDTO(
            message: $message ?? self::DEFAULT_ERROR_MESSAGE,
        );

        return $this->send($data, $statusCode);
    }

    public function send(ResponseDTO $data, int $status): JsonResponse
    {
        return $this->responseHandler->setData([
            "message" => $data->message,
            "data"    => $data->data,
            "meta"    => $data->meta
        ])->setStatusCode($status);
    }

    public static function buildPaginationMeta(LengthAwarePaginator $paginator): array
    {
        return [
            "pagination" => [
                'total'        => $paginator->total(),
                'count'        => $paginator->count(),
                'per_page'     => $paginator->perPage(),
                'current_page' => $paginator->currentPage(),
                'last_page'    => $paginator->lastPage(),
                'from'         => $paginator->firstItem(),
                'to'           => $paginator->lastItem()
            ]
        ];
    }
}
