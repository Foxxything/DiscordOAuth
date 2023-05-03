<?php

namespace Foxxything\DiscordOAuth\Enums;


/**
 * User flags
 * 
 * @see https://discord.com/developers/docs/resources/user#user-object-user-flags
 */
enum UserFlags: int
{
  case STAFF = 1 << 0;
  case PARTNER = 1 << 1;
  case HYPESQUAD = 1 << 2;
  case BUG_HUNTER_LEVEL_1 = 1 << 3;
  case HYPESQUAD_ONLINE_HOUSE_1 = 1 << 6;
  case HYPESQUAD_ONLINE_HOUSE_2 = 1 << 7;
  case HYPESQUAD_ONLINE_HOUSE_3 = 1 << 8;
  case PREMIUM_EARLY_SUPPORTER = 1 << 9;
  case TEAM_PSEUDO_USER = 1 << 10;
  case BUG_HUNTER_LEVEL_2 = 1 << 14;
  case VERIFIED_BOT = 1 << 16;
  case VERIFIED_DEVELOPER = 1 << 17;
  case CERTIFIED_MODERATOR = 1 << 18;
  case BOT_HTTP_INTERACTIONS = 1 << 19;
  case ACTIVE_DEVELOPER = 1 << 22;

  const VALUES = [
    self::STAFF => 'Discord Employee',
    self::PARTNER => 'Partnered Server Owner',
    self::HYPESQUAD => 'HypeSquad Events Member',
    self::BUG_HUNTER_LEVEL_1 => 'Bug Hunter Level 1',
    self::HYPESQUAD_ONLINE_HOUSE_1 => 'House Bravery Member',
    self::HYPESQUAD_ONLINE_HOUSE_2 => 'House Brilliance Member',
    self::HYPESQUAD_ONLINE_HOUSE_3 => 'House Balance Member',
    self::PREMIUM_EARLY_SUPPORTER => 'Early Nitro Supporter',
    self::TEAM_PSEUDO_USER => 'User is a team',
    self::BUG_HUNTER_LEVEL_2 => 'Bug Hunter Level 2',
    self::VERIFIED_BOT => 'Verified Bot',
    self::VERIFIED_DEVELOPER => 'Early Verified Bot Developer',
    self::CERTIFIED_MODERATOR => 'Moderator Programs Alumni',
    self::BOT_HTTP_INTERACTIONS => 'Bot uses only HTTP interactions and is shown in the online member list',
    self::ACTIVE_DEVELOPER => 'User is an Active Developer'
  ];

  public static function getFlags(int $flags): array
  {
    $results = [];

    foreach (self::cases() as $case) {
      if ($flags & $case->value) {
        $results[] = $case;
      }
    }

    return $results;
  }

  public static function getValues(int $flags): array
  {
    $values = [];

    foreach (self::VALUES as $flag => $description) {
      if ($flags & $flag) {
        $values[] = $description;
      }
    }

    return $values;
  }
}
