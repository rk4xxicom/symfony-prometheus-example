<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LegacyMetricsController extends AbstractController
{
    /**
     * @Route("/legacy/metrics", name="legacy_metrics")
     */
    public function index()
    {
        return $this->render('legacy_metrics/index.html.twig', [
            'controller_name' => 'LegacyMetricsController',
        ]);
    }
}
