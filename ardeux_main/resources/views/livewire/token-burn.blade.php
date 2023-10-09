<div class="col-xxl6 col-md-6">
    <div class="card info-card revenue-card">

        <div class="filter">
            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
            <li class="dropdown-header text-start">
                <h6>Action</h6>
            </li>

            <li style="cursor:pointer;"><a class="dropdown-item" wire:click="mintToken">Mint Minter</a></li>
            </ul>
        </div>

        <div class="card-body">
            <h5 class="card-title">Token Burner <span>| version 1</span></h5>

            <div class="d-flex align-items-center">
            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                <i class="bi bi-fire"></i>
            </div>
            <div class="ps-3">
                @if (!$mintProgress)
                    <h6>Ready</h6>
                @else
                    <h6>{{ $mintedToken }}</h6>
                @endif
                <span class="text-success small pt-1 fw-bold" style="cursor: pointer;" wire:click="mintToken">Start Burning</span>
            </div>
            </div>
        </div>

        @if($mintProgress)
            <div class="row">
                <!-- Default Accordion -->
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            {{$mintProgress}}
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                            <strong>Transaction: </strong> {{ ($transaction) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        

    </div>
</div>
