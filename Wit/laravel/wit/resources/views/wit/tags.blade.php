    <ul class="mt-2">
        @foreach ($trend_tags as $tag)
            <li><a class="tag" href="#"><span class="tag-name">{{ $tag->name }}</span><span class="tag-number badge badge-light">{{ $tag->number }}</span></a></li>
        @endforeach
    </ul>





