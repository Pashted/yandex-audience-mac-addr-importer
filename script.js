// извлечение токена из адресной строки и редирект с передачей его php-скрипту
if (window.location.hash)
    window.location.href = window.location.origin + window.location.pathname + '?token=' + window.location.hash.replace(/^.*?access_token=([^&]+)&.*$/, '$1');
