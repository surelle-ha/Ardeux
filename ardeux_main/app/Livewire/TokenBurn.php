<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

use App\Models\Transaction;

class TokenBurn extends Component
{
    public $isLoading = false;

    public $mintProgress = '';
    public $mintedToken = 0;
    public $previousSupply = 0;
    public $newSupply = 0;
    public $transaction = null;
    public $error = null;
    public $timestampRequested = null;
    public $timestampCompleted = null;

    public function mintToken()
    {

        // Make a GET request to your Express.js endpoint
        $response = Http::get(env('API_URL').':'.env('API_PORT').'/v1/api/token/mint');
        
        if ($response->successful()) {
            $data = $response->json();
            $this->mintProgress = $data['mintProgress'];
            $this->mintedToken = $data['mintedToken'];
            $this->previousSupply = $data['previousSupply'];
            $this->newSupply = $data['newSupply'];
            $this->transaction = $data['transaction']['result'];
            $this->error = $data['error'];
            $this->timestampRequested = $data['timestampRequested'];
            $this->timestampCompleted = $data['timestampComplete'];

            try{
                // Save to Database
                Transaction::create([
                    'id' => substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 9),
                    'status' => $data['mintProgress'],
                    'tokenCount' => $data['mintedToken'],
                    'type' => 'Mint',
                    'transaction' => $data['transaction']['result'],
                    'previousSupply' => $data['previousSupply'],
                    'newSupply' => $data['newSupply'],
                    'error' => $data['error'] ?? 'no-error',
                    'timestampRequested' => $data['timestampRequested'],
                    'timestampCompleted' => $data['timestampComplete'],
                ]);

            }catch(\Exception $error){
                $this->error = 'Failed to saving transaction to database.';
            }
            
        } else {
            $this->error = 'Failed to make the request.';
        }

        
        $this->isLoading = false;
    }

    public function render()
    {
        return view('livewire.token-burn');
    }
}
