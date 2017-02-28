<?php

namespace WebModularity\LaravelSession;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\Guard;
use WebModularity\LaravelLog\LogUserAgent;

class DatabaseSessionHandler extends \Illuminate\Session\DatabaseSessionHandler
{
    /**
     * Get the default payload for the session.
     *
     * @param  string  $data
     * @return array
     */
    protected function getDefaultPayload($data)
    {
        $payload = ['payload' => base64_encode($data), 'last_activity' => Carbon::now()->getTimestamp()];

        if (! $container = $this->container) {
            return $payload;
        }

        if ($container->bound(Guard::class)) {
            // User ID
            $payload['user_id'] = $container->make(Guard::class)->id();
        }

        if ($container->bound('request')) {
            // IP Address
            $payload['ip_address'] = inet_pton($container->make('request')->ip());

            // User Agent
            $userAgent = $container->make('request')->header('User-Agent');
            if (!empty($userAgent)) {
                $payload['user_agent_id'] = LogUserAgent::firstOrCreate(
                    ['user_agent_hash' => LogUserAgent::hashUserAgent($userAgent)],
                    ['user_agent' => $userAgent]
                )->id;
            }
        }

        return $payload;
    }
}
