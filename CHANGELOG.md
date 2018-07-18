# Release Notes for Query

## 2.0.3 - 2018-07-18

### Changed
- The utility now show the total number of query results. ([#5](https://github.com/craftcms/query/issues/5))

## 2.0.2 - 2017-12-04

### Changed
- Loosened the Craft CMS version requirement to allow any 3.x version.

## 2.0.1 - 2017-05-15

### Changed
- Improved the styling of the SQL results.
- Added support for a Command/Ctrl + Return keyboard shortcut.
- Compressed the JavaScript.

### Fixed
- Fixed the changelog and download URLs.

## 2.0.0 - 2017-05-10

### Changed
- Craft 3 compatibility.
- Query will now gracefully handle SQL errors and display them to the user instead of exploding.

### Fixed
- Fixed a PHP error that occurred when submitting a query if the `enableCsrfProtection` config setting was enabled.

## 0.1.0 - 2013-09-21

Initial release.
