<td>
    <span class="badge badge-primary" data-container="body" data-toggle="popover" data-placement="top" data-content="{{
        __('match.text_odd')
        }}" data-trigger="hover">{{
        $match->first_odd}}</span>
</td>
<td>
    <span class="badge badge-primary" data-container="body" data-toggle="popover" data-placement="top" data-content="{{
        __('match.text_odd')
        }}" data-trigger="hover">{{ $match->x_odd}}</span>
</td>
<td>
    <span class="badge badge-primary" data-container="body" data-toggle="popover" data-placement="top" data-content="{{
        __('match.text_odd')
        }}" data-trigger="hover">{{ $match->second_odd}}</span>
</td>
<td>
    {{ $match->tip}}<br />
    <span class="badge badge-secondary" data-container="body" data-toggle="popover" data-placement="top" data-content="{{
        __('match.text_odd')
        }}" data-trigger="hover">{{ $match->tip_odd}}</span>
</td>
<td>
    {{ $match->handicap}}<br />
    <span class="badge badge-secondary" data-container="body" data-toggle="popover" data-placement="top" data-content="{{
        __('match.text_odd')
        }}" data-trigger="hover">{{ $match->handicap_odd}}</span>
</td>
<td>
    {{ $match->o_u}}<br />
    <span class="badge badge-secondary" data-container="body" data-toggle="popover" data-placement="top" data-content="{{
        __('match.text_odd')
        }}" data-trigger="hover">{{ $match->o_u_odd}}</span>
</td>
<td>
    {{ $match->correct_score}}<br />
    <span class="badge badge-secondary" data-container="body" data-toggle="popover" data-placement="top" data-content="{{
        __('match.text_odd')
        }}" data-trigger="hover">{{ $match->correct_score_odd}}</span>
</td>
{{-- <td>
    {{ $match->best_tip}}<br />
    <span class="badge badge-secondary" data-container="body" data-toggle="popover" data-placement="top" data-content="{{
        __('match.text_odd')
        }}" data-trigger="hover">{{ $match->best_tip_odd}}</span>
</td> --}}
<td> {{ $match->mixparlay}}
</td>
{{-- <td></td> --}}