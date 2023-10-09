<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class TokenBalance extends Component
{
    public $tokenBalance;
    public $isLoading = false;

    public function mount()
    {
        $this->fetchAndDisplayBalance();
    }

    public function fetchAndDisplayBalance()
    {
        $this->isLoading = true;

        $response = Http::withoutVerifying()
            ->post('https://api.devnet.solana.com', [
                "jsonrpc" => "2.0",
                "id" => 1,
                "method" => "getTokenAccountBalance",
                "params" => [
                    env('TOKEN_ACCOUNT')
                ]
            ]);

        if ($response->successful()) {
            $data = $response->json();
            $this->tokenBalance = number_format($data['result']['value']['amount'] * 0.000000001, 2);
        } else {
            // Handle the error here
            $this->tokenBalance = 'Error fetching token balance';
        }
        
        $this->isLoading = false;
    }
    

    public function render()
    {
        return view('livewire.token-balance');
    }
}
