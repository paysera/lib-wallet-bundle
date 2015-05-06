# Paysera Wallet API bundle

## Installing

```
composer require paysera/lib-wallet-bundle
```

In `AppKernel.php`:

```
$bundles = array(
    // other bundles
    new Paysera\Bundle\WalletBundle\PayseraWalletBundle(),
);
```

## Configuring

In `config.yml`:

If using shared secret:

```
paysera_wallet:
    client_id: %wallet_api_client_id%
    secret: %wallet_api_secret%
```

If using certificate credentials:

```
paysera_wallet:
    client_id: %wallet_api_client_id%
    certificate:
      private_key_path: %kernel.root_dir%/config/keys/wallet.key
      private_key_password: %wallet_api_private_key_password%
      certificate_path: %kernel.root_dir%/config/keys/wallet.crt
```

## Using

```
$walletApi = $container->get('paysera_wallet_api');
$walletClient = $walletApi->walletClient();

$response = $walletClient->get('client');
```
