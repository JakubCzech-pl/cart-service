<?php

declare(strict_types=1);

namespace App\Messenger;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

class MessageSerializer
{
    public function __construct(private SerializerInterface $serializer) {}

    public function deserialize(string $json, string $type): MessageInterface
    {
        return $this->serializer->deserialize($json, $type, JsonEncoder::FORMAT);
    }

    public function serialize(MessageInterface $message): string
    {
        return $this->serializer->serialize($message, JsonEncoder::FORMAT);
    }
}
