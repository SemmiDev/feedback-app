<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FormRateLimitMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $ip = $request->header('X-Forwarded-For') ?: $request->ip();
        $cacheKey = 'form_submission_' . $ip;
        $lockoutTime = 5 * 60 * 60; // 5 jam dalam detik

        // Cek apakah IP sudah melakukan pengiriman
        if (Cache::has($cacheKey)) {
            $lastSubmission = Cache::get($cacheKey);
            $timeSinceLastSubmission = now()->diffInSeconds($lastSubmission);

            if ($timeSinceLastSubmission < $lockoutTime) {
                return redirect()->route('feedback.create')->with('error', 'Anda hanya dapat mengirim formulir setiap 5 jam sekali.');
            }
        }

        // Lanjutkan ke request berikutnya
        $response = $next($request);

        // Simpan waktu pengiriman setelah berhasil
        Cache::put($cacheKey, now(), $lockoutTime);

        return $response;
    }
}
