<div class="review-item border-b border-gray-200 pb-4 mb-4" id="review-{{ $review->id }}">
    <div class="flex justify-between mb-2">
        <div>
            <p class="text-sm text-gray-500">
                {{ $review->user->name }} - {{ $review->created_at->format('d/m/Y') }}
            </p>
        </div>

        @if (auth()->check() && (auth()->id() === $review->user_id || auth()->user()->isAdmin()))
            <div class="flex space-x-2">
                <button type="button" class="delete-review text-red-500 hover:text-red-700" data-review-id="{{ $review->id }}">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        @endif
    </div>
    <p class="text-gray-700">{{ $review->comment }}</p>
</div>
