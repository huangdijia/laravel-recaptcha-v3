<script type="text/javascript" src="https://www.google.com/recaptcha/api.js?render={{$site_key??config('recaptcha-v3.site_key')}}"></script>
<script>
grecaptcha.send = function() {
    grecaptcha.execute('{{$site_key??config('recaptcha-v3.site_key')}}', {action: '{{$action??''}}'}).then(function(token) {
        document.getElementById('{{ md5(($name ?? config('recaptcha-v3.input_name'))) }}').value = token;
		document.dispatchEvent(new Event('grecaptcha.sent'));
    });
}
@if($auto ?? true)
	grecaptcha.ready(function() {
		grecaptcha.send();
	});
@endif
</script>
