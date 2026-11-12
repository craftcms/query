<?php

declare(strict_types=1);

namespace CraftCms\Query\Http\Controllers;

use CraftCms\Cms\Translation\Formatter;
use CraftCms\Cms\Utility\Utilities;
use CraftCms\Query\Utilities\Query;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

/**
 * Executes the SQL submitted from the Query utility, and flashes the result back to it.
 *
 * @since 4.0
 */
class ExecuteQueryController
{
    public function __construct(Utilities $utilities)
    {
        if (! $utilities->checkAuthorization(Query::class)) {
            abort(403, 'User is not authorized to perform this action.');
        }
    }

    public function __invoke(Request $request, Formatter $formatter): RedirectResponse
    {
        $sql = $request->validate(['sql' => ['present', 'nullable', 'string']])['sql'];

        try {
            // Use the write connection, so statements other than SELECT work with read replicas too
            $result = $sql !== null ? DB::select($sql, useReadPdo: false) : [];

            Inertia::flash('query', [
                'success' => true,
                'result' => $result,
                'formattedTotal' => $formatter->asInteger(count($result)),
            ]);
        } catch (QueryException $e) {
            Inertia::flash('query', [
                'success' => false,
                'error' => $e->getPrevious()?->getMessage() ?? $e->getMessage(),
            ]);
        }

        return back();
    }
}
