<?php

namespace FioulMarket\CommonBundle\Traits;

use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

trait ApiFeaturesTrait
{
    /**
     * @param $data
     *
     * @return View
     */
    private function getDataView($data)
    {
        return View::create([
            'count' => sizeof($data),
            'data' => $data,
        ], Response::HTTP_OK);
    }

    /**
     * @param string|array $message
     * @param $httpCode
     *
     * @return View
     */
    private function getExceptionView($message, $httpCode)
    {
        return View::create(['message' => $message], $httpCode);
    }
}
