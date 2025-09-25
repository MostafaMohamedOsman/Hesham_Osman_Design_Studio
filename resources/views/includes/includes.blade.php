<div class="col-12">
    @if(session()->has('successes'))
    <div class="alert alert-success">{{session()->get('successes')}}</div>
    @endif
</div>
