<?php

namespace App\Service;

use Symfony\Component\Notifier\Bridge\Telegram\TelegramOptions;
use Symfony\Component\Notifier\ChatterInterface;
use Symfony\Component\Notifier\Message\ChatMessage;
use Symfony\Component\Notifier\Bridge\Telegram\Reply\Markup\Button\InlineKeyboardButton;
use Symfony\Component\Notifier\Bridge\Telegram\Reply\Markup\InlineKeyboardMarkup;

class TelegramSender
{
    public function __construct(
        private ChatterInterface $chatter
    )
    {}

    public function sendMessage(string $chatId, string $chatMessage)
    {
        $message = new ChatMessage($chatMessage);
        $telegramOptions = (new TelegramOptions())
            ->chatId($chatId)
            ->replyMarkup((new InlineKeyboardMarkup())
                ->inlineKeyboard([
                    (new InlineKeyboardButton('Nový support ticket'))
                        ->url('https://google.com/'),
                ])
            );
        $message->options($telegramOptions);
        $this->chatter->send($message);
    }
}