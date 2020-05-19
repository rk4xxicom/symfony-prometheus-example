<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\BankAccountRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LegacyMetricsController extends AbstractController
{
    /**
     * @Route("/legacy/metrics", name="legacy_metrics")
     */
    public function index(UserRepository $userRepository, BankAccountRepository $bankAccountRepository): Response
    {
        $metrics = array_merge(
            $this->getUserStats($userRepository->getUserStats()),
            $this->getBankAccountStats($bankAccountRepository->getBankAccountStats())
        );

        return new Response(implode(PHP_EOL, $metrics));
    }

    public function getUserStats(array $userStats): array
    {
        $lines = [
            '# HELP users Users by status',
            '# TYPE users gauge',
        ];

        foreach ($userStats as ['enabled' => $enabled, 'count' => $count]) {
            $enabled = $enabled ? 'yes' : 'no';
            $metric = sprintf('users{enabled="%s"}', $enabled);
            $lines[] = sprintf('%s %d', $metric, $count);
        }

        return $lines;
    }

    public function getBankAccountStats(array $bankAccountStats): array
    {
        $lines = [
            '# HELP bank_accounts Bank accounts by status',
            '# TYPE bank_accounts gauge',
        ];

        foreach ($bankAccountStats as ['status' => $status, 'count' => $count]) {
            $metric = sprintf('bank_accounts{status="%s"}', $status);
            $lines[] = sprintf('%s %d', $metric, $count);
        }

        return $lines;
    }
}
