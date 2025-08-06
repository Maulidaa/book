@foreach($chapters as $chapter)
    @if($chapter->chapter_cover)
        <div style="text-align:center; margin-bottom:30px;">
            <img src="{{ public_path('storage/' . $chapter->chapter_cover) }}" style="width:600px; height:180px; object-fit:cover; object-position:center;">
        </div>
    @endif

    <h2 style="text-align: center;">{{ $chapter->title }}</h2>
    <p>{{ $chapter->content }}</p>

    @if(!$loop->last)
        <div style="page-break-after: always;"></div>
    @endif
@endforeach