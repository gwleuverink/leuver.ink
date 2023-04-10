<entry>
    <id>{{ $article->getUrl() }}</id>
    <link type="text/html" rel="alternate" href="{{ $article->getUrl() }}" />
    <title>{{ $article->title }}</title>
    <published>{{ date(DATE_ATOM, $article->date) }}</published>
    <updated>{{ date(DATE_ATOM, $article->date) }}</updated>
    <author>
        <name>{{ $article->author ?? 'Willem Leuverink' }}</name>
    </author>
    <summary type="html">{{ $article->getExcerpt() }}</summary>
    {{--
        <content type="html">
        <![CDATA[
            @includeFirst(['_posts.' . $article->getFilename(), '_posts._tmp.' . $article->getFilename()])
        ]]>
        </content>
    --}}
</entry>
