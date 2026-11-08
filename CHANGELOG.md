# Release Notes for Query

## Unreleased

- Query now requires Craft CMS 6.0 or later and PHP 8.5 or later, and runs natively on Craft 6 without the `craftcms/yii2-adapter` package.
- The plugin’s classes moved to the `CraftCms\Query` namespace. See [UPGRADE.md](UPGRADE.md).
- The Query utility is now a Vue component, with a labeled SQL field.
- Yii’s `{{%table}}` and `[[column]]` quoting syntax is no longer expanded in queries.
- Fixed a bug where query results were rendered as HTML.
- Fixed a bug where the previous results stayed visible after a query returned no rows.

## 3.1.0.1 - 2026-07-23

- Fixed a typo in the changelog.

## 3.1.0 - 2024-03-19

- Added Craft 5 compatibility.
- Fixed a bug where the query results table could overflow the content pane. ([#30](https://github.com/craftcms/query/pull/30))

## 3.0.0 - 2022-05-03

### Added
- Added Craft 4 compatibility.

## 2.0.3 - 2018-07-18

### Changed
- The utility now shows the total number of query results. ([#5](https://github.com/craftcms/query/issues/5))

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
