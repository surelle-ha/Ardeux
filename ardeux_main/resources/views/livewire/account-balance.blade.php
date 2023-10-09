<div>
    @if ($isLoading)
        <div class="spinner-border text-dark" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    @else
        <h6 id="TokenBalance">{{ $accountBalance ?? '0' }}</h6>
    @endif
</div>