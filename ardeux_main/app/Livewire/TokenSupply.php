<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class TokenSupply extends Component
{
    public $tokenSupply;
    public $isLoading = false;

    public function mount()
    {
        $this->fetchAndDisplaySupply();
    }

    public function fetchAndDisplaySupply()
    {
        $this->isLoading = true;

        $response = Http::withoutVerifying()
            ->post('https://api.devnet.solana.com', [
                "jsonrpc" => "2.0",
                "id" => 1,
                "method" => "getTokenSupply",
                "params" => [
                    env('TOKEN_ADDRESS')
                ]
            ]);

        if ($response->successful()) {
            $data = $response->json();
            $this->tokenSupply = number_format($data['result']['value']['amount'] * 0.000000001, 2);
        } else {
            // Handle the error here
            $this->tokenSupply = 'Error fetching token supply';
        }

        $this->isLoading = false;
    }
    
    public function render()
    {
        return view('livewire.token-supply');
    }
}
