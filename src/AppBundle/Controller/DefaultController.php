<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Donate;
use Doctrine\ORM\Query\ResultSetMapping;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Route("/success", name="success")
     * @Route("/dashboard", name="dashboard")
     */
    public function indexAction(Request $request)
    {
        /** @var EntityManager $em */
//        $em = $this->container->get('doctrine')->getManager();
//        $rsm = new ResultSetMapping;
//        $rsm->addEntityResult(Donate::class, 'u');
//        $rsm->addFieldResult('u', 'user', 'user');
//        $startDate = (new \DateTime('-1 month'))->format('Y-m-d');
//        $totalSum = $em->getRepository(Donate::class)->createQueryBuilder('d')
//                              ->select('SUM(d.cost) as sum')
//            ->setMaxResults(1)
//                              ->getQuery()->getResult();
//        $monthSum = $em->getRepository(Donate::class)->createQueryBuilder('d')
//                              ->select('SUM(d.cost) as sum')
//                              ->andWhere('d.createdAt >= :start')
//                              ->setParameter('start', $startDate)
//            ->setMaxResults(1)
//                              ->getQuery()->getResult();
//        \Symfony\Component\VarDumper\VarDumper::dump($monthSum);
//        \Symfony\Component\VarDumper\VarDumper::dump($totalSum);die;
//        $firstDonateUser = $em->getRepository(Donate::class)->createQueryBuilder('d')
//            ->select('SUM(d.cost) as sum, u.name')
//            ->leftJoin('d.user', 'u', \Doctrine\ORM\Query\Expr\Join::WITH)
//            ->addGroupBy('d.user')
//            ->addOrderBy('sum', 'desc')
//            ->setMaxResults(1)
//            ->getQuery()->getResult();
//        \Symfony\Component\VarDumper\VarDumper::dump($firstDonateUser);die;
        return $this->render('default/index.html.twig', [

        ]);
    }

    	public function executeQuery($sql, array $params = array(), array $opts = array())
	{
		$em = $this->container->get('doctrine')->getManager();
		$stmt = $em->getConnection()->prepare($sql);
		foreach ($params as $pn => $pv) $stmt->bindValue($pn, $pv);
		$stmt->execute();
		return $stmt;
	}
}
