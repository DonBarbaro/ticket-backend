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

    public function sendEmail(string $to, string $templateId, array $payload): void
    {
        $email = new Mail();
        $email->setFrom($this->from);
        $email->addTo($to);
        $email->setTemplateId($templateId);
        $email->addDynamicTemplateDatas($payload);

        $response = $this->sendGrid->send($email);
        if ($response->statusCode() >= 200 || $response->statusCode() < 300) {
            throw new BadRequestException('MailSender error');
        }
    }
}