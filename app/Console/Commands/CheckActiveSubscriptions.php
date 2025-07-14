<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Subscription;
use App\Services\AppleJwtService;
use Illuminate\Contracts\Console\Isolatable;
use Illuminate\Support\Facades\Http;

class CheckActiveSubscriptions extends Command implements Isolatable
{
    protected $signature = 'subscriptions:check';
    protected $description = 'Check the status of active subscriptions via Apple API';

    protected $appleJwtService;

    public function __construct(AppleJwtService $appleJwtService)
    {
        $this->appleJwtService = $appleJwtService;
    }

    public function handle()
    {
        $subs = Subscription::where('status', 'active')->get();

        foreach ($subs as $sub) {
            // Get the Apple API endpoint and JWT for this subscription
            $transactionId = $sub->transaction_id;

            $data = $this->appleJwtService->verifyTransaction($transactionId, $sub->type ?? 'Sandbox');

            if ($data && isset($data['transactionId'])) {

                if (!$data['isActive']) {
                    // Update subscription in DB
                    $sub->expires_at = isset($data['expiresAt']) ? $data['expiresAt'] : null;
                    $sub->status = false;
                    $sub->save();
                }

                info("Subscription {$sub->id} with {$sub->transaction_id} checked: " . ($data['isActive'] ? 'active' : 'expired'));

            } else {
                info("Failed to fetch Apple data for subscription ID {$sub->id}  with {$sub->transaction_id}");
            }
        }

        info('Active subscription check completed.');
        return 0;
    }
}
