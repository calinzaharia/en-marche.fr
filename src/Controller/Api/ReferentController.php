<?php

namespace AppBundle\Controller\Api;

use AppBundle\Repository\AdherentRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/referent-dashboard")
 * @Security("is_granted('ROLE_REFERENT')")
 */
class ReferentController extends Controller
{
    /**
     * @Route("/utilisateurs", name="app_referent_dashboard_users")
     * @Method("GET")
     */
    public function usersAction(AdherentRepository $adherentRepository): Response
    {
        $count = $adherentRepository->countByGendreAndTotal();

        return new JsonResponse([
            'male' => round($count['male']/$count['total']),
            'female' => round($count['female']/$count['total']),
            'total' => $count['total'],
        ]);
    }
}
