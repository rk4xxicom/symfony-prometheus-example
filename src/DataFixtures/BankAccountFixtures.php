<?php

namespace App\DataFixtures;

use App\Entity\BankAccount;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BankAccountFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        foreach (range(10000, 10050) as $activeAccountNumber) {
            $bankAccount = new BankAccount();
            $bankAccount->setAccountNumber($activeAccountNumber);
            $bankAccount->setBalance(1000);
            $bankAccount->setStatus(BankAccount::STATUS_ACTIVE);

            $manager->persist($bankAccount);
        }

        foreach (range(20000, 20025) as $droppedAccountNumber) {
            $bankAccount = new BankAccount();
            $bankAccount->setAccountNumber($droppedAccountNumber);
            $bankAccount->setBalance(0);
            $bankAccount->setStatus(BankAccount::STATUS_DROPPED);

            $manager->persist($bankAccount);
        }

        foreach (range(30000, 30050) as $num) {
            $bankAccount = new BankAccount();
            $bankAccount->setAccountNumber($num);
            $bankAccount->setBalance(0);
            $bankAccount->setStatus(BankAccount::STATUS_IN_PROGRESS);

            $manager->persist($bankAccount);
        }


        $manager->flush();
    }
}
