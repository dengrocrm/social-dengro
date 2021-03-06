<?php

namespace dengro\social\dengro\loginproviders;

use Craft;
use dukt\social\base\LoginProvider;

/**
 * Dengro represents the DenGro gateway
 *
 * @author    Dukt <support@dukt.net>
 * @since     1.0
 */
class Dengro extends LoginProvider
{
    /**
     * Get base URL for the ID server (allows for testing etc)
     */
    protected function getBaseUrl()
    {
        return Craft::$app->config->general->socialDengroBaseUrl;
    }
    
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return 'DenGro';
    }

    /**
     * @inheritdoc
     */
    public function getIconUrl()
    {
        return Craft::$app->assetManager->getPublishedUrl('@dengro/social/dengro/icon.svg', true);
    }

    /**
     * @inheritdoc
     */
    public function getManagerUrl()
    {
        return 'https://www.dengro.com/developer';
    }

    /**
     * @inheritdoc
     */
    public function getScopeDocsUrl()
    {
        return $this->getBaseUrl().'/oauth/scopes';
    }

    /**
     * @inheritDoc
     */
    public function getOauthProvider(): \Dengro\OAuth2\Client\Provider\Dengro
    {
        $config = $this->getOauthProviderConfig();
    
        if ($this->getBaseUrl()) {
            $config['options']['baseUrl'] = $this->getBaseUrl();
        }
        
        return new \Dengro\OAuth2\Client\Provider\Dengro($config['options']);
    }

    /**
     * @inheritDoc
     */
    public function getDefaultOauthScope(): array
    {
        return [
            'user-read'
        ];
    }

    /**
     * @inheritdoc
     */
    public function getDefaultUserFieldMapping(): array
    {
        return [
            'id' => '{{ profile.getId() }}',
            'username' => '{{ profile.getEmail() }}',
            'email' => '{{ profile.getEmail() }}',
        ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getDefaultProfileFields(): array
    {
        return [
            'id',
            'name',
            'email',
        ];
    }
}
