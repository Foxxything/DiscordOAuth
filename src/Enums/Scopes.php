<?php

namespace Foxxything\DiscordOAuth\Enums;

enum Scopes: string
{
  case BOT = "bot";
  case CONNECTIONS = "connections";
  case EMAIL = "email";
  case IDENTIFY = "identify";
  case GUILDS = "guilds";
  case GUILDS_JOIN = "guilds.join";
  case GDM_JOIN = "gdm.join";
  case MESSAGES_READ = "messages.read";
  case RPC = "rpc";
  case RPC_API = "rpc.api";
  case RPC_NOTIFICATIONS_READ = "rpc.notifications.read";
  case WEBHOOK_INCOMING = "webhook.incoming";

  public function __toString(): string
  {
    return $this->value;
  }

  public function __debugInfo(): array
  {
    return [
      "value" => $this->value,
      "name" => $this->name,
    ];
  }
}
