<div class="container">
    @if ($plans->isEmpty())
        <p>No Plans Found</p>
    @else
        <div class="card-grid">
            @foreach ($plans as $plan)
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $plan->name }}</h5>
                        <p class="card-text">{{ $plan->description }}</p>
                        <p class="card-text">Price: ${{ $plan->price }}</p>
                        <a href="{{ route('plan.purchase', $plan->id) }}" class="btn btn-primary">Subscribe</a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
