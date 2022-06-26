    <ul class="mt-2">
        @foreach ($trend_tags as $tag)
            <li><button class="tag" type="button"><span class="tag-name">{{ $tag->name }}</span><span class="tag-number badge badge-light">{{ $tag->number }}</span></button></li>
        @endforeach
    </ul>





