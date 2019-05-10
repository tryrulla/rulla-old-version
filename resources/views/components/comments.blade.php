<details open>
    <summary>Comments</summary>

    <form action="{{ $commentUrl }}" method="post" class="my-2">
        @csrf
        <label for="comment" class="text-sm block text-gray-700 mt-1">
            Add a comment
        </label>

        <textarea id="comment" name="comment" class="input-text w-full" placeholder="Placeholder text" rows="3">{{ old('comment') }}</textarea>

        <button class="button-gray" type="submit">Save</button>
    </form>

    @forelse($it->comments as $comment)
        <div class="mb-2">
            <div class="text-xs text-gray-800">
                <span v-tooltip="'[{{ $comment->commentator->identifier }}] {{ $comment->commentator->name }} ({{ $comment->commentator->username }}, {{ $comment->commentator->email }})'">
                    {{ $comment->commentator->name }}
                </span>
                said at
                <formatted-date date="{{ $comment->created_at }}"></formatted-date>
            </div>

            <div class="whitespace-pre-line border-l-4 pl-1 border-gray-500">{{ $comment->comment }}</div>
        </div>
    @empty
        No comments.
    @endforelse
</details>
