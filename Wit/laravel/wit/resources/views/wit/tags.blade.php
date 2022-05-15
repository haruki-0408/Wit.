    <ul class="mt-2">
        @foreach ($trend_tags as $tag)
            <li><a class="tag" href="#">{{ $tag->name }} <span
                        class="badge badge-light">{{ $tag->number }}</span></a></li>
        @endforeach
    </ul>





