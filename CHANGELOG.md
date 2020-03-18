# Changelog

All Notable changes to `froala/nova-froala-field` will be documented in this file.

Updates should follow the [Keep a CHANGELOG](http://keepachangelog.com/) principles.

## 3.3.0 - 2020-03-18

- Updated Froala version to 3.1.1
- Fixed Tui Image Editor plugin import

## 3.2.3 - 2020-02-17

- Fixed files storing consider to new `withFiles($disk, $path)` method signature and `StorableContract`

## 3.2.2 - 2019-12-12

- Removed unnecessary JS bundle size

## 3.2.1 - 2019-11-16

- Updated `Froala::withFiles` method signature according to latest Nova update

## 3.2.0 - 2019-09-07

- Laravel 6.0 support

## 3.1.0 - 2019-07-26

- Nova 2.1 compatibility
- Froala updated to 3.0.5 version

## 3.0.1 - 2019-07-04

- Fixed plugins usage detection

## 3.0.0 - 2019-07-03

- Upgraded Froala to **3.0.1** version!
- Fixed an error when no toolbarButtons provided
- Font Awesome 5 support
- TUI Advanced Image Editor support

## 2.2.1 - 2019-06-10

- Fixed dynamic import of 3rd party plugins
- Downgraded laravel-mix to `^1.0` for providing better support with Laravel Nova

## 2.2.0 - 2019-05-22

- Fixed issue with image manager caused by latest Nova update
- Updated node dependencies and retranspiled assets
- Froala version updated to 2.9.5

## 2.1.0 - 2019-04-25

Ability to use Nova local installation

## 2.0.0 - 2019-03-11

- add support for Laravel 5.8 and Nova 2.0
- _Froala_ version update

## 1.1.4 - 2019-02-01

Added missing return when custom fill callback called

## 1.1.3 - 2019-01-31

Improved creating attachments on resource creation,
according to _Trix_ fix in **Nova v1.1.5**. Now you can use the `trix` driver without any issues.

## 1.1.2 - 2019-01-12

- Updated Froala version to 2.9.1
- Improved get images list
- Readme updated

## 1.1.1 - 2018-12-04

- Prevented jump to global search on pressing "/"

## 1.1.0 - 2018-11-02

- Updated to latest **froala-editor@2.9.0** version.

## 1.0.1 - 2018-10-19

- Added minimum required dependencies versions
