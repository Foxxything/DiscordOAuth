<?php

namespace Foxxything\TheDen\Auth;

use Foxxything\DiscordOAuth\Enums\Scopes;
use Foxxything\DiscordOAuth\Models\User;
use Foxxything\DiscordOAuth\Utility\Http;

/**
 * Discord OAuth2 Library.
 *
 * @package Foxxything\TheDen\Auth
 * @since 1.0.0
 */
class DiscordOAuth
{

    /**
     * The Discord API base URL.
     */
    const API_BASE_URL = 'https://discordapp.com/api';

    /**
     * The Discord OAuth2 authorize URL.
     */
    const OAUTH_AUTHORIZE_URL = 'https://discordapp.com/api/oauth2/authorize';

    /**
     * The Discord OAuth2 token URL.
     */
    const OAUTH_TOKEN_URL = 'https://discordapp.com/api/oauth2/token';

    /**
     * The Discord OAuth2 client ID.
     * 
     * @var string
     */
    private $clientId;

    /**
     * The Discord OAuth2 client secret.
     * 
     * @var string
     */
    private $clientSecret;

    /**
     * The Discord OAuth2 redirect URI.
     * 
     * @var string
     */
    private $redirectUri;

    /**
     * The Discord OAuth2 scopes.
     * 
     * @var Scope[]
     */
    private $scopes;

    /**
     * The Discord OAuth2 state.
     * 
     * @var string
     */
    private $state;

    /**
     * The Discord OAuth2 access token.
     * 
     * @var string
     */
    private $accessToken;

    /**
     * The Discord OAuth2 refresh token.
     * 
     * @var string
     */
    private $refreshToken;

    /**
     * DiscordOAuth constructor.
     *
     * @param string $clientId
     * @param string $clientSecret
     * @param string $redirectUri
     * @param array $scopes
     */
    public function __construct(
        string $clientId,
        string $clientSecret,
        string $redirectUri,
        array $scopes = [
            Scopes::IDENTIFY,
            Scopes::EMAIL
        ]
    ) {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->redirectUri = $redirectUri;

        foreach ($scopes as $scope) {
            if ($scope instanceof Scopes) {
                $this->scopes[] = $scope;
            } else {
                try {
                    $this->scopes[] = Scopes::from($scope);
                } catch (\Exception $e) {
                    throw new \InvalidArgumentException('Invalid scope: ' . $scope);
                }
            }
        }

        $this->state = bin2hex(random_bytes(16));
    }

    /**
     * Get the OAuth2 authorize URL.
     *
     * @return string
     */
    public function getAuthorizeUrl(): string
    {
        $params = array(
            'client_id' => $this->clientId,
            'redirect_uri' => $this->redirectUri,
            'response_type' => 'code',
            'scope' => implode(' ', $this->scopes),
            'state' => $this->state
        );
        return self::OAUTH_AUTHORIZE_URL . '?' . http_build_query($params);
    }

    /**
     * Exchange the authorization code for an access token.
     *
     * @param string $code
     * @return bool
     */
    public function exchangeCodeForAccessToken(string $code): bool
    {
        $params = array(
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => $this->redirectUri,
        );
        $response = Http::post(self::OAUTH_TOKEN_URL, $params);
        $response = json_decode($response, true);
        if (!empty($response['access_token'])) {
            $this->accessToken = $response['access_token'];
            $this->refreshToken = $response['refresh_token'];
            return true;
        } else {
            return false;
        }
    }

    /**
     * Refresh the access token.
     *
     * @return bool
     */
    public function refreshAccessToken(): bool
    {
        $params = array(
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'grant_type' => 'refresh_token',
            'refresh_token' => $this->refreshToken,
            'redirect_uri' => $this->redirectUri,
        );
        $response = Http::post(self::OAUTH_TOKEN_URL, $params);
        $response = json_decode($response, true);
        if (!empty($response['access_token'])) {
            $this->accessToken = $response['access_token'];
            $this->refreshToken = $response['refresh_token'];
            return true;
        }
        return false;
    }

    /**
     * Get the current access token.
     *
     * @return string|null
     */
    public function getAccessToken(): ?string
    {
        return $this->accessToken;
    }

    /**
     * Get the current refresh token.
     *
     * @return string|null
     */
    public function getRefreshToken(): ?string
    {
        return $this->refreshToken;
    }

    /**
     * Get the user information.
     *
     * @return array|null The user information, or null if the request fails.
     */
    public function getUser(): ?User
    {
        if (!$this->accessToken) {
            return null;
        }

        $response = Http::get(self::API_BASE_URL . '/users/@me', array(
            'Authorization' => 'Bearer ' . $this->accessToken
        ));

        $response = json_decode($response, true);

        if (empty($response['id'])) {
            return null;
        }

        return User::createFromApiResponse($response);

        
    }
}
