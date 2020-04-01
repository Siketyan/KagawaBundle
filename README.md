<div align="center">
  <p>
    <img src=".github/resources/kagawa-colored.svg" width="128" height="128">
  </p>
  <h1>Kagawa Bundle</h1>
  <p>
    <img
      alt="Packagist Version"
      src="https://img.shields.io/packagist/v/siketyan/kagawa-bundle?style=for-the-badge"
    >
    <img
      alt="GitHub Workflow Status"
      src="https://img.shields.io/github/workflow/status/Siketyan/KagawaBundle/PHP Composer/master?style=for-the-badge"
    >
    <img
      alt="Licence"
      src="https://img.shields.io/github/license/Siketyan/KagawaBundle?style=for-the-badge"
    >
  </p>
  <p>🚫 Kagawa Prefecture restriction for Symfony.</p>
</div>

<br>

## 🚚 Prequisites
- PHP ^7.3
- Symfony ^4.4
- MaxMind GeoIP Database (\*.mmdb)

## 📦 Installation
1. Download GeoIP database from MaxMind.  
   https://dev.maxmind.com/geoip/

1. Download the package from Packagist.
   ```console
   $ composer require siketyan/kagawa-bundle
   ```

1. Enable the bundle in **config/bundles.php** .
   ```diff
   <?php

   return [
       // ...
   +   Siketyan\KagawaBundle\SiketyanKagawaBundle::class => ['all' => true],
   ];
   ```

1. Configure in **config/packages/siketyan_kagawa.yaml** .
   ```yaml
   siketyan_kagawa:
     geoip_db: '/path/to/geoip_db.mmdb'
     message: 'Hint message'
   ```

## 📷 Screenshot
![Screenshot](.github/resources/screenshot.png)
