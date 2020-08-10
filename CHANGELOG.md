# Changelog

## v2.4.1 (2020-08-10)
### Added
- Ability to show icon on the checkout page

## v2.4.0 (2020-08-04)
### Added
- Multisite compatibility ([#39](https://github.com/thepinecode/simplepay-gateway/issues/39))

### Changed
- Code cleanup, refactoring

## v2.3.7 (2020-07-27)
### Fixed
- Docblocks and param types ([#38](https://github.com/thepinecode/simplepay-gateway/pull/38))

## v2.3.6 (2020-06-25)
### Changed
- Force trailing slash in IPN url

## v2.3.5 (2020-06-22)
### Changed
- Use `home_url` instead of `size_url` ([#35](https://github.com/thepinecode/simplepay-gateway/pull/35))

## v2.3.4 (2020-06-17)
### Added
- Backward compatibility for custom orderRefs
### Fixed
- Payment reference URL based on locale

## v2.3.3 (2020-06-16)
### Fixed
- Fixed order references when using capital prefix ([#33](https://github.com/thepinecode/simplepay-gateway/issues/33))

## v2.3.2 (2020-06-16)
### Added
- Added customizable reference prefixes ([#33](https://github.com/thepinecode/simplepay-gateway/issues/33))
### Changed
- Using order ID as transaction reference ([#33](https://github.com/thepinecode/simplepay-gateway/issues/33))

## v2.3.1 (2020-06-04)
### Added
- Added missing translations ([#31](https://github.com/thepinecode/simplepay-gateway/issues/31))

## v2.3.0 (2020-06-04)
### Added
- Exception based error handling ([#30](https://github.com/thepinecode/simplepay-gateway/issues/30))

### Changed
- Refactored requests

## v2.2.4 (2020-05-27)
### Fixed
- Round quantities using `ceil` (SimplePay does not handle decimal quantities) ([#26](https://github.com/thepinecode/simplepay-gateway/issues/26))

## v2.2.3 (2020-05-26)
### Added
- JS hide/show mechanism on admin

### Fixed
- Return `null` instead of `array` when order does not need shipping address ([#25](https://github.com/thepinecode/simplepay-gateway/issues/25))

## v2.2.2 (2020-05-21)
### Added
- Added custom error messages when IPN/IRN should fail
- Added red labels for sanbox inputs

### Fixed
- Determine if `$order` is instnace of `WC_Order`

## v2.2.1 (2020-05-18)
### Fixed
- Put currency based options before hashing

## v2.2.0 (2020-05-18)
### Fixed
- Do not handle IPN/IRN if order does not exist
- Update Docblocks ([#22](https://github.com/thepinecode/simplepay-gateway/pull/22))
- Check for undefined property in updater ([#21](https://github.com/thepinecode/simplepay-gateway/pull/21))

## v2.1.1 (2020-02-20)
### Added
- composer.json

## v2.1.0 (2020-01-25)
### Added
- Hungarian readme
### Changed
- Refactored config

## v2.0.4 (2020-01-24)
### Fixed
- Typo in translations

## v2.0.3 (2020-01-24)
### Added
- Pending status

## v2.0.2 (2020-01-24)
### Fixed
- Fix transaction status when failed
- Fix translations

## v2.0.1 (2020-01-24)
### Added
- Transaction statuses based on response

## v2.0.0 (2020-01-16)
### Changed
- Migrate to SimplePay API v2
- Refactorings

## v1.3.1 (2020-01-15)
### Fixed
- Boot fix if there is no WooCommerce
- Spacing

## v1.3.0 (2019-09-11)
### Added
- SimplePay transaction ID to order info
### Fixed
- Order handling on failed or cancelled transactions

## v1.2.8 (2019-07-31)
### Fixed
- Early log file path call
- Accessing non-existing array keys

## v1.2.7 (2019-07-19)
### Added
- Set order status to failed when payment failed

## v1.2.6 (2019-07-18)
### Added
- Added new translations
- Separate fields for test credentials
- Show error message when payment failed

## v1.2.5 (2019-07-17)
### Fixed
- Redirect back to checkout page on failed payment

## v1.2.4 (2019-07-14)
### Added
- Add banners

## v1.2.3 (2019-07-14)
### Changed
- Updater structure and logic

## v1.2.2 (2019-07-13)
### Changed
- Revert to `stdClass`

## v1.2.1 (2019-07-13)
### Fixed
- Option fields

## v1.2.0 (2019-07-12)
### Changed
- Refactored Updater

## v1.1.5 (2019-07-11)
### Fixed
- Fixed `glob()` pattern

## v1.1.4 (2019-07-11)
### Fixed
- Fixed updater hooks

## v1.1.3 (2019-07-11)
### Added
- Force correct directory name

## v1.1.2 (2019-07-11)
### Fixed
- Directory naming

## v1.1.1 (2019-07-11)
### Fixed
- Fixed variable names

## v1.1.0 (2019-07-11)
### Added
- Added custom GitHub updater

## v1.0.2 (2019-07-11)
### Changed
- Replace `self` to `static`

## v1.0.1 (2019-04-04)
### Changed
- Flatten code, remove some functions

## v1.0.0 (2019-04-01)
Initial release
