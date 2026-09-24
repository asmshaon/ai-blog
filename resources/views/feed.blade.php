{!! '<?xml version="1.0" encoding="UTF-8"?>' !!}
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
    <channel>
        <title>Abu Saleh · Engineering notes</title>
        <link>{{ route('home') }}</link>
        <description>Notes on building payment, booking, point-of-sale and marketplace systems.</description>
        <language>en</language>
        <atom:link href="{{ route('feed') }}" rel="self" type="application/rss+xml" />
        @if ($posts->isNotEmpty())
            <lastBuildDate>{{ $posts->first()->published_at->toRssString() }}</lastBuildDate>
        @endif
        @foreach ($posts as $post)
            <item>
                <title>{{ $post->title }}</title>
                <link>{{ route('blog.show', $post->slug) }}</link>
                <guid isPermaLink="true">{{ route('blog.show', $post->slug) }}</guid>
                <pubDate>{{ $post->published_at->toRssString() }}</pubDate>
                @if ($post->category)
                    <category>{{ $post->category->name }}</category>
                @endif
                <description>{{ $post->excerpt }}</description>
            </item>
        @endforeach
    </channel>
</rss>
