<script type="text/javascript" src="https://www.recaptcha.net/recaptcha/api.js?render={{$site_key??config('recaptcha.site_key')}}"></script>
<script>
grecaptcha.send = function() {
    grecaptcha.execute('{{$site_key??config('recaptcha.site_key')}}', {action: '{{$action??''}}'}).then(function(token) {
        document.getElementById('{{ md5(($name ?? config('recaptcha.input_name'))) }}').value = token;
        document.dispatchEvent(new Event('grecaptcha.sent'));
    });
}
@if($auto ?? true)
    grecaptcha.ready(function() {
        grecaptcha.send();
    });
@endif
</script>
