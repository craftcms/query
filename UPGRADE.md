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

The `query/default/execute` action URL was removed. The utility now posts to a control panel route, `POST {cpTrigger}/utilities/query`, through Inertia. The route requires a logged-in user with the “Query” utility permission (`utility:query`), and flashes the result back to the utility as Inertia flash data under `query`. The data has the same shape as before: `{"success": true, "result": [...], "formattedTotal": "..."}`, or `{"success": false, "error": "..."}`.

If you called the action URL from your own scripts, run the query from your own code with Laravel’s `DB` facade instead.

Database errors no longer include Yii’s “The SQL being executed was” suffix.

### Templates and Twig

The `query/_index` template was removed.

## Need help?

Report issues at https://github.com/craftcms/query/issues.
