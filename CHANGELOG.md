# Changelog

https://github.com/conedevelopment/simplepay-gateway/releases

## v2.5.1
- Fixed trailing comma ([#86](https://github.com/conedevelopment/simplepay-gateway/issues/86))

## v2.5.0 (2021-10-10)

- Changed namespace from `Pine\SimplePay` to `Cone\SimplePay`
- Changed translation keys from `pine-simplepay` to `cone-simplepay`
- Added two step payment support

## v2.4.14 (2021-05-26)

- Fixed order status after cancelling payment ([#71](https://github.com/conedevelopment/simplepay-gateway/issues/71))

## v2.4.13 (2021-05-05)

- Fixed item mapping if total is `0` ([#68](https://github.com/conedevelopment/simplepay-gateway/pull/68))

## v2.4.12 (2021-03-30)

- Added `WC_Order_Item_Fee` handling on checkout

## v2.4.11 (2021-03-26)

- Changed order prefix handling, now it's more flexible

## v2.4.10 (2021-03-04)

- Changed the usage of `wc_get_checkout_url()` to the `$order->get_checkout_payment_url()` method

## v2.4.9 (2021-02-08)

- Added explicit logging on errors
- Fixed bad locale determination

## v2.4.8 (2021-02-02)

- Fixed products with `0` prices by filtering in the `PaymentPayload` ([#57](https://github.com/conedevelopment/simplepay-gateway/issues/57))

## v2.4.7 (2021-01-17)

- Fixed `$_GET['section']` parameter handling ([#55](https://github.com/conedevelopment/simplepay-gateway/pull/55))

## v2.4.6 (2020-11-20)

- Handle invoiceless transactions when only billing email and name are given ([#44](https://github.com/conedevelopment/simplepay-gateway/issues/44))

## v2.4.5 (2020-10-28)

- Updated icons ([#43](https://github.com/conedevelopment/simplepay-gateway/pull/43))

## v2.4.4 (2020-09-17)

- Added icon link on checkout

## v2.4.3 (2020-09-16)

- Move repo to `conedevelopment`

## v2.4.2 (2020-08-17)

- Fixed missing property

## v2.4.1 (2020-08-10)

- Ability to show icon on the checkout page

## v2.4.0 (2020-08-04)

- Multisite compatibility ([#39](https://github.com/conedevelopment/simplepay-gateway/issues/39))
- Code cleanup, refactoring

## v2.3.7 (2020-07-27)

- Docblocks and param types ([#38](https://github.com/conedevelopment/simplepay-gateway/pull/38))

## v2.3.6 (2020-06-25)

- Force trailing slash in IPN url

## v2.3.5 (2020-06-22)

- Use `home_url` instead of `size_url` ([#35](https://github.com/conedevelopment/simplepay-gateway/pull/35))

## v2.3.4 (2020-06-17)

- Backward compatibility for custom orderRefs
- Payment reference URL based on locale

## v2.3.3 (2020-06-16)

- Fixed order references when using capital prefix ([#33](https://github.com/conedevelopment/simplepay-gateway/issues/33))

## v2.3.2 (2020-06-16)

- Added customizable reference prefixes ([#33](https://github.com/conedevelopment/simplepay-gateway/issues/33))
- Using order ID as transaction reference ([#33](https://github.com/conedevelopment/simplepay-gateway/issues/33))

## v2.3.1 (2020-06-04)

- Added missing translations ([#31](https://github.com/conedevelopment/simplepay-gateway/issues/31))

## v2.3.0 (2020-06-04)

- Exception based error handling ([#30](https://github.com/conedevelopment/simplepay-gateway/issues/30))
- Refactored requests

## v2.2.4 (2020-05-27)

- Round quantities using `ceil` (SimplePay does not handle decimal quantities) ([#26](https://github.com/conedevelopment/simplepay-gateway/issues/26))

## v2.2.3 (2020-05-26)

- JS hide/show mechanism on admin
- Return `null` instead of `array` when order does not need shipping address ([#25](https://github.com/conedevelopment/simplepay-gateway/issues/25))

## v2.2.2 (2020-05-21)

- Added custom error messages when IPN/IRN should fail
- Added red labels for sanbox inputs
- Determine if `$order` is instnace of `WC_Order`

## v2.2.1 (2020-05-18)

- Put currency based options before hashing

## v2.2.0 (2020-05-18)

- Do not handle IPN/IRN if order does not exist
- Update Docblocks ([#22](https://github.com/conedevelopment/simplepay-gateway/pull/22))
- Check for undefined property in updater ([#21](https://github.com/conedevelopment/simplepay-gateway/pull/21))

## v2.1.1 (2020-02-20)

- Added `composer.json`

## v2.1.0 (2020-01-25)

- Added Hungarian readme
- Added Refactored config

## v2.0.4 (2020-01-24)

- Fixed typo in translations

## v2.0.3 (2020-01-24)

- Added pending status

## v2.0.2 (2020-01-24)

- Fixed transaction status when failed
- Fixed translations

## v2.0.1 (2020-01-24)

- Added transaction statuses based on response

## v2.0.0 (2020-01-16)

- Migrate to SimplePay API v2
- Refactorings

## v1.3.1 (2020-01-15)

- Fixed boot if there is no WooCommerce
- Fixed spacing

## v1.3.0 (2019-09-11)

- SimplePay transaction ID to order info
- Order handling on failed or cancelled transactions

## v1.2.8 (2019-07-31)

- Early log file path call
- Accessing non-existing array keys

## v1.2.7 (2019-07-19)

- Set order status to failed when payment failed

## v1.2.6 (2019-07-18)

- Added new translations
- Separate fields for test credentials
- Show error message when payment failed

## v1.2.5 (2019-07-17)

- Redirect back to checkout page on failed payment

## v1.2.4 (2019-07-14)

- Add banners

## v1.2.3 (2019-07-14)

- Updater structure and logic

## v1.2.2 (2019-07-13)

- Revert to `stdClass`

## v1.2.1 (2019-07-13)

- Option fields

## v1.2.0 (2019-07-12)

- Refactored Updater

## v1.1.5 (2019-07-11)

- Fixed `glob()` pattern

## v1.1.4 (2019-07-11)

- Fixed updater hooks

## v1.1.3 (2019-07-11)

- Force correct directory name

## v1.1.2 (2019-07-11)

- Directory naming

## v1.1.1 (2019-07-11)

- Fixed variable names

## v1.1.0 (2019-07-11)

- Added custom GitHub updater

## v1.0.2 (2019-07-11)

- Replace `self` to `static`

## v1.0.1 (2019-04-04)

- Flatten code, remove some functions

## v1.0.0 (2019-04-01)
Initial release
