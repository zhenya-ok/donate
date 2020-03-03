<?php

namespace AppBundle\Command;

use AppBundle\Entity\Company;
use AppBundle\Entity\Donate;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DemoCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('load:demo')
            ->setDescription('Load demo data')
            ->addArgument('countDonate', InputArgument::REQUIRED, 'Count donate')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $countDonate = $input->getArgument('countDonate');
        /** @var EntityManager $em */
        $em = $this->getContainer()->get( "doctrine" )->getManager();
        $companies = ['Apple', 'Samsung', 'Huawei'];
        $users = ['John', 'Make', 'Jane'];
        $issetCompanies = [];
        $issetUsers = [];
        foreach( $companies as $company ) {
            $addCompany = $em->getRepository(Company::class)->findOneBy(['name' => $company]);
            if($addCompany){
                $issetCompanies[]= $addCompany;
                continue;
            }
            $addCompany = new Company();
            $addCompany->setName($company);
            $em->persist($addCompany);
            $em->flush();
            $issetCompanies[] = $addCompany;
        }
        foreach( $users as $user ) {
            $addUser = $em->getRepository(User::class)->findOneBy(['name' => $user]);
            if($addUser){
                $issetUsers[]= $addUser;
                continue;
            }
            $addUser = new User();
            $addUser->setName($user);
            $addUser->setEmail(strtolower($user).'@mail.ru');
            $em->persist($addUser);
            $em->flush();
            $issetUsers[] = $addUser;
        }
        for($i = 0; $i <= $countDonate; $i++){
            $randomCount = rand(1,10);
            for($j = 0; $j <= $randomCount; $j++ ){
                $start = (new \DateTime('-2 month'))->getTimestamp();
                $end = (new \DateTime())->getTimestamp();
                $timestamp = mt_rand($start, $end);
                $randomDate = (new \DateTime())->setTimestamp($timestamp);
                $donate = new Donate();
                $donate->setUser($issetUsers[rand(0, count($issetCompanies) - 1)]);
                $donate->setCost(rand(10,50));
                $donate->setCompany($issetCompanies[rand(0, count($issetCompanies) - 1)]);
                $donate->setCreatedAt($randomDate);
                $em->persist($donate);
            }
        }
        $em->flush();
        $output->writeln('Command result.');
    }

}
