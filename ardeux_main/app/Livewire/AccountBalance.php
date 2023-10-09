<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class AccountBalance extends Component
{
    public $accountBalance;
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
                "method" => "getTokenAccountsByOwner",
                "params" => [
                    Auth::user()->Wallet,
                    [
                        "mint" => env('TOKEN_ADDRESS'),
                    ],
                    [
                        "encoding" => "jsonParsed"
                    ]
                ]
            ]);

        if ($response->successful()) {
            $data = $response->json();
            if (isset($data['result']['value'][0]['account'])) {
                $accountData = $data['result']['value'][0]['account'];
                $this->accountBalance = number_format($accountData['data']['parsed']['info']['tokenAmount']['amount'] * 0.000000001, 2);
            } else {
                $this->accountBalance = 'Account data not found';
            }
        } else {
            // Handle the error here
            $this->accountBalance = 'Error fetching token balance';
        }
        
        $this->isLoading = false;
    }


    public function render()
    {
        return view('livewire.account-balance');
    }
}
