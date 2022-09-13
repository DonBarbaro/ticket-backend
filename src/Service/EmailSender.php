<?php

namespace App\Service;

use Exception;
use SendGrid;
use SendGrid\Mail\Mail;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class EmailSender
{

    private SendGrid $sendGrid;

    public function __construct(private string $apiKey, private string $from)
    {
        $this->sendGrid = new SendGrid($this->apiKey);
    }

    public function sendEmail(string $to, string $templateId ,array $payload): void
    {
    $email = new Mail();
    $email->setFrom($this->from);
    $email->addTo($to);
    $email->setTemplateId($templateId);
    $email->addDynamicTemplateData("subject1", $payload['subject1']);
    $email->addDynamicTemplateData("meno", $payload['meno']);

    try{
        $response = $this->sendGrid->send($email);
        print $response->statusCode() . "\n";
        print $response->body() . "\n";
    }catch (Exception $e){
       throw new BadRequestException('MailSender error');
    }
    }
}