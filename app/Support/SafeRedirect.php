<?php

namespace App\Support;

use Illuminate\Http\Request;

class SafeRedirect
{
    /**
     * Remember where a guest came from (e.g. a post's comment prompt) so that
     * signing in or registering returns them to that post's comments.
     * Only same-site paths are accepted; anything else is ignored.
     */
    public static function rememberFromRequest(Request $request): void
    {
        $path = $request->query('redirect');

        if (! is_string($path) || ! static::isSafePath($path)) {
            return;
        }

        $request->session()->put('url.intended', url($path).'#comments');
    }

    public static function isSafePath(string $path): bool
    {
        if ($path === '' || strlen($path) > 255 || $path[0] !== '/') {
            return false;
        }

        if (str_starts_with($path, '//') || str_starts_with($path, '/\\') || str_contains($path, '\\')) {
            return false;
        }

        $parts = parse_url($path);

        return $parts !== false && ! isset($parts['scheme']) && ! isset($parts['host']);
    }
}
