# Upgrading to Query 4.0 (Craft 6)

Query 4.0 is a native Craft 6 plugin. This guide lists what changed from 3.x and what to update in your project.

## Requirements

- Craft CMS 6.0 or later
- PHP 8.5 or later
- The `craftcms/yii2-adapter` package is not needed.

## Upgrade steps

1. Upgrade your project to Craft 6 first.
2. Update the plugin: `composer require craftcms/query:^4.0`.

The plugin has no settings or database tables, so there’s nothing to migrate.

## Breaking changes

### Classes and namespaces

| Before | After |
| --- | --- |
| `craft\query\Plugin` | `CraftCms\Query\Plugin` |
| `craft\query\Utility` | `CraftCms\Query\Utilities\Query` |
| `craft\query\controllers\DefaultController` | `CraftCms\Query\Http\Controllers\ExecuteQueryController` |
| `craft\query\QueryAsset` | Removed. The utility is a Vue component registered from `resources/js/cp.js`. |

### SQL syntax

Queries run through Laravel’s database connection, so Yii’s quoting syntax isn’t expanded any more. Write table and column names as they are in the database, including the table prefix if your project has one (`DB_PREFIX`).

```sql
-- Before
select [[username]] from {{%users}}

-- After
select username from users
```

### Routes and action URLs

The `query/default/execute` action URL keeps working, and still takes an `sql` body param. It requires a logged-in user with the “Query” utility permission (`utility:query`).

- JSON requests from guests get a `401` response instead of a `403`.
- A request without the `sql` param gets a `422` validation error instead of a `400`.
- Database errors still come back as `{"success": false, "error": "..."}`. The message is the database driver’s error, without Yii’s “The SQL being executed was” suffix.

### Templates and Twig

The `query/_index` template was removed.

## Need help?

Report issues at https://github.com/craftcms/query/issues.
