@for($i=0; $i<8; $i++) <td><a href="#" data-toggle="modal" data-target="#modalInfo" style="display: block">
        <span data-container="body" data-toggle="popover" data-placement="top"
            data-content="Please subscribe in order to see the predictions" data-trigger="hover">
            @if($i > 2)
            <span class="blur-text">x</span><br />
            @endif
            <span class="blur-text badge {{ $i > 2 ? 'badge-secondary' : 'badge-primary' }} ">x</span></span></a>
    </td>
    @endfor
    <td>
        <button type="button" class="btn btn-icon" data-toggle="modal" data-target="#modalInfo">
            <i class="fa fa-lock"></i>
        </button>
    </td>