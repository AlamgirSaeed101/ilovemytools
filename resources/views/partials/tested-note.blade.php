@php($note = \App\Support\SiteData::testedNote($tool['slug']))
@if ($note)
    <h2 id="tested">We tested it</h2>
    <p class="text-sm text-muted">Tested on the live site on <time datetime="{{ $note['tested'] }}">{{ \Illuminate\Support\Carbon::parse($note['tested'])->isoFormat('LL') }}</time>, with sample files we made for the test.</p>
    @foreach ($note['paragraphs'] as $paragraph)
        <p>{{ $paragraph }}</p>
    @endforeach
    @if (! empty($note['table']))
        <div class="table-wrap">
            <table class="compare-table">
                <thead><tr>@foreach ($note['table']['headers'] as $h)<th scope="col">{{ $h }}</th>@endforeach</tr></thead>
                <tbody>
                    @foreach ($note['table']['rows'] as $row)
                        <tr>@foreach ($row as $i => $cell)@if ($i === 0)<th scope="row">{{ $cell }}</th>@else<td>{{ $cell }}</td>@endif @endforeach</tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
    @if (! empty($note['limits']))
        <h3>Limits</h3>
        <ul>
            @foreach ($note['limits'] as $limit)
                <li>{{ $limit }}</li>
            @endforeach
        </ul>
    @endif
@endif
