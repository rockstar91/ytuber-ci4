<script src="https://www.google.com/recaptcha/api.js?render=<?php echo $this->config->item('recaptcha3')['pub']; ?>"></script>
<script>
    grecaptcha.ready(function() {
        grecaptcha.execute('<?php echo $this->config->item('recaptcha3')['pub']; ?>', {action: 'panel'}).then(function(token) {
            fetch('/main/recaptcha_verify/?action=panel&token='+token).then(function(response) {
                response.json().then(function(data) {
                    console.log(data);
                    //document.querySelector('.response').innerHTML = JSON.stringify(data, null, 2);
                    //document.querySelector('.step3').classList.remove('hidden');
                });
            });
        });
    });
</script>