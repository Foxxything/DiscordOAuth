<?php

namespace Foxxything\DiscordOAuth\Models;

use Foxxything\DiscordOAuth\Utility\LinkGenerator;


final class User
{
    private function __construct(
        private string $id,
        private string $username,
        private string $discriminator,
        private ?string $avatar,
        private bool $bot,
        private bool $system,
        private ?bool $mfaEnabled,
        private ?string $banner,
        private ?int $accentColor,
        private ?string $locale,
        private ?bool $verified,
        private ?string $email,
        private ?int $flags,
        private ?int $premiumType,
        private ?int $publicFlags
    ) {
        $this->id = $id;
        $this->username = $username;
        $this->discriminator = $discriminator;
        $this->avatar = $avatar;
        $this->bot = $bot;
        $this->system = $system;
        $this->mfaEnabled = $mfaEnabled;
        $this->banner = $banner;
        $this->accentColor = $accentColor;
        $this->locale = $locale;
        $this->verified = $verified;
        $this->email = $email;
        $this->flags = $flags;
        $this->premiumType = $premiumType;
        $this->publicFlags = $publicFlags;
    }

    public static function createFromApiResponse(array $data): self
    {
        return new self(
            $data['id'],
            $data['username'],
            $data['discriminator'],
            $data['avatar'] ?? null,
            $data['bot'] ?? false,
            $data['system'] ?? false,
            $data['mfaEnabled'] ?? null,
            $data['banner'] ?? null,
            $data['accentColor'] ?? null,
            $data['locale'] ?? null,
            $data['verified'] ?? null,
            $data['email'] ?? null,
            $data['flags'] ?? null,
            $data['premiumType'] ?? null,
            $data['publicFlags'] ?? null
        );
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getDiscriminator(): string
    {
        return $this->discriminator;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function isBot(): bool
    {
        return $this->bot;
    }

    public function isSystem(): bool
    {
        return $this->system;
    }

    public function isMfaEnabled(): ?bool
    {
        return $this->mfaEnabled;
    }

    public function getBanner(): ?string
    {
        return $this->banner;
    }

    public function getAccentColor(): ?int
    {
        return $this->accentColor;
    }

    public function getLocale(): ?string
    {
        return $this->locale;
    }

    public function isVerified(): ?bool
    {
        return $this->verified;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getFlags(): ?int
    {
        return $this->flags;
    }

    public function getPremiumType(): ?int
    {
        return $this->premiumType;
    }

    public function getPublicFlags(): ?int
    {
        return $this->publicFlags;
    }

    private function isAvatarAnimated(): bool
    {
        if ($this->avatar === null) {
            return false;
        }

        return substr($this->avatar, 0, 2) === "a_";
    }


    public function getAvatarUrl(int $size = LinkGenerator::DEFAULT_AVATAR_SIZE): string
    {
        if ($this->avatar === null) {
            return LinkGenerator::defaultAvatarLink($this->discriminator, $size);
        }

        return LinkGenerator::avatarLink($this->id, $this->avatar, $this->isAvatarAnimated(), $size);
    }
}
