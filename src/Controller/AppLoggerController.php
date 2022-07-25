<?php

declare(strict_types=1);

namespace Virtua\ShopwareAppLoggerBundle\Controller;

use App\Repository\ShopwareShopRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Virtua\ShopwareAppLoggerBundle\Exception\ShopwareAppLoggerShopMissingException;
use Virtua\ShopwareAppLoggerBundle\Service\LogsPaginator;

/**
 * @Route("/logs", name="virtua_shopware_app_logger_bundle_")
 */
class AppLoggerController extends AbstractController
{
    private const TRANSLATION_NAME = "logs";

    private LogsPaginator $logsPaginator;
    private ShopwareShopRepository $shopRepository;
    private TranslatorInterface $translator;

    public function __construct(
        LogsPaginator $logsPaginator,
        ShopwareShopRepository $shopRepository,
        TranslatorInterface $translator
    ) {
        $this->logsPaginator = $logsPaginator;
        $this->shopRepository = $shopRepository;
        $this->translator = $translator;
    }

    /**
     * @Route("/list/{shopId}/{lang}/{page}/{order}", name="list", methods={"GET"})
     */
    public function listPage(
        Request $request,
        ?string $shopId = null,
        ?string $lang = null,
        int $page = 1,
        string $order = 'DESC'
    ): Response {
        $shopId = $shopId ?? $request->get('shop-id');
        $shopwareShopUrl = $request->get('shop-url');

        if (!$shopwareShopUrl) {
            $shopEntity = $this->shopRepository->findByShopId($shopId);
            $shopwareShopUrl = $shopEntity->getShopUrl();
        }

        if (!$lang) {
            $lang = $request->get('sw-user-language');
        }

        try {
            $logs = $this->logsPaginator->getPaginatedLogs($shopId, $page, $order);
        } catch (ShopwareAppLoggerShopMissingException $e) {
            return $this->getErrorPage(
                $this->translator->trans(
                    'error.shopMissing',
                    ['%shop%' => $shopId],
                    self::TRANSLATION_NAME,
                    $lang
                ),
                $shopwareShopUrl,
                $lang,
            );
        }

        $translations = [
            'title' => $this->translator->trans('pageTitle', [], self::TRANSLATION_NAME, $lang),
            'columnDate' => $this->translator->trans('columnDate', [], self::TRANSLATION_NAME, $lang),
            'columnCode' => $this->translator->trans('columnCode', [], self::TRANSLATION_NAME, $lang),
            'columnMessage' => $this->translator->trans('columnMessage', [], self::TRANSLATION_NAME, $lang),
            'noLogs' => $this->translator->trans('noLogs', [], self::TRANSLATION_NAME, $lang),
        ];

        return $this->render(
            '@ShopwareAppLogger/logs/index.html.twig',
            [
                'translation' => $translations,
                'shopwareCSS' => $shopwareShopUrl . "/bundles/administration/static/css/app.css",
                'logs' => $logs['logs'],
                'pagination' => $logs['pagination'],
                'language' => $lang,
                'pageUrl' => $this->getParameter('app.app_url') . "/logs/list",
                'order' => $order,
                'shopId' => $shopId
            ]
        );
    }

    private function getErrorPage(
        string $errorMessage,
        string $shopwareShopUrl,
        string $lang
    ): Response {
        return $this->render(
            '@ShopwareAppLogger/logs/error.html.twig',
            [
                'shopwareCSS' => $shopwareShopUrl . "/bundles/administration/static/css/app.css",
                'errorTitle' => $this->translator->trans('error.title', [], self::TRANSLATION_NAME, $lang),
                'errorMessage' => $errorMessage,
            ]
        );
    }
}
