<?php

namespace Paysera\Bundle\WalletBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class PayseraWalletExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        if ($config['secret'] !== null && isset($config['certificate'])) {
            throw new \RuntimeException('Only one of secret or certificate be configured');
        }
        if ($config['secret'] === null && !isset($config['certificate'])) {
            throw new \RuntimeException('One of secret or certificate must be configured');
        }

        $container->setParameter('paysera_wallet.client_id', $config['client_id']);

        $walletApi = $container->getDefinition('paysera_wallet_api');
        if ($config['secret'] !== null) {
            $walletApi->replaceArgument(1, $config['secret']);
        } else {
            $certificate = new Definition('Paysera_WalletApi_Http_ClientCertificate');
            $certificate->addMethodCall('setPrivateKeyPath', array($config['certificate']['private_key_path']));
            $certificate->addMethodCall('setPrivateKeyPassword', array($config['certificate']['private_key_password']));
            $certificate->addMethodCall('setPrivateKeyType', array($config['certificate']['private_key_type']));
            $certificate->addMethodCall('setCertificatePath', array($config['certificate']['certificate_path']));
            $certificate->addMethodCall('setCertificatePassword', array($config['certificate']['certificate_password']));
            $certificate->addMethodCall('setCertificateType', array($config['certificate']['certificate_type']));
            $walletApi->replaceArgument(1, $certificate);
        }
    }
}
