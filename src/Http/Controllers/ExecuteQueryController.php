<?php

declare(strict_types=1);

namespace CraftCms\Query\Http\Controllers;

use CraftCms\Cms\Translation\Formatter;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Executes the SQL submitted from the Query utility.
 *
 * @since 2.0
 */
class ExecuteQueryController
{
    public function __invoke(Request $request, Formatter $formatter): JsonResponse
    {
        $sql = $request->validate(['sql' => ['present', 'nullable', 'string']])['sql'];

        try {
            // Use the write connection, so statements other than SELECT work with read replicas too
            $result = $sql !== null ? DB::select($sql, useReadPdo: false) : [];
        } catch (QueryException $e) {
            return new JsonResponse([
                'success' => false,
                'error' => $e->getPrevious()?->getMessage() ?? $e->getMessage(),
            ]);
        }

        return new JsonResponse([
            'success' => true,
            'result' => $result,
            'formattedTotal' => $formatter->asInteger(count($result)),
        ]);
    }
}
