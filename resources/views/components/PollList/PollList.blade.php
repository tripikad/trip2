
<table class="Table">

    <tr class="Table__row">
        <th class="Table__header">
            ID
        </th>
        <th class="Table__header">
            {{trans('poll.question')}}
        </th>
        <th class="Table__header">
            {{trans('poll.start_date')}}
        </th>
        <th class="Table__header">
            {{trans('poll.end_date')}}
        </th>
        <th class="Table__header">
            {{trans('poll.active')}}
        </th>
        <th class="Table__header">
            {{trans('poll.anonymous')}}
        </th>
        <th class="Table__header">
            {{trans('poll.answered')}}
        </th>
        <th class="Table__header">
            &nbsp;
        </th>
        <th class="Table__header">
            &nbsp;
        </th>
    </tr>

    @foreach (collect($items) as $item)

        <tr class="Table__row {{ $item['front_page'] ? 'background-gray' : '' }}">

            <td class="Table__cell">
                {{ $item['id'] }}
            </td>

            <td class="Table__cell">
                <a class="PollList__question" href="{{route('poll.show', ['poll' => $item['id']])}}">{{ $item['question'] }}</a>
            </td>

            <td class="Table__cell">
                {{ $item['start_date_formatted'] }}
            </td>

            <td class="Table__cell">
                {{ $item['end_date_formatted'] }}
            </td>

            <td class="Table__cell">
                {{$item['active'] ? trans('general.yes') : trans('general.no')}}
            </td>

            <td class="Table__cell">
                {{$item['anonymous'] ? trans('general.yes') : trans('general.no')}}
            </td>

            <td class="Table__cell">
                {{$item['answered']}}
            </td>

            <td class="Table__cell">
                <button-vue route="{{route('poll.edit', ['poll' => $item['id']])}}" title="{{trans('general.edit')}}" isclasses="Button--small"/>
            </td>

            <td class="Table__cell">
                @if (!$item['answered'])
                    <form action="{{route('poll.delete', ['poll' => $item['id']])}}" method="POST">
                        <input type="hidden" name="_method" value="POST">
                        {!! csrf_field() !!}
                        <input type="submit" value="X" class="Button--small Button--gray PollList__delete" title="{{trans('general.delete')}}">
                    </form>
                @endif
            </td>

        </tr>

    @endforeach

</table>
