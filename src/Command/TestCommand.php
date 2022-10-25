<?php

namespace App\Command;

use App\Service\EmailSender;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:test'
)]
class TestCommand extends Command
{
    public function __construct(private EmailSender $emailSender)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // ... put here the code to create the user

        // this method must return an integer number with the "exit status code"
        // of the command. You can also use these constants to make code more readable


        $payload = [
            'subject1' => "nejaky nazov",
            'meno' => "hej, tu je Jano"
        ];

        $this->emailSender->sendEmail('testdozizzy@gmail.com',  'd-14cb2d0b076240459ef443edb0638e70', $payload);
        // return this if there was no problem running the command
        // (it's equivalent to returning int(0))
        return Command::SUCCESS;

        // or return this if some error happened during the execution
        // (it's equivalent to returning int(1))
        // return Command::FAILURE;

        // or return this to indicate incorrect command usage; e.g. invalid options
        // or missing arguments (it's equivalent to returning int(2))
        // return Command::INVALID
    }
}