<?php
    $basic  = new \Vonage\Client\Credentials\Basic("d56cc77c", "N5c9Iz5BNc6kZapD");
    $client = new \Vonage\Client($basic);

    $response = $client->sms()->send(
        new \Vonage\SMS\Message\SMS("19782100999", BRAND_NAME, 'Oi, estamos testando as coisas por aqui')
    );
    $message = $response->current();
    if ($message->getStatus() == 0) {
        echo "The message was sent successfully\n";
    } else {
        echo "The message failed with status: " . $message->getStatus() . "\n";
    }