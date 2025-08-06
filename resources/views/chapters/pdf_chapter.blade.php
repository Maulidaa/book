@if($chapter->chapter_cover)
    <div style="text-align:center; margin-bottom:30px;">
        <img src="{{ public_path('storage/' . $chapter->chapter_cover) }}" style="width:100%; max-width:600px; height:180px; object-fit:cover;">
    </div>
@endif

<h2 style="text-align: center;">{{ $chapter->title }}</h2>
<p>{{ $chapter->content }}</p>