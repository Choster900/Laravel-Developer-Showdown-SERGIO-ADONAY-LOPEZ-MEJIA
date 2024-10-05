<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use GuzzleHttp\Client;

class SyncUserAttributes extends Command
{
    protected $signature = 'sync:user-attributes';
    protected $description = 'Sync user attributes with the third-party provider';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {

        $client = new Client();
        $users = User::where('updated_at', '>=', now()->subHour())->get();
        if ($users->isEmpty()) {
            $this->info('No users need to be synced.');
            return;
        }

        $chunks = $users->chunk(1000);

        foreach ($chunks as $chunk) {
            $payload = [
                'batches' => [
                    'subscribers' => $chunk->map(function ($user) {
                        return [
                            'email' => $user->email,
                            'name' => $user->name,
                            'time_zone' => $user->timezone,
                        ];
                    })->toArray(),
                ],
            ];

            try {
                $response = $client->post(env('THIRD_PARTY_API_URL'), [
                    'json' => $payload,
                    'headers' => [
                        'Authorization' => 'Bearer ' . env('THIRD_PARTY_API_KEY'),
                    ],
                ]);

                $responseBody = $response->getBody()->getContents();
                $this->info($responseBody);

            } catch (\Exception $e) {
                $this->error('Failed to process batch: ' . $e->getMessage());
            }
        }
    }
}
