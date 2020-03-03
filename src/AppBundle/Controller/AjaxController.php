<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Company;
use AppBundle\Entity\Donate;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ajax")
 */
class AjaxController extends Controller
{
    /**
     * @Route("/getCompanies", name="getCompanies")
     */
    public function indexAction(Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->container->get('doctrine')->getManager();
        /** @var Company $companies */
        $companies = $em->getRepository(Company::class)->findAll();
        return new JsonResponse(['companies' => $companies]);
    }

    /**
     * @Route("/addDonate", name="addDonate")
     */
    public function addDonateAction(Request $request)
    {
        if(!$request->isXmlHttpRequest()){
            return;
        }
        $errors = [];
        foreach( [ 'name', 'cost', 'company', 'email' ] as $field ) {
            if(empty($request->get($field))){
                $errors[] = sprintf('Required field %s', $field);
            }
        }
        /** @var EntityManager $em */
        $em = $this->container->get('doctrine')->getManager();

        if($errors) {
            return new JsonResponse(['errors' => $errors]);
        }
        $email = $request->get('email');
        $name = $request->get('name');
        $cost = (float)$request->get('cost');
        $company = (int)$request->get('company');
        $comment = $request->get('comment');
        $company = $em->getRepository(Company::class)->find($company);
        if(!$company){
            return new JsonResponse(['errors' => ['Company not found']]);
        }
        $user = $em->getRepository(User::class)->findOneBy(['email' => $email]);
        if(!$user){
            $user = new User();
        }
        $user->setName($name);
        $user->setEmail($email);
        $donate = new Donate();
        $donate->setUser($user);
        $donate->setComment($comment);
        $donate->setCost($cost);
        $donate->setCompany($company);
        $em->persist($donate);
        $em->flush();
        /** @var Company $companies */
        return new JsonResponse(['success' => true, 'donate' => $donate, 'company' => $company]);
    }

    /**
     * @Route("/getDataDashboard", name="getDataDashboard")
     */
    public function getDataDashboard(Request $request){
        /** @var EntityManager $em */
        $em = $this->container->get('doctrine')->getManager();
        $startDate = (new \DateTime('-1 month'))->format('Y-m-d');
        $totalSum = $em->getRepository(Donate::class)->createQueryBuilder('d')
                              ->select('SUM(d.cost) as sum')
                              ->setMaxResults(1)
                              ->getQuery()->getResult();
        $monthSum = $em->getRepository(Donate::class)->createQueryBuilder('d')
                              ->select('SUM(d.cost) as sum')
                              ->andWhere('d.createdAt >= :start')
                              ->setParameter('start', ((new \DateTime())->modify('first day of this month'))->setTime(0,0,0))
                              ->setMaxResults(1)
                              ->getQuery()->getResult();
        $chart = $em->getRepository(Donate::class)->createQueryBuilder('d')
                              ->andWhere('d.createdAt >= :start')
                              ->setParameter('start', $startDate)
                              ->getQuery()->getResult();
        $firstDonateUser = $em->getRepository(Donate::class)->createQueryBuilder('d')
                              ->select('SUM(d.cost) as sum, u.name')
                              ->leftJoin('d.user', 'u', \Doctrine\ORM\Query\Expr\Join::WITH)
                              ->addGroupBy('d.user')
                              ->addOrderBy('sum', 'desc')
                              ->setMaxResults(1)
                              ->getQuery()->getResult();
        return new JsonResponse([
            'chart' => $chart,
            'firstDonateUser' => count($firstDonateUser) ? array_shift($firstDonateUser): false,
            'monthSum' => count($monthSum) ? array_shift($monthSum) : false,
            'totalSum' => count($totalSum) ? array_shift($totalSum) : false
        ]);
    }

}
