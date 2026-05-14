<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

/**
 * Register a Laravel Gate for every Permission so controllers can
 * call `Gate::denies('user_create')` etc.
 *
 * The Role → Permission mapping is cached across requests; the cache is
 * invalidated whenever a Role or Permission is created / updated /
 * deleted (see App\Models\Role + App\Models\Permission booted() hooks).
 *
 * Refs:
 *   - audit-report.md → H-7 "AuthGates middleware is inefficient and runs
 *     on every request"
 */
class AuthGates
{
    /**
     * Cache key for the role/permission → permission-title map.
     *
     * Public + const so model observers can reference the same key when
     * invalidating after Role/Permission changes.
     */
    public const CACHE_KEY = 'auth_gates.permission_role_map';

    /**
     * Time-to-live for the permission map cache.
     */
    public const CACHE_TTL = 86400; // 24 hours

    public function handle(Request $request, Closure $next): Response
    {
        if (! auth()->check()) {
            return $next($request);
        }

        $map = Cache::remember(
            self::CACHE_KEY,
            self::CACHE_TTL,
            static fn () => self::buildPermissionRoleMap(),
        );

        foreach ($map as $title => $roleIds) {
            Gate::define($title, function ($user) use ($roleIds) {
                return count(
                    array_intersect($user->roles->pluck('id')->toArray(), $roleIds)
                ) > 0;
            });
        }

        return $next($request);
    }

    /**
     * Build the {permissionTitle => [roleId, ...]} map from the DB.
     *
     * Returned as a plain array so it can be cached as a value (Eloquent
     * collections do not serialise/restore cleanly across drivers).
     *
     * @return array<string, int[]>
     */
    protected static function buildPermissionRoleMap(): array
    {
        $map = [];

        foreach (Role::with('permissions')->get() as $role) {
            foreach ($role->permissions as $permission) {
                $map[$permission->title][] = $role->id;
            }
        }

        return $map;
    }
}
