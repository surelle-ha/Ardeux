<div>
    @if ($isLoading)
        <div class="spinner-border text-dark" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    @else
        <h6 id="TokenBalance">{{ $tokenBalance ?? '0' }}</h6>
    @endif
</div>