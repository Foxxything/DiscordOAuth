<?php

namespace Foxxything\DiscordOAuth\Utility;

final class LinkGenerator
{
  const SMALL_AVATAR_SIZE = 128;
  const MEDIUM_AVATAR_SIZE = 256;
  const LARGE_AVATAR_SIZE = 512;
  const DEFAULT_AVATAR_SIZE = self::SMALL_AVATAR_SIZE;

  const SMALL_BANNER_SIZE = 512;
  const MEDIUM_BANNER_SIZE = 1024;
  const LARGE_BANNER_SIZE = 2048;
  const DEFAULT_BANNER_SIZE = self::SMALL_BANNER_SIZE;

  public static function avatarLink(string $id, string $avatarHash, bool $animated, int $size = self::DEFAULT_AVATAR_SIZE): string
  {
    $extension = $animated ? "gif" : "png";
    return "https://cdn.discordapp.com/avatars/$id/$avatarHash.$extension?size=$size";
  }

  public static function defaultAvatarLink(int $discriminator, int $size = self::DEFAULT_AVATAR_SIZE): string
  {
    $number = $discriminator % 5;
    return "https://cdn.discordapp.com/embed/avatars/$number.png?size=$size";
  }

  public static function bannerLink(string $id, string $bannerHash, int $size = self::DEFAULT_BANNER_SIZE): string
  {
    return "https://cdn.discordapp.com/banners/$id/$bannerHash.png?size=$size";
  }
}
