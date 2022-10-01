    <ul class="Tags-List mt-2">
        @foreach ($tags as $tag)
            <li><button class="tag" type="button"><span class="tag-name">{{ $tag->name }}</span><span class="tag-number badge badge-light">{{ $tag->number }}</span></button></li>
        @endforeach
    </ul>





