@foreach ($comments as $comment)
    <div class="media mt-4">
        <i class="fas fa-user text-secondary rounded-circle p-3 mr-2" style="background: darkgray;"></i>
        <div class="media-body">
            <div class="d-flex align-items-center">
                <h5 class="m-0">{{ $comment->user ? $comment->user->name : 'Guest' }}</h5>
                <small class="ml-2 text-muted"><i class="far fa-clock"></i> {{ $comment->created_at->diffForHumans() }}</small>
            </div>
            {{ $comment->body }}
        </div>
    </div>
@endforeach