<?php

namespace FioulMarket\PriceBundle\Controller;

use FioulMarket\CommonBundle\Traits\ApiFeaturesTrait;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UserController.
 */
class ApiController extends FOSRestController
{
    use ApiFeaturesTrait;

    /**
     * Récupére les prix.
     *
     * @ApiDoc(
     *     section="Price",
     *     tags={
     *         "dev"
     *     },
     *     requirements={
     *         {
     *             "name"="postal_code", "dataType"="integer", "requirement"="\d+", "description"="Code postal de la ville"
     *         }
     *     },
     *     parameters={
     *         {"name"="start_date", "dataType"="string", "required"=true, "description"="Date au format d-m-Y"},
     *         {"name"="end_date", "dataType"="string", "required"=true, "description"="Date au format d-m-Y"}
     *     },
     *     statusCodes={
     *         200="Succès.",
     *         404="Prix non trouvé"
     *     }
     * )
     *
     * @param Request $request
     *
     * @return View|mixed
     */
    public function getPriceAction(Request $request)
    {
        try {
            $postalCode = $request->get('postal_code');
            $startDate = $request->get('start_date');
            $endDate = $request->get('end_date');

            $data = $this->get('fioulmarket.price.manager.price')->getPriceByCityAndDate($postalCode, $startDate, $endDate);

            $view = $this->getDataView($data);
        } catch (\Exception $e) {
            $codeHttp = ($e->getCode() > 0) ? $e->getCode() : Response::HTTP_INTERNAL_SERVER_ERROR;
            $view = $this->getExceptionView($e->getMessage(), $codeHttp);
        }

        return $this->handleView($view);
    }
}
