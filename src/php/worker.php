<?php

require "bootstrap.php";
require "handler.php";

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Wire\AMQPTable;

function send(array $arguments) {
    try {
        $connection = new AMQPStreamConnection('rabbitmq', 5672, 'guest', 'guest');
        $channel = $connection->channel();

        $channel->queue_declare(
            'kma.queue.delayed',
            false,
            false,
            false,
            false,
            false,
            new AMQPTable([
                'x-dead-letter-exchange' => '',
                'x-dead-letter-routing-key' => 'kma.queue',
                'x-message-ttl' => 2000,
            ])
        );

        $message = new AMQPMessage(json_encode($arguments));
        $channel->basic_publish($message, '', 'kma.queue.delayed');

        $channel->close();
        $connection->close();
    } catch (Exception $exception) {
        die($exception->getMessage());
    }
}

function resend(array $arguments) {
    try {
        $connection = new AMQPStreamConnection('rabbitmq', 5672, 'guest', 'guest');
        $channel = $connection->channel();

        $channel->queue_declare(
            'kma.queue.delayed.retry',
            false,
            false,
            false,
            false,
            false,
            new AMQPTable([
                'x-dead-letter-exchange' => '',
                'x-dead-letter-routing-key' => 'kma.queue',
                'x-message-ttl' => 1000,
            ])
        );

        $message = new AMQPMessage(json_encode($arguments));
        $channel->basic_publish($message, '', 'kma.queue.delayed');

        $channel->close();
        $connection->close();
    } catch (Exception $exception) {
        die($exception->getMessage());
    }
}

function receive() {
    try {

        $handler = function ($message) {
            handle($message);
        };

        $connection = new AMQPStreamConnection('rabbitmq', 5672, 'guest', 'guest');
        $channel = $connection->channel();

        $channel->queue_declare(
            'kma.queue',
            false,
            true,
            false,
            false,
            false
        );

        $channel->basic_consume(
            'kma.queue',
            '',
            false,
            false,
            false,
            false,
            $handler
        );

        while ($channel->is_open()) {
            $channel->wait();
        }

        $channel->close();
        $connection->close();
    } catch (Exception $exception) {
        die($exception->getMessage());
    }
}
