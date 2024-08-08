<?php

declare(strict_types=1);

namespace App\Messenger;

use Symfony\Component\Serializer\SerializerInterface;

class MessageSerializer
{
    public function __construct(private SerializerInterface $serializer) {}

    public function deserialize(string $json, string $type): MessageInterface
    {
        return $this->serializer->deserialize($json, $type, 'json');
    }

    public function serialize(MessageInterface $message): string
    {
        return $this->serializer->serialize($message, 'json');
    }
}
