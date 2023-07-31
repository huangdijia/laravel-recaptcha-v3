<input type="hidden" name="{{$name ?? config('recaptcha.input_name')}}" id="{{ md5(($name ?? config('recaptcha.input_name'))) }}">
@if($hide_icon ?? 0)
<button type="submit" data-sitekey="{{$site_key ?? config('recaptcha.site_key')}}" data-callback="onSubmit" data-badge="inline" style="display: none"></button>
@endif
