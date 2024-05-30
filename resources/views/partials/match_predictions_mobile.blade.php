<td> {{
    __('match.text_odd')
    }}</td>
<td>
    <span class="badge badge-primary">{{ $match->first_odd}}</span>
</td>
<td><span class="badge badge-primary">{{ $match->x_odd}}</span></td>
<td><span class="badge badge-primary">{{ $match->second_odd}}</span></td>
<td>{{ $match->tip}}<br />
    <span class="badge badge-secondary ml-1">{{ $match->tip_odd}}</span>
</td>
<td> {{ $match->handicap}}<br />
    <span class="badge badge-secondary ml-1">{{ $match->handicap_odd}}</span>
</td>
<td> {{ $match->o_u}}<br />
    <span class="badge badge-secondary ml-1">{{ $match->o_u_odd}}</span>
</td>
<td>{{ $match->correct_score}}<br />
    <span class="badge badge-secondary ml-1">{{ $match->correct_score_odd}}</span>
</td>
<td> {{ $match->best_tip}}<br />
    <span class="badge badge-secondary ml-1">{{ $match->best_tip_odd}}</span>
</td>
<td></td>